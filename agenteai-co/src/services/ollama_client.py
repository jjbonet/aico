import requests
import json

# Endpoint local de Ollama
OLLAMA_URL = "http://localhost:11434/api/chat"


    # Aca se puede cambiar el modelo estandar o parámetros si se quiere
def call_ollama(prompt: str, model: str = "llama3.2:3b", temperature: float = 0.0) -> str:
    """
    Envía un prompt al endpoint /api/chat de Ollama y devuelve la respuesta
    """
    
    payload = {
        "model": model,
        "messages": [
            {
                "role": "user",
                "content": prompt
            }
        ],
        "temperature": temperature,
        "stream": False,
    }

    try:
        response = requests.post(OLLAMA_URL, json=payload, timeout=60)
        response.raise_for_status() 
        data = response.json()

        if "message" in data and "content" in data["message"]:
            return data["message"]["content"].strip()
        
        else:
            print("[Ollama Client Error] Respuesta JSON inesperada:", data)
            return ""

    except requests.exceptions.ConnectionError:
        print(f"\n[Ollama Client Error] No se pudo conectar a Ollama en {OLLAMA_URL}")
        print("Asegúrese de que Ollama esté ejecutándose")
        return ""
    
    except requests.exceptions.RequestException as e:
        print(f"[Ollama Client Error] Error en la solicitud: {e}")
        return ""
    
    except json.JSONDecodeError:
        print("[Ollama Client Error] No se pudo decodificar la respuesta JSON")
        return ""