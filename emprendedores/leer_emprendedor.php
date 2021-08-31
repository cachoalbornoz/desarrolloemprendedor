<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require_once("../accesorios/accesos_bd.php");
$con=conectar();

$id_matriculado = $_GET['id'];

$tabla_matriculado = mysqli_query($con,"select id_matriculado, apellido, nombres,id_estado_cuenta from registros where id_matriculado = $id_matriculado" );

$registro = mysqli_fetch_array($tabla_matriculado) ;

$_SESSION['id_matriculado'] = $registro['id_matriculado'];	
$_SESSION['apellido_matriculado'] = $registro['apellido'];	
$_SESSION['nombres_matriculado'] = $registro['nombres'];
$_SESSION['id_estado_cuenta'] = $registro['id_estado_cuenta'];	

header("location:sesion_usuario_matriculado.php?id=".$registro['id_matriculado']);
	
mysqli_close($con); 
?>
