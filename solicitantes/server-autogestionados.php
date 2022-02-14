<?php

require_once '../accesorios/accesos_bd.php';

$con = conectar();

$request = $_REQUEST;

// COLUMNAS DE LA TABLA

$col = [
    0  => 'accion',
    1  => 'id_solicitante',
    2  => 'solicitante',
    3  => 'fecha',
    4  => 'habilitado',
    5  => 'email',
    6  => 'dni',
    7  => 'tipo',
    8  => 'entidad',
    9  => 'ciudad',
    10 => 'dpto',
    11 => 'resena',
    12 => 'rubro',
    13 => 'estado',
    14 => 'fechar',
    15 => 'observacionesp',
];

$sql = "SELECT t1.id_solicitante, concat(t1.apellido, ', ', t1.nombres) AS solicitante, t1.fecha, t1.dni, t1.email, t4.nombre as ciudad, t5.nombre AS dpto, t2.observaciones as resena, rubro, t10.estado, t10.icono, if(habilitado=1,'SI',if(habilitado=0,'NO','NO')) as habilitado, t9.fecha as fechar, t2.observacionesp, abreviatura, forma, entidad, t8.id_estado, t11.abreviatura
FROM solicitantes t1
INNER JOIN registro_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
INNER JOIN tipo_rubro_productivos t3 ON t2.id_rubro = t3.id_rubro
INNER JOIN localidades t4 ON t1.id_ciudad = t4.id
INNER JOIN departamentos t5 ON t4.departamento_id = t5.id
LEFT JOIN rel_proyectos_solicitantes t6 ON t1.id_solicitante = t6.id_solicitante
LEFT JOIN (SELECT * FROM habilitaciones WHERE id_programa = 1) t7 ON t1.id_solicitante = t7.id_solicitante
LEFT JOIN proyectos t8 ON t6.id_proyecto = t8.id_proyecto
LEFT JOIN seguimiento_proyectos t9 ON t1.id_solicitante = t9.id_solicitante
LEFT JOIN tipo_estado t10 ON t8.id_estado = t10.id_estado
LEFT JOIN tipo_programas t11 ON t2.id_programa = t11.id_programa
LEFT JOIN maestro_empresas t12 ON t2.id_empresa = t12.id
LEFT JOIN tipo_forma_juridica t13 ON t12.id_tipo_sociedad = t13.id_forma
LEFT JOIN maestro_entidades t14 ON t2.id_entidad = t14.id_entidad
WHERE t1.id_responsabilidad = 1 AND t2.id_programa = 1";

$query       = mysqli_query($con, $sql);
$totalData   = mysqli_num_rows($query);
$totalFilter = $totalData;

$sql = "SELECT t1.id_solicitante, concat(t1.apellido, ', ', t1.nombres) AS solicitante, t1.fecha, t1.dni, t1.email, t4.nombre as ciudad, t5.nombre AS dpto, t2.observaciones as resena, rubro, t10.estado, t10.icono, if(habilitado=1,'SI',if(habilitado=0,'NO','NO')) as habilitado, t9.fecha as fechar, t2.observacionesp, abreviatura, forma, entidad, t8.id_estado, t11.abreviatura
FROM solicitantes t1
INNER JOIN registro_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
INNER JOIN tipo_rubro_productivos t3 ON t2.id_rubro = t3.id_rubro
INNER JOIN localidades t4 ON t1.id_ciudad = t4.id
INNER JOIN departamentos t5 ON t4.departamento_id = t5.id
LEFT JOIN rel_proyectos_solicitantes t6 ON t1.id_solicitante = t6.id_solicitante
LEFT JOIN (SELECT * FROM habilitaciones WHERE id_programa = 1) t7 ON t1.id_solicitante = t7.id_solicitante
LEFT JOIN proyectos t8 ON t6.id_proyecto = t8.id_proyecto
LEFT JOIN seguimiento_proyectos t9 ON t1.id_solicitante = t9.id_solicitante
LEFT JOIN tipo_estado t10 ON t8.id_estado = t10.id_estado
LEFT JOIN tipo_programas t11 ON t2.id_programa = t11.id_programa
LEFT JOIN maestro_empresas t12 ON t2.id_empresa = t12.id
LEFT JOIN tipo_forma_juridica t13 ON t12.id_tipo_sociedad = t13.id_forma
LEFT JOIN maestro_entidades t14 ON t2.id_entidad = t14.id_entidad
WHERE t1.id_responsabilidad = 1 AND t2.id_programa = 1";

