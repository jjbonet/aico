import json
import os
import sounddevice as sd
from vosk import Model, KaldiRecognizer, SetLogLevel

SetLogLevel(-1)

# Configuración de Vosk
script_dir = os.path.dirname(os.path.abspath(__file__))
VOSK_MODEL = os.path.join(script_dir, "../../models/voiceRecognition/vosk-model-es-0.42")
RATE = 16000
CHANNELS = 1
DTYPE = 'int16'
CHUNK = 4096

class AicoListener:
    """
    Clase que encapsula el reconocedor de voz Vosk y el stream de audio
    """
    def __init__(self, model_path=VOSK_MODEL):
        try:
            self.model = Model(model_path)
        except Exception as e:
            print(f"Error al cargar el modelo Vosk desde {model_path}: {e}")
            raise

        vocabulario = '["aico", "dni", "obra", "social", "paciente", "agregar", "borrar"]'
        self.recognizer = KaldiRecognizer(self.model, RATE, vocabulario)
        self.stream = None

    def listen_for_command(self, verbose=True) -> str:
        """
        Abre el stream, escucha hasta detectar una frase y la devuelve
        """
        if verbose:
            print("[Escuchando...]")

        with sd.RawInputStream(
            samplerate=RATE,
            channels=CHANNELS,
            dtype=DTYPE,
            blocksize=CHUNK
        ) as stream:
            
            while True:
                data, overflowed = stream.read(CHUNK)
                if overflowed:
                    print("[Advertencia] Overflow de audio detectado")

                if self.recognizer.AcceptWaveform(bytes(data)):
                    res = json.loads(self.recognizer.Result())
                    texto = res.get("text", "").strip()
                    
                    if texto:
                        if verbose:
                            print(f"[Transcripción]: {texto}")
                        return texto
                
try:
    _global_listener = AicoListener(model_path=VOSK_MODEL)
except Exception as e:
    print("Error fatal al inicializar AicoListener. El programa no puede continuar")
    _global_listener = None

def listen() -> str:
    """Función pública para acceder al listener desde cualquier parte del código"""
    if _global_listener:
        return _global_listener.listen_for_command()
    else:
        print("Error: Actualmente no puedo escuchar porque hay un conflicto en el listener global")
        return ''