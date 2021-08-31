<?php
session_start();

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$nombre             = ltrim($_POST['nombre']);
$fechaRealizacion   = $_POST['fechaRealizacion'];
$id_ciudad          = $_POST['id_ciudad'];
$lugar              = strtoupper(ltrim($_POST['lugar']));
$hora               = $_POST['hora'];
$resenia            = ltrim($_POST['resenia']);
$destinatarios      = ltrim($_POST['destinatarios']);
$url                = ltrim($_POST['url']);

mysqli_query($con, "INSERT INTO formacion_cursos (nombre, resenia, fechaRealizacion, lugar, hora, destinatarios, id_ciudad, url)
values ('$nombre', '$resenia', '$fechaRealizacion', '$lugar', '$hora', '$destinatarios', $id_ciudad, '$url')") or die("Error inserc cursos");

mysqli_close($con);

header("location:listado_cursos.php");

?>