// FILTRO
if (!empty($request['search']['value'])) {
    $sql .= " AND ( concat(t1.apellido, ', ', t1.nombres) like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t4.nombre like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t1.dni like '%" . $request['search']['value'] . "%'";
    $sql .= " OR habilitado like '%" . $request['search']['value'] . "%'";
    $sql .= " OR rubro like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t2.observaciones like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t10.estado like '%" . $request['search']['value'] . "%'";
    $sql .= " OR forma like '%" . $request['search']['value'] . "%'";
    $sql .= " OR entidad like '%" . $request['search']['value'] . "%' )";
}

$query     = mysqli_query($con, $sql);
$totalData = mysqli_num_rows($query);

// AGRUPACION

// $sql .= ' GROUP BY t1.id_solicitante ';

// ORDEN

if ($request['length'] > 0) {
    $sql .= ' ORDER BY ' . $col[$request['order'][0]['column']] . '   ' . $request['order'][0]['dir'] . '  LIMIT ' . $request['start'] . ' ,' . $request['length'] . ' ';
} else {
    $sql .= ' ORDER BY ' . $col[$request['order'][0]['column']] . '   ' . $request['order'][0]['dir'] . '  LIMIT ' . $totalData . ' ';
}

$query = mysqli_query($con, $sql);

$data = [];

while ($row = mysqli_fetch_array($query)) {
    $subdata = [];

    $proyecto = (isset($row['id_proyecto'])) ? '<a href="../../impresion/imprimirProyecto.php?IdProyecto=' . $row['id_proyecto'] . '" title="Imprime proyecto"><i class="fas fa-print"></i></a>' : null;

    $subdata[0] = '<a href="javascript:void(0)" title="Elimina solicitante"><i class="fas fa-trash text-danger borrar" id="' . $row['id_solicitante'] . '"></i></a>';
    $subdata[1] = $row['id_solicitante'];
    $subdata[2] = '<a href="../personas/registro_edita.php?id_lugar=0&id_solicitante=' . $row['id_solicitante'] . '" title="Editar datos">' . $row['solicitante'] . '</a>';
    $subdata[3] = date('Y-m-d', strtotime($row['fecha']));
    $subdata[4] = $row['habilitado'];
    $subdata[5] = $row['email'];

    $dni = $row['dni'];

    if ($row['id_estado'] == 25) {

        // SI EL ESTADO DEL PROYECTO ES FINANCIADO

        $tabla_proyectos = mysqli_query($con, "SELECT t4.icono
			FROM emprendedores t1 
			INNER JOIN rel_expedientes_emprendedores AS t2 ON t1.id_emprendedor = t2.id_emprendedor
			INNER JOIN expedientes AS t3 ON t2.id_expediente = t3.id_expediente
			INNER JOIN tipo_estado AS t4 ON t3.estado = t4.id_estado
			WHERE t1.dni = $dni");

        $registro = mysqli_fetch_array($tabla_proyectos);
        if ($registro) {
            $row['icono'] = $registro['icono'];
        }
    }

    $subdata[6]  = $row['dni'];
    $subdata[7]  = $row['forma'];
    $subdata[8]  = $row['entidad'];
    $subdata[9]  = $row['ciudad'];
    $subdata[10] = $row['dpto'];
    $subdata[11] = '<div style="max-width: 15em; max-height: 5em">' . $row['resena'] . '</div>';
    $subdata[12] = $row['rubro'];
    $subdata[13] = $row['icono'];
    $subdata[14] = (isset($row['fechar'])) ? date('Y-m-d', strtotime($row['fechar'])) : null;
    $subdata[15] = $row['observacionesp'];

    $data[] = $subdata;
}

$json_data = [

    'draw'            => intval($request['draw']),
    'recordsTotal'    => intval($totalData),
    'recordsFiltered' => intval($totalFilter),
    'data'            => $data,
];

print json_encode($json_data);
