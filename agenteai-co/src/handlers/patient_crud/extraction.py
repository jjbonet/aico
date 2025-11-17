from ...core.data_manager import extract_entities
from ...core.validation import validate_local

def extract_and_validate(contexto: str):
    """
    Extrae entidades desde texto y ejecuta validación local
    Retorna:
      entidades: dict
      faltantes: lista de campos faltantes
      invalidos: lista de errores no relacionados con faltantes
    """
    entidades = extract_entities(contexto)
    errores = validate_local(entidades)

    faltantes = [e for e in errores if "Falta" in e]
    invalidos = [e for e in errores if "Falta" not in e]

    return entidades, faltantes, invalidos