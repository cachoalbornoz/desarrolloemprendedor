<?php
require_once("../accesorios/accesos_bd.php");
$con=conectar();

$email = $_GET['email'];

$cadena = "SELECT id_solicitante FROM solicitantes WHERE email = '".$email."'";
$query  = mysqli_query($con, $cadena);

if(mysqli_num_rows($query) > 0){
    $result = "Email registrado, ingrese otro por favor ";
}else{    
    $cadena = "SELECT id_emprendedor FROM emprendedores WHERE email = '".$email."'";
    $query  = mysqli_query($con, $cadena);

    // Esta presente en la tabla EMPRENDEDORES
    if(mysqli_num_rows($query) > 0){
        
        $result = "Email registrado, ingrese otro por favor ";

    }else{
        $result = true;
    }
}
mysqli_close($con); 

header('Content-Type: application/json');
echo json_encode($result);
?>
