<?php
require_once("../accesorios/accesos_bd.php");
$con=conectar();

$cuit = $_GET['id'];

$tabla_emprendedores = mysqli_query($con,"SELECT id_emprendedor FROM emprendedores WHERE cuit = '$cuit'" );

if(mysqli_fetch_array($tabla_emprendedores)){
	echo "0" ;
}else{
	echo "1" ;
}
mysqli_close($con); 

?>
