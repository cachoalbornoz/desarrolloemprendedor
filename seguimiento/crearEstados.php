<?php

$query_estado   = mysqli_query($con, "SELECT id_estado, estado, icono FROM tipo_estado WHERE id_estado NOT IN (0,99) ORDER BY estado ASC");
$data       = [];

while ($row = mysqli_fetch_array($query_estado)) {      

    $arreglo = array(
        "id_estado"     => (int)$row['id_estado'],
        "nombre"        => $row['estado'],
        "icono"         => $row['icono'],
    );        
    $data[]    = $arreglo;
}

$filename = "estados.js";
$handle = fopen($filename, 'w+');
$contenido = "let estados = " . json_encode($data) . ";";
fputs($handle, $contenido);
fclose($handle);