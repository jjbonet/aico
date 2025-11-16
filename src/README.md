# Código Fuente - AICO Demo

Esta carpeta contiene el código fuente de la aplicación de demostración AICO.

## Estructura de Archivos

```
src/
├── index.html      # Página principal de la aplicación
├── styles.css      # Estilos y diseño de la interfaz
├── script.js       # Lógica y funcionalidad JavaScript
└── README.md       # Este archivo
```

## Descripción de Archivos

### index.html
Contiene la estructura completa de la aplicación web:
- Cabecera con título y branding
- Menú de navegación
- Secciones principales:
  - Gestión de Pacientes
  - Historias Clínicas
  - Sistema de Citas
  - Reportes y Estadísticas
- Modales para formularios
- Footer con información del proyecto

### styles.css
Define todos los estilos visuales de la aplicación:
- Variables CSS para colores y diseño consistente
- Estilos responsive para diferentes dispositivos
- Diseño de tarjetas y componentes
- Animaciones y transiciones
- Diseño de formularios y modales

### script.js
Implementa toda la funcionalidad interactiva:
- Navegación entre secciones
- Gestión de modales
- Funcionalidad de búsqueda en tiempo real
- Manejo de eventos
- Validaciones básicas

## Ejecución

Para ejecutar la aplicación:

1. **Método Simple**: Abrir `index.html` directamente en un navegador

2. **Con Servidor Local**: 
   ```bash
   python -m http.server 8000
   # Luego abrir http://localhost:8000
   ```

Ver `/docs/instalacion.md` para más opciones de ejecución.

## Tecnologías Utilizadas

- **HTML5**: Estructura semántica
- **CSS3**: Diseño moderno y responsive
- **JavaScript (Vanilla)**: Sin dependencias externas

## Características Técnicas

### Responsive Design
- Diseño adaptable a móviles, tablets y escritorio
- Breakpoints definidos en CSS
- Grid y Flexbox para layouts flexibles

### Accesibilidad
- Estructura semántica HTML
- Contraste de colores adecuado
- Navegación por teclado

### Performance
- Sin dependencias de bibliotecas externas
- Código optimizado
- Carga rápida

## Limitaciones de la Demo

Esta es una versión de demostración con las siguientes características:

✅ **Implementado**:
- Interfaz completa y funcional
- Navegación entre secciones
- Búsqueda de pacientes
- Visualización de datos de ejemplo
- Diseño responsive

❌ **No implementado** (requiere backend):
- Persistencia de datos
- Base de datos
- Autenticación de usuarios
- Guardado real de formularios
- Generación de PDFs

## Personalización

### Cambiar Colores
Editar variables CSS en `styles.css`:
```css
:root {
    --primary-color: #2563eb;  /* Color principal */
    --secondary-color: #0ea5e9; /* Color secundario */
    /* ... otras variables */
}
```

### Agregar Datos de Ejemplo
Modificar el HTML en `index.html` en las secciones correspondientes o extender `script.js` para cargar datos dinámicamente.

### Extender Funcionalidad
Agregar funciones en `script.js` siguiendo el patrón existente.

## Mejoras Futuras

Para convertir esta demo en una aplicación de producción:

1. **Backend**:
   - API REST con Node.js/Express o similar
   - Base de datos (PostgreSQL, MySQL)
   - Autenticación JWT

2. **Frontend**:
   - Framework (React, Vue, Angular)
   - State management
   - Validaciones completas

3. **Características**:
   - Sistema de usuarios y roles
   - Carga de archivos (radiografías)
   - Generación de reportes PDF
   - Notificaciones por email/SMS
   - Calendario interactivo

## Licencia

Este código es parte del Trabajo Final de Grado de Javier Bonet (2025).

## Contacto

Para consultas sobre el código:
- Ver documentación en `/docs`
- Revisar especificaciones en `/anexos`

---

**Desarrollado para el Trabajo Final de Grado - 2025**
