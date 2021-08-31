<?php
session_start();

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$nombre             = strtoupper(ltrim($_POST['nombre']));

mysqli_query($con, "INSERT INTO tipo_formacion (formacion, activo) values ('$nombre', 1)") 
or die("Revisar tipo formacion - L11 / ".time());

mysqli_close($con);

header("location:listado_formaciones.php");

?>
