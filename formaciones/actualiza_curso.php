<?php

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$id                 = $_POST['id'];
$nombre             = ltrim($_POST['nombre']);
$fechaRealizacion   = $_POST['fechaRealizacion'];
$lugar              = strtoupper(ltrim($_POST['lugar']));
$id_ciudad          = $_POST['id_ciudad'];
$hora               = $_POST['hora'];
$resenia            = ltrim($_POST['resenia']);
$destinatarios      = ltrim($_POST['destinatarios']);
if (isset($_POST['activo'])) {
    $activo = 1;
} else {
   $activo  = 0;
}
$url                = ltrim($_POST['url']);



mysqli_query($con, "UPDATE formacion_cursos 
    SET nombre = '$nombre', resenia = '$resenia', fechaRealizacion = '$fechaRealizacion', lugar = '$lugar', hora = '$hora', destinatarios = '$destinatarios', activo = $activo, id_ciudad = $id_ciudad, url = '$url' 
    WHERE id = $id") or die("Error actualizacion de cursos");

mysqli_close($con);

header("location:listado_cursos.php");

?>
