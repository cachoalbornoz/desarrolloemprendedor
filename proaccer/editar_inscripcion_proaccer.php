<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require_once("../accesorios/accesos_bd.php");
$con=conectar();

$id_solicitante 			= $_POST['id_solicitante'];
$id_encuestador				= $_POST['id_encuestador'];

$prodserv1					= $_POST['prodserv1'];
$prodserv2					= $_POST['prodserv2'];
$prodserv3					= $_POST['prodserv3'];
$cantserv1					= $_POST['cantserv1'];
$cantserv2					= $_POST['cantserv2'];
$cantserv3					= $_POST['cantserv3'];
$detalleproducto 			= $_POST['detalleproducto'];
$vendeafueraprovincia 		= $_POST['vendeafueraprovincia'];
$lugarfueraprovincia 		= $_POST['lugarfueraprovincia'];
$productovende 				= $_POST['productovende'];
$comer_directo 				= 0;
$comer_intermediario  		= 0;
$comer_otra    				= 0;

for ($i = 0; $i < count($_POST['formacomercializacion']); $i++) {

	switch ($_POST['formacomercializacion'][$i]) {
		case 1:
			$comer_directo      = 1;
			break;
		case 2:
			$comer_intermediario  = 1;
			break;
		case 3:
			$comer_otra    = 1;
			break;
	}
}

$otraformacomercializacion 	= $_POST['otraformacomercializacion'];
$esexportable 				= $_POST['esexportable'];
$deseaexportar				= $_POST['deseaexportar'];
$paisexporta  				= $_POST['paisexporta'];
$productoexporta 			= $_POST['productoexporta'];

// ALMACENA INFORMACION DE INSCRIPCION

$actualiza = "UPDATE proaccer_inscripcion 
	SET prodserv1 = '$prodserv1', prodserv2 = '$prodserv2', prodserv3 = '$prodserv3', cantserv1 = '$cantserv1',
	cantserv2 = '$cantserv2',	cantserv3 = '$cantserv3', detalleproducto = '$detalleproducto', vendeafueraprovincia = $vendeafueraprovincia, 
	lugarfueraprovincia = '$lugarfueraprovincia', productovende = $productovende, comer_directo = $comer_directo, comer_intermediario = $comer_intermediario,
	comer_otra = $comer_otra, otraformacomercializacion = '$otraformacomercializacion', esexportable = $esexportable, deseaexportar = $deseaexportar, 
	paisexporta = '$paisexporta', productoexporta = $productoexporta 
	WHERE id_solicitante = $id_solicitante";

mysqli_query($con, $actualiza) or die($actualiza);
	


mysqli_close($con);


header("location:InscripcionDigitalActividad.php?id_solicitante=".$id_solicitante."&id_encuestador=".$id_encuestador."&actualizado=1"); 