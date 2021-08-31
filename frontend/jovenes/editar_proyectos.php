<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}

require($_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/accesos_bd.php');
$con = conectar();

$fecha              = date('Y-m-d', time());
$id_proyecto        = $_POST['id_proyecto'];
$id_solicitante     = $_SESSION['id_usuario'];

$latitud            = sanear_campo($_POST['latitud']);
$longitud           = sanear_campo($_POST['longitud']);

$denominacion       = sanear_campo(strtoupper($_POST['denominacion']));
$resumen_ejecutivo  = sanear_campo(strtoupper($_POST['resumen_ejecutivo']));
$monto              = ($_POST['monto'] > 0) ? $_POST['monto'] : 0;
$descripcion        = sanear_campo(strtoupper($_POST['descripcion']));
$objetivos          = sanear_campo(strtoupper($_POST['objetivos']));
$oportunidades      = sanear_campo(strtoupper($_POST['oportunidades']));
$desarrollo         = sanear_campo(strtoupper($_POST['desarrollo']));

$historia           = sanear_campo(strtoupper($_POST['historia']));
$presente           = sanear_campo(strtoupper($_POST['presente']));
$lugardesarrollo    = sanear_campo(strtoupper($_POST['lugardesarrollo']));
$detallelugar       = sanear_campo(strtoupper($_POST['detallelugar']));
$caratecnicas       = sanear_campo(strtoupper($_POST['caratecnicas']));
$caratecnologicas   = sanear_campo(strtoupper($_POST['caratecnologicas']));
$caraprocesos       = sanear_campo(strtoupper($_POST['caraprocesos']));
$caramateriasprimas = sanear_campo(strtoupper($_POST['caramateriasprimas']));
$caradesechos       = sanear_campo(strtoupper($_POST['caradesechos']));

$mercado            = sanear_campo(strtoupper($_POST['mercado']));
$caraclientes       = sanear_campo(strtoupper($_POST['caraclientes']));
$caracompetencia    = sanear_campo(strtoupper($_POST['caracompetencia']));
$caraproveedores    = sanear_campo(strtoupper($_POST['caraproveedores']));
$carariesgosestrategias = sanear_campo(strtoupper($_POST['carariesgosestrategias']));
$destinomonto       = sanear_campo(strtoupper($_POST['destinomonto']));
$personal           = sanear_campo(strtoupper($_POST['personal']));
$interaccion        = sanear_campo(strtoupper($_POST['interaccion']));
$impacto            = sanear_campo(strtoupper($_POST['impacto']));
$preciosproductos   = sanear_campo(strtoupper($_POST['preciosproductos']));
$origenfinanciacion = sanear_campo(strtoupper($_POST['origenfinanciacion']));

$fodafortalezas     = sanear_campo(strtoupper($_POST['fodafortalezas']));
$fodaoportunidades  = sanear_campo(strtoupper($_POST['fodaoportunidades']));
$fodadebilidades    = sanear_campo(strtoupper($_POST['fodadebilidades']));
$fodaamenazas       = sanear_campo(strtoupper($_POST['fodaamenazas']));

$id_rubro           = $_POST['id_rubro'];
$id_medio           = $_POST['id_medio'];
$id_programa        = $_POST['id_programa'];
$observaciones      = sanear_campo(strtoupper($_POST['observaciones']));

// ACTUALIZA REGISTRO SOLICITANTES

mysqli_query(
    $con,
    "UPDATE registro_solicitantes SET id_rubro = $id_rubro, id_medio = $id_medio, observaciones = '$observaciones' 
WHERE id_solicitante = $id_solicitante"
);

// ACTUALIZA REGISTRO PROYECTOS

mysqli_query($con, "UPDATE proyectos SET monto=$monto, denominacion = '$denominacion',resumen_ejecutivo = '$resumen_ejecutivo',monto=$monto,
descripcion='$descripcion',objetivos = '$objetivos',oportunidades = '$oportunidades',desarrollo = '$desarrollo',
historia = '$historia',presente = '$presente',lugardesarrollo=$lugardesarrollo, detallelugar='$detallelugar',caratecnicas = '$caratecnicas',
caratecnologicas = '$caratecnologicas',caraprocesos = '$caraprocesos', caramateriasprimas = '$caramateriasprimas', caradesechos = '$caradesechos',
mercado = '$mercado',caraclientes = '$caraclientes',caracompetencia='$caracompetencia',
caraproveedores='$caraproveedores',carariesgosestrategias = '$carariesgosestrategias',destinomonto = '$destinomonto',personal = '$personal',
interaccion = '$interaccion', impacto = '$impacto', preciosproductos = '$preciosproductos', origenfinanciacion = '$origenfinanciacion',
fodafortalezas = '$fodafortalezas',fodaoportunidades = '$fodaoportunidades', fodadebilidades='$fodadebilidades', fodaamenazas='$fodaamenazas',
latitud = $latitud, longitud = $longitud
WHERE id_proyecto = $id_proyecto") or die("Error edicion proyectos");

// RELACIONAR PROYECTOS CON SEGUIMIENTOS

mysqli_query($con, "UPDATE proyectos_seguimientos SET fecha = '$fecha' WHERE id_proyecto = $id_proyecto") or die('Revisar edicion Proyectos Seguimientos');

mysqli_close($con);

echo 1;