<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}
require_once("../accesorios/accesos_bd.php");

$con = conectar();

$request = $_REQUEST;

// COLUMNAS DE LA TABLA

$col    = array(

    0   =>     'id_proyecto',
    1   =>     'solicitante',
    2   =>     'asociados',
    3   =>     'denominacion',
    4   =>     'monto',
    5   =>     'forma',
    6   =>     'entidad',
    7   =>     'sector',
    8   =>     'rubro',
    9   =>     'funciona',
    10  =>     'localidad',
    11  =>     'dpto',
    12  =>     'latitud',
    13  =>     'longitud',
    14    =>    'informe',
    15    =>    'fechan',
    16    =>    'icono',
    17    =>     'estado',
    18    =>    'resultado',
    19    =>    'fechae',
    20    =>    'agregaModifica',
    21    =>    'imprime',
    22    =>    'lee',
    23    =>    'anula',
    24    =>    'financia',

);


$sql = "SELECT DISTINCT t1.id_proyecto, t1.id_estado, concat(t4.apellido, ', ', t4.nombres) AS solicitante, t1.denominacion, t2.icono, t1.monto, t5.nombre as localidad, t6.nombre as dpto, t7.resultado_final, dni, t9.tipo as sector, rubro, t8.id_rubro, t5.id as id_localidad, t1.fnovedad as fechan, informe, t1.latitud, t1.longitud, t1.funciona, t7.ultima_fecha as fechae, t11.forma, t12.entidad
FROM proyectos t1
INNER JOIN tipo_estado t2 ON t1.id_estado = t2.id_estado
INNER JOIN rel_proyectos_solicitantes t3 ON t1.id_proyecto = t3.id_proyecto
INNER JOIN solicitantes t4 ON t3.id_solicitante = t4.id_solicitante
LEFT JOIN localidades t5 ON t4.id_ciudad = t5.id
LEFT JOIN departamentos t6 ON t5.departamento_id = t6.id
LEFT JOIN proyectos_seguimientos t7 ON t1.id_proyecto = t7.id_proyecto
LEFT JOIN registro_solicitantes t8 ON t4.id_solicitante = t8.id_solicitante
LEFT JOIN tipo_rubro_productivos t9 ON t8.id_rubro = t9.id_rubro 
LEFT JOIN maestro_empresas t10 ON t8.id_empresa = t10.id
LEFT JOIN tipo_forma_juridica t11 ON t10.id_tipo_sociedad = t11.id_forma
LEFT JOIN maestro_entidades t12 ON t8.id_entidad = t12.id_entidad
WHERE t4.id_responsabilidad = 1 AND t1.id_estado > 0 AND t1.id_estado != 25";

$query      = mysqli_query($con, $sql);
$totalData  = mysqli_num_rows($query);
$totalFilter = $totalData;

$sql = "SELECT DISTINCT t1.id_proyecto, t1.id_estado, concat(t4.apellido, ', ', t4.nombres) AS solicitante, t1.denominacion, t2.icono, t1.monto, t5.nombre as localidad, t6.nombre as dpto, t7.resultado_final, dni, t9.tipo as sector, rubro, t8.id_rubro, t5.id as id_localidad, t1.fnovedad as fechan, informe, t1.latitud, t1.longitud, t1.funciona, t7.ultima_fecha as fechae, t11.forma, t12.entidad
FROM proyectos t1
INNER JOIN tipo_estado t2 ON t1.id_estado = t2.id_estado
INNER JOIN rel_proyectos_solicitantes t3 ON t1.id_proyecto = t3.id_proyecto
INNER JOIN solicitantes t4 ON t3.id_solicitante = t4.id_solicitante
LEFT JOIN localidades t5 ON t4.id_ciudad = t5.id
LEFT JOIN departamentos t6 ON t5.departamento_id = t6.id
LEFT JOIN proyectos_seguimientos t7 ON t1.id_proyecto = t7.id_proyecto
LEFT JOIN registro_solicitantes t8 ON t4.id_solicitante = t8.id_solicitante
LEFT JOIN tipo_rubro_productivos t9 ON t8.id_rubro = t9.id_rubro 
LEFT JOIN maestro_empresas t10 ON t8.id_empresa = t10.id
LEFT JOIN tipo_forma_juridica t11 ON t10.id_tipo_sociedad = t11.id_forma
LEFT JOIN maestro_entidades t12 ON t8.id_entidad = t12.id_entidad
WHERE t4.id_responsabilidad = 1 AND t1.id_estado > 0 AND t1.id_estado != 25";

// FILTRO
if (!empty($request['search']['value'])) {

    $sql .= " AND (concat(t4.apellido, ', ', t4.nombres) like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t1.id_proyecto like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t5.nombre like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t12.entidad like '%" . $request['search']['value'] . "%'";
    $sql .= " OR rubro like '%" . $request['search']['value'] . "%'";
    $sql .= " OR t2.icono like '%" . $request['search']['value'] . "%') ";
}

