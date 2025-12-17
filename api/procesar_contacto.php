<?php
require_once '../classes/JsonHandler.php';

// Leer el JSON que envía el Javascript (logic.js)
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

if ($input) {
    $datos = [
        'nombre' => $input['nombre']?? 'Anónimo',
        'email' => $input['email']?? 'No especificado',
        'mensaje' => $input['mensaje']?? ''
    ];

    $db = new JsonHandler('registros.json');
    
    if($db->guardarRegistro($datos)) {
        echo json_encode(['estado' => 'exito', 'mensaje' => 'Guardado correctamente']);
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'Error al escribir en disco']);
    }
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No llegaron datos']);
}
?>