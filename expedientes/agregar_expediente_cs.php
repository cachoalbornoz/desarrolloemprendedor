<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}
require_once('../accesorios/accesos_bd.php');

$con=conectar();
	
$nro_proyecto=$_POST['nro_proyecto'];
$id_rubro = $_POST['id_rubro'];	

$dni = $_POST['dni'];
$apellido = ltrim($_POST['apellido']);	
$nombres  = ltrim($_POST['nombres']);	
$telefono = $_POST['telefono'];	
$email  = $_POST['email'];

$monto = $_POST['monto'];
$fecha_otorgamiento = $_POST['fecha_otorgamiento']; 

$id_localidad = $_POST['id_localidad'];	


if(strlen($_POST['observaciones']) > 0){
    $observaciones=1;
}else{
    $observaciones=0;
}
	
$inserta = "insert into expedientes (nro_proyecto, id_rubro, nro_exp_madre, nro_exp_control, id_localidad, monto, fecha_otorgamiento, observaciones, estado, saldo) 
					VALUES ($nro_proyecto, $id_rubro, 0, 0, $id_localidad, $monto, '$fecha_otorgamiento', '$observaciones', 1, $monto)" ;
					
$resultado = mysqli_query($con, $inserta) or die ("Error en la insercion expedientes");						 																																																							

$id_expediente = mysqli_insert_id($con);

///////////////////////////////////////////////////
$inserta = "insert into emprendedores (apellido, nombres, dni, cuit, direccion, id_ciudad, cod_area, telefono, celular, email,id_responsabilidad) 
                                VALUES ('$apellido', '$nombres', '$dni', 0, '', $id_localidad, 0, '$telefono', '', '$email',1)" ;
$resultado = mysqli_query($con, $inserta) or die ("Error en la insercion emprendedores");								 																																																							

$id_emprendedor = mysqli_insert_id($con);

///////////////////////////////////////////////////
//REVISAR SI EL EXPEDIENTE TIENE OBSERVACIONES
///////////////////////////////////////////////////
if(strlen($_POST['observaciones']) > 0){
    $observaciones = $_POST['observaciones'];

    $tabla_insercion = "insert into observaciones_expedientes (id_expediente, observaciones) VALUES ('$id_expediente', '$observaciones')";
    $resultado = mysqli_query($con, $tabla_insercion);
}

/////////////////////////////////////////////////////////// EXPEDIENTES - EMPRENDEDORES
mysqli_query($con, "insert into rel_expedientes_emprendedores (id_expediente, id_emprendedor) values ($id_expediente,$id_emprendedor)");


mysqli_close($con);
	
header("location:../expedientes/padron_expedientes_cs.php");
