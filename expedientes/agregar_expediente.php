<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}
require_once '../accesorios/accesos_bd.php';

$con = conectar();

$nro_proyecto = $_POST['nro_proyecto'];

$_SESSION['nro_proyecto']       = $nro_proyecto       = $_POST['nro_proyecto'];
$_SESSION['monto']              = $monto              = $_POST['monto'];
$_SESSION['fecha_otorgamiento'] = $fecha_otorgamiento = $_POST['fecha_otorgamiento'];
$_SESSION['titular']            = '';

$id_rubro = $_POST['id_rubro'];

$nro_expediente_madre   = $_POST['nro_expediente_madre'];
$nro_expediente_control = $_POST['nro_expediente_control'];

$id_localidad = $_POST['id_localidad'];

if (strlen($_POST['observaciones']) > 0) {
    $observaciones = 1;
} else {
    $observaciones = 0;
}

$inserta = "INSERT INTO expedientes (nro_proyecto, id_rubro, nro_exp_madre, nro_exp_control, id_localidad, monto, fecha_otorgamiento, observaciones, estado, saldo) 
VALUES ($nro_proyecto, $id_rubro, $nro_expediente_madre, $nro_expediente_control, $id_localidad, $monto, '$fecha_otorgamiento', '$observaciones', 1, $monto)";

$resultado = mysqli_query($con, $inserta) or die('Error en la insercion expedientes');

$_SESSION['id_expediente'] = $id_expediente = mysqli_insert_id($con);

///////////////////////////////////////////////////
//REVISAR SI EL EXPEDIENTE TIENE OBSERVACIONES
///////////////////////////////////////////////////
if (strlen($_POST['observaciones']) > 0) {
    $observaciones = $_POST['observaciones'];

    $tabla_insercion = "INSERT INTO observaciones_expedientes (id_expediente, observaciones) VALUES ('$id_expediente', '$observaciones')";
    $resultado       = mysqli_query($con, $tabla_insercion);
}

/////////////////////////////////////////////////////////// EXPEDIENTES - EMPRENDEDORES
mysqli_query($con, "INSERT INTO rel_expedientes_emprendedores (id_expediente, id_emprendedor) values ($id_expediente, 0)");
/////////////////////////////////////////////////////////// EXPEDIENTES - UBICACIONES
mysqli_query($con, "INSERT INTO ubicaciones (fecha, id_tipo_ubicacion, motivo) values ('$fecha_otorgamiento', 1, 'INICIO TRAMITE')");
$id_ubicacion = mysqli_insert_id($con);
mysqli_query($con, "INSERT INTO rel_expedientes_ubicacion (id_expediente, id_ubicacion) values ($id_expediente, $id_ubicacion)");

/////////////////////////////////////////////////////////// EXPEDIENTES - ESTADOS
mysqli_query($con, "INSERT INTO expedientes_estados (id_expediente, fecha, id_tipo_estado) values ($id_expediente, '$fecha_otorgamiento', 1)");

mysqli_close($con);

header('location:../emprendedores/emprendedor_nuevo.php');
