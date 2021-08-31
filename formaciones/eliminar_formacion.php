<?php

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$id = $_POST['id'];

mysqli_query($con, "DELETE FROM tipo_formacion WHERE id = $id");

mysqli_close($con);

?>
