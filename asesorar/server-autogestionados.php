<?php

require_once "../accesorios/accesos_bd.php";

$con = conectar();

$request = $_REQUEST;

// COLUMNAS DE LA TABLA

$col = [
    0 => 'accion',
    1 => 'id_solicitante',
    2 => 'solicitante',
    3 => 'dni',
    4 => 'seguimiento',
    5 => 'categoria',
    6 => 'color',
    7 => 'asesor',
    8 => 'fecha',
    9 => 'fecha_ini',
    10=> 'fecha_fin',

];

$sql = "SELECT s.id_solicitante, concat(s.apellido, ', ', s.nombres) AS solicitante, s.dni, as2.categoria as id_categoria, ta.tipo as categoria, as2.updated_at 
    FROM solicitantes s
    INNER JOIN asesorar_seguimiento as2 ON s.id_solicitante = as2.id_solicitante
    INNER JOIN tipo_asesoramiento ta ON ta.id = as2.categoria";

$query       = mysqli_query($con, $sql);
$totalData   = mysqli_num_rows($query);
$totalFilter = $totalData;

$sql = "SELECT s.id_solicitante, concat(s.apellido, ', ', s.nombres) AS solicitante, s.dni, as2.categoria as id_categoria, ta.tipo as categoria, as2.updated_at 
    FROM solicitantes s
    INNER JOIN asesorar_seguimiento as2 ON s.id_solicitante = as2.id_solicitante
    INNER JOIN tipo_asesoramiento ta ON ta.id = as2.categoria";

// FILTRO
if(!empty($request['search']['value'])){

	$sql .= " AND (concat(t1.apellido, ', ', t1.nombres) like '%".$request['search']['value']."%'";
    $sql .= " OR t1.dni like '%".$request['search']['value']."%'";
    $sql .= " OR ta.tipo like '%".$request['search']['value']."%')";
}

$query     = mysqli_query($con, $sql);
$totalData = mysqli_num_rows($query);

// ORDEN

if($request['length']>0){
    $sql .= " ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".$request['start']." ,".$request['length']." ";
}else{
    $sql .= " ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir'];
}

$query = mysqli_query($con, $sql);

$data = [];

while ($row = mysqli_fetch_array($query)) {

    $id_solicitante = $row['id_solicitante'];

    $color          = null ;
    $usuario        = null ;
    $fechainicio    = null ;
    $fechafin       = null ;


    if(isset($row['id_categoria'])){

        $id_categoria   = $row['id_categoria'];

        $select         = mysqli_query($con, 
        "SELECT as2.id, as2.fecha_ini, as2.fecha_fin, concat(u2.apellido, ', ', u2.nombres) AS usuario, color 
            FROM asesorar_seguimiento as2
            INNER JOIN usuarios u2 on as2.usuario = u2.id_usuario
            INNER JOIN asesorar_detalle ad ON as2.id = ad.seguimiento 
            INNER JOIN tipo_estado_seguimiento tes ON ad.tipo_estado = tes.id
            WHERE as2.id_solicitante = $id_solicitante AND categoria = $id_categoria
            ORDER BY ad.updated_at DESC 
            LIMIT 1");

        if($fila = mysqli_fetch_array($select)){
        
            $id_seguimiento = $fila['id'];
            $color          = '<div style="background-color:'.$fila['color'].'; color:'.$fila['color'].' ">&nbsp;</div>';
            $usuario        = $fila['usuario'] ;
            $fechainicio    = $fila['fecha_ini'] ;
            $fechafin       = $fila['fecha_fin'] ;

        }
    }
    

    $subdata = [];

    $id_categoria       = (isset($row['id_categoria']))?$row['id_categoria']:1;

    $subdata[] = '<a href="javascript:void(0)" title="Editar datos" onclick="editar_solicitante(' . $id_solicitante . ')">' . $id_solicitante . '</a>';
    $subdata[] = $row['solicitante'];
    $subdata[] = $row['dni'];
    $subdata[] = '<a href="cargar_seguimiento.php?id='.$id_solicitante.'&categoria='.$id_categoria.'" title="Ver detalles del seguimiento"><span class="fa fa-eye"></span></a>';
    $subdata[] = $row['categoria'];
    $subdata[] = $row['updated_at'];
    $subdata[] = $color;
    $subdata[] = $usuario;
    $subdata[] = $fechainicio;
    $subdata[] = $fechafin;
    $subdata[] = (isset($id_seguimiento))?'<a href="javascript:void(0)">
                    <i class="fas fa-trash text-danger borrar" id="'.$id_seguimiento.'"></i>
                 </a>':null;

    $data[] = $subdata;
}

$json_data = [

"draw" => intval($request['draw']),
"recordsTotal" => intval($totalData),
"recordsFiltered" => intval($totalFilter),
"data" => $data,
];

echo json_encode($json_data);