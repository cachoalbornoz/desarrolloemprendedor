<?php

require_once '../accesorios/accesos_bd.php';

$con = conectar();

$request = $_REQUEST;

$sql = 'SELECT exped.nro_proyecto, year(exped.fecha_otorgamiento) as ano, emp.apellido, emp.nombres , exp.id_pago, exp.id_cuenta, exp.fecha, exp.monto, exp.nro_operacion, tp.pago
FROM expedientes_pagos as exp, tipo_pago as tp, expedientes as exped,
rel_expedientes_emprendedores as rel ,emprendedores as emp
WHERE tp.id_tipo_pago = exp.id_tipo_pago AND exp.id_expediente = exped.id_expediente AND exped.id_expediente = rel.id_expediente AND rel.id_emprendedor = emp.id_emprendedor
AND emp.id_responsabilidad = 1 ';

// FILTRO
if (!empty($request['search']['value'])) {
    $sql .= " AND concat(emp.apellido, ', ', emp.nombres) like '%" . $request['search']['value'] . "%'";
    //$sql .= " OR exp.nro_proyecto like '%" . $request['search']['value'] . "%'";
}

if (!empty($_POST['id_cuenta']) and $_POST['id_cuenta'] > 0) {
    $sql .= " AND exp.id_cuenta = '" . $_POST['id_cuenta'] . "'";
}

$query       = mysqli_query($con, $sql);
$totalData   = mysqli_num_rows($query);
$totalFilter = $totalData;

$query     = mysqli_query($con, $sql);
$totalData = mysqli_num_rows($query);

// ORDEN

$sql .= ' ORDER BY exp.fecha DESC LIMIT ' . $request['start'] . ' ,' . $request['length'] . ' ';

$query = mysqli_query($con, $sql);

$data = [];

while ($row = mysqli_fetch_array($query)) {
    $subdata = [];

    $cuenta = '622988/5';

    if ($row['id_cuenta'] == 0) {
        $cuenta = '090024/7';
    } else {
        if ($row['id_cuenta'] == 1) {
            $cuenta = '662047/1';
        } else {
            if ($row['id_cuenta'] == 2) {
                $cuenta = '620230/1';
            }
        }
    }

    $subdata['fecha']         = date('d-m-Y', strtotime($row['fecha']));
    $subdata['proyecto']      = $row['nro_proyecto'] . '/' . substr($row['ano'], -2);
    $subdata['titular']       = $row['apellido'] . ', ' . $row['nombres'];
    $subdata['monto']         = number_format($row['monto'], 2, ',', '.');
    $subdata['cuenta']        = $cuenta;
    $subdata['pago']          = $row['pago'];
    $subdata['nro_operacion'] = $row['nro_operacion'];

    $data[] = $subdata;
}

$json_data = [

    'draw'            => intval($request['draw']),
    'recordsTotal'    => intval($totalData),
    'recordsFiltered' => intval($totalFilter),
    'data'            => $data,
];

print json_encode($json_data);
