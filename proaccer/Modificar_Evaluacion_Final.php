<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}

require_once('../accesorios/accesos_bd.php');

$con=conectar();

$id_usuario = $_SESSION['id_usuario'];
$idProyecto = $_GET['id_proyecto'];

$resultadoFinal = 0;

for ($i=1;$i<7;$i++) {
    $resultadoFinal = $_POST['pto_preg_'.$i] + $resultadoFinal;
}

$fecha      =   $_POST['fecha'];

$ptoPreg1   =   $_POST['pto_preg_1'];
$ptoPreg2   =   $_POST['pto_preg_2'];
$ptoPreg3   =   $_POST['pto_preg_3'];
$ptoPreg4   =   $_POST['pto_preg_4'];
$ptoPreg5   =   $_POST['pto_preg_5'];
$ptoPreg6   =   $_POST['pto_preg_6'];

$observacion=   $_POST['observaciones'];

$obs1       =   $_POST['obs_1'];
$obs2       =   $_POST['obs_2'];
$obs3       =   $_POST['obs_3'];
$obs4       =   $_POST['obs_4'];
$obs5       =   $_POST['obs_5'];
$obs6       =   $_POST['obs_6'];


$tabla_consulta = "UPDATE proaccer_seguimientos SET fecha ='$fecha', puntaje1 = $ptoPreg1, puntaje2 = $ptoPreg2, puntaje3 = $ptoPreg3, puntaje4 = $ptoPreg4, puntaje5 = $ptoPreg5, puntaje6 = $ptoPreg6, comentario = '$observacion', id_usuario = $id_usuario, resultado_final = $resultadoFinal,
    observacion1 = '$obs1', observacion2 = '$obs2', observacion3 = '$obs3', observacion4 = '$obs4', observacion5 = '$obs5', observacion6 = '$obs6' WHERE  id_proyecto = $idProyecto";

mysqli_query($con, $tabla_consulta);


header('location:padron_apoyocomercial.php');
