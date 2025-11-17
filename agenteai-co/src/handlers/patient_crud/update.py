from ...core.data_manager import extract_entities
from ...io.speech import speak

def handle_update(texto_limpio: str) -> str:
    print(f"[Patient CRUD] Iniciando lógica UPDATE (simulada)")
    speak("Iniciando actualización de paciente.")
    
    entidades = extract_entities(texto_limpio)
    dni = entidades.get("dni")
    if not dni:
        speak("Para actualizar, primero dime el DNI del paciente.")
        return "Actualización cancelada: Falta DNI."
    
    speak(f"Ok, paciente DNI {dni}. ¿Qué datos quieres modificar?")
    
    return "Lógica de actualización aún no implementada."