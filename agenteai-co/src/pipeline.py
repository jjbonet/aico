import time
from enum import Enum, auto

# Módulos de estados principales de Aico
from .handlers.patient_handler import state_handler_patient
from .handlers.chat_handler import state_handler_chat

from .core.preprocessing import normalizar_texto
from .services.database import ensure_db
from .io.speech import speak
from .core.speech_input import listen


# DEFINICIÓN DE ESTADOS
class AicoState(Enum):
    STARTING = auto()
    IDLE = auto()
    HANDLING_PATIENT = auto()
    HANDLING_CHAT = auto()
    HANDLING_CANCEL = auto()
    STOPPING = auto()


# BUCLE PRINCIPAL FSM DE AICO
def run_aico_loop():
    """
    El bucle principal de conversación de Aico, ahora como FSM, este es su corazon
    """
    #ensure_db()
    current_state = AicoState.STARTING
    
    state_context = {
        "intent": None,
        "texto_limpio": None
    }
    print("Iniciando Aico... Presiona Ctrl+C para salir\n")

# Aico puede tener cualquier estado mientras esta despierta, con sopping duerme
    while current_state != AicoState.STOPPING:
        respuesta_aico = "" 
        
        try:
            if current_state == AicoState.STARTING:
                respuesta_aico = "Hola, soy Aico, tu asistente personal"
                current_state = AicoState.IDLE

            elif current_state == AicoState.IDLE:
                texto_usuario = listen()
                if not texto_usuario:
                    continue 

                intent, texto_limpio = normalizar_texto(texto_usuario)
                
                state_context["intent"] = intent
                state_context["texto_limpio"] = texto_limpio
                
                # Asignar siguiente estado segun el intent detectado
                if intent in ["agregar", "actualizar", "buscar", "borrar"]:
                    current_state = AicoState.HANDLING_PATIENT
                elif intent == "cancelar":
                    current_state = AicoState.HANDLING_CANCEL
                else: # Este seria como el estado general
                    current_state = AicoState.HANDLING_CHAT
                continue 
            

            elif current_state == AicoState.HANDLING_PATIENT:
                respuesta_aico = state_handler_patient(
                    state_context["intent"], 
                    state_context["texto_limpio"]
                )
                current_state = AicoState.IDLE

            elif current_state == AicoState.HANDLING_CHAT:
                respuesta_aico = state_handler_chat(
                    state_context["texto_limpio"]
                )
                current_state = AicoState.IDLE

            elif current_state == AicoState.HANDLING_CANCEL:
                respuesta_aico = "De acuerdo"
                current_state = AicoState.IDLE

            if respuesta_aico:
                print(f"[Aico] {respuesta_aico}\n")
                speak(respuesta_aico)

            time.sleep(0.1)

        except KeyboardInterrupt:
            current_state = AicoState.STOPPING 

        except Exception as e:
            print(f"Ha ocurrido un error fatal en el estado {current_state}: {e}")
            respuesta_aico = "He encontrado un error interno y debo reiniciarme"
            speak(respuesta_aico)
            current_state = AicoState.IDLE 

    print("\nHasta luego!")
    time.sleep(0.1) 
    speak("Hasta luego")