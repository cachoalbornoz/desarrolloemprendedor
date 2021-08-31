<?php
session_start();

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');
$con=conectar();

$id_emprendedor = $_POST['id_emprendedor'];

$tabla      = mysqli_query($con, "SELECT genero FROM emprendedores WHERE id_emprendedor = $id_emprendedor");
$registro   = mysqli_fetch_array($tabla);

if($registro['genero'] == 0){
    mysqli_query($con, "UPDATE emprendedores SET genero = 1 WHERE id_emprendedor = $id_emprendedor");
}else{
    mysqli_query($con, "UPDATE emprendedores SET genero = 0 WHERE id_emprendedor = $id_emprendedor");
}

mysqli_close($con);

echo '1'   ;

?>