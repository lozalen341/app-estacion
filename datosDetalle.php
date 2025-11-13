<?php
header('Content-Type: application/json');

// Tomamos el chipid y la cantidad de filas desde la URL
$chipid = $_GET['chipid'] ?? '';
$cant   = $_GET['cant'] ?? 1;

// Si no hay chipid, devolvemos vacío
if(!$chipid){
    echo json_encode([]);
    exit;
}

// URL del endpoint de detalle de la estación
$url = "https://mattprofe.com.ar/proyectos/app-estacion/datos.php?chipid={$chipid}&cant={$cant}";

// Obtenemos los datos
$datos = file_get_contents($url);

// Devolvemos el JSON tal cual llega
echo $datos;
