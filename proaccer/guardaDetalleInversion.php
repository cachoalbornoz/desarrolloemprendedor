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
$descripcion 	= $_POST['descripcion'];

if(isset($_POST['facturo']) and $_POST['facturo'] == "on"){
    $facturo 	= 1;
}else{
    $facturo 	= 0;
}

if(isset($_POST['ejecuto']) and $_POST['ejecuto'] == "on"){
    $ejecuto 	= 1;
}else{
    $ejecuto 	= 0;
}

$situacion 	    = $_POST['situacion'];

if($id <> 0){

    mysqli_query($con, "UPDATE proaccer_detalle_inversiones 
    SET descripcion = '$descripcion', facturo = $facturo, ejecuto = $ejecuto, situacion = '$situacion'
    WHERE id = $id" );

}else{

    mysqli_query($con, "INSERT INTO proaccer_detalle_inversiones
    (id_proyecto, descripcion, facturo, ejecuto, situacion) VALUES ($id_proyecto, '$descripcion', $facturo, $ejecuto, '$situacion')" ) ;
}

mysqli_close($con);

$ruta = 'Location:fichaSeguimiento.php?id='.$id_proyecto;

header($ruta);

?>