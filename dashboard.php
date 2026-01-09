<?php
session_start();

// 1. SEGURIDAD: Si no ha iniciado sesión, fuera.
if (!isset($_SESSION['usuario'])) {
    header('Location: login');
    exit;
}

// 2. SEGURIDAD EXTRA: Si está logueado pero NO es Admin, a su panel de cliente.
// Esto evita que un cliente escriba "dashboard.php" y vea tus datos.
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
    <title>Dashboard - SecurityShield</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/png" href="images/shield.png">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container dashboard-view">
        
        <header style="text-align: center; margin: 3rem 0;">
            <h1><i class='bx bxs-dashboard'></i> Panel de Control</h1>
            <p style="color: var(--text-secondary);">Bienvenido, <strong style="color: var(--accent-blue);"><?php echo htmlspecialchars($_SESSION['usuario']);?></strong></p>
            
            <div style="margin-top: 1.5rem;">
                <a href="index" class="btn-danger">
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
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2026 SecurityShield - Proyecto TFG</p>
            <div class="social-links">
                <a href="https://github.com/secureshieldpim-tech/SecurityShield.pim" target="_blank" rel="noopener noreferrer" title="Ver código fuente en GitHub">
                    <i class='bx bxl-github'></i> Código Fuente
                </a>
            </div>
        </div>
    </footer>
</body>
</html>