// Archivo: js/theme.js

// Función principal para aplicar tema
function aplicarTema(tema) {
    const body = document.body;

    // Reseteamos clases
    body.classList.remove('theme-light', 'theme-dark');

    if (tema === 'light') {
        body.classList.add('theme-light');
    } else if (tema === 'dark') {
        body.classList.add('theme-dark'); // Opcional si tienes estilos específicos para dark forzado
    }
    // 'default' no añade clase, usa las variables CSS base
}

// 1. Cargar tema guardado en LocalStorage (Instantáneo para evitar parpadeos)
const temaGuardado = localStorage.getItem('user_theme');
if (temaGuardado) {
    aplicarTema(temaGuardado);
}

// 2. Verificar sesión y sincronizar con base de datos (por si cambió en otro dispositivo)
document.addEventListener('DOMContentLoaded', () => {
    fetch('api/check_session.php')
        .then(res => res.json())
        .then(data => {
            if (data.logged_in && data.tema) {
                // Actualizamos localStorage y aplicamos
                if (data.tema !== localStorage.getItem('user_theme')) {
                    localStorage.setItem('user_theme', data.tema);
                    aplicarTema(data.tema);
                }
            }
        })
        .catch(err => console.log('Check session silent error'));
});