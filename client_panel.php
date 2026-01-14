<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login');
    exit;
}

require_once 'classes/JsonHandler.php';

$db = new JsonHandler('respuestas.json');
$todasLasRespuestas = $db->leerRegistros();

$misMensajes = [];
$miEmail = $_SESSION['usuario'];

foreach ($todasLasRespuestas as $respuesta) {
    $paraQuien = $respuesta['destinatario'] ?? '';

    if ($paraQuien === $miEmail) {
        $misMensajes[] = $respuesta;
    }
}

$nombreMostrar = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="title_client">Área Cliente - SecurityShield</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/jpg" href="https://securityshield.es/images/shield_g.jpg">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .dashboard-view h1 {
            color: #00d2ff;
        }

        .msg-table thead th {
            background: rgba(0, 210, 255, 0.1);
            color: #00d2ff;
        }
    </style>
</head>

<body>
    <div class="container dashboard-view">

        <header style="text-align: center; margin: 3rem 0;">
            <h1><i class='bx bxs-user-detail'></i> <span data-i18n="panel_client_title">Área de Cliente</span></h1>
            <p style="color: var(--text-secondary);"><span data-i18n="hello_user">Hola,</span> <strong
                    style="color: white;"><?php echo htmlspecialchars($nombreMostrar); ?></strong></p>

            <div style="margin-top: 1.5rem; display: flex; justify-content: center; align-items: center; gap: 1rem;">
                <select id="language-selector" class="lang-select" style="margin: 0;">
                    <option value="es">🇪🇸 ES</option>
                    <option value="en">🇬🇧 EN</option>
                    <option value="ca">🏴 CA</option>
                    <option value="eu">🏴 EU</option>
                </select>

                <a href="index.html" class="btn-danger" style="display:inline-block; text-decoration:none;">
                    <i class='bx bx-log-out'></i> <span data-i18n="btn_logout">Salir</span>
                </a>
            </div>
        </header>

        <div class="glass-card">
            <h2 style="margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.5rem;">
                <i class='bx bx-support'></i> <span data-i18n="panel_responses_title">Respuestas del Equipo</span>
            </h2>

            <?php if (empty($misMensajes)): ?>
                <div style="text-align: center; padding: 3rem; color: var(--text-secondary);">
                    <p data-i18n="panel_no_msg">No tienes nuevas respuestas.</p>
                </div>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table class="msg-table">
                        <thead>
                            <tr>
                                <th data-i18n="table_date">Fecha</th>
                                <th data-i18n="table_subject">Asunto</th>
                                <th data-i18n="table_response">Respuesta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_reverse($misMensajes) as $msg): ?>
                                <tr>
                                    <td style="font-size: 0.85rem; color: var(--text-secondary);">
                                        <?php echo htmlspecialchars($msg['fecha'] ?? '-'); ?>
                                    </td>
                                    <td style="font-weight: bold; color: #00d2ff;">
                                        <?php echo htmlspecialchars($msg['asunto'] ?? 'Sin Asunto'); ?>
                                    </td>
                                    <td style="color: var(--text-primary);">
                                        <?php echo htmlspecialchars($msg['mensaje'] ?? ''); ?>
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
</body>

</html>