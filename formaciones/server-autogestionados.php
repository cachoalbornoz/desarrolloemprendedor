<?php
session_start();
require_once("../accesorios/accesos_bd.php");

$con=conectar();

$request= $_REQUEST;

// COLUMNAS DE LA TABLA

$col    = array(
	0	=>	'accion',
	1   => 	'solicitante',
	2	=> 	'fecha',
	3	=> 	'dni', 
	4	=> 	'ciudad',
	5	=> 	'resena',
); 


$sql = "SELECT t1.id_solicitante, concat(t1.apellido, ', ', t1.nombres) AS solicitante, t1.fecha, t1.dni, t1.email, t3.nombre as ciudad, t2.observaciones as resena, t6.entidad
FROM solicitantes t1
INNER JOIN registro_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
INNER JOIN localidades t3 ON t1.id_ciudad = t3.id
LEFT JOIN maestro_empresas t4 ON t2.id_empresa = t4.id
LEFT JOIN tipo_forma_juridica t5 ON t4.id_tipo_sociedad = t5.id_forma
LEFT JOIN maestro_entidades t6 ON t2.id_entidad = t6.id_entidad
WHERE t2.id_programa = 4";

$query      = mysqli_query($con, $sql);
$totalData  = mysqli_num_rows($query);
$totalFilter= $totalData;

$sql = "SELECT t1.id_solicitante, concat(t1.apellido, ', ', t1.nombres) AS solicitante, t1.fecha, t1.dni, t1.email, t3.nombre as ciudad, t2.observaciones as resena, t6.entidad
FROM solicitantes t1
INNER JOIN registro_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
INNER JOIN localidades t3 ON t1.id_ciudad = t3.id
LEFT JOIN maestro_empresas t4 ON t2.id_empresa = t4.id
LEFT JOIN tipo_forma_juridica t5 ON t4.id_tipo_sociedad = t5.id_forma
LEFT JOIN maestro_entidades t6 ON t2.id_entidad = t6.id_entidad
WHERE t2.id_programa = 4";

// FILTRO
if(!empty($request['search']['value'])){

    $sql .= " AND ( concat(t1.apellido, ', ', t1.nombres) like '%".$request['search']['value']."%'";
	$sql .= " OR t3.nombre like '%".$request['search']['value']."%'";
	$sql .= " OR t1.dni like '%".$request['search']['value']."%'";
	$sql .= " OR t2.observaciones like '%".$request['search']['value']."%'";
	$sql .= " OR entidad like '%".$request['search']['value']."%' )";
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

$query      = mysqli_query($con, $sql);

$data       = array();

$habilitados = array("a", "b", "c");

while($row  = mysqli_fetch_array($query)){

	// CONTROL DE USUARIOS EXTERNOS

	
	$borrar = (in_array($_SESSION['tipo_usuario'], $habilitados))?'<a href="javascript:void(0)" title="Elimina solicitante"><i class="fas fa-trash text-danger borrar" id="'.$row['id_solicitante'].'"></i></a>':null;
	$editar = (in_array($_SESSION['tipo_usuario'], $habilitados))?'<a href="javascript:void(0)" title="Editar datos" onclick="editar_solicitante('.$row['id_solicitante'].')">'.$row['solicitante'].'</a>':$row['solicitante'];

    $subdata= array();

	$subdata[] 	= $borrar;
    $subdata[] 	= $editar;
	$subdata[] 	= date('Y-m-d', strtotime($row['fecha']));
	$subdata[] 	= $row['dni'];
	$subdata[] 	= '<a href="fichaSeguimiento.php?id='.$row['id_solicitante'].'&solicitante='.$row['solicitante'].'"><i class="far fa-eye"></i></a>';
	$subdata[] 	= $row['ciudad'];
	$subdata[] 	= '<div style="max-width: 75em; max-height: 5em">'.$row['resena'].'</div>'; 	

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