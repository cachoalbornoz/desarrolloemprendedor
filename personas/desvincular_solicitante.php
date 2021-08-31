<?php
session_start();

require($_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/accesos_bd.php');
$con = conectar();

$id_solicitante = $_POST['id_solicitante'];
$id_proyecto    = $_POST['id_proyecto'];

mysqli_query(
    $con,
    "DELETE 
    FROM rel_proyectos_solicitantes 
    WHERE id_solicitante = $id_solicitante AND id_proyecto = $id_proyecto"
);

// SETEAR SOLICITANTE PARA QUE SEA ASOCIADO
mysqli_query($con, "UPDATE solicitantes set id_responsabilidad = 1 WHERE id_solicitante = $id_solicitante");

mysqli_close($con);

echo '1';