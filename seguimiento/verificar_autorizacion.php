<?php
require_once("../accesorios/accesos_bd.php");
$con = conectar();

$id = $_POST['id'];

$id_solicitante = $_POST['id'];

$tabla           = mysqli_query($con, "SELECT * FROM habilitaciones WHERE id_solicitante = $id_solicitante AND id_programa = 1");
$registro        = mysqli_fetch_array($tabla);

$enviar         = 0;

if ($registro) {

    if ($registro['habilitado'] == 1) {

        $enviar = 1;
        
    } else {
        
        $enviar = 0;
    }
} else {

    $enviar = 0;
}

echo $enviar;

mysqli_close($con);
