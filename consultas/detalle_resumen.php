<?php

require_once '../accesorios/accesos_bd.php';

$con = conectar();

$request = $_REQUEST;

// COLUMNAS DE LA TABLA
$col = [
    0 => 'fecha',
    1 => 'codigo',
    2 => 'titular',
    3 => 'monto',
    4 => 'cuenta',
    5 => 'tipo',
    6 => 'operacion',
];

$sql = 'SELECT exped.nro_proyecto, year(exped.fecha_otorgamiento) as ano, emp.apellido, emp.nombres , ep.id_pago, ep.id_cuenta, ep.fecha, ep.monto, ep.nro_operacion, tp.pago, tc.tipo
    FROM expedientes_pagos as ep 
    INNER JOIN tipo_cuenta as tc ON ep.id_cuenta = tc.id
    INNER JOIN tipo_pago as tp ON tp.id_tipo_pago = ep.id_tipo_pago 
    INNER JOIN expedientes as exped ON ep.id_expediente = exped.id_expediente 
    INNER JOIN rel_expedientes_emprendedores as rel ON exped.id_expediente = rel.id_expediente 
    INNER JOIN emprendedores as emp ON rel.id_emprendedor = emp.id_emprendedor
    WHERE rel.id_responsabilidad = 1';

$query     = mysqli_query($con, $sql);
$totalData = mysqli_num_rows($query);

// FILTRO
if (!empty($request['search']['value'])) {
    $sql .= " AND ( CONCAT(TRIM(emp.apellido), ', ', TRIM(emp.nombres)) like '" . $request['search']['value'] . "%')";
}

$query       = mysqli_query($con, $sql);
$totalFilter = mysqli_num_rows($query);

// ORDEN

if ($request['length'] > 0) {
    $sql .= ' ORDER BY ep.fecha DESC LIMIT ' . $request['start'] . ' ,' . $request['length'] . ' ';
} else {
    $sql .= ' ORDER BY ep.fecha DESC  ';
}

$query = mysqli_query($con, $sql);

$data = [];

while ($row = mysqli_fetch_array($query)) {
    $subdata = [];

    $proyecto = ($row['nro_proyecto']) ? $row['nro_proyecto'] : null;
    $anio     = ($row['ano']) ? substr($row['ano'], -2) : null;

    $subdata[] = date('d-m-Y', strtotime($row['fecha']));
    $subdata[] = $proyecto . '/' . $anio;
    $subdata[] = trim($row['apellido']) . ', ' . trim($row['nombres']);
    $subdata[] = number_format($row['monto'], 2, ',', '.');
    $subdata[] = $row['tipo'];
    $subdata[] = $row['pago'];
    $subdata[] = $row['nro_operacion'];

    $data[] = $subdata;
}

$json_data = [

    'draw'            => intval($request['draw']),
    'recordsTotal'    => intval($totalData),
    'recordsFiltered' => intval($totalFilter),
    'data'            => $data,
];

print json_encode($json_data);
