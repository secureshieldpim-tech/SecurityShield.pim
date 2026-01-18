<?php
// api/check_session.php ACTUALIZADO
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['usuario'])) {
    // Intentar leer el tema actualizado del fichero si no está en sesión
    // (Simplificación: Devolvemos lo que hay en sesión, asegúrate de actualizar $_SESSION al login)
    echo json_encode([
        'logged_in' => true,
        'nombre' => $_SESSION['nombre'] ?? 'Usuario',
        'tema' => $_SESSION['tema'] ?? 'default' // <--- NUEVO CAMPO
    ]);
} else {
    echo json_encode(['logged_in' => false]);
}
?>