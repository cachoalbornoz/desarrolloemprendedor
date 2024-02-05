<?php

// Data rubros
$query_rubro   = mysqli_query($con, "SELECT id_rubro, rubro FROM tipo_rubro_productivos ORDER BY rubro ASC");
$data       = [];

while ($row = mysqli_fetch_array($query_rubro)) {
    
    $arreglo = array(
        "id_rubro"     => (int)$row['id_rubro'],
        "nombre"        => substr($row['rubro'], 0, 35),
    );        
    $data[]    = $arreglo;
}

$filename = "rubros.js";
$handle = fopen($filename, 'w+');
$contenido = "let rubros = " . json_encode($data) . ";";
fputs($handle, $contenido);
fclose($handle);