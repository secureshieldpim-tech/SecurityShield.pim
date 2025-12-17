<?php
session_start();
require_once '../classes/JsonHandler.php';

$emailIngresado = $_POST['email']?? '';
$passIngresada = $_POST['password']?? '';

$db = new JsonHandler('users.json');
$usuarios = $db->leerRegistros();

foreach ($usuarios as $user) {
    // Comprobar email y contraseña
    if ($user['email'] === $emailIngresado && password_verify($passIngresada, $user['password'])) {
        $_SESSION['usuario'] = $user['nombre'];
        header('Location:../dashboard.php'); // ¡Éxito! Al dashboard
        exit;
    }
}

// Si falla
echo "<script>
    alert('Usuario o contraseña incorrectos');
    window.location.href='../login.html';
</script>";
?>