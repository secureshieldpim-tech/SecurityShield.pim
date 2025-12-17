<?php
session_start();
// Si no está logueado, lo echamos fuera
if (!isset($_SESSION['usuario'])) {
    header('Location: login.html');
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
    <title>Dashboard - SecurityShield</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container dashboard-view">
        
        <header style="text-align: center; margin: 3rem 0;">
            <h1><i class='bx bxs-dashboard'></i> Panel de Control</h1>
            <p style="color: var(--text-secondary);">Bienvenido, <strong style="color: var(--accent-blue);"><?php echo htmlspecialchars($_SESSION['usuario']);?></strong></p>
            
            <div style="margin-top: 1.5rem;">
                <a href="index.html" class="btn-danger">
                    <i class='bx bx-log-out'></i> Cerrar Sesión
                </a>
            </div>
        </header>

        <div class="glass-card">
            <h2 style="margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.5rem;">
                Mensajes Recibidos
            </h2>

            <?php if (empty($mensajes)):?>
                <div style="text-align: center; padding: 2rem; color: var(--text-secondary);">
                    <i class='bx bx-envelope' style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                    <p style="text-align: center;">No hay mensajes nuevos en el sistema.</p>
                </div>
            <?php else:?>
                <div style="overflow-x: auto;"> <table class="msg-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Mensaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_reverse($mensajes) as $msg):?>
                            <tr>
                                <td style="font-size: 0.9rem; color: var(--text-secondary); white-space: nowrap;">
                                    <?php echo htmlspecialchars($msg['fecha']);?>
                                </td>
                                <td>
                                    <div style="font-weight: bold;"><?php echo htmlspecialchars($msg['nombre']);?></div>
                                    <div style="font-size: 0.8rem; color: var(--accent-blue);"><?php echo htmlspecialchars($msg['email']);?></div>
                                </td>
                                <td style="color: var(--text-primary);">
                                    <?php echo htmlspecialchars($msg['mensaje']);?>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            <?php endif;?>
        </div>
    </div>
</body>
</html>