<?php
// Asegúrate de que CloudflareHandler.php está en la misma carpeta 'api'
require_once 'CloudflareHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($nombre) && !empty($email) && !empty($password)) {
        
        $db = new CloudflareHandler();
        
        // 1. Verificar si existe
        $sqlCheck = "SELECT id FROM usuarios WHERE email = ?";
        $existe = $db->query($sqlCheck, [$email]);
        
        if (!empty($existe)) {
            echo "<script>
                    alert('Error: Este email ya existe.');
                    window.location.href='../registro.html';
                  </script>";
            exit;
        }

        // 2. Insertar usuario
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sqlInsert = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
        
        // Ejecutar
        $db->query($sqlInsert, [$nombre, $email, $passwordHash]);

        // 3. Redirección CORRECTA
        // Aquí estaba el fallo: ahora te enviamos a login.html que SÍ funciona
        echo "<script>
                alert('¡CUENTA CREADA EN CLOUDFLARE! Pulsa Aceptar para entrar.');
                window.location.href='../login.html';
              </script>";
    } else {
        echo "<script>alert('Faltan datos.'); window.history.back();</script>";
    }
}
?>