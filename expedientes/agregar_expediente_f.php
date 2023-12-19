<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}
require_once '../accesorios/accesos_bd.php';

$con = conectar();

$id_solicitante         = $_POST['id_solicitante'];
$nro_proyecto           = $_POST['nro_proyecto'];
$id_rubro               = $_POST['id_rubro'];
$nro_expediente_madre   = $_POST['nro_expediente_madre'];
$nro_expediente_control = $_POST['nro_expediente_control'];
$id_localidad           = $_POST['id_localidad'];
$monto                  = $_POST['monto'];
$fecha_otorgamiento     = $_POST['fecha_otorgamiento'];

if (strlen($_POST['observaciones']) > 0) {
    $observaciones = 1;
} else {
    $observaciones = 0;
}

// CAMBIAR ESTADO PROYECTO = 25 - PROYECTO FINANCIADO
mysqli_query($con, "UPDATE proyectos SET id_estado = 25 WHERE id_proyecto = $nro_proyecto");

$query_expedientes = mysqli_query($con, "SELECT id_expediente FROM expedientes WHERE nro_exp_madre = $nro_expediente_madre AND nro_exp_control = $nro_expediente_control");
$rows              = mysqli_num_rows($query_expedientes);

if ($rows == 0) {
    $inserta = "INSERT INTO expedientes (nro_proyecto, id_rubro, nro_exp_madre, nro_exp_control, id_localidad, monto, fecha_otorgamiento, observaciones, estado, saldo, id_proyecto) 
    VALUES ($nro_proyecto, $id_rubro, $nro_expediente_madre, $nro_expediente_control, $id_localidad, $monto, '$fecha_otorgamiento', '$observaciones', 1, $monto, $nro_proyecto)";
    $resultado     = mysqli_query($con, $inserta) or die($inserta);
    $id_expediente = mysqli_insert_id($con);
} else {
    $registro_expedientes = mysqli_fetch_array($query_expedientes);
    $id_expediente        = $registro_expedientes['id_expediente'];
}

///////////////////////////////////////////////////
//REVISAR SI EL EXPEDIENTE TIENE OBSERVACIONES
///////////////////////////////////////////////////

if (strlen($_POST['observaciones']) > 0) {
    $observaciones   = $_POST['observaciones'];
    $tabla_insercion = "INSERT INTO observaciones_expedientes (id_expediente, observaciones) VALUES ('$id_expediente', '$observaciones')";
    $resultado       = mysqli_query($con, $tabla_insercion);
}

// EXPEDIENTES - EMPRENDEDORES
$query_solicitantes = mysqli_query($con, "SELECT id_solicitante FROM rel_proyectos_solicitantes WHERE id_proyecto = $nro_proyecto");
$rows_solicitantes  = mysqli_num_rows($query_solicitantes);

while ($registro_soli = mysqli_fetch_array($query_solicitantes)) {
    $id_solicitante = $registro_soli['id_solicitante'];

    $datos_solicitante    = mysqli_query($con, "SELECT * FROM solicitantes WHERE id_solicitante = $id_solicitante");
    $registro_solicitante = mysqli_fetch_array($datos_solicitante);
    $dni                  = $registro_solicitante['dni'];
    $id_resp              = $registro_solicitante['id_responsabilidad'];

    $seleccion = "SELECT id_emprendedor FROM emprendedores WHERE dni = $dni";

    $registro = mysqli_query($con, $seleccion);

    if (mysqli_num_rows($registro) == 0) {
        $apellido   = $registro_solicitante['apellido'];
        $nombres    = $registro_solicitante['nombres'];
        $genero     = $registro_solicitante['genero'];
        $otrogenero = $registro_solicitante['otrogenero'];
        $dni        = $registro_solicitante['dni'];
        $cuit       = $registro_solicitante['cuit'];
        $direccion  = $registro_solicitante['direccion'];
        $fecha_nac  = $registro_solicitante['fecha_nac'];
        $id_ciudad  = $registro_solicitante['id_ciudad'];
        $celular    = $registro_solicitante['celular'];
        $telefono   = $registro_solicitante['telefono'];
        $cod_area   = $registro_solicitante['cod_area'];
        $email      = $registro_solicitante['email'];
        $id_cond    = 0;

        $inserta = "INSERT INTO emprendedores (apellido, nombres, genero, otrogenero, dni, cuit, direccion, fecha_nac, id_ciudad, cod_area, telefono, celular, email, id_condicion_laboral, observaciones) 
        VALUES ('$apellido', '$nombres', $genero, '$otrogenero', '$dni', '$cuit', '$direccion', '$fecha_nac', $id_ciudad, '$cod_area', '$telefono', '$celular', '$email', '$id_cond', '$observaciones')";
        $resultado = mysqli_query($con, $inserta) or die($inserta);

        $id_emprendedor = mysqli_insert_id($con);
    } else {
        $registro_emprendedor = mysqli_fetch_array($registro);
        $id_emprendedor       = $registro_emprendedor[0];
    }

    mysqli_query($con, "INSERT INTO rel_expedientes_emprendedores (id_expediente, id_emprendedor, id_responsabilidad) VALUES ($id_expediente, $id_emprendedor, $id_resp)")
        or die('Revisar insercion Nuevo Emprendedor');
}

// /////////////////////////////////////////////////////////// EXPEDIENTES - UBICACIONES
mysqli_query($con, "INSERT INTO expedientes_ubicaciones (fecha, id_tipo_ubicacion, motivo) values ('$fecha_otorgamiento', 1, 'INICIO TRAMITE')")
or die('Revisar insercion Expediente ubicacion');

$id_ubicacion = mysqli_insert_id($con);

mysqli_query($con, "INSERT INTO rel_expedientes_ubicacion (id_expediente, id_ubicacion) values ($id_expediente, $id_ubicacion)")
or die('Revisar insercion Relacion del Expediente y ubicacion');

// /////////////////////////////////////////////////////////// EXPEDIENTES - ESTADOS
mysqli_query($con, "INSERT INTO expedientes_estados (id_expediente, fecha, id_tipo_estado) values ($id_expediente, '$fecha_otorgamiento', 1)");

mysqli_close($con);

header('location:../evaluaciones/listado_evaluaciones.php');
