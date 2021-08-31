<?php

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$request= $_REQUEST;

// COLUMNAS DE LA TABLA

$col    = array(
	0	=>	'accion',
	1	=>	'id_solicitante',
    2   => 	'solicitante',
	3	=> 	'fecha',
	4	=>	'habilitado',
	5	=>	'email',
	6	=>	'dni',
	7	=> 	'seguimiento',
	8	=> 	'ciudad', 
	9	=> 	'rubro',
	10	=> 	'observaciones',
	11	=> 	'fechai',
	12	=>	'evaluar',
	13	=> 	'nota',
	14	=> 	'informe',
	15	=>	'imprime',
	16	=>	'fechae'
); 


$sql= "SELECT t1.id_solicitante, concat(t1.apellido, ' ', t1.nombres) as solicitante, t1.email, t1.dni, t4.nombre as ciudad, rubro, t2.observaciones, t5.habilitado, t1.fecha, t7.fecha as fechai, t6.fecha as fechae, t7.id, t8.resultado_final as nota, t6.adjunto, t6.id as identre
	FROM solicitantes t1
	INNER JOIN registro_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
	INNER JOIN tipo_rubro_productivos t3 ON t2.id_rubro = t3.id_rubro
	INNER JOIN localidades t4 ON t4.id = t1.id_ciudad
	LEFT JOIN (SELECT * FROM habilitaciones WHERE id_programa = 2) t5 ON t1.id_solicitante = t5.id_solicitante
	LEFT JOIN proaccer_entrevista t6 ON t1.id_solicitante = t6.id_solicitante
	LEFT JOIN proaccer_inscripcion t7 ON t1.id_solicitante = t7.id_solicitante
	LEFT JOIN proaccer_seguimientos t8 ON t7.id = t8.id_proyecto 
	WHERE t2.id_programa = 2";

$query      = mysqli_query($con, $sql);
$totalData  = mysqli_num_rows($query);
$totalFilter= $totalData;

$sql= "SELECT t1.id_solicitante, concat(t1.apellido, ' ', t1.nombres) as solicitante, t1.email, t1.dni, t4.nombre as ciudad, rubro, t2.observaciones, t5.habilitado, t1.fecha, t7.fecha as fechai, t6.fecha as fechae, t7.id, t8.resultado_final as nota, t6.adjunto, t6.id as identre
	FROM solicitantes t1
	INNER JOIN registro_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
	INNER JOIN tipo_rubro_productivos t3 ON t2.id_rubro = t3.id_rubro
	INNER JOIN localidades t4 ON t4.id = t1.id_ciudad
	LEFT JOIN (SELECT * FROM habilitaciones WHERE id_programa = 2) t5 ON t1.id_solicitante = t5.id_solicitante
	LEFT JOIN proaccer_entrevista t6 ON t1.id_solicitante = t6.id_solicitante
	LEFT JOIN proaccer_inscripcion t7 ON t1.id_solicitante = t7.id_solicitante
	LEFT JOIN proaccer_seguimientos t8 ON t7.id = t8.id_proyecto 
	WHERE t2.id_programa = 2";

// FILTRO
if(!empty($request['search']['value'])){

	$sql .= " AND (concat(t1.apellido, ' ', t1.nombres) like '%".$request['search']['value']."%'";
	$sql .= " OR t1.dni like '%".$request['search']['value']."%'";
	$sql .= " OR t4.nombre like '%".$request['search']['value']."%'";
	$sql .= " OR habilitado like '%".$request['search']['value']."%'";
	$sql .= " OR rubro like '%".$request['search']['value']."%' )";
}

$query      = mysqli_query($con, $sql);
$totalData  = mysqli_num_rows($query);

// AGRUPACION 

$sql .= " GROUP BY t1.id_solicitante ";

// ORDEN

if($request['length']>0){
    $sql .= " ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".$request['start']." ,".$request['length']." ";
}else{
    $sql .= " ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir'] ."  LIMIT ".$totalData." ";
}

$query      = mysqli_query($con, $sql) or die($sql);

$data       = array();

while($row  = mysqli_fetch_array($query)){

	$subdata= array();

	if(($row['fechai'] <> null) and ($row['nota'] > 0)){
		$imprime	= '<a href="ImprimirEvaluacion.php?IdProyecto='.$row['id'].'">	<i class="fas fa-print" alt="Imprimir evaluacion" title="Imprimir evaluacion"></i></a>';
	}else{
		$imprime	= null;
	}
	
	if (($row['adjunto'] <> null) and ($row['id'] > 0)) {
		$informe 	= '<a href="informes/'.$row['adjunto'].'"> <i class="fa fa-folder-open" aria-hidden="true" title="Ver informe"></i> </a>';
		$elimina 	= '<a href="Eliminar_Informe.php?id='.$row['id'].'"	<i class="fa fa-eraser" aria-hidden="true" title="Eliminar informe de '.$row['solicitante'].'"></i>	</a>';
	}else{
		$informe	= null;
		$elimina	= null;
	} 

	$subdata[0] 	= '<a href="javascript:void(0)" title="Elimina solicitante"><i class="fas fa-trash text-danger borrar" id="'.$row['id_solicitante'].'"></i></a>';
	$subdata[1] 	= $row['id_solicitante'];
	$subdata[2] 	= '<a href="javascript:void(0)" title="Editar datos" onclick="editar_solicitante('.$row['id_solicitante'].')">'.$row['solicitante'].'</a>';
	$subdata[3] 	= date('Y-m-d', strtotime($row['fecha']));
	$subdata[4] 	= ($row['habilitado']==1) ? 'Si': 'No';
	$subdata[5] 	= $row['email'];
	$subdata[6] 	= $row['dni'];
	$subdata[7] 	= ($row['id'] > 0) ? '<a href="fichaSeguimiento.php?id='.$row['id'].'&solicitante='.$row['solicitante'].'"><i class="far fa-eye"></i></a>' : null;
	$subdata[8] 	= $row['ciudad'];
	$subdata[9] 	= $row['rubro'];	
	$subdata[10] 	= '<div style="max-width: 15em; max-height: 5em">'.$row['observaciones'].'</div>';
	$subdata[11] 	= (isset($row['fechai'])) ? date('Y-m-d', strtotime($row['fechai'])) : null;
	$subdata[12] 	= (($row['fechai'] <> null) and ($row['nota'] == null)) ? '<a href="Agregar_Evaluacion.php?solicitante='.$row['solicitante'].'&id_proyecto='.$row['id'].'" title="Evaluar" > Evaluar</a>' : null;	 
	$subdata[13] 	= (($row['fechai'] <> null)) ? '<a href="Modificar_Evaluacion.php?solicitante='.$row['solicitante'].'&id_proyecto='.$row['id'].'" title="Modificar" > <span class="badge">'.$row['nota'].'</span></a>': null;
	$subdata[14] 	= '<div style="max-width: 15em; max-height: 5em">'.$imprime.' '.$informe.' '.$elimina.'</div>';
	$subdata[15] 	= (($row['fechai'] <> null) and ($row['nota'] > 0)) ? '<a href="ImprimirEntrevistaProaccer.php?id='.$row['identre'].'"> <i class="fas fa-file-pdf" title="Imprime entrevista"></i></a>': null;
	$subdata[16] 	= (isset($row['fechae'])) ? date('Y-m-d', strtotime($row['fechae'])) : null;

    $data[]    	= $subdata;
}

$json_data = array(

    "draw"              => intval($request['draw']),
    "recordsTotal"      => intval($totalData),
    "recordsFiltered"   => intval($totalFilter),
    "data"              => $data
);

echo json_encode($json_data);


?>