<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}
require_once '../accesorios/accesos_bd.php';

$con = conectar();

$id_expediente = $_SESSION['id_expediente'];

$cuit = $_POST['cuit'];

$seleccion = "SELECT id_emprendedor, cuit, apellido, nombres FROM emprendedores WHERE cuit = $cuit";

$registro = mysqli_query($con, $seleccion);

if (mysqli_num_rows($registro) == 0) {
    $apellido         = strtoupper(ltrim($_POST['apellido']));
    $nombres          = strtoupper(ltrim($_POST['nombres']));
    $dni              = $_POST['dni'];
    $direccion        = strtoupper($_POST['direccion']);
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    $id_ciudad = $_POST['id_ciudad'];
    $celular   = $_POST['celular'];
    $telefono  = $_POST['telefono'];
    $cod_area  = $_POST['cod_area'];
    $email     = $_POST['email'];

    $id_condicion_laboral = $_POST['id_condicion_laboral'];

    if (strlen($_POST['observaciones']) > 0) {
        $observaciones = 1;
    } else {
        $observaciones = 0;
    }

    ///////////////////////////////////////////////////
    //REVISAR SI EL EXPEDIENTE TIENE OBSERVACIONES
    ///////////////////////////////////////////////////

    $inserta = "INSERT INTO emprendedores (apellido, nombres, dni, cuit, direccion, fecha_nac, id_ciudad, cod_area, telefono, celular, email, id_condicion_laboral, observaciones) 
    VALUES ('$apellido', '$nombres', '$dni', '$cuit', '$direccion', '$fecha_nacimiento', $id_ciudad, '$cod_area', '$telefono', '$celular', '$email', '$id_condicion_laboral', '$observaciones')";
    mysqli_query($con, $inserta) or die($inserta);

    $id_emprendedor = mysqli_insert_id($con);

    if ($observaciones == 1) {
        $observaciones   = strtoupper($_POST['observaciones']);
        $tabla_insercion = "INSERT INTO observaciones_emprendedores (id_emprendedor, observaciones) VALUES ('$id_emprendedor', '$observaciones')";
        mysqli_query($con, $tabla_insercion);
    }
} else {
    $registro_emprendedor = mysqli_fetch_array($registro);
    $id_emprendedor       = $registro_emprendedor[0];

    if ($registro_emprendedor[4] == 1) {
        $_SESSION['titular'] = $registro_emprendedor[2] . ' ' . $registro_emprendedor[3];
    }
}

$tabla_inserta = mysqli_query(
    $con,
    "INSERT INTO rel_expedientes_emprendedores (id_expediente, id_emprendedor, id_responsabilidad) VALUES ($id_expediente, $id_emprendedor, 0)"
) or die('Revisar insercion Nuevo Emprendedor');

//

mysqli_close($con);

header('location:../formaspago/formaspago.php?id_proyecto=0');
