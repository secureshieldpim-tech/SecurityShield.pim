<?php
// Archivo: api/check_session.php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['usuario'])) {
    echo json_encode([
        'logged_in' => true,
        'nombre' => $_SESSION['nombre'] ?? 'Usuario'
    ]);
} else {
    echo json_encode(['logged_in' => false]);
}
?>