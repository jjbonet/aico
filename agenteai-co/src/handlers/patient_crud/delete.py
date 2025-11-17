import os
from ...core.data_manager import extract_entities, build_sql_from_intent_and_json
from ...core.preprocessing import normalizar_texto
from ...io.speech import speak, ask_confirm_voice
from ...core.speech_input import listen
from ...services.database import exec_sql

def handle_delete(texto_limpio: str) -> str:
    """
    Maneja el flujo de BORRADO (lógica simple).
    """
    print(f"[Patient CRUD] Iniciando lógica DELETE")
    speak("Iniciando protocolo de borrado de paciente")
    
    entidades = extract_entities(texto_limpio)
    dni = entidades.get("dni")

    while not dni:
        speak("Para borrar, necesito el DNI. Por favor, dímelo o di 'cancelar'")
        info_dni = listen()
        if not info_dni: continue
        
        intent_dni, texto_dni = normalizar_texto(info_dni)
        if intent_dni == "cancelar":
            return "Borrado cancelado."
        
        entidades_dni = extract_entities(texto_dni)
        dni = entidades_dni.get("dni")

    print(f"[DELETE] DNI detectado: {dni}")
    
    vosk_path = os.path.join(os.path.dirname(__file__), "../../../models/voiceRecognition/vosk-model-small-es-0.42")

    confirmado = ask_confirm_voice(
        texto_pregunta=f"ADVERTENCIA: Vas a borrar al paciente con DNI {dni}. Esta acción no se puede deshacer. ¿Desea confirmar?",
        vosk_model_path=vosk_path,
        timeout_sec=8
    )

    if not confirmado:
        return "Operación de borrado cancelada"

    speak("Confirmado. Procesando borrado")
    entidades_finales = {"dni": dni}
    
    sql = build_sql_from_intent_and_json("borrar", entidades_finales)
    print(f"SQL Generado: {sql}")

    if sql.startswith("-- ERROR"):
         return f"No se pudo generar el SQL de borrado: {sql}"

    ok, msg = exec_sql(sql)
    if ok:
        return "Operación (Borrado) completada con éxito"
    else:
        return f"Hubo un problema al ejecutar el borrado: {msg}"