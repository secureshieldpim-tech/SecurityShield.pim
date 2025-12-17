<?php
class JsonHandler {
    private $archivo;

    public function __construct($nombreArchivo) {
        // Ruta absoluta compatible con Windows XAMPP
        $this->archivo = __DIR__ . '/../data/' . $nombreArchivo;
        
        // Crear carpeta data si no existe
        if (!is_dir(dirname($this->archivo))) {
            mkdir(dirname($this->archivo), 0777, true);
        }

        // Crear archivo vacío si no existe con un array vacío
        if (!file_exists($this->archivo)) {
            file_put_contents($this->archivo, json_encode([]));
        }
    }

    public function guardarRegistro($nuevoDato) {
        $fp = fopen($this->archivo, 'c+');
        
        // Bloqueo para evitar errores si dos personas escriben a la vez
        if (flock($fp, LOCK_EX)) {
            // Leer contenido actual
            $filesize = filesize($this->archivo);
            $contenido = $filesize > 0 ? fread($fp, $filesize) : '';
            
            // Decodificar JSON actual
            $arrayDatos = json_decode($contenido, true);
            if (!is_array($arrayDatos)) {
                $arrayDatos = []; // <--- CORRECCIÓN 1: Faltaban los corchetes aquí (Línea 32)
            }

            // Añadir ID y Fecha
            $nuevoDato['id'] = uniqid();
            $nuevoDato['fecha'] = date('Y-m-d H:i:s');

            // --- CORRECCIÓN 2: LÓGICA DE GUARDADO ---
            $arrayDatos[] = $nuevoDato; // Añadir al final del array con []
            // ----------------------------------------

            // Borrar contenido viejo y escribir el nuevo array completo
            ftruncate($fp, 0);
            rewind($fp);
            fwrite($fp, json_encode($arrayDatos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            
            fflush($fp);
            flock($fp, LOCK_UN);
            fclose($fp);
            return true;
        }
        fclose($fp);
        return false;
    }

    public function leerRegistros() {
        if (!file_exists($this->archivo)) return [];
        $json = file_get_contents($this->archivo);
        $datos = json_decode($json, true);
        // CORRECCIÓN 3: Faltaban los corchetes al final del return
        return is_array($datos) ? $datos : []; 
    }
}
?>