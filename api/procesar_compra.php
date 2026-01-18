<?php
session_start();
header('Content-Type: application/json');

// 0. Seguridad: Verificar si el usuario está logueado en el Backend
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

// 1. Recibir el JSON
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No se recibieron datos']);
    exit;
}

// Datos calculados
$fechaHoy = date('Y-m-d H:i:s');
$fechaFin = date('Y-m-d H:i:s', strtotime('+7 days')); // Caduca en 7 días
$emailUsuario = $_SESSION['usuario'];
$nombrePlan = $data['plan'] ?? 'Estándar';

// --- PARTE A: GUARDAR REGISTRO DE VENTA (ADMINISTRACIÓN) ---
$nuevaVenta = [
    'id_pedido' => uniqid('ORD-'),
    'fecha' => $fechaHoy,
    'cliente' => $data['nombre'] ?? 'Desconocido',
    'email' => $emailUsuario, // Usamos el email de la sesión para asegurar
    'plan_info' => [
        'nombre_plan' => $nombrePlan,
        'precio' => $data['precio'] ?? '0'
    ],
    'datos_tecnicos' => [
        'sistema_operativo' => $data['os'] ?? 'No especificado',
        'arquitectura' => $data['arquitectura'] ?? 'No especificada'
    ],
    'estado' => 'pagado_pendiente_envio'
];

$archivoVentas = '../data/clientes_pendientes.json';
$ventas = file_exists($archivoVentas) ? json_decode(file_get_contents($archivoVentas), true) : [];
$ventas[] = $nuevaVenta;
file_put_contents($archivoVentas, json_encode($ventas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));


// --- PARTE B: ACTUALIZAR EL USUARIO EN USERS.JSON (LOGICA DE NEGOCIO) ---
$archivoUsuarios = '../data/users.json';

if (file_exists($archivoUsuarios)) {
    $usuarios = json_decode(file_get_contents($archivoUsuarios), true);
    $usuarioEncontrado = false;

    // Recorremos usuarios por referencia (&) para poder modificarlos
    foreach ($usuarios as &$user) {
        if ($user['email'] === $emailUsuario) {
            
            // Si no tiene array de planes, lo creamos
            if (!isset($user['planes'])) {
                $user['planes'] = [];
            }

            // Añadimos el nuevo plan
            $user['planes'][] = [
                'nombre' => $nombrePlan,
                'fecha_compra' => $fechaHoy,
                'fecha_expiracion' => $fechaFin,
                'activo' => true
            ];
            
            $usuarioEncontrado = true;
            break; // Dejamos de buscar
        }
    }

    if ($usuarioEncontrado) {
        // Guardamos el archivo users.json actualizado
        file_put_contents($archivoUsuarios, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        echo json_encode([
            'success' => true, 
            'message' => 'Plan activado correctamente en tu perfil'
        ]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Error crítico: Usuario no encontrado en base de datos'
        ]);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Error: Base de datos de usuarios no encontrada']);
}
?>