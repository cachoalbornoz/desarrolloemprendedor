<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require_once('../accesorios/accesos_bd.php');

$con=conectar();

$id_usuario = $_SESSION['id_usuario'];
$idProyecto = $_GET['id_proyecto'];

$resultadoFinal = 0;

for($i=1;$i<10;$i++){
    $resultadoFinal = $_POST['pto_preg_'.$i] + $resultadoFinal; 
}

$fecha      =   $_POST['fecha'];

$ptoPreg1   =   $_POST['pto_preg_1'];
$ptoPreg2   =   $_POST['pto_preg_2'];
$ptoPreg3   =   $_POST['pto_preg_3'];
$ptoPreg4   =   $_POST['pto_preg_4'];
$ptoPreg5   =   $_POST['pto_preg_5'];
$ptoPreg6   =   $_POST['pto_preg_6'];
$ptoPreg7   =   $_POST['pto_preg_7'];
$ptoPreg8   =   $_POST['pto_preg_8'];
$ptoPreg9   =   $_POST['pto_preg_9'];

$observacion=   $_POST['observaciones'];

$obs1       =   $_POST['obs_1'];
$obs2       =   $_POST['obs_2'];
$obs3       =   $_POST['obs_3'];
$obs4       =   $_POST['obs_4'];
$obs5       =   $_POST['obs_5'];
$obs6       =   $_POST['obs_6'];
$obs7       =   $_POST['obs_7'];
$obs8       =   $_POST['obs_8'];
$obs9       =   $_POST['obs_9'];




$tabla = mysqli_query($con, "SELECT id_seguimiento FROM proyectos_seguimientos WHERE  id_proyecto = $idProyecto");

if(mysqli_affected_rows($con) > 0){

	mysqli_query($con, "UPDATE proyectos_seguimientos SET fecha ='$fecha', puntaje1 = $ptoPreg1, puntaje2 = $ptoPreg2, puntaje3 = $ptoPreg3, puntaje4 = $ptoPreg4, puntaje5 = $ptoPreg5, puntaje6 = $ptoPreg6, puntaje7 = $ptoPreg7, puntaje8 = $ptoPreg8, puntaje9 = $ptoPreg9, comentario = '$observacion', id_usuario = $id_usuario, resultado_final = $resultadoFinal, 
    observacion1 = '$obs1', observacion2 = '$obs2', observacion3 = '$obs3', observacion4 = '$obs4', observacion5 = '$obs5', observacion6 = '$obs6', observacion7 = '$obs7', observacion8 = '$obs8', observacion9 = '$obs9',modificado = 'SI' WHERE  id_proyecto = $idProyecto") 
	or die ('Revisar agregado Evaluacion');
	
}else{

	mysqli_query($con, "INSERT INTO proyectos_seguimientos (id_seguimiento, id_proyecto, fecha, puntaje1, puntaje2, puntaje3, puntaje4, puntaje5, puntaje6, puntaje7, puntaje8, puntaje9, comentario, id_usuario, resultado_final,
	observacion1,observacion2,observacion3,observacion4,observacion5,observacion6,observacion7,observacion8,observacion9)
	VALUES (NULL, $idProyecto, '$fecha', $ptoPreg1, $ptoPreg2, $ptoPreg3, $ptoPreg4, $ptoPreg5, $ptoPreg6, $ptoPreg7, $ptoPreg8, $ptoPreg9, '$observacion', $id_usuario, $resultadoFinal,
	'$obs1','$obs2','$obs3','$obs4','$obs5','$obs6','$obs7','$obs8','$obs9');") or die ('Revisar agregado Evaluacion');
}


if($resultadoFinal > 50){   // APRUEBA PROYECTO
    
    $id_estado = 23;
    
}else{                      // DESAPRUEBA PROYECTO
    
    $id_estado = 22;
}

mysqli_query($con,"UPDATE proyectos SET id_estado = $id_estado WHERE id_proyecto = $idProyecto");

header('location:listado_evaluaciones.php');