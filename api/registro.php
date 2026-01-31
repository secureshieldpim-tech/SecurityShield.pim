<?php
require_once 'CloudflareHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($nombre) && !empty($email) && !empty($password)) {
        
        $db = new CloudflareHandler();
        
        // 1. Comprobar si existe el email (SQL)
        $sqlCheck = "SELECT id FROM usuarios WHERE email = ?";
        $existe = $db->query($sqlCheck, [$email]);
        
        if (!empty($existe)) {
            echo "<script>
                    alert('Error: Este email ya está registrado.');
                    window.location.href='../registro.html'; 
                  </script>"; // Ojo: verifica si es registro.html o ../registro a secas según tu routing
            exit;
        }

        // 2. Crear usuario (SQL)
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sqlInsert = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
        
        $db->query($sqlInsert, [$nombre, $email, $passwordHash]);

        echo "<script>
                alert('¡Cuenta creada en Cloudflare D1! Inicia sesión.');
                window.location.href='../login';
              </script>";
    } else {
        echo "<script>alert('Completa todos los campos.'); window.history.back();</script>";
    }
}
?>