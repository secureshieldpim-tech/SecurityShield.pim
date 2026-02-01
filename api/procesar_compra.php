<?php
// api/procesar_compra.php
session_start();
header('Content-Type: application/json');
require_once 'CloudflareHandler.php';

// 0. Verificar login
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

// 1. Recibir datos
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No se recibieron datos']);
    exit;
}

$db = new CloudflareHandler();
$emailUsuario = $_SESSION['usuario'];
$nombrePlan = $data['plan'] ?? 'Estándar';
$fechaHoy = date('Y-m-d H:i:s');
$fechaFin = date('Y-m-d H:i:s', strtotime('+7 days')); 

try {
    // A. OBTENER ID DEL USUARIO
    // Intentamos sacarlo de sesión, si no, lo consultamos
    $usuarioId = $_SESSION['user_id'] ?? null;
    if (!$usuarioId) {
        $resUser = $db->query("SELECT id FROM usuarios WHERE email = ?", [$emailUsuario]);
        if (!empty($resUser) && isset($resUser[0]['id'])) {
            $usuarioId = $resUser[0]['id'];
            $_SESSION['user_id'] = $usuarioId;
        } else {
            throw new Exception("Usuario no encontrado en la base de datos.");
        }
    }

    // B. VALIDAR SI YA TIENE PLAN ACTIVO
    // SQLite: datetime('now') nos da la fecha actual para comparar
    $sqlCheck = "SELECT id FROM planes_usuarios WHERE usuario_id = ? AND activo = 1 AND fecha_expiracion > datetime('now')";
    $planesActivos = $db->query($sqlCheck, [$usuarioId]);

    // Verificar si devolvió filas (Cloudflare devuelve array vacío si no hay resultados)
    $yaTienePlan = false;
    if (is_array($planesActivos) && count($planesActivos) > 0) {
        $yaTienePlan = true;
    }

    if ($yaTienePlan) {
        echo json_encode([
            'success' => false, 
            'message' => 'AVISO: Ya tienes un plan activo. Espera a que caduque.'
        ]);
        exit;
    }

    // C. PROCESAR LA COMPRA (Insertar en 2 tablas)

    // 1. Insertar en tabla PEDIDOS (Historial de ventas)
    $idPedido = uniqid('ORD-');
    $sqlPedido = "INSERT INTO pedidos (id_pedido, cliente_nombre, cliente_email, plan, precio, so, arquitectura, estado, fecha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $paramsPedido = [
        $idPedido,
        $data['nombre'] ?? 'Desconocido',
        $emailUsuario,
        $nombrePlan,
        $data['precio'] ?? 0,
        $data['os'] ?? 'No especificado',
        $data['arquitectura'] ?? 'No especificada',
        'pagado_pendiente_envio',
        $fechaHoy
    ];
    
    $db->query($sqlPedido, $paramsPedido);

    // 2. Insertar en tabla PLANES_USUARIOS (Activación del servicio)
    $sqlPlan = "INSERT INTO planes_usuarios (usuario_id, nombre_plan, fecha_compra, fecha_expiracion, activo) VALUES (?, ?, ?, ?, 1)";
    $db->query($sqlPlan, [$usuarioId, $nombrePlan, $fechaHoy, $fechaFin]);

    echo json_encode([
        'success' => true, 
        'message' => 'Plan activado correctamente y guardado en la base de datos.'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Error al procesar la compra: ' . $e->getMessage()
    ]);
}
?>