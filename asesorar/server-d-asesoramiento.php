<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}
require_once("../accesorios/accesos_bd.php");

$con=conectar();

if(isset($_POST)){

    $id = $_POST['id'];

    $resultado = mysqli_query($con, "DELETE FROM asesorar_seguimiento WHERE id = $id");
	
	echo '1';

}


?>