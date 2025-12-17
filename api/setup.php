<?php
require_once '../classes/JsonHandler.php';

$db = new JsonHandler('users.json');

// CORRECCIÓN: Definimos el array con los datos y HASHEAMOS la contraseña
$usuarioAdmin = [
    'nombre' => 'Administrador',
    'email' => 'admin@secureshield.com',
    'password' => password_hash('admin123', PASSWORD_DEFAULT) // Importante: encriptar
];

// Guardamos el usuario dentro de un array (corchetes extra para que sea una lista)
file_put_contents('../data/users.json', json_encode([$usuarioAdmin], JSON_PRETTY_PRINT));

echo "✅ Usuario creado correctamente.<br>";
echo "Email: admin@secureshield.com<br>";
echo "Contraseña: admin123";
?>