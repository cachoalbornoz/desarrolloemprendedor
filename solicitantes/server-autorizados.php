<?php

require_once '../accesorios/accesos_bd.php';

$con = conectar();

$request = $_REQUEST;

// COLUMNAS DE LA TABLA

$col = [

    0  => 'id_solicitante',
    1  => 'solicitante',
    2  => 'direccion',
    3  => 'email',
    4  => 'dni',
    5  => 'telefono',
    6  => 'celular',
    7  => 'localidad',
    8  => 'dpto',
    9  => 'rubro',
    10 => 'edad',
    11 => 'habilitado',
];

$sql = "SELECT t1.id_solicitante, t1.fecha_nac, concat(t1.apellido,', ', t1.nombres) as solicitante, t1.direccion, t1.email, t1.dni,  t1.telefono, t1.celular, t4.nombre AS ciudad, t5.nombre AS dpto, t3.rubro, t6.id_programa, t7.abreviatura, t6.habilitado 
FROM solicitantes t1
INNER JOIN registro_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
INNER JOIN tipo_rubro_productivos t3 ON t2.id_rubro = t3.id_rubro
INNER JOIN localidades t4 ON t1.id_ciudad = t4.id
INNER JOIN departamentos t5 ON t4.departamento_id = t5.id
LEFT JOIN (SELECT * FROM habilitaciones WHERE id_programa = 1) t6 ON t1.id_solicitante = t6.id_solicitante
LEFT JOIN tipo_programas t7 ON t6.id_programa = t7.id_programa 
WHERE t1.id_responsabilidad = 1 AND t2.id_programa = 1";

$query       = mysqli_query($con, $sql);
$totalData   = mysqli_num_rows($query);
$totalFilter = $totalData;

$sql = "SELECT t1.id_solicitante, t1.fecha_nac, concat(t1.apellido,', ', t1.nombres) as solicitante, t1.direccion, t1.email, t1.dni,  t1.telefono, t1.celular, t4.nombre AS ciudad, t5.nombre AS dpto, t3.rubro, t6.id_programa, t7.abreviatura, t6.habilitado 
FROM solicitantes t1
INNER JOIN registro_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
INNER JOIN tipo_rubro_productivos t3 ON t2.id_rubro = t3.id_rubro
INNER JOIN localidades t4 ON t1.id_ciudad = t4.id
INNER JOIN departamentos t5 ON t4.departamento_id = t5.id
LEFT JOIN (SELECT * FROM habilitaciones WHERE id_programa = 1) t6 ON t1.id_solicitante = t6.id_solicitante
LEFT JOIN tipo_programas t7 ON t6.id_programa = t7.id_programa 
WHERE t1.id_responsabilidad = 1 AND t2.id_programa = 1";

// FILTRO
if (!empty($request['search']['value'])) {
    $sql .= " AND (concat(t1.apellido, ', ', t1.nombres) like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t1.nombres like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t1.direccion like '%" . $request['search']['value'] . "%'";
    $sql .= " OR email like '%" . $request['search']['value'] . "%'";
    $sql .= " OR dni like '%" . $request['search']['value'] . "%'";
    $sql .= " OR email like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t4.nombre like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t5.nombre like '%" . $request['search']['value'] . "%'";
    $sql .= " OR abreviatura like '%" . $request['search']['value'] . "%' )";
}

// AGRUPACION

// $sql .= ' GROUP BY t1.id_solicitante ';

$query     = mysqli_query($con, $sql);
$totalData = mysqli_num_rows($query);

// ORDEN

if ($request['length'] > 0) {
    $sql .= ' ORDER BY ' . $col[$request['order'][0]['column']] . '   ' . $request['order'][0]['dir'] . '  LIMIT ' . $request['start'] . ' ,' . $request['length'] . ' ';
} else {
    $sql .= ' ORDER BY ' . $col[$request['order'][0]['column']] . '   ' . $request['order'][0]['dir'];
}

$query = mysqli_query($con, $sql);

$data = [];

while ($row = mysqli_fetch_array($query)) {
    $subdata = [];

    $checked = ($row['habilitado'] == 1) ? 'checked' : '';

    $subdata[] = $row['id_solicitante'];
    $subdata[] = '<a href="../personas/registro_edita.php?id_lugar=0&id_solicitante=' . $row['id_solicitante'] . '" title="Editar datos">' . $row['solicitante'] . '</a>';
    $subdata[] = strtoupper($row['direccion']);
    $subdata[] = $row['email'];
    $subdata[] = $row['dni'];
    $subdata[] = $row['telefono'];
    $subdata[] = $row['celular'];
    $subdata[] = $row['ciudad'];
    $subdata[] = $row['dpto'];
    $subdata[] = $row['rubro'];
    $subdata[] = getEdad($row['fecha_nac']);
    $subdata[] = '<input type="checkbox" class="autorizar" ' . $checked . ' id="' . $row['id_solicitante'] . '" >';

    $data[] = $subdata;
}

$json_data = [

    'draw'            => intval($request['draw']),
    'recordsTotal'    => intval($totalData),
    'recordsFiltered' => intval($totalFilter),
    'data'            => $data,
];

print json_encode($json_data);
