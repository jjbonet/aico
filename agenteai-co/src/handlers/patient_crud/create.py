from .prompts import pedir_datos_faltantes, confirmar_entidades, solicitar_datos_iniciales
from .executor import ejecutar_alta

from ...core.data_manager import extract_entities, EMPTY_PATIENT_DATA
from ...core.validation import validate_local
from ...io.speech import speak


def handle_create(texto_limpio_inicial: str) -> str:
    """
    Flujo principal para alta de paciente
    """
    speak("Perfecto, iniciemos el alta del paciente")

    entidades_actuales = extract_entities(texto_limpio_inicial)

    while True:
        errores_validacion = validate_local(entidades_actuales)

        faltantes = [e for e in errores_validacion if "Falta" in e]
        invalidos = [e for e in errores_validacion if "Falta" not in e]

        if invalidos:
            speak(f"He detectado errores en los datos: {', '.join(invalidos)}. Debemos reiniciar la carga")
            entidades_actuales = EMPTY_PATIENT_DATA.copy()
            continue

        if faltantes:
            if all(v == "" for k, v in entidades_actuales.items() if k in ["dni", "nombre", "apellido"]):
                nueva_info_normalizada = solicitar_datos_iniciales()
            else:
                campos_faltantes = [f.split(" ")[1] for f in faltantes]
                nueva_info_normalizada = pedir_datos_faltantes(campos_faltantes)

            if nueva_info_normalizada == "CANCELAR":
                return "De acuerdo, cancelando el alta. En cualquier momento puedes pedirme ayuda."
            
            if not nueva_info_normalizada:
                continue


            nuevas_entidades = extract_entities(nueva_info_normalizada)

            for key, value in nuevas_entidades.items():
                if value:
                    print(f"[Create] Fusionando: {key} = {value}")
                    entidades_actuales[key] = value

            continue
        
        confirm = confirmar_entidades(entidades_actuales)

        if confirm is None:
            continue

        if confirm == "CANCELAR":
            return "De acuerdo, cancelando el alta"
        
        if confirm is False:
            speak("Perfecto, reiniciemos los datos.")
            entidades_actuales = EMPTY_PATIENT_DATA.copy()
            continue
        break

    speak("Datos confirmados. Los guardaré en la base de datos. Aguarde por favor")
    print(f"[Alta] Entidades a guardar: {entidades_actuales}")

    ok, msg = ejecutar_alta(entidades_actuales)

    if ok:
        return "Alta completada con éxito. ¿En qué más puedo ayudarte?"
    else:
        return f"No se pudo guardar: {msg}, por favor inténtalo de nuevo o ingresalos manualmente"