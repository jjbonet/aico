# Anexo II - Casos de Uso Detallados

## Trabajo Final de Grado - AICO
**Autor**: Javier Bonet  
**Año**: 2025

---

## Índice de Casos de Uso

1. [Gestión de Pacientes](#1-gestión-de-pacientes)
2. [Gestión de Historias Clínicas](#2-gestión-de-historias-clínicas)
3. [Gestión de Citas](#3-gestión-de-citas)
4. [Reportes y Estadísticas](#4-reportes-y-estadísticas)

---

## 1. Gestión de Pacientes

### CU-01: Registrar Nuevo Paciente

**Actores**: Odontólogo, Personal Administrativo

**Precondiciones**: 
- El usuario ha accedido al sistema
- El usuario está en la sección "Pacientes"

**Flujo Principal**:
1. El usuario hace clic en el botón "+ Nuevo Paciente"
2. El sistema muestra un formulario modal con los campos:
   - Nombre completo (obligatorio)
   - DNI/NIE (obligatorio)
   - Fecha de nacimiento (obligatorio)
   - Teléfono (obligatorio)
   - Email (opcional)
   - Dirección (opcional)
3. El usuario completa los campos requeridos
4. El usuario hace clic en "Guardar Paciente"
5. El sistema valida los datos introducidos
6. El sistema guarda el nuevo paciente
7. El sistema cierra el modal
8. El sistema actualiza la lista de pacientes
9. El sistema muestra un mensaje de confirmación

**Flujos Alternativos**:

**FA-01: Datos incompletos**
- En el paso 5, si faltan datos obligatorios:
  - El sistema resalta los campos incompletos
  - El sistema muestra mensajes de error
  - El flujo continúa en el paso 3

**FA-02: DNI duplicado**
- En el paso 6, si el DNI ya existe:
  - El sistema muestra mensaje "El DNI ya está registrado"
  - El sistema sugiere buscar el paciente existente
  - El flujo continúa en el paso 3

**Postcondiciones**:
- Se ha creado un nuevo registro de paciente
- El paciente aparece en la lista principal
- Se ha creado una historia clínica vacía asociada

---

### CU-02: Buscar Paciente

**Actores**: Odontólogo, Personal Administrativo

**Precondiciones**:
- El usuario está en la sección "Pacientes"
- Existen pacientes registrados

**Flujo Principal**:
1. El usuario hace clic en el campo de búsqueda
2. El usuario escribe el nombre del paciente
3. El sistema filtra la lista en tiempo real
4. El sistema muestra solo los pacientes que coinciden
5. El usuario identifica al paciente buscado

**Flujos Alternativos**:

**FA-01: Sin resultados**
- En el paso 4, si no hay coincidencias:
  - El sistema muestra mensaje "No se encontraron pacientes"
  - El sistema sugiere verificar la ortografía

**Postcondiciones**:
- La lista de pacientes está filtrada según la búsqueda
- El usuario puede ver la información del paciente buscado

---

### CU-03: Ver Historial de Paciente

**Actores**: Odontólogo

**Precondiciones**:
- El paciente está registrado en el sistema
- El usuario está en la sección "Pacientes"

**Flujo Principal**:
1. El usuario localiza la tarjeta del paciente
2. El usuario hace clic en "Ver Historial"
3. El sistema cambia a la sección "Historias Clínicas"
4. El sistema muestra la historia clínica del paciente con:
   - Información general del paciente
   - Alergias registradas
   - Enfermedades previas
   - Listado de tratamientos realizados
   - Próximas citas programadas

**Postcondiciones**:
- El usuario visualiza la historia clínica completa
- El usuario puede revisar todos los tratamientos previos

---

## 2. Gestión de Historias Clínicas

### CU-04: Consultar Historia Clínica

**Actores**: Odontólogo

**Precondiciones**:
- El usuario ha accedido a la historia clínica de un paciente

**Flujo Principal**:
1. El sistema muestra la sección de historia clínica
2. El usuario revisa la información general:
   - Edad del paciente
   - Alergias conocidas
   - Enfermedades previas
3. El usuario revisa los tratamientos recientes
4. El usuario revisa las próximas citas programadas
5. El usuario toma nota de información relevante

**Postcondiciones**:
- El usuario ha revisado la información médica del paciente
- El usuario está informado para la atención actual

---

### CU-05: Registrar Tratamiento (Versión Futura)

**Actores**: Odontólogo

**Precondiciones**:
- El usuario está viendo la historia clínica de un paciente
- Se ha completado un tratamiento

**Flujo Principal**:
1. El usuario hace clic en "Agregar Tratamiento"
2. El sistema muestra formulario con campos:
   - Fecha del tratamiento
   - Tipo de tratamiento
   - Pieza dental (si aplica)
   - Descripción detallada
   - Medicación prescrita
   - Observaciones
3. El usuario completa los campos
4. El usuario guarda el tratamiento
5. El sistema registra el tratamiento
6. El sistema actualiza la historia clínica

**Postcondiciones**:
- El tratamiento queda registrado
- La historia clínica está actualizada

---

## 3. Gestión de Citas

### CU-06: Consultar Agenda del Día

**Actores**: Odontólogo, Personal Administrativo

**Precondiciones**:
- El usuario ha accedido a la sección "Citas"

**Flujo Principal**:
1. El sistema muestra las citas del día actual
2. El sistema organiza las citas cronológicamente
3. Para cada cita, el sistema muestra:
   - Hora programada
   - Nombre del paciente
   - Tipo de tratamiento
   - Estado (Confirmada/Pendiente)
4. El usuario revisa la agenda del día

**Postcondiciones**:
- El usuario conoce la agenda del día
- El usuario puede planificar su jornada

---

### CU-07: Filtrar Citas por Fecha

**Actores**: Odontólogo, Personal Administrativo

**Precondiciones**:
- El usuario está en la sección "Citas"

**Flujo Principal**:
1. El usuario hace clic en el selector de fecha
2. El usuario selecciona una fecha específica
3. El sistema actualiza la lista de citas
4. El sistema muestra solo las citas de la fecha seleccionada
5. El usuario revisa las citas de esa fecha

**Flujos Alternativos**:

**FA-01: Sin citas en la fecha**
- En el paso 4, si no hay citas programadas:
  - El sistema muestra "No hay citas programadas para esta fecha"
  - El sistema sugiere fechas cercanas con citas

**Postcondiciones**:
- Se visualizan las citas de la fecha seleccionada

---

### CU-08: Programar Nueva Cita (Versión Demo)

**Actores**: Personal Administrativo

**Precondiciones**:
- El usuario está en la sección "Citas"
- El paciente está registrado en el sistema

**Flujo Principal**:
1. El usuario hace clic en "+ Nueva Cita"
2. El sistema muestra formulario modal con:
   - Selector de paciente
   - Fecha de la cita
   - Hora de la cita
   - Tipo de tratamiento
   - Duración estimada
   - Notas adicionales
3. El usuario completa los campos
4. El usuario guarda la cita
5. El sistema valida disponibilidad de horario
6. El sistema registra la cita
7. El sistema actualiza el calendario
8. El sistema muestra confirmación

**Flujos Alternativos**:

**FA-01: Conflicto de horario**
- En el paso 5, si hay conflicto:
  - El sistema muestra "Ya existe una cita en ese horario"
  - El sistema sugiere horarios alternativos
  - El flujo continúa en el paso 3

**Postcondiciones**:
- La cita queda programada
- El calendario está actualizado
- El paciente puede recibir confirmación (versión futura)

---

## 4. Reportes y Estadísticas

### CU-09: Visualizar Dashboard

**Actores**: Odontólogo, Administrador

**Precondiciones**:
- El usuario ha accedido a la sección "Reportes"

**Flujo Principal**:
1. El sistema muestra el dashboard con métricas:
   - Total de pacientes registrados
   - Citas programadas en el mes
   - Tratamientos activos
   - Tasa de ocupación del consultorio
2. El sistema muestra gráfico de evolución
3. El usuario analiza las métricas
4. El usuario identifica tendencias

**Postcondiciones**:
- El usuario tiene visión general del consultorio
- El usuario puede tomar decisiones informadas

---

### CU-10: Generar Reporte (Versión Futura)

**Actores**: Odontólogo, Administrador

**Precondiciones**:
- El usuario está en la sección "Reportes"

**Flujo Principal**:
1. El usuario selecciona tipo de reporte:
   - Reporte mensual de pacientes
   - Reporte de tratamientos realizados
   - Reporte financiero
   - Reporte de ocupación
2. El usuario selecciona período de tiempo
3. El usuario hace clic en "Generar Reporte"
4. El sistema procesa los datos
5. El sistema genera el reporte en PDF
6. El sistema descarga el archivo

**Postcondiciones**:
- Se ha generado el reporte solicitado
- El usuario puede imprimir o compartir el reporte

---

## Diagrama de Casos de Uso

```
                    ┌─────────────────┐
                    │   Odontólogo    │
                    └────────┬────────┘
                             │
            ┌────────────────┼────────────────┐
            │                │                │
            ▼                ▼                ▼
    [Gestionar          [Consultar      [Ver Dashboard]
     Pacientes]          Historia
                         Clínica]
            │                │                │
            │                │                │
    ┌───────┴────────┐      │         ┌──────┴──────┐
    │ Personal Admin │      │         │Administrador│
    └───────┬────────┘      │         └──────┬──────┘
            │               │                 │
            ▼               ▼                 ▼
    [Gestionar          [Registrar      [Generar
     Citas]              Tratamiento]    Reportes]
```

---

## Matriz de Trazabilidad

| Caso de Uso | Requisito Funcional | Prioridad |
|-------------|---------------------|-----------|
| CU-01 | RF-01 | Alta |
| CU-02 | RF-01, RF-04 | Alta |
| CU-03 | RF-01, RF-02 | Alta |
| CU-04 | RF-02 | Alta |
| CU-05 | RF-02 | Alta |
| CU-06 | RF-03 | Alta |
| CU-07 | RF-03, RF-04 | Media |
| CU-08 | RF-03 | Alta |
| CU-09 | RF-05 | Media |
| CU-10 | RF-05 | Media |

---

**Documento elaborado por**: Javier Bonet  
**Fecha**: Noviembre 2025  
**Versión**: 1.0
