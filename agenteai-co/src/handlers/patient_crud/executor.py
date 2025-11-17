from ...core.data_manager import build_sql_from_intent_and_json
from ...services.database import exec_sql
from ...io.speech import speak

def ejecutar_alta(entidades: dict):
    sql = build_sql_from_intent_and_json("agregar", entidades)

    if sql.startswith("-- ERROR"):
        speak("No pude generar el comando de guardado")
        return False, sql

    ok, msg = exec_sql(sql)
    return ok, msg