<?php
session_start();

// Seguridad: Si no está logueado, mandar al login
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
    <title>Mi Perfil - SecurityShield</title>

    <link rel="icon" type="image/jpg" href="images/shield_g.jpg">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
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
                        <a href="#" class="active"><i class='bx bx-id-card'></i> Mi Perfil</a>
                        <a href="api/logout.php" style="color: #ff6b6b;"><i class='bx bx-log-out'></i> Cerrar Sesión</a>
                    </div>
                </div>
            </li>

            <li>
                <select id="language-selector" class="lang-select">
                    <option value="es">🇪🇸 ES</option>
                    <option value="en">🇬🇧 EN</option>
                </select>
            </li>
        </ul>
    </nav>

    <div class="container" style="min-height: 60vh; margin-top: 2rem;">
        <div class="glass-card">
            <h2 style="margin-bottom: 1rem;">Bienvenido a tu área personal</h2>
            <p style="color: var(--text-muted);">
                Has iniciado sesión correctamente con el correo:
                <strong style="color: var(--primary);"><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong>
            </p>

            <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin: 2rem 0;">

            <div style="display: grid; gap: 1.5rem; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
                <div
                    style="background: rgba(255,255,255,0.03); padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                    <i class='bx bx-check-shield'
                        style="font-size: 2.5rem; color: var(--primary); margin-bottom: 1rem;"></i>
                    <h3>Estado de Cuenta</h3>
                    <p style="color: #94a3b8; font-size: 0.9rem;">Tu cuenta está activa y funcionando correctamente.</p>
                </div>

                <div
                    style="background: rgba(255,255,255,0.03); padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                    <i class='bx bx-package'
                        style="font-size: 2.5rem; color: var(--secondary); margin-bottom: 1rem;"></i>
                    <h3>Mis Planes</h3>
                    <p style="color: #94a3b8; font-size: 0.9rem;">No tienes planes activos actualmente.</p>
                    <a href="planes.html"
                        style="color: var(--primary); text-decoration: none; font-size: 0.9rem; display: inline-block; margin-top: 0.5rem;">Ver
                        planes disponibles &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer" style="margin-top: auto;">
        <div class="footer-content">
            <p>&copy; 2026 SecurityShield - Proyecto PIM - Defensa de Servidor Web</p>

            <p style="margin-top: 0.5rem; font-size: 0.9rem;">
                <i class='bx bx-envelope'></i>
                <a href="mailto:contact@securityshield.es"
                    style="color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.3s;">
                    contact@securityshield.es
                </a>
            </p>

            <div class="social-links" style="display: flex; gap: 0.5rem; flex-wrap: wrap; justify-content: center;">
                <a href="https://x.com/SecurityShield_" target="_blank" rel="noopener noreferrer" title="Instagram">
                    <i class='bx bxl-instagram'></i>
                </a>

                <a href="https://x.com/SecurityShield_" target="_blank" rel="noopener noreferrer" title="Twitter / X">
                    <i class='bx bxl-twitter'></i>
                </a>

                <a href="https://github.com/secureshieldpim-tech/SecurityShield.pim" target="_blank"
                    rel="noopener noreferrer" title="Ver código fuente en GitHub">
                    <i class='bx bxl-github'></i> <span data-i18n="footer_source">Código Fuente</span>
                </a>
            </div>
        </div>
    </footer>

    <script src="js/translations.js"></script>
    <script>
        // Menú Móvil
        const menuBtn = document.getElementById('mobile-menu');
        const navLinks = document.getElementById('nav-links');

        if (menuBtn) {
            menuBtn.addEventListener('click', () => {
                navLinks.classList.toggle('active');
            });
        }

        // Desplegable de Usuario
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