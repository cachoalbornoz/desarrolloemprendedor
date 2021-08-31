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

mysqli_query($con, "INSERT INTO proaccer_seguimientos (id_proyecto, fecha, puntaje1, puntaje2, puntaje3, puntaje4, puntaje5, puntaje6, comentario, id_usuario, resultado_final,
observacion1,observacion2,observacion3,observacion4,observacion5,observacion6)
VALUES ($idProyecto, '$fecha', $ptoPreg1, $ptoPreg2, $ptoPreg3, $ptoPreg4, $ptoPreg5, $ptoPreg6, '$observacion', $id_usuario, $resultadoFinal,
'$obs1','$obs2','$obs3','$obs4','$obs5','$obs6');") or die('Revisar agregado Evaluacion');


header('location:padron_apoyocomercial.php');
