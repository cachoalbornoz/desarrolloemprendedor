<?php
session_start();
if(!isset($_SESSION['usuario'])){
	header('location:../accesorios/salir.php');
	exit;
}
require_once('../accesorios/accesos_bd.php');

$con=conectar();

$id_expediente=$_GET['id'];
$nro_proyecto = $_POST['nro_proyecto'];	
$id_rubro = $_POST['id_rubro'];	

$nro_expediente_madre = $_POST['nro_expediente_madre'];	
$nro_expediente_control = $_POST['nro_expediente_control'];	

$monto = $_POST['monto']; 
$fecha_otorgamiento = $_POST['fecha_otorgamiento']; 
$id_localidad = $_POST['id_localidad'];	


if(strlen($_POST['observaciones']) > 0){
	$observaciones=1;
}else{
	$observaciones=0;
}


$edita = "UPDATE expedientes SET nro_proyecto = '$nro_proyecto', id_rubro = '$id_rubro', nro_exp_madre = $nro_expediente_madre,
			nro_exp_control = $nro_expediente_control, id_localidad = $id_localidad, monto = $monto, fecha_otorgamiento = '$fecha_otorgamiento' 
			WHERE id_expediente = '$id_expediente'";	
	


$resultado = mysqli_query($con, $edita) or die ("Error en la edicion expedientes");

///////////////////////////////////////////////////
//REVISAR SI EL EXPEDIENTE TIENE OBSERVACIONES
///////////////////////////////////////////////////
if($observaciones == 1){
	$observaciones = $_POST['observaciones'];
	
	mysqli_query($con, "update expedientes set observaciones = 1 where id_expediente = '$id_expediente'");
	
	$registro=mysqli_query($con, "select id_expediente from observaciones_expedientes where id_expediente = '$id_expediente'");
	
	if(mysqli_num_rows($registro) == 0){
		$resultado = mysqli_query($con, "insert into observaciones_expedientes (id_expediente, observaciones) VALUES ('$id_expediente', '$observaciones')");
	}else{	
		$resultado = mysqli_query($con, "update observaciones_expedientes set observaciones = '$observaciones' where id_expediente = $id_expediente");
	}
	
}else{
	
	mysqli_query($con, "update expedientes set observaciones = 0 where id_expediente = '$id_expediente'");
	
	$elimina = mysqli_query($con, "delete from observaciones_expedientes where id_expediente = $id_expediente");
}

	
	
unset($_SESSION['nro_proyecto']);


mysqli_close($con);

header("location:padron_expedientes.php");
?>