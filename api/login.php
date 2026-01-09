<?php
session_start();
require_once '../classes/JsonHandler.php';

$emailIngresado = $_POST['email'] ?? '';
$passIngresada = $_POST['password'] ?? '';

$db = new JsonHandler('users.json');
$usuarios = $db->leerRegistros();

foreach ($usuarios as $user) {
    // Comprobar email y contraseña
    if ($user['email'] === $emailIngresado && password_verify($passIngresada, $user['password'])) {
        
        // 1. Guardamos datos básicos en la sesión
        $_SESSION['usuario'] = $user['email'];
        $_SESSION['nombre']  = $user['nombre']; 
        
        // 2. Leemos el ROL
        $rol = isset($user['rol']) ? $user['rol'] : 'cliente';
        $_SESSION['rol'] = $rol;

        // 3. Decidimos a dónde enviarlo (SIN EXTENSIONES)
        if ($rol === 'admin') {
            header('Location: ../dashboard.php');
        } else {
            header('Location: ../client_panel.php');
        }
        exit;
    }
}

// Si llega aquí es que falló el login
echo "<script>
    alert('Usuario o contraseña incorrectos');
    window.location.href='../login';
</script>";
?>