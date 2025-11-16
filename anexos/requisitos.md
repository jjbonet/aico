# Anexo I - Especificación de Requisitos

## Trabajo Final de Grado - AICO
**Autor**: Javier Bonet  
**Año**: 2025

---

## 1. Introducción

### 1.1 Propósito
Este documento describe los requisitos funcionales y no funcionales del sistema AICO (Asistente Inteligente para Consultorios Odontológicos), desarrollado como Trabajo Final de Grado.

### 1.2 Alcance
AICO es un sistema de gestión diseñado para consultorios odontológicos que permite:
- Gestión digital de historias clínicas
- Administración de pacientes
- Programación y seguimiento de citas
- Generación de reportes y estadísticas

### 1.3 Definiciones y Acrónimos
- **AICO**: Asistente Inteligente para Consultorios Odontológicos
- **TFG**: Trabajo Final de Grado
- **HC**: Historia Clínica
- **UI**: User Interface (Interfaz de Usuario)
- **UX**: User Experience (Experiencia de Usuario)

## 2. Descripción General

### 2.1 Perspectiva del Producto
AICO es una aplicación web independiente diseñada para modernizar la gestión de consultorios odontológicos, reemplazando métodos tradicionales en papel por un sistema digital eficiente.

### 2.2 Funciones del Producto
- Registro y gestión de pacientes
- Mantenimiento de historias clínicas digitales
- Sistema de citas y calendario
- Generación de reportes estadísticos
- Panel de control administrativo

### 2.3 Características de Usuario
- **Odontólogos**: Usuarios principales que gestionan pacientes y tratamientos
- **Personal Administrativo**: Usuarios que gestionan citas y pacientes
- **Administradores del Sistema**: Usuarios con acceso completo

### 2.4 Restricciones
- Debe funcionar en navegadores web modernos
- Debe ser responsive (adaptable a diferentes dispositivos)
- Debe mantener la privacidad de datos médicos

## 3. Requisitos Funcionales

### RF-01: Gestión de Pacientes
**Prioridad**: Alta  
**Descripción**: El sistema debe permitir crear, leer, actualizar y eliminar registros de pacientes.

**Criterios de Aceptación**:
- El usuario puede agregar un nuevo paciente con datos básicos
- El usuario puede buscar pacientes por nombre o DNI
- El usuario puede ver la lista completa de pacientes
- El usuario puede editar la información de un paciente existente
- El usuario puede acceder al historial de un paciente

### RF-02: Historias Clínicas
**Prioridad**: Alta  
**Descripción**: El sistema debe mantener un registro completo de la historia clínica de cada paciente.

**Criterios de Aceptación**:
- Cada paciente tiene una historia clínica asociada
- Se registran alergias y enfermedades previas
- Se mantiene un historial de tratamientos realizados
- Se pueden agregar notas y observaciones
- El historial es cronológico y auditable

### RF-03: Sistema de Citas
**Prioridad**: Alta  
**Descripción**: El sistema debe permitir gestionar citas de pacientes.

**Criterios de Aceptación**:
- Se pueden crear nuevas citas con fecha, hora y paciente
- Las citas se visualizan en un calendario
- Se pueden filtrar citas por fecha
- Las citas tienen estados (Confirmada, Pendiente, Cancelada)
- Se evitan conflictos de horarios

### RF-04: Búsqueda y Filtrado
**Prioridad**: Media  
**Descripción**: El sistema debe proporcionar funcionalidades de búsqueda.

**Criterios de Aceptación**:
- Búsqueda de pacientes por nombre
- Filtrado de citas por fecha
- Resultados en tiempo real
- Búsqueda insensible a mayúsculas/minúsculas

### RF-05: Reportes y Estadísticas
**Prioridad**: Media  
**Descripción**: El sistema debe generar reportes y estadísticas del consultorio.

**Criterios de Aceptación**:
- Dashboard con métricas principales
- Contador de pacientes totales
- Estadísticas de citas mensuales
- Indicadores de ocupación
- Visualización de tendencias

## 4. Requisitos No Funcionales

### RNF-01: Usabilidad
- La interfaz debe ser intuitiva y fácil de usar
- El sistema debe ser accesible sin capacitación extensa
- Debe seguir principios de diseño moderno

### RNF-02: Rendimiento
- La aplicación debe cargar en menos de 3 segundos
- Las búsquedas deben responder instantáneamente
- La navegación entre secciones debe ser fluida

### RNF-03: Compatibilidad
- Debe funcionar en Chrome, Firefox, Safari y Edge
- Versiones de navegador de los últimos 2 años
- Responsive para móviles, tablets y escritorio

### RNF-04: Mantenibilidad
- Código limpio y bien documentado
- Separación clara de HTML, CSS y JavaScript
- Uso de estándares web modernos

### RNF-05: Seguridad (para versión de producción)
- Protección de datos sensibles de pacientes
- Cumplimiento con regulaciones de privacidad médica
- Acceso controlado por roles de usuario

## 5. Casos de Uso

### CU-01: Registrar Nuevo Paciente
**Actor**: Odontólogo/Personal Administrativo  
**Flujo Principal**:
1. El usuario hace clic en "Nuevo Paciente"
2. El sistema muestra el formulario de registro
3. El usuario completa los datos del paciente
4. El usuario guarda el registro
5. El sistema confirma el registro exitoso

### CU-02: Consultar Historia Clínica
**Actor**: Odontólogo  
**Flujo Principal**:
1. El usuario busca un paciente
2. El usuario selecciona "Ver Historial"
3. El sistema muestra la historia clínica completa
4. El usuario revisa tratamientos y datos médicos

### CU-03: Programar Cita
**Actor**: Personal Administrativo  
**Flujo Principal**:
1. El usuario accede a la sección de Citas
2. El usuario hace clic en "Nueva Cita"
3. El usuario selecciona paciente, fecha y hora
4. El sistema valida disponibilidad
5. El sistema confirma la cita programada

### CU-04: Generar Reporte
**Actor**: Odontólogo/Administrador  
**Flujo Principal**:
1. El usuario accede a la sección de Reportes
2. El sistema muestra estadísticas actualizadas
3. El usuario puede visualizar métricas clave
4. El usuario puede exportar reportes (versión futura)

## 6. Requisitos de Interfaz

### 6.1 Interfaz de Usuario
- Diseño limpio y profesional
- Paleta de colores azul (profesional y sanitaria)
- Tipografía clara y legible
- Iconos y símbolos significativos
- Feedback visual de las acciones

### 6.2 Interfaz de Hardware
- Dispositivo con navegador web
- Conexión a internet (para versión con backend)
- Pantalla mínima de 320px de ancho

## 7. Restricciones de Diseño

### 7.1 Tecnológicas
- Aplicación web basada en HTML5, CSS3 y JavaScript
- Sin dependencias de frameworks pesados
- Código vanilla para mejor rendimiento

### 7.2 Normativas
- Cumplimiento de estándares web W3C
- Accesibilidad según pautas WCAG (objetivo futuro)
- Protección de datos según GDPR (versión de producción)

## 8. Conclusiones

Esta especificación de requisitos define las funcionalidades principales del sistema AICO en su versión de demostración para el Trabajo Final de Grado. La implementación actual satisface los requisitos funcionales básicos, sentando las bases para futuras mejoras y la transición a un sistema de producción completo.

---

**Documento aprobado por**: Javier Bonet  
**Fecha**: Noviembre 2025  
**Versión**: 1.0
