<?php 
session_start();	
require_once('../accesorios/accesos_bd.php');

$con=conectar();
$id_usuario = $_SESSION['id_usuario'];
$clave_vieja=$_POST['password'];
$clave_nueva=$_POST['password_nueva'];

$tabla = mysqli_query($con, "SELECT password FROM usuarios WHERE id_usuario = '$id_usuario'" ) or die("Error lectura de usuarios");
$registro = mysqli_fetch_array($tabla) ;
$clave_registro = $registro['password'];

if(md5($clave_vieja) == $clave_registro)
{
	$password= md5($clave_nueva);
	$edita="UPDATE usuarios SET password = '$password', clave = '$clave_nueva' WHERE id_usuario = $id_usuario";
	$resultado=mysqli_query($con, $edita);
	$_SESSION['verifica']=true;
}
else
{
	$_SESSION['verifica']=false;
}

mysqli_close($con);

header("location:/desarrolloemprendedor/registro/cambio_clave.php");
?>
