function aplicarTema(tema) {
    const body = document.body;
    body.classList.remove('theme-light', 'theme-dark');
    if (tema === 'light') body.classList.add('theme-light');
    else if (tema === 'dark') body.classList.add('theme-dark');
}

// Lógica de inicio
document.addEventListener('DOMContentLoaded', () => {
    // 1. Verificar sesión ANTES de decidir qué tema dejar fijo
    fetch('api/check_session.php')
        .then(res => res.json())
        .then(data => {
            if (data.logged_in) {
                // USUARIO LOGUEADO:
                // Si el servidor dice que tiene un tema guardado, lo usamos.
                // Si no, miramos si tenía uno en local.
                const temaServidor = data.tema;
                const temaLocal = localStorage.getItem('user_theme');

                if (temaServidor && temaServidor !== 'default') {
                    aplicarTema(temaServidor);
                    localStorage.setItem('user_theme', temaServidor);
                } else if (temaLocal) {
                    aplicarTema(temaLocal);
                }
            } else {
                // USUARIO NO LOGUEADO:
                // Forzamos el tema por defecto y borramos la memoria local
                if (localStorage.getItem('user_theme')) {
                    localStorage.removeItem('user_theme');
                    aplicarTema('default'); // Quita las clases light/dark
                }
            }
        })
        .catch(err => {
            console.error("Error verificando sesión:", err);
            // En caso de error, por seguridad visual, aplicamos lo que haya en local
            const temaGuardado = localStorage.getItem('user_theme');
            if (temaGuardado) aplicarTema(temaGuardado);
        });
});