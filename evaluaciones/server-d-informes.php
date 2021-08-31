<?php 
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

include_once('../accesorios/accesos_bd.php');
$con=conectar();
    
if(isset($_POST)){

    $idProyecto = $_POST['id'];

    $tabla      = mysqli_query($con,"select informe from proyectos WHERE id_proyecto = $idProyecto");
    $resultado  = mysqli_fetch_array($tabla);
    
    $informe    = $resultado['informe']; 
    
    if (file_exists("informes/".$informe)) {
        unlink("informes/".$informe); 
    }
    
    
    mysqli_query($con,"update proyectos set informe = NULL where id_proyecto = $idProyecto");

    echo '1';

}