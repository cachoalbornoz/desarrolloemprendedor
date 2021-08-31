<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require_once('../accesorios/accesos_bd.php');

$con=conectar();

$idProyecto = $_GET['id_proyecto'];

$archivo    = $_FILES['archivo']['name'];

if(move_uploaded_file($_FILES['archivo']['tmp_name'],"informes/".$archivo)){
    chmod("informes/".$_FILES['archivo']['name'],0777);
    mysqli_query($con,"update proyectos set informe = '$archivo' where id_proyecto = $idProyecto");
}



header('location:listado_evaluaciones.php');