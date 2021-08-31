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
$id_formacion   = $_POST['id_formacion'];
$inscribir      = $_POST['inscribir'];

if($inscribir == 1){

    mysqli_query($con,"INSERT INTO rel_solicitante_formacion (id_solicitante, id_formacion) VALUES ($id_solicitante, $id_formacion)");

}else{

    mysqli_query($con,"DELETE FROM rel_solicitante_formacion WHERE id_solicitante = $id_solicitante AND id_formacion = $id_formacion");

}


echo $inscribir;


?>