$query      = mysqli_query($con, $sql);
$totalData  = mysqli_num_rows($query);

// ORDEN

if ($request['length'] > 0) {
    $sql .= " ORDER BY " . $col[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'] . "  LIMIT " . $request['start'] . " ," . $request['length'] . " ";
} else {
    $sql .= " ORDER BY " . $col[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];
}

$query      = mysqli_query($con, $sql);

$data       = array();

while ($row  = mysqli_fetch_array($query)) {

    $subdata = array();

    $id_proyecto = $row['id_proyecto'];

    // IMAGEN DEL PROYECTO
    $query_foto    = mysqli_query($con, "SELECT foto1 FROM rel_proyectos_fotos WHERE id_proyecto = $id_proyecto");
    $record_foto   = mysqli_fetch_array($query_foto);
    $link_foto     = ($record_foto)?
        '<a href="../evaluaciones/ver_imagen.php?foto='.$record_foto['foto1'].'&IdProyecto=' . $row['id_proyecto'] . '&solicitante=' . $row['solicitante'] . '">
            <i class="fas fa-camera"></i>
        </a>':str_pad($id_proyecto, 4, '0', STR_PAD_LEFT);



    //NROS DE SOLICITANTES
    $query_sol    = mysqli_query($con, "SELECT count(id_solicitante) FROM rel_proyectos_solicitantes WHERE id_proyecto = $id_proyecto");
    $record_sol    = mysqli_fetch_array($query_sol);
    $asociados     = $record_sol[0];

    //
    // DNI SOLICITANTES
    //
    $dni    = $row['dni'];
    $tabla     = mysqli_query($con, "SELECT t4.icono FROM expedientes t1 
		INNER JOIN rel_expedientes_emprendedores t2 ON t1.id_expediente = t2.id_expediente 
		INNER JOIN emprendedores t3 ON t2.id_emprendedor = t3.id_emprendedor
		INNER JOIN tipo_estado t4 ON t1.estado = t4.id_estado 
		WHERE t3.dni = $dni");

    if ($registro = mysqli_fetch_array($tabla)) {
        $icono = $registro['icono'];
    } else {
        $icono = null;
    }




    if (isset($row['informe'])) {
        $informe     =
            '<a href="../evaluaciones/informes/' . $row['informe'] . '">
			<i class="fa fa-folder-open" aria-hidden="true" title="Ver informe"></i>
		</a>';

        $elimina     =
            '<a href="javascript:void(0)">
			<i class="fas fa-eraser text-danger borrari" id="' . $row['id_proyecto'] . '" value="' . $row['solicitante'] . '" title="Eliminar informe de ' . $row['solicitante'] . '"></i>
		</a>';

        $agrega        = null;
    } else {

        $informe     = null;

        $elimina     = null;

        $agrega     =
            '<a href="../evaluaciones/Agregar_Informe.php?IdProyecto=' . $row['id_proyecto'] . '&solicitante=' . $row['solicitante'] . '">
			<i class="fa fa-paperclip" aria-hidden="true" title="Agregar Informe Técnico"></i> 
		</a>';
    }

    $cadena     = $informe . '' . $elimina . '' . $agrega;

    // Estado del proyecto
    $agregaModifica = null;
    $imprime         = null;
    $lee             = null;
    $anula             = null;
    $financia         = null;

    switch ($row['id_estado']) {
        case 24:                    // PROYECTO ENVIADO
            {
                $agregaModifica =
                    '<a href="../evaluaciones/Agregar_Evaluacion.php?IdProyecto=' . $row['id_proyecto'] . '&solicitante=' . $row['solicitante'] . '">
				<i class="fas fa-th-list"></i>
			</a>';

                $imprime         = null;

                $lee            =
                    '<a href="../impresion/imprimirProyecto.php?IdProyecto=' . $row['id_proyecto'] . '">
				<i class="far fa-eye"></i> 
			</a>';

                $anula            = ($_SESSION['tipo_usuario'] == 'c') ?

                    '<a href="javascript:void(0)" title="Anula evaluación">
				<i value="' . $row['solicitante'] . '" class="fas fa-exclamation-triangle text-danger borrar" id="' . $row['id_proyecto'] . '"></i>
			</a>' : null;

                $financia         = null;

                break;
            }
        case 22:                   // PROYECTO RECHAZADO
            {
                $agregaModifica =
                    '<a href="../evaluaciones/Modificar_Evaluacion.php?IdProyecto=' . $row['id_proyecto'] . '&solicitante=' . $row['solicitante'] . '" title="Modifica evaluacion">
					<i class="fas fa-edit"></i>
				</a>';
                $imprime         =
                    '<a href="../evaluaciones/ImprimirEvaluacion.php?IdProyecto=' . $row['id_proyecto'] . '" title="Imprime evaluación">
				<i class="fas fa-print"></i>
			</a>';
                $lee            =
                    '<a href="../impresion/imprimirProyecto.php?IdProyecto=' . $row['id_proyecto'] . '">
				<i class="far fa-eye"></i>
			</a>';

                $anula        = ($_SESSION['tipo_usuario'] == 'c') ?
                    '<a href="javascript:void(0)" title="Anula evaluación">
				<i value="' . $row['solicitante'] . '" class="fas fa-exclamation-triangle text-danger borrar" id="' . $row['id_proyecto'] . '" title="Anula evaluación"></i>
			</a>' : null;

                $financia         = null;

                break;
            }
        case 23:                    // PROYECTO APROBADO
            {
                $agregaModifica =
                    '<a href="../evaluaciones/Modificar_Evaluacion.php?IdProyecto=' . $row['id_proyecto'] . '&solicitante=' . $row['solicitante'] . '" title="Corrige evaluación">
				<i class="fas fa-edit"></i></span>
			</a>';
                $imprime        =
                    '<a href="../evaluaciones/ImprimirEvaluacion.php?IdProyecto=' . $row['id_proyecto'] . '" title="Imprime evaluación ">
				<i class="fas fa-print"></i>
			</a>';
                $lee            =
                    '<a href="../impresion/imprimirProyecto.php?IdProyecto=' . $row['id_proyecto'] . '" title="Imprime proyecto ">
				<i class="far fa-eye"></i>
			</a>';

                $anula            = ($_SESSION['tipo_usuario'] == 'c') ?
                    '<a href="javascript:void(0)" title="Anula evaluación">
				<i value="' . $row['solicitante'] . '" class="fas fa-exclamation-triangle text-danger borrar" id="' . $row['id_proyecto'] . '" title="Anula evaluación y habilita proyecto"></i>
			</a>' : null;

                if (($_SESSION['tipo_usuario'] == 'a' or $_SESSION['tipo_usuario'] == 'c') and $row['id_estado'] == 23) {

                    $financia =
                        '<a href="../expedientes/su_expediente_nuevo_financiado.php?solicitante=' . $row['solicitante'] . '&IdProyecto=' . $row['id_proyecto'] . '&IdRubro=' . $row['id_rubro'] . '&rubro=' . $row['rubro'] . '&IdLocalidad=' . $row['id_localidad'] . '&localidad=' . $row['localidad'] . '" title="Financia Proyecto y pasa a Expediente ">
					Fi
				</a>';
                } else {

                    $financia = null;
                }

                break;
            }
        default: {
                $agregaModifica = null;
                $imprime         = null;
                $lee             = null;
                $anula             = null;
                $financia         = null;
            }
    }

    //

    $subdata[]    =     $link_foto;
    $subdata[]    =     $row['solicitante'];
    $subdata[]    =     $asociados;
    $subdata[]    =     '<div style="max-width: 15em; max-height: 5em">' . $row['denominacion'] . '</div>';
    $subdata[]    =     $row['monto'];
    $subdata[]    =     $row['forma'];
    $subdata[]    =     $row['entidad'];
    $subdata[]    =     ($row['sector'] == 0) ? 'A <i class="fas fa-tractor"></i>' : 'I <i class="fas fa-industry"></i>';
    $subdata[]    =     $row['rubro'];
    $subdata[]    =     $row['funciona'];
    $subdata[]    =     $row['localidad'];
    $subdata[]    =     $row['dpto'];
    $subdata[]    =     substr($row['latitud'], 0, 10);
    $subdata[]    =     substr($row['longitud'], 0, 10);
    $subdata[]    =    $cadena;
    $subdata[]    =    (isset($row['fechan'])) ? date('Y-m-d', strtotime($row['fechan'])) : null;
    $subdata[]    =     $icono;
    $subdata[]    =     $row['icono'];
    $subdata[]    =    '<span class=" badge badge-secondary">' . $row['resultado_final'] . '</span>';
    $subdata[]    =    (isset($row['fechae'])) ? date('Y-m-d', strtotime($row['fechae'])) : null;
    $subdata[]    =    $agregaModifica;
    $subdata[]    =    $imprime;
    $subdata[]    =    $lee;
    $subdata[]    =    $anula;
    $subdata[]    =    $financia;


    $data[]    = $subdata;
}

$json_data = array(

    "draw"              => intval($request['draw']),
    "recordsTotal"      => intval($totalData),
    "recordsFiltered"   => intval($totalFilter),
    "data"              => $data
);

echo json_encode($json_data);
