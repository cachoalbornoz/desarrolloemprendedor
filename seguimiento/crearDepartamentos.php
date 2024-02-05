<?php

$query   = mysqli_query($con, "SELECT id, nombre FROM departamentos WHERE provincia_id = 7 ORDER BY nombre ASC");
$data       = [];

while ($row = mysqli_fetch_array($query)) {      

    $arreglo = array(
        "id_departamento"   => (int)$row['id'],
        "nombre"      => $row['nombre'],
    );        
    $data[]    = $arreglo;
}

$filename = "departamentos.js";
$handle = fopen($filename, 'w+');
$contenido = "let departamentos = " . json_encode($data) . ";";
fputs($handle, $contenido);
fclose($handle);