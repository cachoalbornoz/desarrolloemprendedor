<?php
require_once("../accesorios/accesos_bd.php");
$con=conectar();

$id = $_POST['id'];

$tabla_resena = mysqli_query($con,"SELECT observaciones	FROM registro_solicitantes WHERE id_solicitante = $id");
$registro_res = mysqli_fetch_array($tabla_resena);

if($registro_res){
    echo $registro_res['observaciones'];
}else{
    echo "0" ;
}

mysqli_close($con); 

