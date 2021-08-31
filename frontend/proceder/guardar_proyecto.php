<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');
$con=conectar();

// DATOS DE LA EMPRESA 

$id_empresa = $_SESSION['id_empresa'] ;

$razon_social       = sanear_campo($_POST['razon_sociali']);
$cuit               = sanear_campo($_POST['cuiti']);
$id_tipo_sociedad   = $_POST['id_tipo_sociedadi'];
$domicilio          = sanear_campo($_POST['domicilioi']) ;
$nro                = sanear_campo($_POST['nroi']) ;
$id_ciudad          = sanear_campo($_POST['id_ciudadi']) ;
$representante      = sanear_campo($_POST['representantei']) ;
$fecha_inscripcioni = $_POST['fecha_inscripcioni'];

mysqli_query($con, "UPDATE proceder_empresas 
SET razon_social = '$razon_social', cuit = '$cuit', id_tipo_sociedad = $id_tipo_sociedad, domicilio = '$domicilio',
nro = '$nro', id_localidad = $id_ciudad, representante = '$representante', fecha_inscripcion = '$fecha_inscripcioni'
WHERE id_empresa = $id_empresa") or die("Error edicion empresas");

// FIN DATOS DE LA EMPRESA


// DATOS DEL INVERSOR

$id_inversor = $_SESSION['id_inversor'] ;

$apellido  = $_POST['apellidoii'];
$nombres   = $_POST['nombresii'];
$dni       = $_POST['dniii'];
$cuit      = $_POST['cuitii'];
$domicilio = $_POST['domicilioii'];
$nro       = $_POST['nroii'];
$cp        = $_POST['cpii'];
$id_ciudad = $_POST['id_ciudadii'];
$fecha_nac = $_POST['fecha_nacii'];
$cod_area  = $_POST['cod_areaii'];
$telefono  = $_POST['telefonoii'];
$celular   = $_POST['celularii'];
$email     = $_POST['emailii'];



mysqli_query($con, "UPDATE proceder_inversores 
SET apellido = '$apellido', nombres = '$nombres', cuit = '$cuit', dni = $dni, direccion = '$domicilio',
nro = '$nro', cp = '$cp', id_ciudad = $id_ciudad, fecha_nac = '$fecha_nac', 
cod_area = '$cod_area', telefono = '$telefono', celular = '$celular',  email = '$email'
WHERE id_inversor = $id_inversor") or die("Error edicion inversor");


// FIN DATOS DEL INVERSOR

// DATOS DEL PROYECTO

$id_proyecto    = $_SESSION['id_proyecto'] ;

$detalleser     = $_POST['detalleser'];
$historia       = $_POST['historia'];
$detallepro     = $_POST['detallepro'];
$resenia        = $_POST['resenia'];
$monto          = $_POST['monto'];
$rubro          = $_POST['rubro'];
$aspectos       = $_POST['aspectos'];

mysqli_query($con, "UPDATE proceder_proyectos 
SET detalleservicio = '$detalleser', historia = '$historia', detalleproducto = '$detallepro',
resenia = '$resenia', monto = $monto, rubro = '$rubro', aspectos = '$aspectos'
WHERE id_proyecto = $id_proyecto") or die("Error edicion proyecto");


// FIN DATOS DEL PROYECTO


mysqli_close($con);

echo $id_proyecto;

?>
