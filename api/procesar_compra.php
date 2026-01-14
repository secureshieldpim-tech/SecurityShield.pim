<?php
header('Content-Type: application/json');

// 1. Recibir el JSON que envía el nuevo payment.js
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

// Verificar si llegaron datos
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No se recibieron datos de la compra']);
    exit;
}

// 2. Estructurar la información de la venta y los datos técnicos
// Usamos uniqid() para darle un número de pedido único
$nuevaVenta = [
    'id_pedido' => uniqid('ORD-'),
    'fecha' => date('Y-m-d H:i:s'),
    'cliente' => $data['nombre'] ?? 'Desconocido',
    'email' => $data['email'] ?? 'Sin email',
    'plan_info' => [
        'nombre_plan' => $data['plan'] ?? 'Estándar',
        'precio' => $data['precio'] ?? '0'
    ],
    'datos_tecnicos' => [
        'sistema_operativo' => $data['os'] ?? 'No especificado',
        'arquitectura' => $data['arquitectura'] ?? 'No especificada'
    ],
    'estado' => 'pagado_pendiente_envio'
];

// 3. Guardar en un archivo JSON específico para ventas
// Nota: Guardamos esto en 'clientes_pendientes.json' para no mezclarlo con mensajes de contacto
$archivoJson = '../data/clientes_pendientes.json';

$ventas = [];

// Si el fichero ya existe, leemos las ventas anteriores
if (file_exists($archivoJson)) {
    $contenidoActual = file_get_contents($archivoJson);
    $ventas = json_decode($contenidoActual, true) ?? [];
}

// Añadimos la nueva venta al array
$ventas[] = $nuevaVenta;

// 4. Guardar el archivo actualizado
if (file_put_contents($archivoJson, json_encode($ventas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {

    // ÉXITO: Respondemos al Javascript
    echo json_encode([
        'success' => true,
        'estado' => 'exito', // Mantengo ambos por compatibilidad
        'message' => 'Compra y datos técnicos registrados correctamente'
    ]);

} else {
    // ERROR
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'estado' => 'error',
        'message' => 'Error al guardar el registro en el servidor'
    ]);
}
?>