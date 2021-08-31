<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}
require_once('../accesorios/accesos_bd.php');
$con=conectar();

$id_proyecto    = $_POST['id_proyecto'];
$id             = $_POST['idDetalle'];
$observacion 	= $_POST['observacion'];
$id_usuario 	= $_POST['id_usuario'];


if($id <> 0){

    mysqli_query($con, "UPDATE proaccer_detalle_observaciones 
    SET observacion = '$observacion', id_usuario = $id_usuario
    WHERE id = $id" );

}else{

    mysqli_query($con, "INSERT INTO proaccer_detalle_observaciones
    (id_proyecto, observacion, id_usuario) VALUES ($id_proyecto, '$observacion', $id_usuario)" ) ;
}

mysqli_close($con);

$ruta = 'Location:fichaSeguimiento.php?id='.$id_proyecto;

header($ruta);

?>