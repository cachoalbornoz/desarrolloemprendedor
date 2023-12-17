<?php
session_start();
require_once("../accesorios/accesos_bd.php");

$con=conectar();

$id_expediente = $_POST['id'];

// OBTENER EL ESTADO DEL EXPEDIENTE ANTES DE SER ELIMINADO
$seleccion          = mysqli_query($con,"SELECT id_tipo_estado FROM expedientes_estados WHERE id_expediente = $id_expediente ORDER BY fecha desc LIMIT 1" );
$fila_estado        = mysqli_fetch_array($seleccion);
$id_tipo_estado_ant = $fila_estado[0];

// 99 - ESTADO ELIMINADO
$insercion          = "INSERT INTO expedientes_estados (fecha, id_expediente, id_tipo_estado, id_tipo_estado_ant) VALUES (NOW(), $id_expediente, 99, $id_tipo_estado_ant)";
mysqli_query($con, $insercion) or die ("Error en la insercion Estado");	


// GUARDAR EN AUDITORIA EL USUARIO QUE ELIMINO EL EXPEDIENTE
$usuario                = $_SESSION['usuario'];
$insercion_auditoria    = "INSERT INTO expedientes_auditoria (id_expediente, usuario, id_tipo_estado) VALUES ($id_expediente, '$usuario', 99)";
mysqli_query($con, $insercion_auditoria) or die ("Error en la insercion Auditoria");	

// CAMBIAR EL EXPEDIENTE A ESTADO ELIMINADO
$edicion = mysqli_query($con, "UPDATE expedientes SET estado = 99 WHERE id_expediente = $id_expediente");	

mysqli_close($con);

echo '1';

?>