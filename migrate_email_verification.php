<?php
require_once __DIR__ . '/env.php';
require_once __DIR__ . '/models/DBAbstract.php';

$tokenSeguridad = 'CAMBIAR_ESTE_TOKEN';
if(!isset($_GET['token']) || $_GET['token'] !== $tokenSeguridad){
    http_response_code(403);
    echo 'Acceso denegado';
    exit;
}

class EmailVerificationMigrator extends DBAbstract {
    public function migrate(){
        // Cambiado: usuario → usuarios_app_estacion
        $cols = $this->consultar("SHOW COLUMNS FROM usuarios_app_estacion");
        $names = array_map(fn($c) => $c['Field'], $cols);

        $alterStatements = [];

        if(!in_array('email_verificado', $names)){
            $alterStatements[] = 'ADD COLUMN email_verificado TINYINT(1) NOT NULL DEFAULT 0 AFTER contraseña';
        }
        if(!in_array('verificacion_token', $names)){
            $alterStatements[] = 'ADD COLUMN verificacion_token VARCHAR(90) NULL AFTER email_verificado';
        }
        if(!in_array('verificacion_enviada_en', $names)){
            $alterStatements[] = 'ADD COLUMN verificacion_enviada_en DATETIME NULL AFTER verificacion_token';
        }
        if(!in_array('verificado_en', $names)){
            $alterStatements[] = 'ADD COLUMN verificado_en DATETIME NULL AFTER verificacion_enviada_en';
        }

        if(empty($alterStatements)){
            return ['changed' => false, 'message' => 'Columnas ya existen'];
        }

        // Cambiado: usuario → usuarios_app_estacion
        $sql = 'ALTER TABLE usuarios_app_estacion ' . implode(', ', $alterStatements);
        $ok = $this->ejecutar($sql);

        return ['changed' => $ok, 'sql' => $sql];
    }
}

$m = new EmailVerificationMigrator();
$res = $m->migrate();
header('Content-Type: application/json; charset=utf-8');
echo json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
