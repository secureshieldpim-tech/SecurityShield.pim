<?php

class CloudflareHandler {
    private $workerUrl = "https://securityshield-api.rosadocortesivan.workers.dev"; 
    private $apiSecret = "ClaveSegura_2026"; 

    public function query($sql, $params = []) {
        $ch = curl_init($this->workerUrl);
        
        $payload = json_encode([
            'sql' => $sql,
            'params' => $params
        ]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiSecret
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            die('Error Curl: ' . curl_error($ch));
        }
        curl_close($ch);

        if ($httpCode !== 200) {
            die("Error Worker ($httpCode): " . $response);
        }

        return json_decode($response, true);
    }
}
?>