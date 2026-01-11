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
    <title>Área Cliente - SecurityShield</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/png" href="images/shield.png">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .dashboard-view h1 { color: #00d2ff; } 
        .msg-table thead th { background: rgba(0, 210, 255, 0.1); color: #00d2ff; }
    </style>
</head>
<body>
    <div class="container dashboard-view">
        
        <header style="text-align: center; margin: 3rem 0;">
            <h1><i class='bx bxs-user-detail'></i> <span data-i18n="panel_client_title">Área de Cliente</span></h1>
            <p style="color: var(--text-secondary);">Hola, <strong style="color: white;"><?php echo htmlspecialchars($nombreMostrar); ?></strong></p>
            
            <div style="margin-top: 1.5rem;">
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
    <script src="js/translations.js"></script>
</body>
</html>