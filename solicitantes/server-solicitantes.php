<?php

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$request= $_REQUEST;

// COLUMNAS DE LA TABLA

$col    = array(
    0   =>	'id_solicitante',
    1   => 	'solicitante',
	2	=> 	'fecharegistro',
	3	=> 	'dni', 
	4	=> 	'email',
	5	=> 	'ciudad',
	6	=> 	'dpto',
	7	=> 	'programa'
); 


$sql		= "SELECT t1.id_solicitante, CONCAT(t1.apellido, ', ', t1.nombres) AS solicitante, email, dni, id_responsabilidad, t1.fecha AS fecharegistro, t2.nombre AS ciudad, t3.nombre AS dpto, abreviatura
FROM solicitantes t1
INNER JOIN localidades t2 ON t1.id_ciudad = t2.id
INNER JOIN departamentos t3 ON t2.departamento_id = t3.id
INNER JOIN registro_solicitantes t4 ON t1.id_solicitante = t4.id_solicitante
INNER JOIN tipo_programas t5 ON t4.id_programa = t5.id_programa";

$query      = mysqli_query($con, $sql);
$totalData  = mysqli_num_rows($query);
$totalFilter= $totalData;

$sql		= "SELECT t1.id_solicitante, CONCAT(t1.apellido, ', ', t1.nombres) AS solicitante, email, dni, id_responsabilidad, t1.fecha AS fecharegistro, t2.nombre AS ciudad, t3.nombre AS dpto, abreviatura
FROM solicitantes t1
INNER JOIN localidades t2 ON t1.id_ciudad = t2.id
INNER JOIN departamentos t3 ON t2.departamento_id = t3.id
INNER JOIN registro_solicitantes t4 ON t1.id_solicitante = t4.id_solicitante
INNER JOIN tipo_programas t5 ON t4.id_programa = t5.id_programa";

// FILTRO
if(!empty($request['search']['value'])){

    $sql .= " WHERE concat(apellido, ', ', nombres) like '%".$request['search']['value']."%'";
	$sql .= " OR t2.nombre like '%".$request['search']['value']."%'";
	$sql .= " OR t3.nombre like '%".$request['search']['value']."%'";
	$sql .= " OR dni like '%".$request['search']['value']."%'";
}

$query      = mysqli_query($con, $sql);
$totalData  = mysqli_num_rows($query);

// AGRUPACION 

$sql .= " GROUP BY id_solicitante ";

// ORDEN

if($request['length']>0){
    $sql .= " ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".$request['start']." ,".$request['length']." ";
}else{
    $sql .= " ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir'] ."  LIMIT ".$totalData." ";
}

$query      = mysqli_query($con, $sql);

$data       = array();

while($row  = mysqli_fetch_array($query)){

    $subdata		= array();

	$subdata[0] 	= $row['id_solicitante'];
    $subdata[1] 	= '<a href="javascript:void(0)" class="text-dark" title="Editar datos" onclick="editar_solicitante('.$row['id_solicitante'].')">'.$row['solicitante'].'</a>';
	$subdata[2] 	= (isset($row['fecharegistro'])) ? date('Y-m-d', strtotime($row['fecharegistro'])) : null;
	$subdata[3] 	= $row['dni'];
	$subdata[4] 	= $row['email'];	
	$subdata[5] 	= $row['ciudad'];
	$subdata[6] 	= $row['dpto'];
	$subdata[7] 	= $row['abreviatura'];

    $data[]    		= $subdata;
}

$json_data = array(

    "draw"              => intval($request['draw']),
    "recordsTotal"      => intval($totalData),
    "recordsFiltered"   => intval($totalFilter),
    "data"              => $data
);

echo json_encode($json_data);


?>