<?php

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$id                 = $_POST['id'];
$lugar              = strtoupper(ltrim($_POST['lugar']));
$referente          = strtoupper(ltrim($_POST['referente']));
$capacitador        = strtoupper(ltrim($_POST['capacitador']));
$asistentes         = strtoupper(ltrim($_POST['asistentes']));


mysqli_query($con, "UPDATE formacion_cursos 
    SET lugar = '$lugar', referente = '$referente', capacitador='$capacitador', asistentes = '$asistentes'
    WHERE id = $id") or die("Error actualizacion de cursos");

mysqli_close($con);

header("location:listado_registros.php");

?>
