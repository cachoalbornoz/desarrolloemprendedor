<?php
require_once("../accesorios/accesos_bd.php");
$con=conectar();

$user = $_GET['usuario'];

$tabla_usuarios = mysqli_query($con,"select id_usuario from usuarios where nombre_usuario = '$user'" );

if(mysqli_fetch_array($tabla_usuarios)){
    echo "1" ;
}else{
    echo "0" ;
}
mysqli_close($con); 
