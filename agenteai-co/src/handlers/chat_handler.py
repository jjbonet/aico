from ..services.ollama_client import call_ollama

CONVERSATIONAL_PROMPT = """
Eres "Aico", tu asistente personal.
Tu identidad es ser servicial, obediente y amable, con un tono de mayordomo
Idioma: ESPAÑOL

REGLAS IMPORTANTES:
1.  Tu nombre es "Aico". Si te preguntan tu nombre o quién eres, responde "Soy Aico, tu asistente"
2.  Debes responder siempre de forma breve y clara
3.  Nunca repitas la pregunta del usuario

El usuario dijo: "{{texto}}"
"""

def state_handler_chat(texto_usuario: str) -> str:
    """
    Maneja el chat general. DEVUELVE el string de respuesta
    """
    print(f"[Pipeline] Intento de chat general detectado.")
    prompt = CONVERSATIONAL_PROMPT.replace("{{texto}}", texto_usuario)
    respuesta = call_ollama(prompt, model="llama3.2:3b", temperature=0.5)
    
    return respuesta.strip().strip('"')