import json
from ..services.ollama_client import call_ollama

# Esquema de la tabla pacientes en MySQL
MYSQL_SCHEMA_DESC = """
CREATE TABLE `pacientes` (
  `id_paciente` BIGINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  `dni` VARCHAR(15) UNIQUE NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `apellido` VARCHAR(100) NOT NULL,
  `fecha_nacimiento` DATE NULL,
  `telefono` VARCHAR(30) NULL,
  `email` VARCHAR(150) NULL,
  `obra_social` VARCHAR(120) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
"""

EXTRACTION_PROMPT = f"""
Extrae SOLO las entidades presentes en el texto y devuelve ÚNICAMENTE este JSON:
{{"dni": "", "nombre": "", "apellido": "", "fecha_nacimiento": "", "telefono": "", "email": "", "obra_social": ""}}

Reglas:
- No inventes datos. Campo no dicho → "".
- No infieras apellido/nombre si solo aparece uno.
- Salida = solo JSON válido, sin explicar nada.
- Los números encerrados en <NUM_RAW>...</NUM_RAW> deben ser copiados literalmente, sin modificar, sin interpretar y sin estimar.
- El DNI debe conservar el orden EXACTO de los dígitos en los <NUM_RAW>.
- Cada <NUM_RAW> representa una secuencia ya validada por el motor de voz; no debes reconstruir, dividir ni unir nada.
- No infieras miles, cientos ni formas típicas de DNI.
- Copia teléfonos y números tal como aparecen.
- No agregues claves extra.
- Fecha: si no es explícita → "".

Esquema MySQL:
{MYSQL_SCHEMA_DESC}

Texto: \"\"\"{{texto}}\"\"\" 
"""


SQL_PROMPT = f"""
Eres un generador de SQL seguro.
Esquema MySQL:
{MYSQL_SCHEMA_DESC}

Recibirás una ACCIÓN ("agregar", "actualizar" o "borrar") y un JSON con campos.
- Genera una sentencia SQL compatible con **MySQL**.
- Asegúrate de que todos los valores de texto (VARCHAR) y fecha (DATE) estén entre **comillas simples** (ej: 'valor', '2023-10-25').
- Los campos no provistos en el JSON no deben incluirse en el INSERT o UPDATE (excepto DNI para WHERE).
- Si la ACCIÓN es "agregar" -> genera INSERT INTO pacientes(...) VALUES(...)
- Si la ACCIÓN es "actualizar" -> genera UPDATE pacientes SET ... WHERE dni = '...'
- Si la ACCIÓN es "borrar" -> genera DELETE FROM pacientes WHERE dni = '...'
- El DNI es crucial para UPDATE y BORRAR.
- No generes SQL para los campos autogestionados (id_paciente, created_at, updated_at).
- No hagas DROP, ALTER, TRUNCATE ni DELETE sin un WHERE dni.
- Devuelve SOLO el SQL en una línea, sin explicaciones ni markdown.

ACCIÓN: {{accion}}
JSON: {{json}}
"""

# JSON de retorno por defecto
EMPTY_PATIENT_DATA = {
    "dni": "",
    "nombre": "",
    "apellido": "",
    "fecha_nacimiento": "",
    "telefono": "",
    "email": "",
    "obra_social": ""
}

# Lista de claves de extracción
EXTRACTION_KEYS = [
    "dni", "nombre", "apellido", "fecha_nacimiento", 
    "telefono", "email", "obra_social"
]


def extract_entities(texto: str, model: str = "llama3.1:8b") -> dict:
    """
    Extrae entidades del texto usando el LLM (EXTRACTION_PROMPT)
    """
    prompt = EXTRACTION_PROMPT.replace("{texto}", texto) 
    raw = call_ollama(prompt, model=model, temperature=0.0)
    
    try:
        js_start = raw.find("{")
        js_end = raw.rfind("}") + 1
        
        if js_start == -1 or js_end == 0:
            print("[Extractor Error] No se encontró JSON en la respuesta del LLM.")
            return EMPTY_PATIENT_DATA.copy()

        js = raw[js_start:js_end]
        data = json.loads(js)
        
        # Normalizacion del DNi
        dni_limpio = ""
        if data.get("dni"):
            dni_limpio = str(data.get("dni")).replace(".", "").replace(" ", "").replace("-", "")

        out = {k: (data.get(k) if data.get(k) is not None else "") for k in EXTRACTION_KEYS}
        out["dni"] = dni_limpio # DNI limpio
        
        return out
        
    except Exception as e:
        print(f"[Extractor Error] Falló el parseo de JSON: {e}")
        print(f"[Extractor Error] Raw problemático: {raw}")
        return EMPTY_PATIENT_DATA.copy()


def build_sql_from_intent_and_json(intent: str, data: dict, model: str = "llama3.1:latest") -> str:
    """
    Construye el SQL usando el LLM (SQL_PROMPT)
    para manejar diferentes intentos (INSERT, UPDATE y DELETE).
    """
    
    if intent == "buscar":
        return "-- SQL no generado: La acción es 'buscar'."
    
    if not data.get("dni"):
        return "-- ERROR: Imposible generar SQL (agregar, actualizar o borrar) sin un DNI."
    data_con_valores = {k: v for k, v in data.items() if v}

    if intent in ["agregar", "actualizar"] and len(data_con_valores) <= 1 and "dni" in data_con_valores:
         return f"-- ERROR: No hay suficientes datos para {intent} (solo DNI)."

    if not data_con_valores:
        return "-- ERROR: No hay datos válidos para generar SQL."
    
    if intent in ["actualizar", "borrar"] and "dni" not in data_con_valores:
         return f"-- ERROR: Imposible generar SQL para {intent} sin un DNI."


    data_json_str = json.dumps(data_con_valores, ensure_ascii=False)
    
    prompt = SQL_PROMPT.replace("{accion}", intent)
    prompt = prompt.replace("{json}", data_json_str)
    
    sql = call_ollama(prompt, model=model)
    
    if sql.startswith("```sql"):
        sql = sql[6:]
    if sql.endswith("```"):
        sql = sql[:-3]
    
    sql = sql.strip().replace("\n", " ").replace(";", "")

    # Verificaciones de seguridad
    sql_lower = sql.lower()
    
    if any(kw in sql_lower for kw in ["drop", "alter", "truncate"]):
        return "-- ERROR: SQL inseguro detectado (DROP/ALTER/TRUNCATE)."
    
    if "delete" in sql_lower and "where" not in sql_lower:
        return "-- ERROR: SQL inseguro detectado (DELETE sin WHERE)."

    # Intención
    if intent == "agregar" and "insert" not in sql_lower:
        return "-- ERROR: El LLM no generó el INSERT esperado."
    if intent == "actualizar" and "update" not in sql_lower:
        return "-- ERROR: El LLM no generó el UPDATE esperado."
    if intent == "borrar" and "delete" not in sql_lower:
        return "-- ERROR: El LLM no generó el DELETE esperado."

    return sql + ";"