<?php
require_once '../classes/JsonHandler.php';

$db = new JsonHandler('users.json');

// Datos de tu usuario administrador
$usuarioAdmin =;

// Ojo: Esto sobrescribe el archivo de usuarios para reiniciarlo
file_put_contents('../data/users.json', json_encode([$usuarioAdmin], JSON_PRETTY_PRINT));

echo "✅ Usuario creado correctamente.<br>";
echo "Email: admin@secureshield.com<br>";
echo "Contraseña: admin123";
?>