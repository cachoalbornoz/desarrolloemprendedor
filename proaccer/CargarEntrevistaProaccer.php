<?php 
session_start();

if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require_once("../accesorios/accesos_bd.php");
$con=conectar();

$id_entrevistador	= $_POST['id_entrevistador'];
$id_solicitante		= $_POST['id_solicitante'];
$tipoemprendimiento = strtoupper(trim($_POST['tipoemprendimiento']));
$productos			= strtoupper(trim($_POST['productos']));
$id_formajuridica	= $_POST['id_formajuridica'];
$inscripcion		= strtoupper(trim($_POST['inscripcion']));
$objetivos			= strtoupper(trim($_POST['objetivos']));
$feriaseventos		= strtoupper(trim($_POST['feriaseventos']));


$registro = mysqli_query($con,"SELECT id FROM proaccer_entrevista WHERE id_solicitante = $id_solicitante");
if($fila = mysqli_fetch_array($registro)){
	
	$id_entrevista = $fila['id'];
	
	$query = "UPDATE proaccer_entrevista SET id_entrevistador = $id_entrevistador, tipoemprendimiento = '$tipoemprendimiento', productos = '$productos', id_formajuridica = $id_formajuridica, 
	inscripcion = '$inscripcion', objetivos = '$objetivos', feriaseventos = '$feriaseventos' WHERE id = $id_entrevista";
	
	mysqli_query($con, $query) or die('Revisar Edicion de Entrevistas Proaccer');
	
}else{
	
	$query = "INSERT INTO proaccer_entrevista (id_entrevistador, id_solicitante, tipoemprendimiento, productos, id_formajuridica, inscripcion, objetivos, feriaseventos)
	VALUES ($id_entrevistador, $id_solicitante, '$tipoemprendimiento', '$productos', $id_formajuridica, '$inscripcion', '$objetivos', '$feriaseventos')";
	
	mysqli_query($con, $query) or die('Revisar Ingreso Entrevistas Proaccer');
	
	$id_entrevista = mysqli_insert_id($con);
	
}


$adjunto    = $_FILES['adjunto']['name'];

if(move_uploaded_file($_FILES['adjunto']['tmp_name'],"informes/".$adjunto)){
    chmod("informes/".$_FILES['adjunto']['name'],0777);
    mysqli_query($con,"UPDATE proaccer_entrevista SET adjunto = '$adjunto' WHERE id = $id_entrevista");
}



mysqli_close($con);

header('location: ../proaccer/ImprimirEntrevistaProaccer.php?id='.$id_entrevista);

?>