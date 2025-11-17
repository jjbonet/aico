# Aico - Asistente de Voz para Gestión de Datos

Aico es un asistente interactivo operado por voz, diseñado para la manipulación de una base de datos de pacientes. El sistema emplea reconocimiento de voz (STT), un motor de procesamiento de lenguaje local y síntesis de voz (TTS) para permitir a los usuarios gestionar registros mediante comandos de voz.

El sistema está diseñado para interpretar intenciones (ej. agregar, actualizar, buscar pacientes) y extraer entidades clave (DNI, nombre, apellido) del comando de voz. Esta información se utiliza para generar y ejecutar sentencias SQL parametrizadas.

## Características Principales

- **Interfaz Operada por Voz:** Interacción completa mediante reconocimiento (STT) y síntesis (TTS).
- **Interpretación de Comandos:** Utiliza un motor de procesamiento local (vía Ollama) para el análisis semántico y la extracción de entidades.
- **Generación de SQL:** Traduce la intención y los datos extraídos en sentencias SQL (INSERT, UPDATE) para una base de datos MySQL.
- **Arquitectura Modular (FSM):** Un bucle principal basado en una Máquina de Estados Finitos (`pipeline.py`) que delega tareas a _handlers_ específicos (para diálogo general, gestión de pacientes, etc.).
- **Protocolo de Confirmación:** Implementa rutinas de validación de datos y confirmación explícita por voz para garantizar la integridad de las operaciones de base de datos (Data Integrity).
- **Modo Simulación:** Incluye un simulador de base de datos (`database.py`) para probar el pipeline completo sin una conexión de BD real.

## Arquitectura y Tecnologías

Este proyecto está construido sobre una arquitectura modular, desacoplando los componentes de E/S de audio, el procesamiento de lenguaje y la lógica de negocio.

- **Python 3.10+**
- **Reconocimiento de Voz (STT):** `Vosk`
- **Síntesis de Voz (TTS):** `pyttsx3`
- **Manejo de Audio:** `sounddevice`
- **Procesamiento de Lenguaje:** `Ollama` (compatible con modelos de inferencia como `llama3.1`, `phi3`, etc.)
- **Base de Datos:** `mysql-connector-python` (para modo real)
- **Comunicación con el Motor (Ollama):** `requests`

## Instalación

Siga los siguientes pasos para desplegar el proyecto en un entorno local.

### 1. Prerrequisitos

- **Python 3.10** o superior.
- **Ollama** instalado y ejecutándose. (Puede descargarlo desde [ollama.com](https://ollama.com/))
- Un servidor de base de datos **MySQL** (solo si no se utiliza el modo simulación).
- Un **micrófono** y **altavoces** funcionales.

### 2. Configuración del Proyecto

1.  **Clone el repositorio:**

    ```bash
    git clone [https://github.com/tu-usuario/tu-repositorio.git](https://github.com/tu-usuario/tu-repositorio.git)
    cd tu-repositorio
    ```

2.  **Cree un entorno virtual:**

    ```bash
    python -m venv venv
    ```

3.  **Active el entorno virtual:**

    - En Windows: `.\venv\Scripts\activate`
    - En macOS/Linux: `source venv/bin/activate`

4.  **Instale las dependencias:**
    ```bash
    pip install -r requirements.txt
    ```

### 3. Configuración de Componentes y Servicios

1.  **Modelo Vosk (STT):**

    - Descargue un modelo de reconocimiento de voz de Vosk (ej. `vosk-model-small-es-0.42`).
    - Descomprímalo y colóquelo en la carpeta `models/voiceRecognition/`.
    - Asegúrese de que la ruta en `pipeline.py` (o su módulo de configuración) apunte a esta carpeta.

2.  **Motor de Procesamiento (Ollama):**

    - Asegúrese de que Ollama esté ejecutándose en segundo plano.
    - Descargue el modelo de lenguaje que se utilizará (el código está optimizado para `llama3.1`):
      ```bash
      ollama pull llama3.1
      ```
    - Verifique que la `OLLAMA_URL` en `ollama_client.py` (`http://localhost:11434`) sea correcta.

3.  **Base de Datos (MySQL):**
    - Abra `src/services/database.py`.
    - Por defecto, `SIMULATION_MODE = True`. El sistema funcionará sin una base de datos real.
    - Para conectar a una BD real, cambie `SIMULATION_MODE = False` y complete las credenciales `MYSQL_HOST`, `MYSQL_USER`, `MYSQL_PASS`, y `MYSQL_DB`.

## Ejecución

Una vez que todos los servicios (Ollama) y dependencias estén configurados, puede iniciar el sistema.

1.  Asegúrese de que su entorno virtual esté activado.
2.  Ejecute el punto de entrada principal:

    ```bash
    python main.py
    ```

3.  El sistema se inicializará, emitirá una señal auditiva de disponibilidad y quedará a la espera de comandos de voz.
4.  Para detener el asistente, presione `Ctrl+C` en la terminal.
