<?php
// api/login.php

// Configuración de la sesión (duración de 30 días)
$duracion = 60 * 60 * 24 * 30;
ini_set('session.gc_maxlifetime', $duracion);
session_set_cookie_params([
    'lifetime' => $duracion,
    'path' => '/',
    'domain' => '', 
    'secure' => true, // true en producción (https)
    'httponly' => true
]);

session_start();

// Incluimos el handler de Cloudflare
require_once 'CloudflareHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. CARGAR CLAVE SECRETA (ESTO ES LO QUE TE FALTABA)
    // Sin esto, $config no existe y el login falla
    $config = require __DIR__ . '/secrets.php';
    $secretKey = $config['turnstile_secret']; 

    // --- INICIO VERIFICACIÓN TURNSTILE ---
    $turnstileResponse = $_POST['cf-turnstile-response'] ?? '';
    $ip = $_SERVER['REMOTE_ADDR'];

    $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
    $data = [
        'secret' => $secretKey,
        'response' => $turnstileResponse,
        'remoteip' => $ip
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);

    if ($response->success == false) {
        echo "<script>
            alert('Error de seguridad: Por favor completa el captcha.');
            window.location.href='../login.html';
        </script>";
        exit;
    }
    // --- FIN VERIFICACIÓN TURNSTILE ---


    // 2. PROCESAR EL LOGIN NORMAL
    $emailIngresado = $_POST['email'] ?? '';
    $passIngresada = $_POST['password'] ?? '';

    // Instanciamos la conexión a Cloudflare
    $db = new CloudflareHandler();

    // Buscamos el usuario por su email
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $resultados = $db->query($sql, [$emailIngresado]);

    // Verificamos si la base de datos devolvió algún usuario
    $usuarioEncontrado = null;
    if (!empty($resultados) && isset($resultados[0])) {
        $usuarioEncontrado = $resultados[0];
    } elseif (!empty($resultados) && isset($resultados['id'])) {
        $usuarioEncontrado = $resultados;
    }

    // Comprobamos la contraseña
    if ($usuarioEncontrado && password_verify($passIngresada, $usuarioEncontrado['password'])) {
        
        // ¡LOGIN CORRECTO!
        $_SESSION['usuario'] = $usuarioEncontrado['email'];
        $_SESSION['user_id'] = $usuarioEncontrado['id'];
        $_SESSION['nombre'] = $usuarioEncontrado['nombre'];
        $_SESSION['rol'] = $usuarioEncontrado['rol'] ?? 'cliente';
        $_SESSION['tema'] = $usuarioEncontrado['tema'] ?? 'default';

        // Redirección al panel principal
        header('Location: ../principal'); 
        exit;

    } else {
        // Login Fallido
        echo "<script>
            alert('Usuario o contraseña incorrectos.');
            window.location.href='../login.html';
        </script>";
    }
} else {
    // Si intentan entrar directo al archivo sin POST
    header('Location: ../login.html');
    exit;
}
?>