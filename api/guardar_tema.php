<?php
// Archivo: api/guardar_tema.php
session_start();
header('Content-Type: application/json');
require_once 'CloudflareHandler.php';

// Validar sesión
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

// Leer datos entrada
$input = json_decode(file_get_contents('php://input'), true);
$nuevoTema = $input['tema'] ?? 'default';

// Validar temas permitidos
$temasValidos = ['default', 'light', 'dark'];
if (!in_array($nuevoTema, $temasValidos)) {
    $nuevoTema = 'default';
}

try {
    $db = new CloudflareHandler();
    
    // SQL para actualizar el tema del usuario logueado
    $sql = "UPDATE usuarios SET tema = ? WHERE email = ?";
    // Ejecutamos la consulta. Cloudflare devuelve un resultado, pero en un UPDATE nos interesa que no dé error.
    $db->query($sql, [$nuevoTema, $_SESSION['usuario']]);

    // Actualizamos la sesión para que se note el cambio sin recargar
    $_SESSION['tema'] = $nuevoTema;

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error al guardar tema: ' . $e->getMessage()]);
}
?>