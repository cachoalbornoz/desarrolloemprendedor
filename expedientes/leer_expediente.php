<?php
session_start();
if(!isset($_SESSION['usuario']))
{
	header('location:../accesorios/salir.php');
	exit;
}
require_once('../accesorios/accesos_bd.php');

$con=conectar();
	
$nro_proyecto=$_GET['id'];
$fecha = $_GET['fecha'];
$año = date('Y',strtotime($fecha));
					
$resultado = mysqli_query($con, "select id_expediente from expedientes where nro_proyecto = $nro_proyecto and year(fecha_otorgamiento) = $año");						 																																																							
if(mysqli_fetch_array($resultado)){
	echo "0";
}else{
	echo "1";
}

mysqli_close($con);

?>