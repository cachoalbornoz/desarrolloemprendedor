<?php

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$id                 = $_POST['id'];
$nombre             = strtoupper(ltrim($_POST['nombre']));
if (isset($_POST['activo'])) {
    $activo = 1;
} else {
   $activo  = 0;
}

mysqli_query($con, "UPDATE tipo_formacion SET formacion = '$nombre', activo = $activo WHERE id = $id") 
or die("Actualizar tipo formacion - L16 / ".time());

mysqli_close($con);

header("location:listado_formaciones.php");

?>
