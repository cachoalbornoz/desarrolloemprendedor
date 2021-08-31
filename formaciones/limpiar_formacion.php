<?php

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$id = $_POST['id'];

mysqli_query($con, "DELETE t1 FROM rel_solicitante_formacion t1 WHERE id_formacion = $id") or die('Revisar formaciones');

mysqli_close($con);

?>
