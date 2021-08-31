<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}
require_once("../accesorios/accesos_bd.php");

$con=conectar();

if(isset($_POST)){

    $idProyecto = $_POST['id'];

    $consulta = " DELETE FROM proyectos_seguimientos WHERE id_proyecto = $idProyecto";

    $resultado = mysqli_query($con,$consulta);
    
	mysqli_query($con,"UPDATE proyectos SET id_estado = 20 WHERE id_proyecto = $idProyecto");
	
	echo '1';

}


?>