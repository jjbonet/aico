from .patient_crud.create import handle_create
from .patient_crud.read import handle_read
from .patient_crud.update import handle_update
from .patient_crud.delete import handle_delete

def state_handler_patient(intent: str, texto_limpio: str) -> str:
    """
    Router de Pacientes (Sub-FSM)
    Deriva la lógica a un handler modular según la intención
    """
    print(f"[Patient Router] Intento recibido: {intent}")
    
    if intent == "agregar":
        return handle_create(texto_limpio)
        
    elif intent == "actualizar":
        return handle_update(texto_limpio)
        
    elif intent == "buscar":
        return handle_read(texto_limpio)
        
    elif intent == "borrar":
        return handle_delete(texto_limpio)
        
    else:
        print(f"Error: Intento de paciente desconocido: {intent}")
        return "Error interno: no reconozco esa acción de paciente"
