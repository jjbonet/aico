import re

def validate_local(paciente: dict) -> list[str]:
    """
    Valida los datos extraídos contra las reglas de negocio
    definidas por el esquema de la BD (NOT NULL, formatos).
    
    Esta función es rápida y se ejecuta localmente.
    """
    errores = []
    
    dni = paciente.get("dni", "").strip()
    if not dni:
        errores.append("Falta DNI (campo obligatorio)")
    else:
        if not (len(dni) == 8):
            print(f"[Validation] DNI recibido para validación: '{dni}'")
            errores.append(f"DNI '{dni}' parece inválido (longitud incorrecta)")

    if not paciente.get("nombre", "").strip():
        errores.append("Falta nombre (campo obligatorio)")

    if not paciente.get("apellido", "").strip():
        errores.append("Falta apellido (campo obligatorio)")
    
    email = paciente.get("email", "").strip()
    if email:
        if not re.match(r"[^@]+@[^@]+\.[^@]+", email):
            errores.append(f"Email '{email}' no parece tener un formato válido")

    fecha_nac = paciente.get("fecha_nacimiento", "").strip()
    if fecha_nac:
        if not re.match(r"^\d{4}-\d{2}-\d{2}$", fecha_nac):
            errores.append(f"Fecha de nacimiento '{fecha_nac}' no está en formato AAAA-MM-DD")

    return errores