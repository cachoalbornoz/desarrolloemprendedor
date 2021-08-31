<?php

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$request= $_REQUEST;

// COLUMNAS DE LA TABLA

$col    = array(

    0   => 	'solicitante',
    1	=> 	'dni',
    2   =>  'edad',
    3	=> 	'asociar',	
); 

$sql= "SELECT id_solicitante, concat(apellido,' ', nombres) as solicitante, dni, fecha_nac FROM solicitantes";

$query      = mysqli_query($con, $sql);
$totalData  = mysqli_num_rows($query);
$totalFilter= $totalData;

$sql= "SELECT id_solicitante, concat(apellido,' ', nombres) as solicitante, dni, fecha_nac FROM solicitantes";

// FILTRO
if(!empty($request['search']['value'])){

    $sql .= " WHERE (concat(apellido,' ', nombres) like '%".$request['search']['value']."%'";
    $sql .= " OR dni like '%".$request['search']['value']."%')";
}else{
    $sql .= " WHERE dni = -1";
}

$query      = mysqli_query($con, $sql);
$totalData  = mysqli_num_rows($query);

// ORDEN

if($request['length']>0){
    $sql .= " ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".$request['start']." ,".$request['length']." ";
}else{
    $sql .= " ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir'];
}

$query      = mysqli_query($con, $sql);

$data       = array();

while($row  = mysqli_fetch_array($query)){

    $subdata= array();

    list($Y,$m,$d)  = explode("-",$row['fecha_nac']);
    $edad           = date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y ;

    $subdata[]  =   '<a href="javascript:void(0)" title="Editar datos" onclick="editar_solicitante('.$row['id_solicitante'].')">'.$row['solicitante'].'</a>';        
    $subdata[]  =   $row['dni'];
    $subdata[]  =   $edad; 
    $subdata[]  =   '<a href="javascript:void(0)" title="Vincula el solicitante al proyecto "> <i class="fas fa-link asociar" id="'.$row['id_solicitante'].'"></i></a>';

    $data[]     = $subdata;
}

$json_data = array(

    "draw"              => intval($request['draw']),
    "recordsTotal"      => intval($totalData),
    "recordsFiltered"   => intval($totalFilter),
    "data"              => $data
);

echo json_encode($json_data);
?>