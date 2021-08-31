<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');
$con=conectar();


$id_proyecto        = $_POST['idProaccer'] ;

$presentoexpediente = $_POST['presentoexpediente'];
$sepago 	        = $_POST['sepago'];
$solicitovideo 	    = $_POST['solicitovideo'];
$presentorendicion 	= $_POST['presentorendicion'];


mysqli_query($con, "UPDATE proaccer_detalle_seguimiento
    SET presentoexpediente = $presentoexpediente, sepago = $sepago, solicitovideo = $solicitovideo, presentorendicion = $presentorendicion
    WHERE id_proyecto = $id_proyecto") or die("Error edicion proyecto");

mysqli_close($con);

echo $id_proyecto ;


?>