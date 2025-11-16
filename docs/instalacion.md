# Guía de Instalación - AICO

## Requisitos del Sistema

### Requisitos Mínimos

- **Navegador Web Moderno**:
  - Google Chrome 90+
  - Mozilla Firefox 88+
  - Safari 14+
  - Microsoft Edge 90+
  
- **Sistema Operativo**: 
  - Windows 10/11
  - macOS 10.15+
  - Linux (cualquier distribución moderna)
  - iOS 14+ / Android 10+ (para dispositivos móviles)

- **Conectividad**:
  - No se requiere conexión a internet para la versión demo
  - Conexión a internet necesaria para versión con backend (futura)

### Requisitos Recomendados

- Pantalla de al menos 1366x768 píxeles para mejor experiencia
- 4 GB de RAM
- Navegador actualizado a la última versión

## Instalación de la Demo

### Opción 1: Ejecución Directa (Más Simple)

1. **Descargar el Repositorio**
   ```bash
   git clone https://github.com/jjbonet/aico.git
   cd aico
   ```

2. **Abrir la Aplicación**
   - Navegar a la carpeta `src/`
   - Hacer doble clic en el archivo `index.html`
   - El sistema se abrirá en tu navegador predeterminado

¡Listo! La aplicación demo está funcionando.

### Opción 2: Usando un Servidor Web Local

Para una experiencia más similar a producción:

#### Usando Python

1. **Abrir terminal/consola**

2. **Navegar a la carpeta src**
   ```bash
   cd aico/src
   ```

3. **Iniciar servidor HTTP**
   
   Para Python 3:
   ```bash
   python -m http.server 8000
   ```
   
   Para Python 2:
   ```bash
   python -m SimpleHTTPServer 8000
   ```

4. **Acceder a la aplicación**
   - Abrir navegador
   - Ir a: `http://localhost:8000`

#### Usando Node.js

1. **Instalar http-server** (solo la primera vez)
   ```bash
   npm install -g http-server
   ```

2. **Navegar a la carpeta src**
   ```bash
   cd aico/src
   ```

3. **Iniciar servidor**
   ```bash
   http-server
   ```

4. **Acceder a la aplicación**
   - Abrir navegador
   - Ir a: `http://localhost:8080`

#### Usando PHP

1. **Navegar a la carpeta src**
   ```bash
   cd aico/src
   ```

2. **Iniciar servidor**
   ```bash
   php -S localhost:8000
   ```

3. **Acceder a la aplicación**
   - Abrir navegador
   - Ir a: `http://localhost:8000`

### Opción 3: Usando Visual Studio Code con Live Server

1. **Instalar VS Code** (si no lo tienes)
   - Descargar de: https://code.visualstudio.com/

2. **Instalar extensión Live Server**
   - Abrir VS Code
   - Ir a extensiones (Ctrl+Shift+X)
   - Buscar "Live Server"
   - Instalar la extensión de Ritwick Dey

3. **Abrir el proyecto**
   - File > Open Folder
   - Seleccionar la carpeta `aico`

4. **Ejecutar Live Server**
   - Abrir `src/index.html`
   - Click derecho > "Open with Live Server"
   - O presionar Alt+L Alt+O

5. **Acceder a la aplicación**
   - Se abrirá automáticamente en tu navegador predeterminado
   - URL típica: `http://127.0.0.1:5500/src/`

## Verificación de la Instalación

Una vez abierta la aplicación, deberías ver:

1. ✅ Encabezado azul con el título "🦷 AICO"
2. ✅ Menú de navegación con 4 botones (Pacientes, Historias Clínicas, Citas, Reportes)
3. ✅ Sección de Pacientes con tarjetas de ejemplo
4. ✅ Funcionalidad de búsqueda operativa
5. ✅ Navegación funcional entre secciones

### Pruebas Básicas

1. **Probar Búsqueda**:
   - En sección "Pacientes"
   - Escribir "Juan" en el campo de búsqueda
   - Debería filtrar y mostrar "Juan Pérez García"

2. **Probar Navegación**:
   - Hacer clic en cada botón del menú
   - Verificar que cambia el contenido

3. **Probar Modal**:
   - Hacer clic en "+ Nuevo Paciente"
   - Debería aparecer un formulario
   - Cerrar con la X

4. **Probar Ver Historial**:
   - En tarjeta de paciente, clic en "Ver Historial"
   - Debería cambiar a sección "Historias Clínicas"

## Solución de Problemas

### Problema: La página no carga correctamente

**Solución**:
- Verificar que todos los archivos estén presentes:
  - `index.html`
  - `styles.css`
  - `script.js`
- Asegurarse de que estén en la misma carpeta
- Limpiar caché del navegador (Ctrl+Shift+Delete)

### Problema: Los estilos no se aplican

**Solución**:
- Verificar que `styles.css` esté en la misma carpeta que `index.html`
- Abrir la consola del navegador (F12) y verificar errores
- Recargar la página con Ctrl+F5 (recarga forzada)

### Problema: La búsqueda no funciona

**Solución**:
- Verificar que `script.js` esté cargado correctamente
- Abrir consola del navegador (F12) y verificar errores de JavaScript
- Asegurarse de que JavaScript esté habilitado en el navegador

### Problema: En móvil no se ve correctamente

**Solución**:
- El diseño es responsive, pero algunos navegadores móviles antiguos pueden tener problemas
- Actualizar el navegador móvil a la última versión
- Rotar el dispositivo (probar orientación horizontal)

## Desinstalación

Para desinstalar, simplemente:
1. Cerrar el navegador/servidor
2. Eliminar la carpeta del proyecto

No se instalan archivos en el sistema ni se modifican configuraciones.

## Actualización

Para actualizar a una nueva versión:

```bash
cd aico
git pull origin main
```

O descargar y reemplazar los archivos manualmente.

## Próximos Pasos

Una vez verificada la instalación:

1. **Revisar la documentación**:
   - `/docs/manual-usuario.md` - Guía de uso
   - `/docs/documentacion-tecnica.md` - Detalles técnicos

2. **Explorar los anexos**:
   - `/anexos/requisitos.md` - Especificación de requisitos
   - `/anexos/casos-de-uso.md` - Casos de uso detallados

3. **Experimentar con la demo**:
   - Probar todas las funcionalidades
   - Navegar por las diferentes secciones
   - Familiarizarse con la interfaz

## Soporte

Para problemas o preguntas:
- Revisar la documentación en `/docs`
- Consultar los anexos en `/anexos`
- Contactar al autor del proyecto

---

**AICO** - Asistente Inteligente para Consultorios Odontológicos  
Trabajo Final de Grado - Javier Bonet  
2025
