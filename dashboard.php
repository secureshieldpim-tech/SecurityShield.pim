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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 style="text-align: center; margin-top: 2rem;">Panel de Control</h1>
        <p style="text-align: center;">Bienvenido, <strong><?php echo $_SESSION['usuario'];?></strong></p>
        
        <div style="text-align: center; margin-bottom: 2rem;">
            <a href="index.html" class="btn-login" style="background: red; border-color: red;">Cerrar Sesión</a>
        </div>

        <div class="glass-card">
            <h2>Mensajes Recibidos</h2>
            <?php if (empty($mensajes)):?>
                <p>No hay mensajes todavía.</p>
            <?php else:?>
                <table style="width: 100%; text-align: left; border-collapse: collapse; color: white;">
                    <thead>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.2);">
                            <th style="padding: 10px;">Fecha</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Mensaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_reverse($mensajes) as $msg):?>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                            <td style="padding: 10px; opacity: 0.7;"><?php echo $msg['fecha'];?></td>
                            <td><?php echo htmlspecialchars($msg['nombre']);?></td>
                            <td style="color: #00d9ff;"><?php echo htmlspecialchars($msg['email']);?></td>
                            <td><?php echo htmlspecialchars($msg['mensaje']);?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            <?php endif;?>
        </div>
    </div>
</body>
</html>