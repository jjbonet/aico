import mysql.connector
from config import DB_CONFIG

SCHEMA_PACIENTES = """
CREATE TABLE IF NOT EXISTS `pacientes` (
  `id_paciente` BIGINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  `dni` VARCHAR(15) UNIQUE NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `apellido` VARCHAR(100) NOT NULL,
  `fecha_nacimiento` DATE NULL,
  `telefono` VARCHAR(30) NULL,
  `email` VARCHAR(150) NULL,
  `obra_social` VARCHAR(120) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
"""

def get_connection():
    """Establece y devuelve una conexión a la BD"""
    try:
        conn = mysql.connector.connect(**DB_CONFIG)
        return conn
    except mysql.connector.Error as err:
        print(f"Error al conectar con la base de datos: {err}")
        return None

def ensure_db():
    """
    Se asegura que la tabla 'pacientes' exista
    Llamado por pipeline.py al iniciar
    """
    conn = get_connection()
    if not conn:
        print("No se pudo asegurar la DB, conexión fallida")
        return

    try:
        cursor = conn.cursor()
        cursor.execute(SCHEMA_PACIENTES)
        print("[DB Ensure] Tabla 'pacientes' verificada/creada con éxito")
    except mysql.connector.Error as err:
        print(f"Error al verificar/crear tabla: {err}")
    finally:
        if conn.is_connected():
            cursor.close()
            conn.close()

def exec_sql(sql: str) -> tuple[bool, str]:
    """
    Ejecuta una sentencia SQL (INSERT, UPDATE, DELETE) 
    y maneja la transacción
    
    Devuelve la tupla (ok, msg) que espera executor.py
    """
    if not sql or sql.startswith("-- ERROR"):
        return False, f"SQL inválido: {sql}"

    conn = None
    try:
        conn = get_connection()
        if not conn:
            return False, "No se pudo conectar a la base de datos"

        cursor = conn.cursor()
        cursor.execute(sql)
        conn.commit()
        return True, "Operación completada con éxito"

    except mysql.connector.Error as err:
        if conn:
            conn.rollback()

        if err.errno == 1062:
            return False, f"Error: Ya existe un paciente con ese DNI. ({err.msg})"
        elif err.errno == 1048:
             return False, f"Error: Un campo obligatorio (como DNI, nombre o apellido) está vacío. ({err.msg})"
        else:
            return False, f"Error de MySQL: {err.msg}"
            
    except Exception as e:
        if conn:
            conn.rollback()
        return False, f"Error inesperado de Python: {str(e)}"

    finally:
        if conn and conn.is_connected():
            cursor.close()
            conn.close()

def fetch_sql(sql: str, params: tuple = None) -> tuple[bool, list[dict] | str]:
    """
    Ejecuta una sentencia SELECT y devuelve los resultados

    Usa un cursor de diccionario para devolver una lista de diccionarios
    Devuelve (True, [lista de resultados]) o (False, "mensaje de error")
    """
    conn = None
    try:
        conn = get_connection()
        if not conn:
            return False, "No se pudo conectar a la base de datos"

        cursor = conn.cursor(dictionary=True) 
        cursor.execute(sql, params)
        resultados = cursor.fetchall()
        
        return True, resultados

    except mysql.connector.Error as err:
        return False, f"Error de MySQL al consultar: {err.msg}"
            
    except Exception as e:
        return False, f"Error inesperado de Python: {str(e)}"

    finally:
        if conn and conn.is_connected():
            cursor.close()
            conn.close()