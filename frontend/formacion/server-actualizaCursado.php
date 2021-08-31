<?php

session_start();

if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/mailer.php');


$con=conectar();

$id_solicitante = $_SESSION['id_usuario'];
$id_curso       = $_POST['id_curso'];
$inscripto      = $_POST['inscripto'];

$tabla 		= mysqli_query($con,"SELECT nombre FROM formacion_cursos WHERE id = $id_curso");
$registro	= mysqli_fetch_array($tabla);
$curso		= $registro['nombre'];

if($inscripto == 1){

    mysqli_query($con,"INSERT INTO rel_solicitante_curso (id_solicitante, id_curso) VALUES ($id_solicitante, $id_curso)");

}else{

    mysqli_query($con,"DELETE FROM rel_solicitante_curso WHERE id_solicitante = $id_solicitante AND id_curso = $id_curso");

}

echo $inscripto;

?>