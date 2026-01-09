<?php
require_once '../classes/JsonHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($nombre) && !empty($email) && !empty($password)) {
        
        $db = new JsonHandler('users.json');
        
        // 1. Verificar si el email ya existe
        $usuariosExistentes = $db->leerRegistros();
        foreach ($usuariosExistentes as $usuario) {
            if ($usuario['email'] === $email) {
                echo "<script>
                        alert('Error: Este email ya está registrado.');
                        window.location.href='../registro';
                      </script>";
                exit;
            }
        }

        // 2. Crear el nuevo usuario
        $nuevoUsuario = [
            'nombre' => $nombre,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        // 3. Guardar
        if ($db->guardarRegistro($nuevoUsuario)) {
            echo "<script>
                    alert('¡Cuenta creada con éxito! Ahora puedes iniciar sesión.');
                    window.location.href='../login';
                  </script>";
        } else {
            echo "<script>alert('Error al guardar en la base de datos.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Por favor completa todos los campos.'); window.history.back();</script>";
    }
}