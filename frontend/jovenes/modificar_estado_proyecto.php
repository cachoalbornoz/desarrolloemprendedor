<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

date_default_timezone_set('America/Buenos_Aires');

$fnovedad = date('Y-m-d',time());

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');
require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/mailer.php');

$con=conectar(); 

$id_estado                      = $_POST['estado'];

$_SESSION['id_estado_proyecto'] = $id_estado;

$id_proyecto                    = $_SESSION['id_proyecto'] ;

mysqli_query($con, "UPDATE proyectos SET id_estado = $id_estado, fnovedad = '$fnovedad' WHERE id_proyecto = $id_proyecto");

$id_usuario = $_SESSION['id_usuario'];

echo 1;

// OBTENER DATOS DEL SOLICITANTE
$tabla 		= mysqli_query($con,"SELECT apellido, nombres, email FROM solicitantes WHERE id_solicitante = $id_usuario") or die ('Ver seleccion solicitantes');

$registro	= mysqli_fetch_array($tabla, 3);
$email		= $registro['email'];
$nombres	= $registro['nombres'] .' '. $registro['apellido'];
$titulo 	= ' - Proyecto Enviado -';
$mensaje	= 'Se ha enviado un proyecto a nombre de <b>'.$nombres.'</b> . <br>';
$logo       = null;

$envio      = enviar($email, $titulo, $nombres, $mensaje, $logo);
						
mysqli_close($con);

