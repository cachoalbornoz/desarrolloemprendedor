<?php 
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

include_once('../accesorios/accesos_bd.php');
$con=conectar();
    
if(isset($_GET)){
    $id = $_GET['id'];

    $tabla      = mysqli_query($con,"SELECT adjunto FROM proaccer_entrevista WHERE id = $id");
    $resultado  = mysqli_fetch_array($tabla) or die('Revisar eliminacion Informe');
    
    $adjunto = $resultado['adjunto']; 
    
    if (file_exists("informes/".$adjunto)) {
        unlink("../proaccer/informes/".$adjunto); 
    }
    
    
    mysqli_query($con,"UPDATE proaccer_entrevista SET adjunto = NULL WHERE id = $id");

}

header('location:padron_apoyocomercial.php');