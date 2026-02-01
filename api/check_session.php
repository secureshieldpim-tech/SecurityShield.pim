<?php
// api/check_session.php
session_start();
header('Content-Type: application/json');

// Verificamos si la variable de sesión existe
if (isset($_SESSION['usuario'])) {
    echo json_encode([
        'logged_in' => true,
        'nombre' => $_SESSION['nombre'] ?? 'Usuario',
        'email' => $_SESSION['usuario'],
        'rol' => $_SESSION['rol'] ?? 'cliente',
        'tema' => $_SESSION['tema'] ?? 'default'
    ]);
} else {
    echo json_encode([
        'logged_in' => false
    ]);
}
?>