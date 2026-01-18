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

// Rutas de archivos
$archivoUsuarios = '../data/users.json';
$archivoVentas = '../data/clientes_pendientes.json';

// --- VALIDACIÓN PREVIA: Comprobar si ya tiene plan activo ---
// Cargamos usuarios antes de hacer nada para verificar
if (file_exists($archivoUsuarios)) {
    $usuarios = json_decode(file_get_contents($archivoUsuarios), true);
    $usuarioIndex = -1;

    // Buscamos al usuario
    foreach ($usuarios as $key => $user) {
        if ($user['email'] === $emailUsuario) {
            $usuarioIndex = $key;
            
            // Comprobar planes activos
            if (isset($user['planes']) && is_array($user['planes'])) {
                foreach ($user['planes'] as $plan) {
                    $fechaExpiracion = strtotime($plan['fecha_expiracion']);
                    $ahora = time();

                    if ($fechaExpiracion > $ahora) {
                        // ¡STOP! Tiene un plan activo.
                        echo json_encode([
                            'success' => false, 
                            'message' => 'AVISO: Ya tienes el plan "' . $plan['nombre'] . '" activo. Debes esperar a que caduque para contratar otro.'
                        ]);
                        exit; // Detenemos el script aquí. No se guarda venta ni se cobra.
                    }
                }
            }
            break;
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error: Base de datos de usuarios no encontrada']);
    exit;
}

// SI LLEGAMOS AQUÍ, ES QUE NO TIENE PLANES ACTIVOS. PROCESAMOS LA COMPRA.

// --- PARTE A: GUARDAR REGISTRO DE VENTA (ADMINISTRACIÓN) ---
$nuevaVenta = [
    'id_pedido' => uniqid('ORD-'),
    'fecha' => $fechaHoy,
    'cliente' => $data['nombre'] ?? 'Desconocido',
    'email' => $emailUsuario,
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

$ventas = file_exists($archivoVentas) ? json_decode(file_get_contents($archivoVentas), true) : [];
$ventas[] = $nuevaVenta;
file_put_contents($archivoVentas, json_encode($ventas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));


// --- PARTE B: ACTUALIZAR EL USUARIO EN USERS.JSON ---
// Usamos el índice que encontramos arriba para ir directos
if ($usuarioIndex !== -1) {
    if (!isset($usuarios[$usuarioIndex]['planes'])) {
        $usuarios[$usuarioIndex]['planes'] = [];
    }

    $usuarios[$usuarioIndex]['planes'][] = [
        'nombre' => $nombrePlan,
        'fecha_compra' => $fechaHoy,
        'fecha_expiracion' => $fechaFin,
        'activo' => true
    ];

    file_put_contents($archivoUsuarios, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    echo json_encode([
        'success' => true, 
        'message' => 'Plan activado correctamente en tu perfil'
    ]);
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Error crítico: Usuario no encontrado al guardar el plan'
    ]);
}
?>