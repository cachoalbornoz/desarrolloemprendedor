<?php

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$request= $_REQUEST;

// COLUMNAS DE LA TABLA

$col    = array(

    0   => 	'id_emprendedor',
    1   => 	'apellido',
    2   => 	'nombres',
    3	=> 	'dni',
    4	=> 	'genero',
); 

$sql= "SELECT id_emprendedor, apellido, nombres, dni, genero  FROM emprendedores";

$query      = mysqli_query($con, $sql);
$totalData  = mysqli_num_rows($query);
$totalFilter= $totalData;


$sql= "SELECT id_emprendedor, apellido, nombres, dni, genero  FROM emprendedores";

// FILTRO
if(!empty($request['search']['value'])){

    $sql = "SELECT id_emprendedor, apellido, nombres, dni, genero FROM emprendedores";
    $sql .= " WHERE apellido LIKE '%".$request['search']['value']."%'";

}

// ORDEN

if($request['length']>0){
    
    $sql .= " ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".$request['start']." ,".$request['length']." ";
}else{
    $sql .= " ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir'];
}

$query      = mysqli_query($con, $sql) or die ($sql);
$totalData  = mysqli_num_rows($query);


$query      = mysqli_query($con, $sql);

$data       = array();

while($row  = mysqli_fetch_array($query)){
    
    $checked    = ($row['genero']==0) ? 'checked' : '';

    $subdata= array();

    $subdata[]  =   $row['id_emprendedor'];
    $subdata[]  =   $row['apellido'];        
    $subdata[]  =   $row['nombres'];        
    $subdata[]  =   $row['dni'];
    $subdata[]  =   '<input type="checkbox" class="cambiar" '.$checked.' id="'.$row['id_emprendedor'].'" >';
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