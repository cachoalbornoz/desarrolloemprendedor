<?php

require_once("../accesorios/accesos_bd.php");

$con = conectar();

$request = $_REQUEST;

// COLUMNAS DE LA TABLA

$col    = array(
    0   =>  'accion',
    1   =>  'resp',
    2   =>  'id_solicitante',
    3   =>  'solicitante',
    4   =>  'genero',
    5   =>  'fecha',
    6   =>  'abreviatura',
    7   =>  'habilitado',
    8   =>  'fhabilitacion',
    9   =>  'email',
    10   =>  'cod_area',
    11   =>  'telefono',
    12  =>  'dni',
    13  =>  'tipo',
    14  =>  'entidad',
    15  =>  'ciudad',
    16  =>  'dpto',
    17  =>  'resena',
    18  =>  'rubro',
    19  =>  'estado',
    20  =>  'fechar',
    21  =>  'observacionesp'
);

$sql =
    "SELECT t1.id_solicitante, concat(t1.apellido, ', ', t1.nombres) AS solicitante, t1.id_responsabilidad, t1.genero ,t1.fecha, t1.dni, t1.email, t1.cod_area, t1.celular, t4.nombre as ciudad, t5.nombre AS dpto, t2.observaciones as resena, rubro, t10.estado, t10.icono, if(habilitado=1,'SI',if(habilitado=0,'NO','NO')) as habilitado, t9.fecha as fechar, t2.observacionesp, abreviatura, forma, entidad, t8.id_estado, t7.fecha as fhabilitacion
FROM solicitantes t1
LEFT JOIN registro_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
LEFT JOIN tipo_rubro_productivos t3 ON t2.id_rubro = t3.id_rubro
LEFT JOIN localidades t4 ON t1.id_ciudad = t4.id
LEFT JOIN departamentos t5 ON t4.departamento_id = t5.id
LEFT JOIN rel_proyectos_solicitantes t6 ON t1.id_solicitante = t6.id_solicitante
LEFT JOIN habilitaciones t7 ON t1.id_solicitante = t7.id_solicitante
LEFT JOIN proyectos t8 ON t6.id_proyecto = t8.id_proyecto
LEFT JOIN seguimiento_proyectos t9 ON t1.id_solicitante = t9.id_solicitante
LEFT JOIN tipo_estado t10 ON t8.id_estado = t10.id_estado
LEFT JOIN tipo_programas t11 ON t7.id_programa = t11.id_programa
LEFT JOIN maestro_empresas t12 ON t2.id_empresa = t12.id
LEFT JOIN tipo_forma_juridica t13 ON t12.id_tipo_sociedad = t13.id_forma
LEFT JOIN maestro_entidades t14 ON t2.id_entidad = t14.id_entidad ";

$query      = mysqli_query($con, $sql);
$totalData  = mysqli_num_rows($query);
$totalFilter = $totalData;

$sql =

"SELECT t1.id_solicitante, concat(t1.apellido, ', ', t1.nombres) AS solicitante, t1.id_responsabilidad, t1.genero ,t1.fecha, t1.dni, t1.email, t1.cod_area, t1.celular, t4.nombre as ciudad, t5.nombre AS dpto, t2.observaciones as resena, rubro, t10.estado, t10.icono, if(habilitado=1,'SI',if(habilitado=0,'NO','NO')) as habilitado, t9.fecha as fechar, t2.observacionesp, abreviatura, forma, entidad, t8.id_estado, t7.fecha as fhabilitacion
        FROM solicitantes t1
        LEFT JOIN registro_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
        LEFT JOIN tipo_rubro_productivos t3 ON t2.id_rubro = t3.id_rubro
        LEFT JOIN localidades t4 ON t1.id_ciudad = t4.id
        LEFT JOIN departamentos t5 ON t4.departamento_id = t5.id
        LEFT JOIN rel_proyectos_solicitantes t6 ON t1.id_solicitante = t6.id_solicitante
        LEFT JOIN habilitaciones t7 ON t1.id_solicitante = t7.id_solicitante
        LEFT JOIN proyectos t8 ON t6.id_proyecto = t8.id_proyecto
        LEFT JOIN seguimiento_proyectos t9 ON t1.id_solicitante = t9.id_solicitante
        LEFT JOIN tipo_estado t10 ON t8.id_estado = t10.id_estado
        LEFT JOIN tipo_programas t11 ON t7.id_programa = t11.id_programa
        LEFT JOIN maestro_empresas t12 ON t2.id_empresa = t12.id
        LEFT JOIN tipo_forma_juridica t13 ON t12.id_tipo_sociedad = t13.id_forma
        LEFT JOIN maestro_entidades t14 ON t2.id_entidad = t14.id_entidad 
        WHERE t1.id_solicitante > 1 ";

