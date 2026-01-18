<?php
session_start();

// Seguridad: Si no está logueado, mandar al login
if (!isset($_SESSION['usuario'])) {
    header('Location: login.html');
    exit;
}

// --- LÓGICA PARA OBTENER PLANES ACTIVOS ---
$planesActivos = [];
$archivoUsuarios = 'data/users.json'; // Ruta relativa desde perfil.php

if (file_exists($archivoUsuarios)) {
    $usuarios = json_decode(file_get_contents($archivoUsuarios), true);
    foreach ($usuarios as $user) {
        if ($user['email'] === $_SESSION['usuario']) {
            if (isset($user['planes']) && is_array($user['planes'])) {
                foreach ($user['planes'] as $plan) {
                    // Comprobar si la fecha de expiración es mayor a hoy
                    $fechaExpiracion = strtotime($plan['fecha_expiracion']);
                    $ahora = time();
                    
                    if ($fechaExpiracion > $ahora) {
                        // El plan sigue activo
                        $plan['dias_restantes'] = ceil(($fechaExpiracion - $ahora) / (60 * 60 * 24));
                        $planesActivos[] = $plan;
                    }
                }
            }
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="title_profile">Mi Perfil - SecurityShield</title>

    <link rel="icon" type="image/jpg" href="images/shield_g.jpg">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/theme.js" defer></script>
</head>

<body>

    <script>
        (function () {
            // 1. Recuperar tema guardado
            const tema = localStorage.getItem('user_theme');
            const body = document.body;

            // 2. Bloquear animaciones para que no haya 'fundido'
            body.classList.add('preload');

            // 3. Aplicar color de fondo INSTANTÁNEAMENTE
            if (tema === 'light') {
                body.classList.add('theme-light');
            } else if (tema === 'dark') {
                body.classList.add('theme-dark');
            }

            // 4. Reactivar animaciones tras un breve momento
            setTimeout(() => {
                body.classList.remove('preload');
            }, 200);
        })();
    </script>

    <nav class="navbar">
        <div class="logo"><i class='bx bxs-shield-plus'></i> SecurityShield</div>
        <div class="menu-toggle" id="mobile-menu"><i class='bx bx-menu'></i></div>

        <ul class="nav-links" id="nav-links">
            <li><a href="principal.html">Inicio</a></li>
            <li><a href="planes.html">Planes</a></li>
            <li><a href="contacto.html">Contacto</a></li>

            <li>
                <div class="user-menu-container">
                    <a href="#" class="user-toggle" onclick="toggleUserMenu(event)">
                        <i class='bx bxs-user-circle'></i>
                        <?php echo htmlspecialchars($_SESSION['nombre'] ?? 'Usuario'); ?>
                        <i class='bx bx-chevron-down'></i>
                    </a>
                    <div class="user-dropdown" id="userDropdown">
                        <a href="perfil.php"><i class='bx bx-id-card'></i> <span data-i18n="menu_profile">Mi Perfil</span></a>
                        <a href="configuracion.php"><i class='bx bx-cog'></i> <span data-i18n="menu_config">Configuración</span></a>
                        
                        <a href="api/logout.php" style="color: #ff6b6b;"><i class='bx bx-log-out'></i> <span data-i18n="menu_logout">Cerrar Sesión</span></a>
                    </div>
                </div>
            </li>

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

    <div class="container" style="min-height: 60vh; margin-top: 2rem;">
        <div class="glass-card">
            <h2 style="margin-bottom: 1rem;" data-i18n="profile_welcome">Bienvenido a tu área personal</h2>
            <p style="color: var(--text-muted);">
                <span data-i18n="profile_user_id">Usuario identificado:</span> <strong style="color: var(--primary);"><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong>
            </p>

            <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin: 2rem 0;">

            <div style="display: grid; gap: 1.5rem; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
                
                <div style="background: rgba(255,255,255,0.03); padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                    <i class='bx bx-check-shield' style="font-size: 2.5rem; color: var(--primary); margin-bottom: 1rem;"></i>
                    <h3 data-i18n="profile_status_title">Estado de Cuenta</h3>
                    <p style="color: #94a3b8; font-size: 0.9rem;" data-i18n="profile_status_verified">Tu cuenta está verificada.</p>
                </div>

                <div style="background: rgba(255,255,255,0.03); padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                    <i class='bx bx-package' style="font-size: 2.5rem; color: var(--secondary); margin-bottom: 1rem;"></i>
                    <h3>Mis Planes Activos</h3>
                    
                    <?php if (count($planesActivos) > 0): ?>
                        <div style="margin-top: 1rem;">
                            <?php foreach ($planesActivos as $plan): ?>
                                <div style="background: rgba(56, 189, 248, 0.1); padding: 0.8rem; border-radius: 8px; border: 1px solid var(--primary); margin-bottom: 0.5rem;">
                                    <strong style="color: var(--primary); display:block;"><?php echo htmlspecialchars($plan['nombre']); ?></strong>
                                    <small style="color: #ccc;"><span data-i18n="profile_plans_expire">Caduca en:</span> <?php echo $plan['dias_restantes']; ?> <span data-i18n="profile_plans_days">días</span></small>
                                    <small style="color: #94a3b8; font-size: 0.8rem;">(<?php echo date('d/m/Y', strtotime($plan['fecha_expiracion'])); ?>)</small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p style="color: #94a3b8; font-size: 0.9rem;">No tienes planes activos actualmente.</p>
                        <a href="planes.html" style="color: var(--primary); text-decoration: none; font-size: 0.9rem; display: inline-block; margin-top: 0.5rem;">
                            Contratar nuevo plan &rarr;
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

<footer class="footer">
        <div class="footer-content">
            <p>&copy; 2026 SecurityShield - Proyecto PIM</p>

            <div class="social-links" style="display: flex; gap: 0.5rem; flex-wrap: wrap; justify-content: center;">
                
                <a href="mailto:contact@securityshield.es" title="Enviar correo">
                    <i class='bx bx-envelope'></i> Email
                </a>

                <a href="https://www.instagram.com/securityshield_/" target="_blank" rel="noopener noreferrer" title="Instagram">
                    <i class='bx bxl-instagram'></i>
                </a>

                <a href="https://x.com/SecurityShield_" target="_blank" rel="noopener noreferrer" title="Twitter / X">
                    <i class='bx bxl-twitter'></i>
                </a>

                <a href="https://github.com/secureshieldpim-tech/SecurityShield.pim" target="_blank" rel="noopener noreferrer" title="GitHub">
                    <i class='bx bxl-github'></i>
                </a>
            </div>
        </div>
    </footer>

    <script src="js/translations.js"></script>
    <script>
        // Menú Móvil y User Dropdown
        const menuBtn = document.getElementById('mobile-menu');
        const navLinks = document.getElementById('nav-links');
        if (menuBtn) {
            menuBtn.addEventListener('click', () => { navLinks.classList.toggle('active'); });
        }
        function toggleUserMenu(e) {
            e.preventDefault();
            const menu = document.getElementById('userDropdown');
            menu.classList.toggle('show');
            document.addEventListener('click', function closeMenu(event) {
                if (!event.target.closest('.user-menu-container')) {
                    menu.classList.remove('show');
                    document.removeEventListener('click', closeMenu);
                }
            });
        }
    </script>
</body>
</html>