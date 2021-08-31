<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}
require_once('../accesorios/accesos_bd.php');
$con=conectar();

$id_emprendedor=$_POST['id'];
$id_expediente = $_SESSION['id_expediente'];

$registro = mysqli_query($con, "select * from rel_expedientes_emprendedores where id_expediente = $id_expediente");

if(mysqli_num_rows($registro) > 1){
	
	//// ELIMINA DE TABLA RELACION EXPEDIENTES - EMPRENDEDORES 
	$tabla_elimina = "delete from rel_expedientes_emprendedores where id_emprendedor = $id_emprendedor and id_expediente = $id_expediente";
	$result = mysqli_query($con,$tabla_elimina) or die('Revisar eliminar_emprendedor ');
	
	//// ELIMINA DE TABLA EMPRENDEDORES 
	$tabla_elimina = "delete from emprendedores where id_emprendedor = '$id_emprendedor'";
	$result = mysqli_query($con,$tabla_elimina);
	
	//// ELIMINA DE TABLA EMPRENDEDORES - OBSERVACIONES  
	$tabla_elimina = "delete from observaciones_emprendedores where id_emprendedor = '$id_emprendedor'";
	$result = mysqli_query($con,$tabla_elimina);
}
	
mysqli_close($con);

?>