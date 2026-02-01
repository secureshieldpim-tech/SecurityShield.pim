<?php
class CloudflareHandler {
    // URL del Worker (Coincide con la que tienes en el código que me pasaste)
    private $workerUrl = "https://securityshield-api.rosadocortesivan.workers.dev/"; 

    // Tu contraseña de seguridad (Debe coincidir con la del Worker en JS)
    private $apiSecret = "ClaveSegura_2026"; 

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
        
        // 1. DETECCIÓN DE ERRORES DE CONEXIÓN (NUEVO)
        // Si la URL está mal o no tienes internet, esto te avisará en lugar de dar un error genérico.
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