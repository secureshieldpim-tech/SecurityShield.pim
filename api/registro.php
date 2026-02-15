<?php
// Incluimos el archivo que acabamos de crear
require_once 'CloudflareHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- INICIO VERIFICACIÓN TURNSTILE ---
    $turnstileResponse = $_POST['cf-turnstile-response'] ?? '';
    $secretKey = $config['turnstile_secret'];
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
            window.location.href='../registro.html';
        </script>";
        exit;
    }
    // --- FIN VERIFICACIÓN TURNSTILE ---
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($nombre) && !empty($email) && !empty($password)) {

        $db = new CloudflareHandler();

        // 1. Comprobar si ya existe el email
        $sqlCheck = "SELECT id FROM usuarios WHERE email = ?";
        $existe = $db->query($sqlCheck, [$email]);

        if (!empty($existe)) {
            echo "<script>
                    alert('Error: Ese email ya está registrado en Cloudflare.');
                    window.location.href='../registro.html';
                  </script>";
            exit;
        }

        // 2. Guardar el nuevo usuario
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sqlInsert = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";

        $db->query($sqlInsert, [$nombre, $email, $passwordHash]);

        // ÉXITO
        echo "<script>
                alert('¡CONEXIÓN ÉXITOSA! Usuario guardado en la base de datos.');
                window.location.href='../login.html';
              </script>";
    } else {
        echo "<script>alert('Faltan datos.'); window.history.back();</script>";
    }
}
?>