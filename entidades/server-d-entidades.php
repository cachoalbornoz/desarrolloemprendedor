<?php

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$id = $_POST['id'];

if($id > 0){
    
    mysqli_query($con, "UPDATE maestro_entidades SET estado = 1 WHERE id_entidad = $id");
    echo '1';
    
}else{

    echo '0';
}

mysqli_close($con);

?>