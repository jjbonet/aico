# Documentación Técnica - AICO

## Arquitectura del Sistema

AICO está construido como una aplicación web de demostración que ilustra las funcionalidades principales de un sistema de gestión para consultorios odontológicos.

### Componentes Principales

1. **Frontend Web**
   - HTML5 para la estructura
   - CSS3 con variables personalizadas para el diseño
   - JavaScript vanilla para la interactividad
   - Diseño responsive adaptable a diferentes dispositivos

2. **Características Implementadas**
   - Gestión de pacientes
   - Visualización de historias clínicas
   - Sistema de citas
   - Dashboard con reportes y estadísticas

### Tecnologías Utilizadas

- **HTML5**: Estructura semántica de la aplicación
- **CSS3**: Estilos modernos con CSS Grid y Flexbox
- **JavaScript (ES6+)**: Lógica de la aplicación y gestión de eventos
- **Diseño Responsive**: Adaptable a móviles, tablets y escritorio

## Estructura de Archivos

```
src/
├── index.html      # Página principal de la aplicación
├── styles.css      # Estilos globales de la aplicación
└── script.js       # Lógica y funcionalidad de la aplicación
```

## Funcionalidades Implementadas

### 1. Gestión de Pacientes
- Listado de pacientes con información básica
- Búsqueda de pacientes por nombre
- Modal para agregar nuevos pacientes (demo)
- Acceso rápido al historial de cada paciente

### 2. Historias Clínicas
- Visualización detallada de historias clínicas
- Información del paciente (alergias, enfermedades previas)
- Registro de tratamientos realizados
- Visualización de próximas citas

### 3. Sistema de Citas
- Visualización de citas por fecha
- Estado de las citas (Confirmada/Pendiente)
- Organización cronológica
- Filtro por fecha

### 4. Reportes y Estadísticas
- Métricas principales del consultorio
- Estadísticas visuales
- Panel de control con indicadores clave

## Instalación y Uso

### Requisitos
- Navegador web moderno (Chrome, Firefox, Safari, Edge)
- No requiere instalación de dependencias adicionales

### Ejecución
1. Abrir el archivo `src/index.html` en un navegador web
2. También puede ser servido mediante un servidor web local:
   ```bash
   # Usando Python
   cd src
   python -m http.server 8000
   
   # Usando Node.js
   cd src
   npx http-server
   ```
3. Acceder a `http://localhost:8000` en el navegador

## Consideraciones de Diseño

### Interfaz de Usuario
- Diseño limpio y moderno
- Paleta de colores profesional (azules)
- Iconos y emojis para mejor UX
- Transiciones suaves entre estados

### Experiencia de Usuario
- Navegación intuitiva mediante pestañas
- Feedback visual en interacciones
- Diseño responsive para todos los dispositivos
- Accesibilidad considerada en contraste de colores

### Escalabilidad
Esta demostración está diseñada para ser extendida con:
- Backend con API RESTful
- Base de datos (PostgreSQL, MySQL)
- Autenticación y autorización
- Almacenamiento de archivos para radiografías
- Integración con sistemas de facturación

## Limitaciones de la Demo

Esta es una versión de demostración con las siguientes limitaciones:
- Los datos son estáticos y no se persisten
- No incluye backend ni base de datos
- Las funcionalidades son simuladas
- No implementa seguridad real
- No incluye validaciones completas de formularios

## Próximas Mejoras Planificadas

1. Implementación de backend con Node.js/Express
2. Base de datos para persistencia de datos
3. Sistema de autenticación de usuarios
4. Carga de archivos (radiografías, documentos)
5. Generación real de reportes en PDF
6. Notificaciones automáticas de citas
7. Integración con sistema de facturación

## Soporte y Contacto

**Autor**: Javier Bonet  
**Proyecto**: Trabajo Final de Grado  
**Año**: 2025
