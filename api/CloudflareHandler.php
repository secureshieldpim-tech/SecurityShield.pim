<?php
class CloudflareHandler {
    // URL del Worker (Coincide con la que tienes en el código que me pasaste)
    private $workerUrl = "https://securityshield-api.rosadocortesivan.workers.dev/"; 

    // Variable para la contraseña (se cargará desde secrets.php)
    private $apiSecret; 

    public function __construct() {
        // Cargamos la configuración desde el archivo externo protegido
        // Usamos __DIR__ para asegurar la ruta correcta dentro de la carpeta 'api'
        $config = require __DIR__ . '/secrets.php';
        
        // Asignamos la contraseña del archivo a la variable privada
        $this->apiSecret = $config['api_secret'];
    }

    public function query($sql, $params = []) {
        $ch = curl_init($this->workerUrl);
        
        // Preparamos los datos para enviar
        $payload = json_encode(['sql' => $sql, 'params' => $params]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiSecret
        ]);

        // Ejecutamos la petición
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // 1. DETECCIÓN DE ERRORES DE CONEXIÓN
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            die("Error Crítico de Conexión cURL: " . $error_msg);
        }
        curl_close($ch);

        // 2. DETECCIÓN DE ERRORES DEL WORKER (404, 500, 401)
        if ($httpCode !== 200) {
            // Usamos htmlspecialchars para que el error se vea bien en el navegador y no rompa el HTML
            die("Error del Worker (Código HTTP $httpCode): " . htmlspecialchars($response));
        }

        // 3. DECODIFICACIÓN Y VALIDACIÓN DEL JSON
        $decoded = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            die("Error JSON: La respuesta del Worker no es válida. Respuesta recibida: " . htmlspecialchars($response));
        }

        return $decoded;
    }
}
?>