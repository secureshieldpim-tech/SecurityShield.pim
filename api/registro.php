<?php
// api/registro.php

// Incluimos el handler para la BD
require_once 'CloudflareHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Recogemos los datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? ''; // El campo nuevo
    $turnstileResponse = $_POST['cf-turnstile-response'] ?? '';

    // 2. VALIDACIÓN DE CONTRASEÑAS (NUEVO)
    // Antes de molestar a Cloudflare, comprobamos esto que es básico
    if ($password !== $passwordConfirm) {
        echo "<script>
                alert('Error: Las contraseñas no coinciden. Inténtalo de nuevo.');
                window.history.back(); 
              </script>";
        exit;
    }

    // 3. CARGAR CLAVE SECRETA (SEGURIDAD)
    // Cargamos el archivo que pusimos en .gitignore para no exponer la clave
    $config = require __DIR__ . '/secrets.php';
    $secretKey = $config['turnstile_secret']; 

    // 4. VERIFICACIÓN TURNSTILE (CAPTCHA)
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

    // Si Cloudflare dice que es un robot o el token es inválido:
    if ($response->success == false) {
        echo "<script>
            alert('Error de seguridad: No has superado la verificación (Captcha).');
            window.location.href='../registro.html';
        </script>";
        exit;
    }

    // 5. REGISTRO EN BASE DE DATOS (Si llega aquí, es humano y las claves coinciden)
    if (!empty($nombre) && !empty($email) && !empty($password)) {

        $db = new CloudflareHandler();

        // A. Comprobar si ya existe el email
        $sqlCheck = "SELECT id FROM usuarios WHERE email = ?";
        $existe = $db->query($sqlCheck, [$email]);

        if (!empty($existe)) {
            echo "<script>
                    alert('Error: Ese email ya está registrado en SecurityShield.');
                    window.location.href='../registro.html';
                  </script>";
            exit;
        }

        // B. Guardar el nuevo usuario (Hash de contraseña)
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sqlInsert = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";

        $db->query($sqlInsert, [$nombre, $email, $passwordHash]);

        // C. ÉXITO TOTAL
        echo "<script>
                alert('¡CUENTA CREADA! Ya puedes iniciar sesión.');
                window.location.href='../login.html';
              </script>";
    } else {
        echo "<script>alert('Faltan datos obligatorios.'); window.history.back();</script>";
    }
} else {
    // Si intentan entrar directo al archivo sin enviar formulario
    header('Location: ../registro.html');
    exit;
}
?>