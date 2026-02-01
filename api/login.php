<?php
// Configuración de la sesión (duración de 30 días)
$duracion = 60 * 60 * 24 * 30;
ini_set('session.gc_maxlifetime', $duracion);
session_set_cookie_params([
    'lifetime' => $duracion,
    'path' => '/',
    'domain' => '', 
    'secure' => true, // Pon false si pruebas en localhost sin https, true en producción
    'httponly' => true
]);

session_start();

// CAMBIO: Usamos el handler de Cloudflare en vez de JsonHandler
require_once 'CloudflareHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailIngresado = $_POST['email'] ?? '';
    $passIngresada = $_POST['password'] ?? '';

    // Instanciamos la conexión a Cloudflare
    $db = new CloudflareHandler();

    // 1. Buscamos el usuario por su email en la base de datos
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $resultados = $db->query($sql, [$emailIngresado]);

    // Verificamos si la base de datos devolvió algún usuario
    // (Cloudflare suele devolver un array de resultados)
    $usuarioEncontrado = null;
    if (!empty($resultados) && isset($resultados[0])) {
        $usuarioEncontrado = $resultados[0];
    } elseif (!empty($resultados) && isset($resultados['id'])) {
        // Por si acaso devuelve el objeto directo (depende de la estructura exacta del worker)
        $usuarioEncontrado = $resultados;
    }

    // 2. Comprobamos la contraseña
    if ($usuarioEncontrado && password_verify($passIngresada, $usuarioEncontrado['password'])) {
        
        // ¡LOGIN CORRECTO! Guardamos datos en la sesión
        $_SESSION['usuario'] = $usuarioEncontrado['email'];
        $_SESSION['user_id'] = $usuarioEncontrado['id']; // Guardamos el ID para futuras consultas
        $_SESSION['nombre'] = $usuarioEncontrado['nombre'];
        $_SESSION['rol'] = $usuarioEncontrado['rol'] ?? 'cliente';
        $_SESSION['tema'] = $usuarioEncontrado['tema'] ?? 'default';

        // 3. Redirección al panel principal
        // Nota: Asegúrate de que 'principal' existe (puede ser principal.html o principal.php)
        header('Location: ../principal'); 
        exit;

    } else {
        // Login Fallido
        echo "<script>
            alert('Usuario o contraseña incorrectos (Verificado en D1 Cloudflare)');
            window.location.href='../login';
        </script>";
    }
} else {
    // Si intentan entrar directo al archivo sin POST
    header('Location: ../login');
    exit;
}
?>