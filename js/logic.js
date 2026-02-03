document.addEventListener('DOMContentLoaded', () => {

    // ---------------------------------------------------------
    // 1. LÓGICA DE SESIÓN DE USUARIO (Mejorada con traducciones)
    // ---------------------------------------------------------
    fetch('api/check_session.php')
        .then(response => {
            if (!response.ok) {
                // Si falla (ej: 404), no pasa nada, seguimos como invitado
                return { logged_in: false };
            }
            return response.json();
        })
        .then(data => {
            if (data.logged_in) {
                // Si el usuario está logueado, actualizamos la barra de navegación
                updateNavForUser(data.user || { nombre: data.nombre });
            }
        })
        .catch(error => console.error('Estado de sesión: Invitado (o error):', error));


    // ---------------------------------------------------------
    // 2. LÓGICA DEL FORMULARIO DE CONTACTO (TU CÓDIGO ORIGINAL)
    // ---------------------------------------------------------
    const botonEnviar = document.querySelector('.btn-submit');

    // Solo ejecutamos esto si existe el botón (para evitar errores en otras páginas)
    if (botonEnviar) {
        botonEnviar.addEventListener('click', async (e) => {
            // Verificamos si es el formulario de contacto real revisando si hay inputs
            const inputNombre = document.querySelector('input[name="nombre"]') || document.querySelector('input');

            // Si es un botón decorativo (como en planes), no interceptamos el click
            if (!inputNombre) return;

            e.preventDefault();

            const inputEmail = document.querySelector('input[type="email"]');
            const inputMensaje = document.querySelector('textarea');

            const datos = {
                nombre: inputNombre.value,
                email: inputEmail ? inputEmail.value : '',
                mensaje: inputMensaje ? inputMensaje.value : ''
            };

            const textoOriginal = botonEnviar.innerHTML;

            // Texto de carga (podríamos traducirlo también, pero por ahora lo dejamos simple)
            botonEnviar.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> ...';
            botonEnviar.disabled = true;

            try {
                const respuesta = await fetch('api/procesar_contacto.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(datos)
                });

                const resultado = await respuesta.json();

                if (resultado.estado === 'exito') {
                    alert('Registro completado: ' + resultado.mensaje);
                    document.querySelectorAll('.form-input').forEach(i => i.value = '');
                } else {
                    alert('Error: ' + resultado.mensaje);
                }
            } catch (error) {
                console.error(error);
                alert('Error de conexión con el servidor.');
            } finally {
                botonEnviar.innerHTML = textoOriginal;
                botonEnviar.disabled = false;
            }
        });
    }

    // Listener global para el logout (porque el botón se crea dinámicamente)
    document.addEventListener('click', (e) => {
        if (e.target.closest('#logout-btn')) {
            e.preventDefault();
            fetch('api/logout.php')
                .then(() => window.location.href = 'index.html')
                .catch(err => console.error(err));
        }
    });
});

// ---------------------------------------------------------
// 3. FUNCIONES PARA CAMBIAR EL MENÚ (CON TRADUCCIÓN)
// ---------------------------------------------------------
function updateNavForUser(usuario) {
    // 1. Buscamos los botones de Login/Registro
    const loginLink = document.querySelector('a[data-i18n="nav_item_login"]') || document.querySelector('a[href="login.html"]');
    const registerLink = document.querySelector('a[data-i18n="nav_item_register"]') || document.querySelector('a[href="registro.html"]');

    // 2. Ocultamos el botón de Iniciar Sesión (mejor ocultar que borrar para evitar saltos)
    if (loginLink && loginLink.parentElement) {
        loginLink.parentElement.style.display = 'none';
    }

    // 3. Usamos el contenedor del botón "Registrarse" para poner el menú
    if (registerLink && registerLink.parentElement) {
        const liPadre = registerLink.parentElement;

        // Limpiamos el contenido actual (el botón de registro)
        liPadre.innerHTML = '';
        liPadre.className = 'user-menu-wrapper'; // Clase para CSS si la necesitas

        // --- PREPARAR TRADUCCIONES ---
        const currentLang = localStorage.getItem('selectedLang') || 'es';
        let t = {};
        // Intentamos cargar las traducciones si el archivo translations.js ya cargó
        if (typeof translations !== 'undefined') {
            t = translations[currentLang] || translations['es'] || {};
        }

        // Textos por defecto por si falla la carga
        const txtProfile = t.menu_profile || "Mi Perfil";
        const txtConfig = t.menu_config || "Configuración";
        const txtLogout = t.menu_logout || "Cerrar Sesión";
        const nombreMostrar = usuario.nombre || "Usuario";

        // 4. CREAR EL HTML DEL MENÚ
        // Usamos la estructura que tenías antes para no romper estilos
        const container = document.createElement('div');
        container.className = 'user-menu-container'; // Asegúrate de tener estilos para esto

        container.innerHTML = `
            <a href="#" class="user-toggle" onclick="toggleUserMenu(event)">
                <i class='bx bxs-user-circle'></i> ${nombreMostrar} <i class='bx bx-chevron-down'></i>
            </a>
            <div class="user-dropdown" id="userDropdown">
                <a href="perfil.php"><i class='bx bx-id-card'></i> ${txtProfile}</a>
                <a href="configuracion.php"><i class='bx bx-cog'></i> ${txtConfig}</a>
                <a href="#" id="logout-btn" style="color: #ff6b6b;"><i class='bx bx-log-out'></i> ${txtLogout}</a>
            </div>
        `;

        liPadre.appendChild(container);
    }
}

function toggleUserMenu(e) {
    e.preventDefault();
    const menu = document.getElementById('userDropdown');
    if (menu) {
        menu.classList.toggle('show');

        // Cerrar al hacer click fuera (solo se activa una vez)
        const closeMenu = (event) => {
            if (!event.target.closest('.user-menu-container')) {
                menu.classList.remove('show');
                document.removeEventListener('click', closeMenu);
            }
        };

        // Pequeño timeout para que el click actual no cierre el menú inmediatamente
        setTimeout(() => {
            document.addEventListener('click', closeMenu);
        }, 10);
    }
}