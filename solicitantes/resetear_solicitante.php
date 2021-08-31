<?php

session_start();

if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require_once("../accesorios/accesos_bd.php");
$con=conectar();

$id_solicitante = $_POST['id_solicitante'];

$tabla      = mysqli_query($con, "select * from rel_proyectos_solicitantes where id_solicitante = $id_solicitante");
$registro   = mysqli_fetch_array($tabla);


mysqli_close($con);

//header('location:admin_solicitantes.php');