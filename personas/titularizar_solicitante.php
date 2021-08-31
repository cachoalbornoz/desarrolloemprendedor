<?php
session_start();

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');
$con=conectar();

$id_solicitante = $_POST['id_solicitante'];
$id_proyecto	= $_POST['id_proyecto'] ;


// PONER SOLICITANTE COMO TITULAR
mysqli_query($con, "UPDATE solicitantes SET id_responsabilidad = 1 WHERE id_solicitante = $id_solicitante ");


// PASAR LOS OTROS SOLICITANTES A ASOCIADOS

$tabla_relacion = mysqli_query($con, "SELECT * FROM rel_proyectos_solicitantes WHERE id_proyecto = $id_proyecto AND id_solicitante <> $id_solicitante ");

while($fila = mysqli_fetch_array($tabla_relacion)){

    $id_solicitante = $fila['id_solicitante'];

    // PONER SOLICITANTE COMO ASOCIADOS
    mysqli_query($con, "UPDATE solicitantes SET id_responsabilidad = 0 WHERE id_solicitante = $id_solicitante ");

}   

mysqli_close($con);

echo '1'   ;

?>