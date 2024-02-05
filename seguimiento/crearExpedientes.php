<?php

// Obtencion de expedientes
$sql_expediente = "SELECT t1.id_expediente, nro_exp_madre, nro_proyecto, t1.latitud, t1.longitud, concat(apellido, ', ' , nombres) AS titular, YEAR(fecha_otorgamiento) AS anio, dni, t7.id as id_departamento, t7.nombre AS departamento, icono, t4.estado, rubro, monto, saldo, t3.id_emprendedor, dni, fecha_otorgamiento, t4.id_estado as id_estado, t1.id_rubro
FROM expedientes t1
INNER JOIN rel_expedientes_emprendedores t2 ON t1.id_expediente = t2.id_expediente
INNER JOIN emprendedores t3 ON t2.id_emprendedor = t3.id_emprendedor
INNER JOIN tipo_estado t4 ON t1.estado = t4.id_estado
INNER JOIN tipo_rubro_productivos t5 ON t1.id_rubro = t5.id_rubro
INNER JOIN localidades t6 ON t3.id_ciudad = t6.id
INNER JOIN departamentos t7 ON t6.departamento_id = t7.id
WHERE t2.id_responsabilidad = 1 AND t1.nro_exp_madre > 0 AND t1.estado <> 99 
ORDER BY apellido ASC";


// Data expedientes
$query_expediente   = mysqli_query($con, $sql_expediente);
$data       = [];

while ($row = mysqli_fetch_array($query_expediente)) {

$arreglo = array(
    "titular"           => $row['titular'],
    "anio"              => (int)$row['anio'],
    "id_departamento"   => $row['id_departamento'],
    "id_estado"         => $row['id_estado'],
    "id_rubro"          => (int)$row['id_rubro'],
    "latitud"           => ($row['latitud'] > 0)?round($row['latitud'],4)*(-1):0,
    "longitud"          =>($row['longitud'] > 0)?round($row['longitud'],4)*(-1):0,
);        

// Si tiene datos de Latitud y Longitud, van al archivo de Expediente 
if(($row['latitud'] > 0) AND ($row['longitud'] > 0)){
    $data[]         = $arreglo;
}
}

$filename = "expedientes.js";
$handle = fopen($filename, 'w+');
$contenido = "let expedientes = " . json_encode($data) . ";";
fputs($handle, $contenido);
fclose($handle);