<?php

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$request= $_REQUEST;

// COLUMNAS DE LA TABLA

$col    = array(

    0   =>	'nroproyecto',
    1   => 	'solicitante',
    2   => 	'anio',
    3	=> 	'dni',
    4	=> 	'icono',
    5	=> 	'estado',
    6	=> 	'rubro',
    7	=> 	'fechao', 	
	8	=> 	'monto',
    9	=>	'saldo',
    10	=>	'borrar',
); 

$sql= "SELECT t1.id_expediente, nro_proyecto, concat(apellido, ', ' , nombres) AS solicitante, YEAR(fecha_otorgamiento) AS anio, dni, icono, t4.estado, rubro, monto, saldo, t3.id_emprendedor, dni, fecha_otorgamiento, t4.id_estado
FROM expedientes t1
INNER JOIN rel_expedientes_emprendedores t2 ON t1.id_expediente = t2.id_expediente
INNER JOIN emprendedores t3 ON t2.id_emprendedor = t3.id_emprendedor
INNER JOIN tipo_estado t4 ON t1.estado = t4.id_estado
INNER JOIN tipo_rubro_productivos t5 ON t1.id_rubro = t5.id_rubro
WHERE t3.id_responsabilidad = 1 AND t1.nro_exp_madre > 0 AND t1.estado <> 99";

$query      = mysqli_query($con, $sql);
$totalData  = mysqli_num_rows($query);
$totalFilter= $totalData;

$sql= "SELECT t1.id_expediente, nro_proyecto, concat(apellido, ', ' , nombres) AS solicitante, YEAR(fecha_otorgamiento) AS anio, dni, icono, t4.estado, rubro, monto, saldo, t3.id_emprendedor, dni, fecha_otorgamiento, t4.id_estado
FROM expedientes t1
INNER JOIN rel_expedientes_emprendedores t2 ON t1.id_expediente = t2.id_expediente
INNER JOIN emprendedores t3 ON t2.id_emprendedor = t3.id_emprendedor
INNER JOIN tipo_estado t4 ON t1.estado = t4.id_estado
INNER JOIN tipo_rubro_productivos t5 ON t1.id_rubro = t5.id_rubro
WHERE t3.id_responsabilidad = 1 AND t1.nro_exp_madre > 0 AND t1.estado <> 99";

// FILTRO
if(!empty($request['search']['value'])){

    $sql .= " AND concat(apellido, ', ', nombres) like '%".$request['search']['value']."%'";
    $sql .= " OR nro_proyecto like '%".$request['search']['value']."%'";
    $sql .= " OR YEAR(fecha_otorgamiento) like '%".$request['search']['value']."%'";
    $sql .= " OR dni like '%".$request['search']['value']."%'";
    $sql .= " OR t4.estado like '%".$request['search']['value']."%'";
    $sql .= " OR rubro like '%".$request['search']['value']."%'";
}

if(!empty($_POST['anio']) AND $_POST['anio'] > 0){
    $sql .= " AND YEAR(fecha_otorgamiento) like '%".$_POST['anio']."%'";
}

if(isset($_POST['estado']) AND $_POST['estado'] > 0 ){
    $sql .= " AND t4.id_estado = ".$_POST['estado'];
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

    // 
    $id_expediente  = $row['id_expediente'];
    $dni            = $row['dni'];

    $tabla_proyecto = mysqli_query($con,
    "SELECT proy.id_proyecto FROM proyectos proy 
        INNER JOIN rel_proyectos_solicitantes relps on relps.id_proyecto = proy.id_proyecto 
        INNER JOIN solicitantes soli on soli.id_solicitante = relps.id_solicitante 
            WHERE proy.id_estado = 25 AND soli.dni = $dni");
    
    $registro_proyecto = mysqli_fetch_array($tabla_proyecto);

    if($registro_proyecto){
        $id_proyecto = $registro_proyecto['id_proyecto'];
    }else{
        $id_proyecto = 0;
    }


    //

    
    $subdata[]  =   $row['nro_proyecto'];
    $subdata[]  =   '<a class="text-dark" href="sesion_usuario_expediente.php?id='.$id_expediente.'&id_proyecto='.$id_proyecto.'" title="Ver expediente">'.$row['solicitante'].'</a>';
    $subdata[]  =   $row['anio']; 
    $subdata[]  =   $row['dni']; 
    $subdata[]  =   $row['icono'];
    $subdata[]  =   $row['estado'];
	$subdata[]  =   $row['rubro'];
	$subdata[]  =   date('d/m/Y', strtotime($row['fecha_otorgamiento']));
	$subdata[]  =   number_format($row['monto'],0,'.',',');
    $subdata[]  =   number_format($row['saldo'],0,'.',','); 
    $subdata[]  =   '<a href="javascript:void(0)" title="Elimina expediente">
                        <i class="fas fa-trash text-danger borrar" id="'.$id_expediente.'" value="'.$row['solicitante'].'" title="Eliminar expediente de '.$row['solicitante'].'"></i>
                    </a>';    

    $data[]    = $subdata;
}

$json_data = array(

    "draw"              => intval($request['draw']),
    "recordsTotal"      => intval($totalData),
    "recordsFiltered"   => intval($totalFilter),
    "data"              => $data
);

echo json_encode($json_data);

?>