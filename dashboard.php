<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login');
    exit;
}

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: client_panel.php');
    exit;
}

require_once 'classes/JsonHandler.php';
$db = new JsonHandler('registros.json');
$mensajes = $db->leerRegistros();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="title_dashboard">Dashboard - SecurityShield</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/jpg" href="https://securityshield.es/images/shield_g.jpg">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container dashboard-view">

        <header style="text-align: center; margin: 3rem 0;">
            <h1><i class='bx bxs-dashboard'></i> <span data-i18n="dash_title">Panel de Control</span></h1>
            <p style="color: var(--text-secondary);"><span data-i18n="welcome_user">Bienvenido,</span> <strong
                    style="color: var(--accent-blue);"><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></p>

            <div style="margin-top: 1.5rem; display: flex; justify-content: center; align-items: center; gap: 1rem;">
                <select id="language-selector" class="lang-select" style="margin: 0;">
                    <option value="es">🇪🇸 ES</option>
                    <option value="en">🇬🇧 EN</option>
                    <option value="ca">🏴 CA</option>
                    <option value="eu">🏴 EU</option>
                </select>

                <a href="index" class="btn-danger">
                    <i class='bx bx-log-out'></i> <span data-i18n="btn_logout">Cerrar Sesión</span>
                </a>
            </div>
        </header>

        <div class="glass-card">
            <h2 style="margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.5rem;">
                <span data-i18n="dash_msgs_title">Mensajes Recibidos</span>
            </h2>

            <?php if (empty($mensajes)): ?>
                <div style="text-align: center; padding: 2rem; color: var(--text-secondary);">
                    <i class='bx bx-envelope' style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                    <p style="text-align: center;" data-i18n="dash_no_msg">No hay mensajes nuevos en el sistema.</p>
                </div>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table class="msg-table">
                        <thead>
                            <tr>
                                <th data-i18n="table_date">Fecha</th>
                                <th data-i18n="table_user">Usuario</th>
                                <th data-i18n="table_msg">Mensaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_reverse($mensajes) as $msg): ?>
                                <tr>
                                    <td style="font-size: 0.9rem; color: var(--text-secondary; white-space: nowrap;">
                                        <?php echo htmlspecialchars($msg['fecha']); ?>
                                    </td>
                                    <td>
                                        <div style="font-weight: bold;"><?php echo htmlspecialchars($msg['nombre']); ?></div>
                                        <div style="font-size: 0.8rem; color: var(--accent-blue);">
                                            <?php echo htmlspecialchars($msg['email']); ?></div>
                                    </td>
                                    <td style="color: var(--text-primary);">
                                        <?php echo htmlspecialchars($msg['mensaje']); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <footer class="footer">
        <div class="footer-content">
            <p data-i18n="footer_text">&copy; 2026 SecurityShield - Proyecto PIM - Defensa de Servidor Web</p>

            <p style="margin-top: 0.5rem; font-size: 0.9rem;">
                <i class='bx bx-envelope'></i>
                <a href="mailto:contact@securityshield.es"
                    style="color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.3s;">
                    contact@securityshield.es
                </a>
            </p>

            <div class="social-links">
                <a href="https://github.com/secureshieldpim-tech/SecurityShield.pim" target="_blank"
                    rel="noopener noreferrer" title="Ver código fuente en GitHub">
                    <i class='bx bxl-github'></i> <span data-i18n="footer_source">Código Fuente</span>
                </a>
            </div>
        </div>
    </footer>
    <script src="js/translations.js"></script>
</body>

</html>