<?php

$query   = mysqli_query($con, "SELECT year(date(fecha_otorgamiento)) as anio
    FROM expedientes
    WHERE year(date(fecha_otorgamiento)) > 0
    GROUP BY year(date(fecha_otorgamiento)) 
    ORDER BY year(date(fecha_otorgamiento)) ");
$data       = [];

while ($row = mysqli_fetch_array($query)) {      

    $arreglo = array(
        "anio"   => (int)$row['anio'],
    );        
    $data[]    = $arreglo;
}

$filename = "anios.js";
$handle = fopen($filename, 'w+');
$contenido = "let anios = " . json_encode($data) . ";";
fputs($handle, $contenido);
fclose($handle);