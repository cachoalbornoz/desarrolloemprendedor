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

$objetivos 	= $_POST['objetivos'];
$acciones 	= $_POST['acciones'];
$cumplio 	= $_POST['cumplio'];

$solicitante    = $_SESSION['solicitante'];

if($id <> 0){

    $query = "UPDATE formacion_detalle_formaciones
        SET objetivos = '$objetivos', acciones = '$acciones', cumplio = $cumplio
        WHERE id = $id";

    mysqli_query($con, $query ) or die ($query);

}else{

    $query = "INSERT INTO formacion_detalle_formaciones
        (id_solicitante, objetivos, acciones, cumplio) VALUES 
        ($id_solicitante, '$objetivos', '$acciones', $cumplio)" ;
    
    mysqli_query($con, $query) or die ($query);
}

mysqli_close($con);

$ruta = 'Location:fichaSeguimiento.php?id='.$id_solicitante.'&solicitante='.$solicitante;

header($ruta);

?>