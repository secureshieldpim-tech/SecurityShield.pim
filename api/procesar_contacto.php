<?php
// api/procesar_contacto.php
header('Content-Type: application/json');
require_once 'CloudflareHandler.php';

// Leer el JSON que envía el Javascript
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

if ($input) {
    $nombre = $input['nombre'] ?? 'Anónimo';
    $email = $input['email'] ?? 'No especificado';
    $mensaje = $input['mensaje'] ?? '';

    try {
        $db = new CloudflareHandler();
        
        $sql = "INSERT INTO mensajes_contacto (nombre, email, mensaje, fecha, leido) VALUES (?, ?, ?, datetime('now'), 0)";
        
        // Ejecutar la inserción
        $db->query($sql, [$nombre, $email, $mensaje]);

        echo json_encode(['estado' => 'exito', 'mensaje' => 'Mensaje guardado en D1']);

    } catch (Exception $e) {
        // En producción podrías guardar el error en un log
        echo json_encode(['estado' => 'error', 'mensaje' => 'Error de conexión: ' . $e->getMessage()]);
    }

} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No llegaron datos válidos']);
}
?>