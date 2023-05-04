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

$sql = 'SELECT exped.nro_proyecto, year(exped.fecha_otorgamiento) as ano, emp.apellido, emp.nombres , exp.id_pago, exp.id_cuenta, exp.fecha, exp.monto, exp.nro_operacion, tp.pago
FROM expedientes_pagos as exp, tipo_pago as tp, expedientes as exped,
rel_expedientes_emprendedores as rel, emprendedores as emp
WHERE tp.id_tipo_pago = exp.id_tipo_pago and exp.id_expediente = exped.id_expediente
AND exped.id_expediente = rel.id_expediente AND rel.id_emprendedor = emp.id_emprendedor AND rel.id_responsabilidad = 1';

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
    $sql .= ' ORDER BY exp.fecha DESC LIMIT ' . $request['start'] . ' ,' . $request['length'] . ' ';
} else {
    $sql .= ' ORDER BY exp.fecha DESC  ';
}

$query = mysqli_query($con, $sql);

$data = [];

while ($row = mysqli_fetch_array($query)) {
    $subdata = [];

    $cuenta = null;
    if ($row['id_cuenta'] == 0) {
        $cuenta = '090024/7';
    } else {
        if ($row['id_cuenta'] == 1) {
            $cuenta = '662047/1';
        } else {
            if ($row['id_cuenta'] == 2) {
                $cuenta = '620230/1';
            } else {
                $cuenta = '622988/5';
            }
        }
    }

    $proyecto = ($row['nro_proyecto']) ? $row['nro_proyecto'] : null;
    $anio     = ($row['ano']) ? substr($row['ano'], -2) : null;

    $subdata[] = date('d-m-Y', strtotime($row['fecha']));
    $subdata[] = $proyecto . '/' . $anio;
    $subdata[] = trim($row['apellido']) . ', ' . trim($row['nombres']);
    $subdata[] = number_format($row['monto'], 2, ',', '.');
    $subdata[] = $cuenta;
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
