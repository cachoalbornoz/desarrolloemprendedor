<?php

session_start();

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');
$con=conectar();

$id_solicitante     = $_SESSION['id_usuario'];

// ACTUALIZA DATOS DE LA EMPRESA
    
$id_empresa			= $_POST['id_empresa'];
$razon_social       = strtoupper(ltrim($_POST['razon_social']));
$cuite              = $_POST['cuite'];
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


if($id_empresa > 0){

	mysqli_query($con, 
		"UPDATE maestro_empresas
		SET razon_social = '$razon_social', cuit = '$cuite', id_tipo_sociedad = '$id_tipo_sociedad', fecha_inscripcion = STR_TO_DATE('$fecha_inscripcion','%d/%m/%Y'), fecha_inicio = STR_TO_DATE('$fecha_inicio','%d/%m/%Y'),  domicilio = '$domiciliol', nro = '$nrol', 
		id_localidad = '$id_ciudadl', domicilio_actividad = '$domicilior', nro_actividad = '$nror',  id_localidad_actividad = '$id_ciudadr',  codigoafip = '$codigoafip',  actividadafip = '$actividadafip', representante = '$representante', otrosregistros = '$otrosregistros', nroexportador = '$nroexportador' 
		WHERE id= $id_empresa") or die('Revisar Update Empresas');    

}else{		

	// NO TIENE UNA EMPRESA Y AGREGA DATOS DE LA MISMA
		
    mysqli_query($con, 
        "INSERT INTO maestro_empresas (razon_social,  cuit,  id_tipo_sociedad,  fecha_inscripcion,  fecha_inicio,  domicilio,  nro,  id_localidad,  domicilio_actividad,  nro_actividad,  id_localidad_actividad,  codigoafip,  actividadafip, representante, otrosregistros, nroexportador)
        VALUES ('$razon_social',  '$cuite',  $id_tipo_sociedad,  STR_TO_DATE('$fecha_inscripcion','%d/%m/%Y'),  STR_TO_DATE('$fecha_inicio','%d/%m/%Y'),  '$domiciliol',  '$nrol',  $id_ciudadl,  '$domicilior',  '$nror',  $id_ciudadr,  '$codigoafip',  '$actividadafip', '$representante', '$otrosregistros', '$nroexportador')")
        or die('Revisar insert Empresas');         
        $id_empresa = mysqli_insert_id($con);

    mysqli_query($con, 
        "UPDATE registro_solicitantes 
        SET id_empresa = $id_empresa
        WHERE id_solicitante = $id_solicitante") or die('Revisar actualizacion empresas - solicitante'); 
}

mysqli_close($con);

?>