<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}
require_once '../accesorios/accesos_bd.php';

$con = conectar();

$id_emprendedor = $_GET['id'];

$apellido         = ltrim($_POST['apellido']);
$nombres          = ltrim($_POST['nombres']);
$dni              = $_POST['dni'];
$cuit             = $_POST['cuit'];
$direccion        = $_POST['direccion'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];

$id_ciudad = $_POST['id_ciudad'];
$celular   = $_POST['celular'];
$telefono  = $_POST['telefono'];
$cod_area  = $_POST['cod_area'];
$email     = $_POST['email'];

$id_responsabilidad   = $_POST['id_responsabilidad'];
$id_condicion_laboral = $_POST['id_condicion_laboral'];

if ($id_responsabilidad == 1) {
    $_SESSION['titular'] = $apellido . ' ' . $nombres;
}

if (strlen($_POST['observaciones']) > 0) {
    $observaciones = 1;
} else {
    $observaciones = 0;
}

if ($id_emprendedor == 0) {
    $inserta = "INSERT INTO emprendedores (apellido, nombres, dni, cuit, direccion, fecha_nac, id_ciudad, cod_area, telefono, celular, email, id_condicion_laboral, observaciones) 
	VALUES ('$apellido', '$nombres', '$dni', '$cuit', '$direccion', '$fecha_nacimiento', $id_ciudad, '$cod_area', '$telefono', '$celular', '$email', '$id_condicion_laboral', '$observaciones')";
    $resultado = mysqli_query($con, $inserta) or die('Error en la insercion emprendedor');

    $id_emprendedor = mysqli_insert_id($con);
    $id_expediente  = $_SESSION['id_expediente'];

    mysqli_query($con, "UPDATE rel_expedientes_emprendedores SET id_emprendedor = $id_emprendedor WHERE id_emprendedor = 0 AND id_expediente = $id_expediente");

    $resultado = mysqli_query($con, $inserta) or die('Error en la edicion emprendedor');
} else {
    $edita = "UPDATE emprendedores SET apellido = '$apellido', nombres = '$nombres', dni = '$dni', cuit = '$cuit', direccion='$direccion', 
	id_ciudad='$id_ciudad', telefono='$telefono', cod_area='$cod_area', email='$email', celular = '$celular', 
	id_condicion_laboral = '$id_condicion_laboral', fecha_nac ='$fecha_nacimiento', observaciones='$observaciones' where id_emprendedor = '$id_emprendedor'";

    print $edita;

    $resultado = mysqli_query($con, $edita) or die('Error en la edicion emprendedor');
}

$id_expediente = $_SESSION['id_expediente'];
mysqli_query($con, "UPDATE rel_expedientes_emprendedores SET id_responsabilidad = $id_responsabilidad WHERE id_emprendedor = '$id_emprendedor' and id_expediente = $id_expediente");

/////////////////////////////////////////////////////////////////////////////////////
if ($observaciones == 1) {
    $observaciones = $_POST['observaciones'];

    $seleccion = "SELECT id_emprendedor FROM observaciones_emprendedores WHERE id_emprendedor = '$id_emprendedor'";
    $registro  = mysqli_query($con, $seleccion) or die('Error en la selección observaciones emprendedor');

    if (mysqli_num_rows($registro) == 0) {
        $tabla_insercion = "INSERT INTO observaciones_emprendedores (id_emprendedor, observaciones) VALUES ('$id_emprendedor', '$observaciones')";
        $resultado       = mysqli_query($con, $tabla_insercion) or die('Error en la inserción observaciones emprendedor');
    } else {
        $edicion   = "UPDATE observaciones_emprendedores SET observaciones = '$observaciones' WHERE id_emprendedor = $id_emprendedor";
        $resultado = mysqli_query($con, $edicion) or die('Error en la edicion observaciones emprendedor');
    }
} else {
    $elimina = mysqli_query($con, "DELETE FROM observaciones_emprendedores WHERE id_emprendedor = $id_emprendedor");
}

mysqli_close($con);

header('location:padron_emprendedores.php');
