<?php

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$request= $_REQUEST;

// COLUMNAS DE LA TABLA

$col    = array(

    0   =>	'id_solicitante',
    1	=> 	'id_solicitante',
    2   => 	'solicitante',
    3	=> 	'dni',
    4	=> 	'email',
    5   =>  'edad',	
    6   =>  'ciudad',	
    7   =>  'dpto',	
); 

$sql= 
    "SELECT id_solicitante, concat(apellido,' ', nombres) as solicitante, dni, email, fecha_nac, t2.nombre as ciudad, t3.nombre as dpto 
        FROM solicitantes t1
        INNER JOIN localidades t2 ON t1.id_ciudad = t2.id 
        INNER JOIN departamentos t3 ON t2.departamento_id = t3.id

    UNION

    SELECT id_emprendedor, concat(apellido,' ', nombres) as solicitante, dni, email, fecha_nac, t2.nombre as ciudad, t3.nombre as dpto 
        FROM emprendedores t1
        INNER JOIN localidades t2 ON t1.id_ciudad = t2.id 
        INNER JOIN departamentos t3 ON t2.departamento_id = t3.id";

$query      = mysqli_query($con, $sql);
$totalData  = mysqli_num_rows($query);
$totalFilter= $totalData;

$sql= 
    "SELECT id_solicitante, concat(apellido,' ', nombres) as solicitante, dni, email, fecha_nac, t2.nombre as ciudad, t3.nombre as dpto 
        FROM solicitantes t1
        INNER JOIN localidades t2 ON t1.id_ciudad = t2.id 
        INNER JOIN departamentos t3 ON t2.departamento_id = t3.id

    UNION

    SELECT id_emprendedor, concat(apellido,' ', nombres) as solicitante, dni, email, fecha_nac, t2.nombre as ciudad, t3.nombre as dpto 
        FROM emprendedores t1
        INNER JOIN localidades t2 ON t1.id_ciudad = t2.id 
        INNER JOIN departamentos t3 ON t2.departamento_id = t3.id";

// FILTRO
if(!empty($request['search']['value'])){

    $sql = "SELECT t1.id_solicitante, CONCAT(t1.apellido,' ', t1.nombres) as solicitante, t1.dni, t1.email, t1.fecha_nac, t2.nombre as ciudad, t3.nombre as dpto 
        FROM solicitantes t1
        INNER JOIN localidades t2 ON t1.id_ciudad = t2.id 
        INNER JOIN departamentos t3 ON t2.departamento_id = t3.id";
    $sql .= " WHERE CONCAT(t1.apellido,' ', t1.nombres) LIKE '%".$request['search']['value']."%'";
    $sql .= " OR t1.dni like '%".$request['search']['value']."%'";

    $sql .= " UNION ";

    $sql .= "SELECT t4.id_emprendedor, CONCAT(t4.apellido,' ', t4.nombres) as solicitante, t4.dni, t4.email, t4.fecha_nac, t5.nombre as ciudad, t6.nombre as dpto 
        FROM emprendedores t4
        INNER JOIN localidades t5 ON t4.id_ciudad = t5.id 
        INNER JOIN departamentos t6 ON t5.departamento_id = t6.id";
    $sql .= " WHERE CONCAT(t4.apellido,' ', t4.nombres) LIKE '%".$request['search']['value']."%'";
    $sql .= " OR t4.dni like '%".$request['search']['value']."%'";

}else{
    $sql= 
    "SELECT id_solicitante, concat(apellido,' ', nombres) as solicitante, dni, email, fecha_nac, t2.nombre as ciudad, t3.nombre as dpto 
        FROM solicitantes t1
        INNER JOIN localidades t2 ON t1.id_ciudad = t2.id 
        INNER JOIN departamentos t3 ON t2.departamento_id = t3.id WHERE t1.id_solicitante = -1

    UNION

    SELECT id_emprendedor, concat(apellido,' ', nombres) as solicitante, dni, email, fecha_nac, t2.nombre as ciudad, t3.nombre as dpto 
        FROM emprendedores t1
        INNER JOIN localidades t2 ON t1.id_ciudad = t2.id 
        INNER JOIN departamentos t3 ON t2.departamento_id = t3.id WHERE t1.id_emprendedor = -1";
}

$query      = mysqli_query($con, $sql) or die ($sql);
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

    $subdata[]  =   $row['id_solicitante'];
    $subdata[]  =   '<a href="javascript:void(0)" title="Ver datos de la persona "> <i class="fas fa-search ver" id="'.$row['dni'].'"></i></a>';
    $subdata[]  =   $row['solicitante'];        
    $subdata[]  =   $row['dni'];
    $subdata[]  =   $row['email'];
    $subdata[]  =   $edad; 
    $subdata[]  =   $row['ciudad'];
    $subdata[]  =   $row['dpto'];

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