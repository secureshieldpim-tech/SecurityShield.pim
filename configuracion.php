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
    <nav class="navbar">
        <div style="display: flex; align-items: center; gap: 15px;">
            <i class='bx bx-left-arrow-alt' onclick="window.history.back()" 
               style="font-size: 2rem; cursor: pointer; color: var(--primary);"></i>
            
            <div class="logo"><i class='bx bxs-cog'></i> Configuración</div>
        </div>

        <div class="nav-links">
            <a href="perfil.php" class="btn-login" style="background: transparent; border: 1px solid var(--primary); color: var(--text-main)!important;">
                <i class='bx bx-user'></i> <span data-i18n="btn_back_profile">Ir al Perfil</span>
            </a>
        </div>
    </nav>

    <div class="container" style="margin-top: 3rem;">
        <div class="glass-card" style="max-width: 600px; margin: 0 auto;">
            <h2><i class='bx bx-palette'></i> <span data-i18n="config_personalization_title">Personalización</span></h2>
            <p data-i18n="config_personalization_desc">Elige como quieres ver SecurityShield. Tu preferencia se guardará para futuras sesiones.</p>
            
            <div class="theme-selector" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-top: 2rem;">
                
                <div class="theme-option" onclick="guardarTema('default')" style="cursor: pointer; text-align: center;">
                    <div style="height: 80px; background: #0a0e17; border: 2px solid var(--border-glass); border-radius: 10px; margin-bottom: 10px; position: relative;">
                        <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff;">Default</span>
                    </div>
                    <span data-i18n="theme_default">Original</span>
                </div>

                <div class="theme-option" onclick="guardarTema('light')" style="cursor: pointer; text-align: center;">
                    <div style="height: 80px; background: #f8fafc; border: 2px solid #cbd5e1; border-radius: 10px; margin-bottom: 10px; position: relative;">
                         <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #000;">Light</span>
                    </div>
                    <span data-i18n="theme_light">Modo Claro</span>
                </div>

                <div class="theme-option" onclick="guardarTema('dark')" style="cursor: pointer; text-align: center;">
                    <div style="height: 80px; background: #000000; border: 2px solid #333; border-radius: 10px; margin-bottom: 10px; position: relative;">
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
            // 1. Aplicar visualmente al instante
            aplicarTema(tema); 
            localStorage.setItem('user_theme', tema);

            // 2. Guardar en servidor
            fetch('api/guardar_tema.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ tema: tema })
            })
            .then(res => res.json())
            .then(data => {
                const msg = document.getElementById('mensaje-estado');
                if (data.success) {
                    msg.textContent = "Tema guardado correctamente.";
                    setTimeout(() => msg.textContent = "", 2000);
                } else {
                    msg.style.color = 'red';
                    msg.textContent = "Error al guardar.";
                }
            });
        }
    </script>
</body>
</html>