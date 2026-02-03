<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="title_config">Configuración - SecurityShield</title>
    <link rel="icon" type="image/jpg" href="images/shield_g.jpg">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/theme.js" defer></script>
</head>

<body>
    <script>
        (function () {
            const tema = localStorage.getItem('user_theme');
            const body = document.body;
            body.classList.add('preload');
            if (tema === 'light') {
                body.classList.add('theme-light');
            } else if (tema === 'dark') {
                body.classList.add('theme-dark');
            }
            setTimeout(() => {
                body.classList.remove('preload');
            }, 200);
        })();
    </script>

    <nav class="navbar">
        <div class="logo"><i class='bx bxs-shield-plus'></i> SecurityShield</div>
        <div class="menu-toggle" id="mobile-menu"><i class='bx bx-menu'></i></div>
        
        <ul class="nav-links" id="nav-links">
            <li><a href="principal.html" data-i18n="nav_inicio">Inicio</a></li>
            <li><a href="planes.html" data-i18n="nav_planes">Planes</a></li>
            <li><a href="contacto.html" data-i18n="nav_contacto">Contacto</a></li>
            
            <li><a href="login.html" data-i18n="nav_item_login">Iniciar Sesión</a></li>
            <li><a href="registro.html" class="btn-login" data-i18n="nav_item_register">Registrarse</a></li>

            <li>
                <select id="language-selector" class="lang-select">
                    <option value="es">🇪🇸 ES</option>
                    <option value="en">🇬🇧 EN</option>
                    <option value="ca">🏴 CA</option>
                    <option value="eu">🏴 EU</option>
                </select>
            </li>
        </ul>
    </nav>

    <div class="container" style="margin-top: 100px;">
        <h2 style="margin-bottom: 2rem; text-align: center;" data-i18n="menu_config">Configuración</h2>

        <div class="glass-card" style="max-width: 800px; margin: 0 auto;">
            <h3 style="margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.5rem;" data-i18n="config_personalization_title">
                Personalización
            </h3>
            
            <p style="color: #94a3b8; margin-bottom: 1.5rem;" data-i18n="config_personalization_desc">
                Elige como quieres ver SecurityShield. Tu preferencia se guardará para futuras sesiones.
            </p>

            <div class="theme-selector" style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
                <div class="theme-option" onclick="guardarTema('default')" style="text-align: center; cursor: pointer;">
                    <div style="width: 100px; height: 60px; background: linear-gradient(135deg, #0f172a 0%, #000 100%); border: 2px solid #38bdf8; border-radius: 10px; margin-bottom: 10px;"></div>
                    <span data-i18n="theme_default">Original</span>
                </div>

                <div class="theme-option" onclick="guardarTema('light')" style="text-align: center; cursor: pointer;">
                    <div style="width: 100px; height: 60px; background: #f8fafc; border: 1px solid #ccc; border-radius: 10px; margin-bottom: 10px; position: relative;">
                        <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #000; font-weight: bold;">Light</span>
                    </div>
                    <span data-i18n="theme_light">Modo Claro</span>
                </div>

                <div class="theme-option" onclick="guardarTema('dark')" style="text-align: center; cursor: pointer;">
                    <div style="width: 100px; height: 60px; background: #1e293b; border: 1px solid #334155; border-radius: 10px; margin-bottom: 10px; position: relative;">
                         <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff;">Dark</span>
                    </div>
                    <span data-i18n="theme_dark">Modo Oscuro</span>
                </div>
            </div>

            <p id="mensaje-estado" style="text-align: center; margin-top: 2rem; min-height: 20px; color: var(--primary);"></p>
        </div>
    </div>

    <script>
        function guardarTema(tema) {
            aplicarTema(tema); 
            localStorage.setItem('user_theme', tema);

            fetch('/api/guardar_tema.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ tema: tema })
            })
            .then(res => res.json())
            .then(data => {
                const msg = document.getElementById('mensaje-estado');
                if (data.success) {
                    msg.textContent = "Tema guardado / Theme saved"; 
                    setTimeout(() => msg.textContent = "", 2000);
                } else {
                    msg.style.color = 'red';
                    msg.textContent = "Error al guardar.";
                }
            });
        }

        const menuBtn = document.getElementById('mobile-menu');
        const navLinks = document.getElementById('nav-links');
        if(menuBtn && navLinks) {
            menuBtn.addEventListener('click', () => {
                navLinks.classList.toggle('active');
            });
        }
    </script>
    
    <script src="js/logic.js"></script>
    <script src="js/translations.js"></script>
</body>
</html>