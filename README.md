## 🚀 Actualización del Frontend (v1.0)

Se ha implementado la estructura web inicial del proyecto **SecurityShield**, estableciendo la identidad visual y las páginas principales de navegación pública.

### 📋 Cambios Realizados
* **Diseño Visual (UI/UX):**
    * Implementación de hoja de estilos (`style.css`) con temática *Cyber-Secure* (modo oscuro, paleta neón cian/púrpura).
    * Diseño **Glassmorphism** para tarjetas y contenedores.
    * Navegación totalmente **responsiva** con menú móvil.

* **Estructura de Páginas:**
    1.  **Inicio (`index.html`):** Landing page con la propuesta de valor "Defensa en Profundidad" y resumen de características (Nmap, AppArmor, SSH).
    2.  **Planes (`planes.html`):** Tabla de precios interactiva diferenciando entre "Plan Personal" (Gratis/Auditoría básica) y "Plan Empresarial" (Defensa completa).
    3.  **Contacto (`contacto.html`):** Sección con información del equipo (Roles Red Team/Blue Team) y formulario de contacto.
    4.  **Login (`login.html`):** Interfaz de acceso restringido para el "Cyber Range".

### 🛠️ Tecnologías
* HTML5 Semántico
* CSS3 (Variables, Flexbox, Grid, Backdrop-filter)
* Boxicons (Iconografía)
Entendido. Aquí tienes la documentación de las siguientes versiones (v1.1, v1.2 y v1.3) replicando exactamente el formato del README.md que subiste (v1.0), usando los mismos emojis, estructura de listas y estilo de redacción técnico.

## ⚙️ Backend Core & Persistencia (v1.1)
Se ha desarrollado la lógica del servidor para permitir el almacenamiento persistente de datos sin base de datos SQL, utilizando un sistema de archivos JSON securizado.

### 📋 Cambios Realizados
Motor de Persistencia (classes/JsonHandler.php):
Implementación de clase reutilizable para lectura/escritura en data/.
Uso de bloqueo de archivos (flock) para evitar condiciones de carrera en escrituras simultáneas.
Gestión automática de creación de directorios y estructuras vacías.
Configuración Inicial:
Setup (api/setup.php): Script de instalación que genera el usuario administrador inicial.
Seguridad: Hashing de contraseñas con Bcrypt (password_hash) y protección de la carpeta data/ mediante .htaccess (Require all denied).

### 🛠️ Tecnologías
PHP 7.4+ (POO, Streams, JSON)
Apache (.htaccess Security)

## 📡 API de Contacto Asíncrona (v1.2)
Se ha dotado de interactividad al formulario de contacto, conectando el frontend con el backend mediante peticiones asíncronas para una experiencia de usuario fluida.

### 📋 Cambios Realizados
Lógica Cliente (js/logic.js):

Interceptación del evento submit para prevenir la recarga de la página.
Comunicación asíncrona mediante Fetch API enviando payloads JSON.
Feedback visual de estado (Loading/Éxito/Error) en el botón de envío.
Endpoint de Procesamiento (api/procesar_contacto.php):
Recepción de datos crudos (php://input) desde el frontend.
Validación de campos y almacenamiento en registros.json usando el JsonHandler.

### 🛠️ Tecnologías
JavaScript ES6+ (Fetch, Async/Await)
PHP (Input Streams)
JSON

## 🔐 Autenticación & Dashboard (v1.3)
Implementación del "Cyber Range" (área de administración), asegurando el acceso a los datos mediante un sistema de login y sesiones controladas.

### 📋 Cambios Realizados
Sistema de Acceso (api/login.php):
Verificación de credenciales segura mediante password_verify().
Gestión de sesiones de usuario con session_start().
Panel de Control (dashboard.php):
Protección de Ruta: Redirección automática al login si no existe sesión activa.
Visualización: Tabla dinámica que lista los mensajes recibidos desde registros.json.
UI Funcional: Bienvenida personalizada al usuario y botón de cierre de sesión.

### 🛠️ Tecnologías
PHP Sessions
HTML Dinámico
CSS Glassmorphism (Reutilizado)

## 🌍 Internacionalización y Mejoras de UX (v1.4)
*Actualización enfocada en la accesibilidad, el alcance en redes y la experiencia de usuario global.*

### 📦 Commits y Cambios Detallados

#### 1. `feat(i18n): Implement multi-language support system`
Se ha desarrollado un motor de traducción propio en Vanilla JS (`js/translations.js`) sin dependencias externas.
* **Diccionario JSON:** Soporte nativo para Español (ES), Inglés (EN), Catalán (CA) y Euskera (EU).
* **Persistencia:** Uso de `localStorage` para recordar la preferencia de idioma del usuario entre visitas.
* **Detección de Fallos:** Implementación de bloques `try-catch` para evitar bloqueos en navegadores privados (Incógnito/Instagram) que restringen el acceso al almacenamiento local.

#### 2. `feat(seo): Add Open Graph and Twitter Cards metadata`
Optimización completa para compartir enlaces en redes sociales y aplicaciones de mensajería.
* **Social Preview:** Generación e integración de `social-preview.jpg` para mostrar una tarjeta visual atractiva al compartir enlaces.
* **Meta Tags:** Configuración de etiquetas `og:title`, `og:description` y `og:image` dinámicas según la vista (Inicio, Planes, Registro).
* **Schema.org:** Inyección de JSON-LD para mejorar la indexación del logotipo y la organización en Google Search.

#### 3. `fix(ui): Integrate language selector in Auth & Dashboard panels`
Corrección de la interfaz de usuario en las áreas privadas (`dashboard.php` y `client_panel.php`) y de registro.
* **Unificación UI:** Inserción del selector de idioma alineado junto al botón de "Cerrar Sesión" o "Salir".
* **Hot-Fix CSS:** Ajuste de márgenes (`margin: 0`) en los selectores dentro de los headers para mantener la alineación vertical correcta en pantallas de escritorio.

#### 4. `style(footer): Update footer with corporate contact info`
Estandarización del pie de página en toda la plataforma.
* **Acceso Directo:** Implementación de enlace `mailto:contact@securityshield.es` para abrir el cliente de correo predeterminado del usuario.
* **Consistencia:** Despliegue del nuevo footer en vistas estáticas (`html`) y dinámicas (`php`), asegurando que la información legal y de contacto esté siempre visible.
