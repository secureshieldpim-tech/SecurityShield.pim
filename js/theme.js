// Archivo: js/theme.js

// 1. Función para aplicar tema (Dark/Light)
function aplicarTema(tema) {
    const body = document.body;
    body.classList.remove('theme-light', 'theme-dark');
    if (tema === 'light') body.classList.add('theme-light');
    else if (tema === 'dark') body.classList.add('theme-dark');
}

// Cargar tema guardado al instante
const temaGuardado = localStorage.getItem('user_theme');
if (temaGuardado) aplicarTema(temaGuardado);

// 2. Función para gestionar el MENÚ DE NAVEGACIÓN
function actualizarNavbar(usuario) {
    const loginLink = document.querySelector('a[href="login.html"]');
    const registroLink = document.querySelector('a[href="registro.html"]');
    const userMenuLi = document.getElementById('user-menu-li');
    const userNameSpan = document.getElementById('nav-user-name');

    if (usuario && userMenuLi) {
        // ESTAMOS LOGUEADOS:
        // 1. Ocultar botones de login/registro (buscamos su padre <li>)
        if (loginLink) loginLink.parentElement.style.display = 'none';
        if (registroLink) registroLink.parentElement.style.display = 'none';

        // 2. Mostrar el menú de usuario y poner el nombre
        userMenuLi.style.display = 'block';
        if (userNameSpan) userNameSpan.textContent = usuario;
    }
}

// 3. Función global para abrir/cerrar el desplegable (necesaria en los HTML)
window.toggleUserMenu = function (e) {
    e.preventDefault();
    const menu = document.getElementById('userDropdown');
    if (menu) {
        menu.classList.toggle('show');

        // Cerrar al hacer click fuera
        const closeMenu = (event) => {
            if (!event.target.closest('.user-menu-container')) {
                menu.classList.remove('show');
                document.removeEventListener('click', closeMenu);
            }
        };
        document.addEventListener('click', closeMenu);
    }
};

// 4. Verificar sesión al cargar
document.addEventListener('DOMContentLoaded', () => {
    fetch('api/check_session.php')
        .then(res => res.json())
        .then(data => {
            if (data.logged_in) {
                // Si hay tema nuevo en la BD, actualizarlo
                if (data.tema && data.tema !== localStorage.getItem('user_theme')) {
                    localStorage.setItem('user_theme', data.tema);
                    aplicarTema(data.tema);
                }
                // ACTUALIZAR LA BARRA DE NAVEGACIÓN
                actualizarNavbar(data.nombre);
            }
        })
        .catch(err => console.log('Sesión no activa o error'));
});