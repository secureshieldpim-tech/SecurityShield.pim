<?php
// Archivo: api/guardar_tema.php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$nuevoTema = $input['tema'] ?? 'default';

// Validar temas permitidos
$temasValidos = ['default', 'light', 'dark'];
if (!in_array($nuevoTema, $temasValidos)) {
    $nuevoTema = 'default';
}

$archivoUsuarios = '../data/users.json';

if (file_exists($archivoUsuarios)) {
    $usuarios = json_decode(file_get_contents($archivoUsuarios), true);
    $usuarioEncontrado = false;

    foreach ($usuarios as &$user) {
        if ($user['email'] === $_SESSION['usuario']) {
            $user['tema'] = $nuevoTema; // Guardamos el tema
            $_SESSION['tema'] = $nuevoTema; // Actualizamos la sesión también
            $usuarioEncontrado = true;
            break;
        }
    }

    if ($usuarioEncontrado) {
        file_put_contents($archivoUsuarios, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error de base de datos']);
}
?>