import sys
import os

sys.path.append(os.path.join(os.path.dirname(__file__), 'src'))
sys.path.append(os.path.join(os.path.dirname(__file__), 'core'))

if __name__ == "__main__":
    from src.pipeline import run_aico_loop

    try:
        run_aico_loop()
    except Exception as e:
        print(f"Ha ocurrido un error fatal en el pipeline: {e}")
