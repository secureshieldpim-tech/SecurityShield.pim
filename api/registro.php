<?php
// Incluimos el archivo que acabamos de crear
require_once 'CloudflareHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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