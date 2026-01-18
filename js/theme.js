// js/theme.js SIMPLIFICADO
function aplicarTema(tema) {
    const body = document.body;
    body.classList.remove('theme-light', 'theme-dark');
    if (tema === 'light') body.classList.add('theme-light');
    else if (tema === 'dark') body.classList.add('theme-dark');
}

// Cargar tema al iniciar
const temaGuardado = localStorage.getItem('user_theme');
if (temaGuardado) aplicarTema(temaGuardado);

// Sincronizar con base de datos (segundo plano)
document.addEventListener('DOMContentLoaded', () => {
    fetch('api/check_session.php')
        .then(res => res.json())
        .then(data => {
            if (data.logged_in && data.tema && data.tema !== localStorage.getItem('user_theme')) {
                localStorage.setItem('user_theme', data.tema);
                aplicarTema(data.tema);
            }
        })
        .catch(err => console.log(err));
});