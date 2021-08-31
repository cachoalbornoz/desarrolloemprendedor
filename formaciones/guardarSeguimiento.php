<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');
$con=conectar();


$id_solicitante     = $_POST['id_solicitante'] ;

$asistio1   = $_POST['asistio1'];
$asistio2	= $_POST['asistio2'];
$asistio3	= $_POST['asistio3'];
$asistio4 	= $_POST['asistio4'];
$asistio5 	= $_POST['asistio5'];
$asistio6 	= $_POST['asistio6'];


mysqli_query($con, "UPDATE formacion_detalle_seguimiento
    SET asistio1 = $asistio1, asistio2 = $asistio2, asistio3 = $asistio3, asistio4 = $asistio4, asistio5 = $asistio5, asistio6 = $asistio6, updated_at = now()
    WHERE id_solicitante = $id_solicitante") or die("Error edicion seguimiento");

mysqli_close($con);

echo $id_solicitante ;


?>