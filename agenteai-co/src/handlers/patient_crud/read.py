from ...core.data_manager import extract_entities
from ...core.preprocessing import normalizar_texto
from ...services.database import fetch_sql
from ...io.speech import speak
from ...core.speech_input import listen

def _format_results(resultados: list[dict]) -> str:
    """Formatea la lista de pacientes para ser hablada"""
    
    if not resultados:
        return "No encontré pacientes que coincidan con esa búsqueda"
    
    if len(resultados) == 1:
        p = resultados[0]

        respuesta = f"Encontré un paciente: {p['nombre']} {p['apellido']}, con DNI {p['dni']}"
        if p.get('telefono'):
            respuesta += f" Su teléfono es {p['telefono']}"
        return respuesta
    
    respuesta = f"Encontré {len(resultados)} pacientes: "
    nombres = [f"{p['nombre']} {p['apellido']}" for p in resultados]
    respuesta += ", ".join(nombres) + "."
    return respuesta


def handle_read(texto_limpio_inicial: str) -> str:
    """
    Flujo principal para buscar un paciente por DNI o Apellido
    """
    speak("Iniciando consulta de paciente.")
    
    entidades = extract_entities(texto_limpio_inicial)
    dni = entidades.get("dni")
    apellido = entidades.get("apellido")
    
    if not dni and not apellido:
        speak("Puedo buscar por DNI o por apellido. ¿Qué dato tienes?")
        texto_usuario = listen()
        
        if not texto_usuario:
            return "No escuché nada. Cancelando"
        if "cancelar" in texto_usuario:
            return "Búsqueda cancelada"
        
        _, texto_limpio_nuevo = normalizar_texto(texto_usuario)
        
        entidades_nuevas = extract_entities(texto_limpio_nuevo)
        dni = entidades_nuevas.get("dni")
        apellido = entidades_nuevas.get("apellido")

        if not dni and not apellido:
            return "No logré entender el DNI o apellido. Por favor, intenta de nuevo"
    
    query_base = "SELECT nombre, apellido, dni, telefono FROM pacientes"
    where_clauses = []
    params = []

    if dni:
        where_clauses.append("dni = %s")
        params.append(dni)
    
    if apellido:
        where_clauses.append("apellido LIKE %s")
        params.append(f"%{apellido}%")

    sql = query_base + " WHERE " + " AND ".join(where_clauses) + " LIMIT 5;"
    print(f"[Read] SQL a ejecutar: {sql} con Params: {params}")
    ok, resultados = fetch_sql(sql, tuple(params))
    
    if not ok:
        return f"Ocurrió un error al consultar la base de datos: {resultados}"
    
    respuesta_hablada = _format_results(resultados)
    return respuesta_hablada