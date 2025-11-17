import json
import time
import pyttsx3
import sounddevice as sd
from vosk import Model, KaldiRecognizer, SetLogLevel

SetLogLevel(-1)

def speak(text: str):
    """
    Inicializa el motor TTS, habla y lo detiene
    Esto soluciona conflictos con sounddevice al inicializar
    el motor en cada llamada
    """
    try:
        engine = pyttsx3.init()
        engine.setProperty("rate", 150)
        engine.say(text)
        engine.runAndWait()
        
        engine.stop()
        
    except Exception as e:
        print(f"[TTS Speak Error] No se pudo reproducir audio: {e}")


def ask_confirm_voice(
    texto_pregunta: str,
    vosk_model_path: str,
    timeout_sec: int = 6,
    verbose: bool = True
) -> bool:
    """
    Lee un texto por voz y espera confirmación por voz
    """
    # Hablar la pregunta al usuario
    speak(texto_pregunta)

    if verbose:
        print("\n[Confirmación por voz] Decí: 'sí' o 'no'...")

    model = Model(vosk_model_path)
    recognizer = KaldiRecognizer(model, 16000)
    start_time = time.time()
    
    SAMPLE_RATE = 16000
    CHANNELS = 1
    DTYPE = 'int16'
    CHUNK_SIZE = 4096

    try:
        with sd.RawInputStream(
            samplerate=SAMPLE_RATE,
            channels=CHANNELS,
            dtype=DTYPE,
            blocksize=CHUNK_SIZE
        ) as stream:

            while time.time() - start_time < timeout_sec:
                data, overflowed = stream.read(CHUNK_SIZE)
                
                if overflowed and verbose:
                    print("[Advertencia] Overflow de audio detectado.")

                if recognizer.AcceptWaveform(bytes(data)):
                    result = json.loads(recognizer.Result())
                    text = result.get("text", "").lower().strip()

                    if verbose and text:
                        print(f"[Detectado]: {text}")

                    if any(w in text for w in ["si", "sí", "confirmar", "dale", "ok", "okay", "acepto"]):
                        speak("Perfecto, confirmo la acción.")
                        return True

                    if any(w in text for w in ["no", "cancelar", "negativo"]):
                        speak("Cancelado.")
                        return False

    except Exception as e:
        print(f"Ocurrió un error con el stream de audio: {e}")

        return False
    
    speak("No escuché una respuesta. Cancelo la acción.")
    
    return False