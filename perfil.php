<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login'); // Si no está logueado, vuelve al login
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav class="navbar">
        <div class="logo">SecurityShield</div>
        <div>
            Hola,
            <?php echo htmlspecialchars($_SESSION['nombre'] ?? 'Usuario'); ?>
            <a href="api/logout.php" style="color: red; margin-left: 15px;">Cerrar Sesión</a>
        </div>
    </nav>
    <div class="container" style="margin-top: 100px;">
        <div class="glass-card">
            <h2>Bienvenido a tu cuenta</h2>
            <p>Has iniciado sesión correctamente.</p>
        </div>
    </div>
</body>

</html>