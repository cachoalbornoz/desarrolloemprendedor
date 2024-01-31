<?php
session_start();	
require_once '../accesorios/accesos_bd.php';

$con = conectar();

$request = $_REQUEST;

// COLUMNAS DE LA TABLA

$col = [

    0  => 'nroproyecto',
    1  => 'nroexpmadre',
    2  => 'solicitante',
    3  => 'anio',
    4  => 'dni',
    5  => 'icono',
    6  => '',
    7  => 'estado',
    8  => 'rubro',
    9  => 'fechao',
    10 => 'monto',
    11 => 'saldo',
    12 => 'borrar',
];

$sql = "SELECT t1.id_expediente, nro_exp_madre, nro_proyecto, concat(apellido, ', ' , nombres) AS solicitante, YEAR(fecha_otorgamiento) AS anio, dni, t7.nombre AS localidad, icono, t4.estado, rubro, monto, saldo, t3.id_emprendedor, dni, fecha_otorgamiento, t4.id_estado
FROM expedientes t1
INNER JOIN rel_expedientes_emprendedores t2 ON t1.id_expediente = t2.id_expediente
INNER JOIN emprendedores t3 ON t2.id_emprendedor = t3.id_emprendedor
INNER JOIN tipo_estado t4 ON t1.estado = t4.id_estado
INNER JOIN tipo_rubro_productivos t5 ON t1.id_rubro = t5.id_rubro
INNER JOIN localidades t6 ON t3.id_ciudad = t6.id
INNER JOIN departamentos t7 ON t6.departamento_id = t7.id
WHERE t2.id_responsabilidad = 1 AND t1.nro_exp_madre > 0 AND t1.estado <> 99";

$query       = mysqli_query($con, $sql);
$totalData   = mysqli_num_rows($query);
$totalFilter = $totalData;

$sql = "SELECT t1.id_expediente, nro_exp_madre, nro_proyecto, concat(apellido, ', ' , nombres) AS solicitante, YEAR(fecha_otorgamiento) AS anio, dni, t7.nombre AS localidad, icono, t4.estado, rubro, monto, saldo, t3.id_emprendedor, dni, fecha_otorgamiento, t4.id_estado
FROM expedientes t1
INNER JOIN rel_expedientes_emprendedores t2 ON t1.id_expediente = t2.id_expediente
INNER JOIN emprendedores t3 ON t2.id_emprendedor = t3.id_emprendedor
INNER JOIN tipo_estado t4 ON t1.estado = t4.id_estado
INNER JOIN tipo_rubro_productivos t5 ON t1.id_rubro = t5.id_rubro
INNER JOIN localidades t6 ON t3.id_ciudad = t6.id
INNER JOIN departamentos t7 ON t6.departamento_id = t7.id
WHERE t2.id_responsabilidad = 1 AND t1.nro_exp_madre > 0 AND t1.estado <> 99";

// FILTRO
if (!empty($request['search']['value'])) {
    $sql .= " AND ( concat(apellido, ', ', nombres) like '%" . $request['search']['value'] . "%'";
    $sql .= " OR nro_exp_madre like '%" . $request['search']['value'] . "%'";
    $sql .= " OR nro_proyecto like '%" . $request['search']['value'] . "%'";
    $sql .= " OR YEAR(fecha_otorgamiento) like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t7.nombre like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t4.estado like '%" . $request['search']['value'] . "%'";
    $sql .= " OR rubro like '%" . $request['search']['value'] . "%' )";
}

if (!empty($_POST['anio']) and $_POST['anio'] > 0) {
    $sql .= " AND YEAR(fecha_otorgamiento) like '%" . $_POST['anio'] . "%'";
}

if (isset($_POST['estado']) and $_POST['estado'] > 0) {
    $sql .= ' AND t4.id_estado = ' . $_POST['estado'];
}

$query     = mysqli_query($con, $sql);
$totalData = mysqli_num_rows($query);

// ORDEN

if ($request['length'] > 0) {
    $sql .= ' ORDER BY apellido ASC LIMIT ' . $request['start'] . ' ,' . $request['length'] . ' ';
} else {
    $sql .= ' ORDER BY apellido ASC LIMIT ' . $totalData . ' ';
}

$query = mysqli_query($con, $sql);

$data = [];

while ($row = mysqli_fetch_array($query)) {
    $subdata = [];

    //
    $id_expediente = $row['id_expediente'];
    $dni           = $row['dni'];

    $tabla_proyecto = mysqli_query($con, "SELECT proy.id_proyecto FROM proyectos proy 
        INNER JOIN rel_proyectos_solicitantes relps on relps.id_proyecto = proy.id_proyecto 
        INNER JOIN solicitantes soli on soli.id_solicitante = relps.id_solicitante 
        WHERE proy.id_estado = 25 AND soli.dni = $dni"
    );

    $registro_proyecto = mysqli_fetch_array($tabla_proyecto);
    $id_proyecto = ($registro_proyecto)?$registro_proyecto['id_proyecto']:0;
    

    // Ubicaion del Expediente

    $tabla_ubicacion = mysqli_query($con, "SELECT tu.ubicacion FROM rel_expedientes_ubicacion reu
        INNER JOIN expedientes_ubicaciones eu ON eu.id_ubicacion = reu.id_ubicacion
        INNER JOIN tipo_ubicaciones tu ON eu.id_tipo_ubicacion = tu.id_ubicacion
        WHERE reu.id_expediente = $id_expediente
        ORDER BY eu.fecha 
		DESC LIMIT 1");
    $registro_ubicacion = mysqli_fetch_array($tabla_ubicacion); 

    $ubicacion = ($registro_ubicacion)?$registro_ubicacion[0]:null;

    //

    $subdata[] = $row['nro_proyecto'];
    $subdata[] = $row['nro_exp_madre'];
    $subdata[] = '<a href="sesion_usuario_expediente.php?id=' . $id_expediente . '&id_proyecto=' . $id_proyecto . '" title="Ver expediente">' . substr($row['solicitante'],0,20) . '</a>';
    $subdata[] = $row['anio'];
    $subdata[] = $row['localidad'];
    $subdata[] = $row['icono'];
    $subdata[] = $ubicacion;
    $subdata[] = $row['estado'];
    $subdata[] = substr($row['rubro'],0,20);
    $subdata[] = date('d/m/Y', strtotime($row['fecha_otorgamiento']));
    $subdata[] = number_format($row['monto'], 0, '.', ',');
    $subdata[] = number_format($row['saldo'], 0, '.', ',');
    $subdata[] = ($_SESSION['tipo_usuario'] == 'c')?'<a href="javascript:void(0)" title="Elimina expediente">
                        <i class="fas fa-trash text-danger borrar" id="' . $id_expediente . '" value="' . $row['solicitante'] . '" title="Eliminar expediente de ' . $row['solicitante'] . '"></i>
                    </a>':null;

    $data[] = $subdata;
}

$json_data = [

    'draw'            => intval($request['draw']),
    'recordsTotal'    => intval($totalData),
    'recordsFiltered' => intval($totalFilter),
    'data'            => $data,
];

print json_encode($json_data);
