<?php
require_once '../classes/JsonHandler.php';

// Leer el JSON que envía el Javascript (payment.js)
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

if ($input) {
    // TRUCO: Adaptamos los datos de la compra al formato que ya lee tu Dashboard.
    // Dashboard espera: 'nombre', 'email', 'mensaje'
    
    $plan = strtoupper($input['plan'] ?? 'UNKNOWN');
    $titular = $input['titular'] ?? 'Cliente Anónimo';
    
    $datos = [
        'nombre' => "💰 NUEVA VENTA ($titular)",     // Aparecerá destacado en la columna Usuario
        'email'  => "Plan $plan",                    // Aparecerá en la columna de email
        'mensaje'=> "Se ha registrado un pago exitoso simulado. Servicio activado automáticamente." 
    ];

    $db = new JsonHandler('registros.json');
    
    if($db->guardarRegistro($datos)) {
        echo json_encode(['estado' => 'exito', 'mensaje' => 'Compra registrada']);
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'Error al guardar transacción']);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'Datos de pago no válidos']);
}
?>