import re
import unicodedata

UNIDADES = {
    "cero": 0, "sero": 0,
    "uno": 1, "una": 1,
    "dos": 2,
    "tres": 3,
    "cuatro": 4, "kuatro": 4,
    "cinco": 5,
    "seis": 6, "ceis": 6,
    "siete": 7,
    "ocho": 8,
    "nueve": 9,
}

ESPECIALES = {
    "diez": 10,
    "once": 11, "doce": 12, "trece": 13, "catorce": 14, "quince": 15,
    "dieciseis": 16, "diecisiete": 17, "dieciocho": 18, "diecinueve": 19,

    "veinte": 20, "veintiuno": 21, "veintidos": 22, "veintitres": 23,
    "veinticuatro": 24, "veinticinco": 25, "veintiseis": 26,
    "veintisiete": 27, "veintiocho": 28, "veintinueve": 29,
}

DECENAS = {
    "treinta": 30, "cuarenta": 40, "cincuenta": 50,
    "sesenta": 60, "setenta": 70, "ochenta": 80, "noventa": 90
}

NUM_WORDS = set(UNIDADES) | set(ESPECIALES) | set(DECENAS) | {"y"}


# Conversion de secuencia de tokens numéricos a número entero
def convertir_run_numerico(tokens):
    """
    Convierte una secuencia de tokens numéricos (palabras + dígitos)
    en un número entero.
    Ejemplo:
        ["40", "y", "4"] -> 44
        ["cuarenta", "y", "cuatro"] -> 44
        ["cuatro", "dos"] -> 42   (caso DNI)
    """

    nums = []
    for t in tokens:
        if t.isdigit():
            nums.append(int(t))
        elif t in UNIDADES:
            nums.append(UNIDADES[t])
        elif t in ESPECIALES:
            nums.append(ESPECIALES[t])
        elif t in DECENAS:
            nums.append(DECENAS[t])
        elif t == "y":
            nums.append("y")
        else:
            return None

    # Caso 1: decena + y + unidad (ej: 40 y 5, cuarenta y cinco)
    if len(nums) == 3 and isinstance(nums[0], int) and nums[1] == "y" and isinstance(nums[2], int):
        if nums[0] % 10 == 0 and nums[2] < 10:
            return nums[0] + nums[2]

    # Caso 2: todos son unidades o dígitos → concatenar (DNI)
    if all(isinstance(n, int) for n in nums):
        return int("".join(str(n) for n in nums))

    return None

# Tokenizacion
def convertir_numeros_a_token(texto: str) -> str:
    palabras = texto.split()
    out = []
    i = 0
    n = len(palabras)

    def is_num_like(t):
        return t.isdigit() or t in NUM_WORDS

    while i < n:
        if not is_num_like(palabras[i]):
            out.append(palabras[i])
            i += 1
            continue

        j = i
        sec = []
        while j < n and is_num_like(palabras[j]):
            sec.append(palabras[j])
            j += 1

        val = convertir_run_numerico(sec)
        if val is not None:
            out.append(f"<NUM_RAW>{val}</NUM_RAW>")
        else:
            digits = []
            for t in sec:
                if t.isdigit():
                    digits.append(t)
                elif t in UNIDADES:
                    digits.append(str(UNIDADES[t]))
                elif t in ESPECIALES:
                    digits.append(str(ESPECIALES[t]))
                elif t in DECENAS:
                    digits.append(str(DECENAS[t] // 10))
            if digits:
                out.append(f"<NUM_RAW>{''.join(digits)}</NUM_RAW>")
            else:
                out.extend(sec)

        i = j

    return " ".join(out)

def normalizar_texto(texto: str) -> tuple[str, str]:
    texto = texto.lower().strip()
    texto = unicodedata.normalize("NFKD", texto)
    texto = re.sub(r"[^a-z0-9áéíóúüñ\s/]", "", texto)
    texto = re.sub(r"\s+", " ", texto)

    correcciones_dni = [
        "de en y", "de en i", "de ene i", "de ene y",
        "den ey", "den i", "de ni", "de nay", "de n y", "de n i"
    ]
    for c in correcciones_dni:
        texto = texto.replace(c, "dni")

    texto = convertir_numeros_a_token(texto)

    mapa_intentos = {
        "agregar": ["agregar", "agregá", "agrega", "añadir", "añadí", "poner", "poné", "cargar", "cargá",
                    "insertar", "insertá", "dar de alta", "nuevo paciente", "crear", "creá", "incorporar"],
        "actualizar": ["actualizar", "actualiza", "actualizá", "modificar", "modificá", "cambiar", "cambiá",
                       "editar", "editá"],
        "buscar": ["buscar", "buscá", "busca", "consultar", "consultá", "consulta", "traer", "traeme", "dame",
                   "ver", "decime", "encontrar", "mostrame"],
        "borrar": ["borrar", "borrá", "borra", "eliminar", "eliminá", "quita", "quitar",
                   "sacar", "sacá", "dar de baja"],
        "cancelar": ["cancelar", "cancela", "salir", "salí", "olvídalo", "olvidalo", "basta", "terminar"]
    }

    intent = "desconocido"
    for intento, palabras in mapa_intentos.items():
        for s in palabras:
            if re.search(r'\b' + re.escape(s) + r'\b', texto):
                intent = intento
                break
        if intent != "desconocido":
            break

    return intent, texto
