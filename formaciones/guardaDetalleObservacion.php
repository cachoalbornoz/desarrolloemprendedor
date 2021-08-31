<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}
require_once('../accesorios/accesos_bd.php');
$con=conectar();

$id_solicitante = $_POST['id_solicitante'];
$id             = $_POST['idDetalle'];
$observacion 	= $_POST['observacion'];
$id_usuario 	= $_POST['id_usuario'];

$solicitante    = $_SESSION['solicitante'];

if($id <> 0){

    mysqli_query($con, "UPDATE formacion_detalle_observaciones 
    SET observacion = '$observacion', id_capacitador = $id_usuario
    WHERE id = $id" );

}else{

    mysqli_query($con, "INSERT INTO formacion_detalle_observaciones
    (id_solicitante, observacion, id_capacitador) VALUES ($id_solicitante, '$observacion', $id_usuario)" ) ;
}

mysqli_close($con);

$ruta = 'Location:fichaSeguimiento.php?id='.$id_solicitante.'&solicitante='.$solicitante;

header($ruta);

?>