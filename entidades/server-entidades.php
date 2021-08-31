<?php

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$request= $_REQUEST;

// COLUMNAS DE LA TABLA

$col    = array(
	0   =>	'accion',
    1   =>	'id_entidad',
    2   =>	'entidad',
    3   =>	'usuario',
    4   =>	'clave',
    5   =>	'foto'
); 


$sql = "SELECT t1.id_entidad, entidad, t3.nombre_usuario, t3.clave, t1.foto  
FROM maestro_entidades t1
INNER JOIN rel_entidad_usuario t2 ON t1.id_entidad = t2.id_entidad
INNER JOIN usuarios t3 ON t2.id_usuario = t3.id_usuario
WHERE t1.estado <> 1 AND t1.id_entidad > 0";

$query      = mysqli_query($con, $sql);
$totalData  = mysqli_num_rows($query);
$totalFilter= $totalData;

$sql = "SELECT t1.id_entidad, entidad, t3.nombre_usuario, t3.clave, t1.foto 
FROM maestro_entidades t1
INNER JOIN rel_entidad_usuario t2 ON t1.id_entidad = t2.id_entidad
INNER JOIN usuarios t3 ON t2.id_usuario = t3.id_usuario
WHERE t1.estado <> 1 AND t1.id_entidad > 0";

// FILTRO
if(!empty($request['search']['value'])){

    $sql .= " AND entidad like '%".$request['search']['value']."%'";
}

$query      = mysqli_query($con, $sql);
$totalData  = mysqli_num_rows($query);

// ORDEN

if($request['length']>0){
    $sql .= " ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".$request['start']." ,".$request['length']." ";
}else{
    $sql .= " ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir'] ."  LIMIT ".$totalData." ";
}

$query      = mysqli_query($con, $sql);

$data       = array();

while($row  = mysqli_fetch_array($query)){

    $subdata= array();

    
    $foto       = (strlen($row['foto'])>0)?'<img src="/desarrolloemprendedor/entidades/image/'.$row['foto'].'" alt="IMAGEN" class=" img-thumbnail"/>':NULL;
    

    $subdata[] 	= '<a href="javascript:void(0)" title="Elimina entidad"><i class="fas fa-trash text-danger borrar" id="'.$row['id_entidad'].'"></i></a>';
    $subdata[] 	= $row['id_entidad'];
    $subdata[] 	= '<a href="javascript:void(0)" title="Editar los datos de la entidad" onclick="editar_entidad('.$row['id_entidad'].')">'.$row['entidad'].'</a>';
    $subdata[] 	= $row['nombre_usuario'];
    $subdata[]  = $row['clave'];
    $subdata[]  = $foto;
	
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