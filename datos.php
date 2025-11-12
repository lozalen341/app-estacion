<?php
header('Content-Type: application/json');
$datos = file_get_contents("https://mattprofe.com.ar/proyectos/app-estacion/datos.php?mode=list-stations");
echo $datos;
?>