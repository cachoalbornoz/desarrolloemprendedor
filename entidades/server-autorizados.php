<?php
session_start();

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$id_usuario = $_SESSION['id_usuario'];
$sqle       = "SELECT id_entidad FROM rel_entidad_usuario WHERE id_usuario = $id_usuario";
$querye     = mysqli_query($con, $sqle);
$rowe       = mysqli_fetch_array($querye);
$id_entidad = $rowe['id_entidad'];

$request= $_REQUEST;

// COLUMNAS DE LA TABLA

$col    = array(

    0   =>	'id_solicitante',
    1   => 	'solicitante',
    2   =>  'dni', 	
	3	=> 	'localidad',
    4	=>	'dpto',
    5	=>	'resena',
    6	=> 	'habilitado',	
); 


$sql= "SELECT t1.id_solicitante, concat(t1.apellido,', ', t1.nombres) as solicitante, t1.dni, t3.nombre AS ciudad, t4.nombre AS dpto, t2.observaciones, t2.verificado_e 
FROM solicitantes t1
INNER JOIN registro_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
INNER JOIN localidades t3 ON t1.id_ciudad = t3.id
INNER JOIN departamentos t4 ON t3.departamento_id = t4.id";

$query      = mysqli_query($con, $sql);
$totalData  = mysqli_num_rows($query);
$totalFilter= $totalData;

$sql= "SELECT t1.id_solicitante, concat(t1.apellido,', ', t1.nombres) as solicitante, t1.dni, t3.nombre AS ciudad, t4.nombre AS dpto, t2.observaciones, t2.verificado_e 
FROM solicitantes t1
INNER JOIN registro_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
INNER JOIN localidades t3 ON t1.id_ciudad = t3.id
INNER JOIN departamentos t4 ON t3.departamento_id = t4.id";

// FILTRO
if(!empty($request['search']['value'])){

    $sql .= " WHERE concat(t1.apellido, ', ', t1.nombres) like '%".$request['search']['value']."%'";
    $sql .= " OR t1.nombres like '%".$request['search']['value']."%'";
    $sql .= " OR t3.nombre like '%".$request['search']['value']."%'";
    $sql .= " OR t4.nombre like '%".$request['search']['value']."%'";

}

$sql .= " AND t1.id_responsabilidad = 1 AND t2.id_programa = 1 AND t2.id_entidad = $id_entidad";

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

    $checked    = ($row['verificado_e']==1) ? 'checked' : '';

    $subdata[]  = $row['id_solicitante'];
    $subdata[]  = $row['solicitante'];  
    $subdata[]  = $row['dni'];  
	$subdata[]  = $row['ciudad'];
    $subdata[]  = $row['dpto']; 
    $subdata[]  = '<div style="max-width: 15em; max-height: 5em">'.$row['observaciones'].'</div>';
    $subdata[]  = '<input type="checkbox" class="autorizar" '.$checked.' id="'.$row['id_solicitante'].'" >';

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