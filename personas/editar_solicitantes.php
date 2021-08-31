<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require_once("../accesorios/accesos_bd.php");
$con=conectar();

$id_solicitante     = $_POST['id_solicitante'];
$dni                = $_POST['dni'];
$apellido           = strtoupper(ltrim($_POST['apellido']));
$nombres            = strtoupper(ltrim($_POST['nombres']));
$genero             = $_POST['genero'];
($_POST['genero'] == 0 or $_POST['genero'] == 1) ? $_POST['otrogenero'] = '' : null;
$otrogenero         = $_POST['otrogenero'];
$fecha_nac          = $_POST['fecha_nac'];
$email              = $_POST['email'];
$cuit               = $_POST['cuit'];
$direccion          = strtoupper(ltrim($_POST['direccion']));
$id_ciudad          = $_POST['id_ciudad'];
$id_responsabilidad = $_POST['id_responsabilidad'];
$cod_area           = $_POST['cod_area'];
$celular            = $_POST['celular'];
$telefono           = $_POST['telefono'];
$observaciones      = strtoupper(ltrim($_POST['idea']));

$id_medio           = $_POST['id_medio'];
$id_rubro           = $_POST['id_rubro'];
$id_entidad         = $_POST['id_entidad'];

if (isset($_POST['funciona']) and $_POST['funciona'] == "on") {

    $id_empresa         = $_POST['id_empresa'];
    $razon_social       = strtoupper(ltrim($_POST['razon_social']));
    $cuite              = $_POST['cuit'];
    $id_tipo_sociedad   = $_POST['id_tipo_sociedad'];
    $fecha_inscripcion  = $_POST['fecha_inscripcion'];
    $fecha_inicio       = $_POST['fecha_inicio'];
    $domiciliol         = strtoupper(ltrim($_POST['domiciliol']));
    $nrol               = $_POST['nrol'];
    $id_ciudadl         = $_POST['id_ciudadl'];
    $domicilior         = strtoupper(ltrim($_POST['domicilior']));
    $nror               = $_POST['nror'];
    $id_ciudadr         = $_POST['id_ciudadr'];
    $representante      = strtoupper(ltrim($_POST['representante']));
    $codigoafip         = $_POST['codigoafip'];
    $actividadafip      = strtoupper(ltrim($_POST['actividadafip']));
    $otrosregistros     = $_POST['otrosregistros'];
    $nroexportador      = $_POST['nroexportador'];

} else {

    $id_empresa            = 0;
}


// CARGAR DATOS DEL SOLICITANTE

mysqli_query($con,
"UPDATE solicitantes 
	SET dni = '$dni', apellido='$apellido', nombres='$nombres', genero=$genero, otrogenero = '$otrogenero', direccion='$direccion', cuit='$cuit', observaciones = 1,
	fecha_nac= '$fecha_nac', email='$email', cod_area = '$cod_area', telefono='$telefono',celular='$celular', 
    id_ciudad=$id_ciudad, id_responsabilidad = $id_responsabilidad
	WHERE id_solicitante = $id_solicitante" ) or die("Error en la actualización solicitantes");


// LIMPIO EL REGISTRO DEL SOLICITANTE
mysqli_query($con,"DELETE FROM registro_solicitantes WHERE id_solicitante = $id_solicitante");


// CARGO EL REGISTRO DEL SOLICITANTE

if(isset($_POST['id_programa'])){

    $id_programa    = $_POST['id_programa'];

    foreach ($id_programa as $id_prog){ 

        mysqli_query($con,
        "INSERT INTO registro_solicitantes (id_solicitante, id_rubro, id_medio, id_programa, observaciones, id_empresa, id_entidad) 
            VALUES ($id_solicitante, $id_rubro, $id_medio, $id_prog, '$observaciones', $id_empresa, $id_entidad)") or die("Error en la insercion registro_solicitantes");
    }

}else{

    mysqli_query($con,
    "INSERT INTO registro_solicitantes (id_solicitante, id_rubro, id_medio, id_programa, observaciones, id_empresa, id_entidad) 
        VALUES ($id_solicitante, $id_rubro, $id_medio, 1, '$observaciones', $id_empresa, $id_entidad)") or die("Error en la insercion registro_solicitantes");
}

// TIENE UNA EMPRESA
if ($id_empresa > 0) {

    mysqli_query($con, 
    "UPDATE maestro_empresas
		SET razon_social = '$razon_social', cuit = '$cuite', id_tipo_sociedad = '$id_tipo_sociedad', fecha_inscripcion = '$fecha_inscripcion', fecha_inicio = '$fecha_inicio',  domicilio = '$domiciliol', nro = '$nrol', id_localidad = '$id_ciudadl', domicilio_actividad = '$domicilior', nro_actividad = '$nror',  id_localidad_actividad = '$id_ciudadr',  codigoafip = '$codigoafip',  actividadafip = '$actividadafip', representante = '$representante', otrosregistros = '$otrosregistros', nroexportador = '$nroexportador' 
		WHERE id= $id_empresa") or die('Revisar Update Empresas');

} else {

    // NO TIENE UNA EMPRESA Y AGREGA DATOS DE LA MISMA
    if (isset($_POST['funciona']) and $_POST['funciona'] == "on") {

        $inserta = "INSERT INTO maestro_empresas (razon_social,  cuit,  id_tipo_sociedad,  fecha_inscripcion,  fecha_inicio,  domicilio,  nro,  id_localidad,  domicilio_actividad,  nro_actividad,  id_localidad_actividad,  codigoafip,  actividadafip, representante, otrosregistros, nroexportador)
			VALUES ('$razon_social',  '$cuite',  $id_tipo_sociedad,  '$fecha_inscripcion',  '$fecha_inicio',  '$domiciliol',  '$nrol',  $id_ciudadl,  '$domicilior',  '$nror',  $id_ciudadr,  '$codigoafip',  '$actividadafip', '$representante', '$otrosregistros', '$nroexportador')";

        mysqli_query($con, $inserta) or die($inserta);

        $id_empresa = mysqli_insert_id($con);

        mysqli_query($con, "UPDATE registro_solicitantes SET id_empresa = $id_empresa WHERE id_solicitante = $id_solicitante") or die('Revisar actualizacion empresas - solicitante');

    } else {

        // ELIMINO LA EMPRESA QUE TENIA Y DESMARCO

        mysqli_query($con,
        "DELETE t2
            FROM registro_solicitantes t1
            INNER JOIN maestro_empresas t2 ON t1.id_empresa = t2.id
            WHERE t1.id_solicitante = $id_solicitante");
    }
}


mysqli_close($con);

echo '1';
