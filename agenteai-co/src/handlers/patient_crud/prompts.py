from ...core.speech_input import listen
from ...core.preprocessing import normalizar_texto
from ...io.speech import speak

def solicitar_datos_iniciales():
    speak("Decime los datos del paciente que querés agregar")
    respuesta = listen()

    if not respuesta:
        speak("No te escuché. Intentemos nuevamente.")
        return None

    intent, texto = normalizar_texto(respuesta)
    if intent == "cancelar":
        return "CANCELAR"
    return texto

def pedir_datos_faltantes(faltantes: list):
    errores_str = ", ".join(faltantes)
    speak(f"Falta información obligatoria: {errores_str}. Por favor, decímelos")

    respuesta = listen()
    if not respuesta:
        speak("No te escuché")
        return None

    intent, texto = normalizar_texto(respuesta)
    if intent == "cancelar":
        return "CANCELAR"
    
    return texto


def confirmar_entidades(entidades: dict):
    entidades_str = ", ".join(f"{k}: {v}" for k, v in entidades.items() if v)
    speak(f"He entendido: {entidades_str}. ¿Es correcto?")

    respuesta = listen()
    if not respuesta:
        speak("No te he escuché. Repetimos")
        return None

    intent, texto = normalizar_texto(respuesta)

    if intent == "cancelar":
        return "CANCELAR"

    positivos = ["si", "sí", "s", "ok", "correcto", "confirmo", "dale", "acepto"]
    negativos = ["no", "n", "incorrecto", "equivocado"]

    if any(p in texto for p in positivos):
        return True
    if any(n in texto for n in negativos):
        return False

    speak("No entendí la respuesta")
    return None