// FILTRO
if (!empty($request['search']['value'])) {

    $sql .= " AND ( concat(t1.apellido, ', ', t1.nombres) like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t4.nombre like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t1.genero like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t1.dni like '%" . $request['search']['value'] . "%'";
    $sql .= " OR habilitado like '%" . $request['search']['value'] . "%'";
    $sql .= " OR rubro like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t2.observaciones like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t10.estado like '%" . $request['search']['value'] . "%'";
    $sql .= " OR forma like '%" . $request['search']['value'] . "%'";
    $sql .= " OR entidad like '%" . $request['search']['value'] . "%' )";
}

if (!empty($_POST['fini']) and !empty($_POST['ffin'])) {
    $sql .= " AND t1.fecha >= '" . $_POST['fini'] . "' AND  t1.fecha < '" . $_POST['ffin'] . "' + interval 1 day";
}

// AGRUPACION 

$sql    .= " GROUP BY t1.id_solicitante ";

$query      = mysqli_query($con, $sql);
$totalData  = mysqli_num_rows($query);

// ORDEN

if ($request['length'] > 0) {
    $sql .= " ORDER BY " . $col[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'] . "  LIMIT " . $request['start'] . " ," . $request['length'] . " ";
} else {
    $sql .= " ORDER BY " . $col[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'] . "  LIMIT " . $totalData . " ";
}

$query      = mysqli_query($con, $sql);

$data       = array();

while ($row  = mysqli_fetch_array($query)) {

    $subdata = array();

    $proyecto        = (isset($row['id_proyecto'])) ? '<a href="../../impresion/imprimirProyecto.php?IdProyecto=' . $row['id_proyecto'] . '" title="Imprime proyecto"><i class="fas fa-print"></i></a>' : null;

    $subdata[]  = '<a href="javascript:void(0)" title="Elimina solicitante"><i class="fas fa-trash text-danger borrar" id="' . $row['id_solicitante'] . '"></i></a>';
    $subdata[]  = ($row['id_responsabilidad'] == 1) ? ' T' : ' A';
    $subdata[]  = $row['id_solicitante'];
    $subdata[]  = '<a href="javascript:void(0)" title="Editar datos" onclick="editar_solicitante(' . $row['id_solicitante'] . ')">' . $row['solicitante'] . '</a>';
    $subdata[]  = ($row['genero'] == 0) ? 'MUJER' : ($row['genero'] == 1) ? 'HOMBRE':'OTRO';
    $subdata[]  = $row['fecha'];
    $subdata[]  = $row['abreviatura'];
    $subdata[]  = $row['habilitado'];
    $subdata[]  = $row['fhabilitacion'];
    $subdata[]  = $row['email'];
    $subdata[]  = $row['cod_area'];
    $subdata[]  = $row['celular'];

    $dni        = $row['dni'];

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

    $subdata[]     = $row['dni'];
    $subdata[]     = $row['forma'];
    $subdata[]     = $row['entidad'];
    $subdata[]     = $row['ciudad'];
    $subdata[]     = $row['dpto'];
    $subdata[]     = '<div style="max-width: 15em; max-height: 5em">' . $row['resena'] . '</div>';
    $subdata[]     = $row['rubro'];
    $subdata[]     = $row['icono'];
    $subdata[]     = (isset($row['fechar'])) ? date('Y-m-d', strtotime($row['fechar'])) : null;
    $subdata[]     = $row['observacionesp'];

    $data[]        = $subdata;
}

$json_data = array(

    "draw"              => intval($request['draw']),
    "recordsTotal"      => intval($totalData),
    "recordsFiltered"   => intval($totalFilter),
    "data"              => $data
);

echo json_encode($json_data);