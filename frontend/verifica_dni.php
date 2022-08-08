<?php
require_once("../accesorios/accesos_bd.php");
$con=conectar();

if(!$_POST){
    header("Location:../index.php");
}

$dni = $_POST['dni'];

$tabla_solicitantes = mysqli_query($con,"SELECT id_solicitante FROM solicitantes WHERE dni = $dni" );

if(mysqli_affected_rows($con) > 0){
    $result = "DNI registrado ";
}else{
    
    $tabla_emprendedores = mysqli_query($con,"SELECT id_emprendedor FROM emprendedores WHERE dni = $dni" );
    
    if(mysqli_affected_rows($con) > 0){
        $result = "DNI registrado ";
    }else{
        $result = true;
    }
}
mysqli_close($con); 

header('Content-Type: application/json');
echo json_encode($result);
?>
