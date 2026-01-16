document.addEventListener('DOMContentLoaded', () => {

    // ---------------------------------------------------------
    // 1. LÓGICA DE SESIÓN DE USUARIO (EL CÓDIGO NUEVO)
    // ---------------------------------------------------------
    // Esto pregunta al archivo PHP si estamos logueados
    fetch('api/check_session.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('No se encontró check_session.php');
            }
            return response.json();
        })
        .then(data => {
            // Si PHP dice que sí, actualizamos el menú
            if (data.logged_in) {
                console.log("Usuario logueado:", data.nombre); // Para depurar en consola
                updateNavForUser(data.nombre);
            }
        })
        .catch(error => console.error('Error de sesión:', error));


    // ---------------------------------------------------------
    // 2. LÓGICA DEL FORMULARIO DE CONTACTO (TU CÓDIGO ANTIGUO)
    // ---------------------------------------------------------
    const botonEnviar = document.querySelector('.btn-submit');

    // Solo ejecutamos esto si existe el botón (para evitar errores en Inicio/Login)
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
            botonEnviar.innerHTML = 'Guardando...';
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
                alert('Error de conexión.');
            } finally {
                botonEnviar.innerHTML = textoOriginal;
                botonEnviar.disabled = false;
            }
        });
    }
});

// ---------------------------------------------------------
// 3. FUNCIONES PARA CAMBIAR EL MENÚ
// ---------------------------------------------------------
function updateNavForUser(nombreUsuario) {
    // 1. Buscamos los botones de forma "inteligente" (con o sin .html)
    const loginLink = document.querySelector('a[href="login.html"]') || document.querySelector('a[href="login"]');
    const registerLink = document.querySelector('a[href="registro.html"]') || document.querySelector('a[href="registro"]');

    // 2. Si existe el botón de "Iniciar Sesión", LO BORRAMOS por completo
    if (loginLink && loginLink.parentElement) {
        loginLink.parentElement.remove(); // Adiós botón inútil 👋
    }

    // 3. Usamos el hueco del botón "Registrarse" para poner el Menú de Usuario
    if (registerLink && registerLink.parentElement) {
        const liPadre = registerLink.parentElement;

        // Inyectamos el HTML del menú desplegable
        liPadre.innerHTML = `
            <div class="user-menu-container">
                <a href="#" class="user-toggle" onclick="toggleUserMenu(event)">
                    <i class='bx bxs-user-circle'></i> ${nombreUsuario} <i class='bx bx-chevron-down'></i>
                </a>
                <div class="user-dropdown" id="userDropdown">
                    <a href="perfil.php"><i class='bx bx-id-card'></i> Mi Perfil</a>
                    <a href="api/logout.php" style="color: #ff6b6b;"><i class='bx bx-log-out'></i> Cerrar Sesión</a>
                </div>
            </div>
        `;
    }
}

function toggleUserMenu(e) {
    e.preventDefault();
    const menu = document.getElementById('userDropdown');
    if (menu) {
        menu.classList.toggle('show');

        // Cerrar al hacer clic fuera
        document.addEventListener('click', function closeMenu(event) {
            if (!event.target.closest('.user-menu-container')) {
                menu.classList.remove('show');
                document.removeEventListener('click', closeMenu);
            }
        });
    }
}