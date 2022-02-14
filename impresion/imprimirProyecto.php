<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}
require $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/accesos_bd.php';
date_default_timezone_set('America/Buenos_Aires');

$con = conectar();

$id_proyecto = $_GET['IdProyecto'];

$tabla_sol = mysqli_query(
    $con,
    "SELECT sol.id_solicitante 
  FROM solicitantes sol 
  INNER JOIN rel_proyectos_solicitantes rel on rel.id_solicitante = sol.id_solicitante 
  WHERE sol.id_responsabilidad = 1 AND rel.id_proyecto = $id_proyecto"
);
$registro_sol = mysqli_fetch_array($tabla_sol);

$id_solicitante = $registro_sol['id_solicitante'];

// ACCEDER AL SOLICITANTE
$tabla = mysqli_query(
    $con,
    "SELECT sol.*, loc.nombre as ciudad, dep.id as id_departamento, dep.nombre as departamento 
  FROM solicitantes sol, localidades loc, departamentos dep 
  WHERE loc.id = sol.id_ciudad AND loc.departamento_id = dep.id AND sol.id_solicitante = $id_solicitante"
);
$registro = mysqli_fetch_array($tabla);

if (isset($registro)) {
    $id_solicitante  = $registro['id_solicitante'];
    $dni             = $registro['dni'];
    $apellido        = $registro['apellido'];
    $nombres         = $registro['nombres'];
    $direccion       = $registro['direccion'];
    $email           = $registro['email'];
    $cod_area        = $registro['cod_area'];
    $telefono        = $registro['telefono'];
    $celular         = $registro['celular'];
    $ciudad          = $registro['ciudad'];
    $id_ciudad       = $registro['id_ciudad'];
    $fecha_nac       = $registro['fecha_nac'];
    $id_departamento = $registro['id_departamento'];
    $departamento    = $registro['departamento'];
} else {

    //DATOS DEL SOLICITANTE
    $dni             = '';
    $apellido        = '';
    $nombres         = '';
    $direccion       = '';
    $nro             = '';
    $email           = '';
    $cod_area        = '';
    $telefono        = '';
    $celular         = '';
    $ciudad          = '';
    $id_ciudad       = 0;
    $fecha_nac       = '';
    $id_departamento = 0;
    $departamento    = '';
}

$tabla_proyectos    = mysqli_query($con, "SELECT * FROM proyectos WHERE id_proyecto = $id_proyecto") or die('Error lectura de proyectos');
$registro_proyectos = mysqli_fetch_array($tabla_proyectos);

if (isset($registro_proyectos)) {

    // ACCEDER AL PROYECTO
    $denominacion      = $registro_proyectos['denominacion'];
    $resumen_ejecutivo = $registro_proyectos['resumen_ejecutivo'];
    $monto             = $registro_proyectos['monto'];
    $descripcion       = $registro_proyectos['descripcion'];
    $objetivos         = $registro_proyectos['objetivos'];
    $oportunidades     = $registro_proyectos['oportunidades'];
    $desarrollo        = $registro_proyectos['desarrollo'];
    $historia          = $registro_proyectos['historia'];
    $presente          = $registro_proyectos['presente'];
    $lugardesarrollo   = ($registro_proyectos['lugardesarrollo'] == 0) ? 'Alquilado' : 'Propio';

    $detallelugar           = $registro_proyectos['detallelugar'];
    $caratecnicas           = $registro_proyectos['caratecnicas'];
    $caratecnologicas       = $registro_proyectos['caratecnologicas'];
    $caraprocesos           = $registro_proyectos['caraprocesos'];
    $caramateriasprimas     = $registro_proyectos['caramateriasprimas'];
    $caradesechos           = $registro_proyectos['caradesechos'];
    $mercado                = $registro_proyectos['mercado'];
    $caraclientes           = $registro_proyectos['caraclientes'];
    $caracompetencia        = $registro_proyectos['caracompetencia'];
    $caraproveedores        = $registro_proyectos['caraproveedores'];
    $carariesgosestrategias = $registro_proyectos['carariesgosestrategias'];
    $destinomonto           = $registro_proyectos['destinomonto'];
    $personal               = $registro_proyectos['personal'];
    $interaccion            = $registro_proyectos['interaccion'];
    $impacto                = $registro_proyectos['impacto'];
    $preciosproductos       = $registro_proyectos['preciosproductos'];
    $origenfinanciacion     = $registro_proyectos['origenfinanciacion'];
    $fodafortalezas         = $registro_proyectos['fodafortalezas'];
    $fodaoportunidades      = $registro_proyectos['fodaoportunidades'];
    $fodadebilidades        = $registro_proyectos['fodadebilidades'];
    $fodaamenazas           = $registro_proyectos['fodaamenazas'];
    $latitud                = $registro_proyectos['latitud'];
    $longitud               = $registro_proyectos['longitud'];
    $fnovedad               = $registro_proyectos['fnovedad'];
    $fnovedad               = date('d/m/Y', strtotime($fnovedad));
//
} else {

    // INICIALIZO VARIABLES DEL PROYECTO
    $denominacion           = '';
    $resumen_ejecutivo      = '';
    $monto                  = 0;
    $descripcion            = '';
    $objetivos              = '';
    $oportunidades          = '';
    $desarrollo             = '';
    $historia               = '';
    $presente               = '';
    $lugardesarrollo        = 0;
    $detallelugar           = '';
    $caratecnicas           = '';
    $caratecnologicas       = '';
    $caraprocesos           = '';
    $caramateriasprimas     = '';
    $caradesechos           = '';
    $mercado                = '';
    $caraclientes           = '';
    $caracompetencia        = '';
    $caraproveedores        = '';
    $carariesgosestrategias = '';
    $destinomonto           = '';
    $personal               = '';
    $interaccion            = '';
    $impacto                = '';
    $preciosproductos       = '';
    $origenfinanciacion     = '';
    $fodafortalezas         = '';
    $fodaoportunidades      = '';
    $fodadebilidades        = '';
    $fodaamenazas           = '';
    $latitud                = 0;
    $longitud               = 0;
    $fnovedad               = date('d/m/Y', time());
}

$tabla_solicitantes    = mysqli_query($con, "SELECT * FROM registro_solicitantes WHERE id_solicitante = $id_solicitante");
$registro_solicitantes = mysqli_fetch_array($tabla_solicitantes);

// RUBROS PRODUCTIVOS
$id_rubro        = $registro_solicitantes['id_rubro'];
$tabla_rubros    = mysqli_query($con, "SELECT rubro FROM tipo_rubro_productivos WHERE id_rubro = $id_rubro");
$registro_rubros = mysqli_fetch_array($tabla_rubros);
$rubro           = $registro_rubros['rubro'];
// MEDIO DE COMUNICACION QUE SE INFORMO
$id_medio        = $registro_solicitantes['id_medio'];
$tabla_medios    = mysqli_query($con, "SELECT medio FROM tipo_medios_contacto WHERE id_medio = $id_medio");
$registro_medios = mysqli_fetch_array($tabla_medios);
$medio           = $registro_medios['medio'];

// ACCEDO A LOS DATOS DE LA EMPRESA (SI CORRESPONDE)
$id_empresa = $registro_solicitantes['id_empresa'];

if ($id_empresa > 0) {
    $tabla = mysqli_query($con, "SELECT *
    FROM maestro_empresas t1
    INNER JOIN tipo_forma_juridica t2 ON t1.id_tipo_sociedad = t2.id_forma
    WHERE id = $id_empresa");
    $fila = mysqli_fetch_array($tabla);

    $razon_social = $fila['razon_social'];
    $id_tipo_soc  = $fila['id_tipo_sociedad'];
    $sociedad     = $fila['forma'];
    $cuit         = $fila['cuit'];
    $fecha_insc   = $fila['fecha_inscripcion'];
    $fecha_inicio = $fila['fecha_inicio'];
    $fecha_insc   = date('d/m/Y', strtotime($fecha_insc));
    $fecha_inicio = date('d/m/Y', strtotime($fecha_inicio));
} else {
    $razon_social = '';
    $id_tipo_soc  = 0;
    $sociedad     = '';
    $cuit         = 0;
    $fecha_insc   = '';
    $fecha_inicio = '';
}

//////////////////////////////////////////////////////////////////////////////

$html = '

<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8">
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td width="70%">PRESENTACION FORMAL DE PROYECTOS</td>
  <td width="30%">FORMULARIO 001</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>FECHA <b>' . $fnovedad . '</b></td>
  <td>GEORREFERENCIA </td>
</tr>
<tr>
  <td>CODIGO SIST. NRO <b>' . $id_proyecto . '</b></td>
  <td>Lat <b>' . $latitud . '</b> Lon <b>' . $longitud . '</b></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr style="background-color:#CCC">
  <td colspan="2">RUBRO PRODUCTIVO</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><b>' . $rubro . '</b></td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</table>
  
<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8">
<tr style="background-color:#CCC">
  <td colspan="2">DENOMINACION DE LA IDEA - PROYECTO</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td colspan="4">&nbsp;</td>
</tr>
<tr>
  <td colspan="4"><p align="justify"><b>' . strtoupper($denominacion) . '</b></p></td>
</tr>
<tr>
  <td colspan="4">&nbsp;</td>
</tr>
<tr style="background-color:#CCC">
  <td colspan="4">RESUMEN EJECUTIVO</td>
</tr>
<tr>
  <td colspan="4">&nbsp;</td>
</tr>
<tr>
  <td colspan="4"><p align="justify"><b>' . $resumen_ejecutivo . '</b></p></td>
</tr>
<tr>
  <td colspan="4">&nbsp;</td>
</tr>
<tr style="background-color:#CCC">
  <td colspan="4">MONTO SOLICITADO A LA DIRECCION DE JOVENES EMPRENDEDORES</td>
</tr>
<tr>
  <td colspan="4">&nbsp;</td>
</tr>
<tr>
  <td colspan="4"><h3>$ <b>' . $monto . '</b></h3></td>
</tr>
<tr>
  <td width="25%">&nbsp;</td>
  <td width="25%">&nbsp;</td>
  <td width="25%">&nbsp;</td>
  <td width="25%">&nbsp;</td>
</tr>
<tr style="background-color:#CCC">
  <td colspan="4">RESPONSABLE DEL PROYECTO</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td colspan="2">Responsable <b>' . $apellido . ', ' . $nombres . '</b></td>
  <td>DNI <b>' . $dni . '</b></td>
  <td>Fecha Nac. <b>' . date('d/m/Y', strtotime($fecha_nac)) . '</b></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td colspan="2">Domicilio <b>' . strtoupper($direccion) . '</b></td>
  <td colspan="2">Ciudad <b>' . $ciudad . '</b> - Entre Ríos</td>
</tr>
<tr>
  <td colspan="4">Cod área (' . $cod_area . ') Tel fijo <b>' . $telefono . '</b> Móvil ' . $celular . '</td>
</tr>
<tr>
  <td colspan="4">E-mail <b>' . $email . '</b></td>
</tr>
<tr>
  <td colspan="4">&nbsp;</td>
</tr>
 <tr>
  <td colspan="4">&nbsp;</td>
</tr>
<tr>
  <td colspan="4">Otros Responsables del Proyecto (en caso que corresponda)</td>
</tr>
<tr>
  <td colspan="4"><hr></td>
</tr>';

$contador       = 1;
$registro_otros = mysqli_query($con, "SELECT sol.*, loc.nombre as ciudad FROM solicitantes sol, 
localidades loc, rel_proyectos_solicitantes rel 
WHERE loc.id = sol.id_ciudad AND rel.id_solicitante = sol.id_solicitante AND id_responsabilidad = 0 AND rel.id_proyecto = $id_proyecto");

while ($fila_otros = mysqli_fetch_array($registro_otros)) {
    $html .= ' 
      <tr>
        <td colspan="4">' . $contador . ' - </td>
      </tr>
      <tr>
        <td colspan="2">Apellido <b>' . $fila_otros['apellido'] . ', ' . $fila_otros['nombres'] . '</b></td>
        <td>DNI <b>' . $fila_otros['dni'] . '</b></td>
        <td>Fecha Nac. <b>' . date('d/m/Y', strtotime($fila_otros['fecha_nac'])) . '</b></td>
      </tr>
      <tr>
        <td>Domicilio <b>' . $fila_otros['direccion'] . '</b></td>
        <td></td>
        <td colspan="2">Ciudad <b>' . $fila_otros['ciudad'] . '</b> - Entre Ríos</td>
      </tr>
      <tr>
        <td colspan="4">Cod área (' . $fila_otros['cod_area'] . ') Tel fijo <b>' . $fila_otros['telefono'] . '</b> Móvil ' . $fila_otros['celular'] . '</td>
      </tr>
      <tr>
        <td colspan="4">E-mail <b>' . $fila_otros['email'] . '</b></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>';

    $contador++;
}

$html .= '
  <tr>
    <td colspan="4">De la Empresa (sólo si corresponde)</td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  <tr>
    <td>Nombre de la Empresa</td>
    <td colspan="3"><b>' . $razon_social . '</b></td>
  </tr>
  <tr>
    <td>Tipo sociedad</td>
    <td><b>' . $sociedad . '</b></td>
    <td>Cuit</td>
    <td><b>' . $cuit . '</b></td>
  </tr>
  <tr>
    <td>Fecha Inscripción Registro Público</td>
    <td><b>' . $fecha_insc . '</b></td>
    <td>Fecha Inicio Actividades</td>
    <td><b>' . $fecha_inicio . '</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr style="background-color:#CCC">
    <td colspan="4">REPRESENTACION DE LA IDEA - PROYECTO</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>- Descripción</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $descripcion . '</b></p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>- Objetivos</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $objetivos . '</b></p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>- Oportunidades que significa</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $oportunidades . '</b></p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>- Desarrollo actual</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $desarrollo . '</b></p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr style="background-color:#CCC">
    <td colspan="4">REPRESENTACION DEL GRUPO DE EMPRENDEDORES</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>Historia</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $historia . '</b></p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Presente</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $presente . '</b></p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr style="background-color:#CCC">
    <td colspan="4">ASPECTOS DE LOS PRODUCTOS / SERVICIOS Y DE LA PRODUCCION DE LOS MISMOS.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Lugar donde desarrolla actividad </td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $lugardesarrollo . '</p></b></td>
  </tr>
  <tr>
    <td colspan="4">Lugar donde desarrolla actividad</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $detallelugar . '</p></b></td>
  </tr>
  <tr>
    <td colspan="4">* Características técnicas de los productos / servicios </td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $caratecnicas . '</p></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">* Características tecnológicas de los productos / servicios </td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $caratecnologicas . '</p></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">* Descripción de los procesos productivos</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $caraprocesos . '</p></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">* Descripción de las materias primas</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $caramateriasprimas . '</p></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">* Descripción de los subproductos, desechos y/o residuos que se generarán durante los procesos productivos.</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $caradesechos . '</p></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr style="background-color:#CCC">
    <td colspan="4">ASPECTOS DEL MERCADO</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">- Determinación del Mercado</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $mercado . '</p></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">- Descripción de los Clientes</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $caraclientes . '</p></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">- Descripción de la Competencia</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $caracompetencia . '</p></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">- Descripción de los Proveedores</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $caraproveedores . '</p></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">- Riesgos y estrategias de superación de los mismos</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $carariesgosestrategias . '</p></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr style="background-color:#CCC">
    <td colspan="4">GENERALES</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Destino del monto solicitado. (adjuntar presupuesto / s)</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $destinomonto . '</p></b></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr style="background-color:#CCC">
    <td colspan="4">RESUMEN PRESUPUESTARIO</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>Descripción</td>
    <td align="center">Cantidades</td>
    <td align="center">Costo Unit.</td>
    <td align="right">Subtotal</td>
  </tr>
   <tr>
    <td colspan="4">&nbsp;</td>
  </tr>';

$total              = 0;
$contador           = 1;
$registro_productos = mysqli_query($con, "SELECT id_producto, descripcion, cantidades, costounitario
  FROM jovenes_resumen_presupuestario
  WHERE id_proyecto = $id_proyecto");
while ($fila_productos = mysqli_fetch_array($registro_productos)) {
    $subtotal = $fila_productos['cantidades'] * $fila_productos['costounitario'];

    $html .= '
      <tr>
        <td>' . $contador . ' - ' . $fila_productos['descripcion'] . '</td>
        <td align="center">' . $fila_productos['cantidades'] . '</td>
        <td align="center">' . $fila_productos['costounitario'] . '</td>
        <td align="right">' . number_format($subtotal, 2) . '</td>
      </tr>
	';

    $total = $subtotal + $total;

    $contador++;
}
$html .= '
   <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right">TOTAL $ ' . number_format($total, 2) . '</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
  <tr>
    <td colspan="4">Personal</td>
  </tr>
  <tr>
    <td colspan="4"><b>' . $personal . '</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Interacción prevista con el Sector Científico - Tecnológico regional y nacional</td>
  </tr>
  <tr>
    <td colspan="4"><b>' . $interaccion . '</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Impacto económico y social</td>
  </tr>
  <tr>
    <td colspan="4"><b>' . $impacto . '</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr style="background-color:#CCC">
    <td colspan="4">ASPECTOS ECONOMICOS - FINANCIEROS </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>COSTOS FIJOS</b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Detalle Año 1</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>';

$subtotal_ano1      = 0;
$total              = 0;
$contador           = 1;
$registro_conceptos = mysqli_query(
    $con,
    "SELECT id_concepto, concepto, monto, ano 
    FROM jovenes_costos_fijos 
    WHERE id_proyecto = $id_proyecto AND ano = 1"
);

while ($fila_conceptos = mysqli_fetch_array($registro_conceptos)) {
    $subtotal_ano1 = $fila_conceptos['monto'] + $subtotal_ano1;

    $html .= '
  <tr>
    <td>' . $contador . ' - ' . $fila_conceptos['concepto'] . '</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">' . $fila_conceptos['monto'] . '</td>
  </tr>';

    $contador++;
}
$html .= '
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">TOTAL $ <b>' . number_format($subtotal_ano1, 2) . '</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Detalle Año 2</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>';

$subtotal_ano2      = 0;
$total              = 0;
$contador           = 1;
$registro_conceptos = mysqli_query(
    $con,
    "SELECT id_concepto, concepto, monto, ano 
    FROM jovenes_costos_fijos 
    WHERE id_proyecto = $id_proyecto AND ano = 2"
);
while ($fila_conceptos = mysqli_fetch_array($registro_conceptos)) {
    $subtotal_ano2 = $fila_conceptos['monto'] + $subtotal_ano2;

    $html .= '
  <tr>
    <td>' . $contador . ' - ' . $fila_conceptos['concepto'] . '</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">' . $fila_conceptos['monto'] . '</td>
  </tr>';

    $contador++;
}

$html .= '
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">TOTAL $ <b>' . number_format($subtotal_ano2, 2) . '</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>COSTOS VARIABLES</b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>Detalle Año 1</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>';

$subtotal_ano1      = 0;
$total              = 0;
$contador           = 1;
$registro_conceptos = mysqli_query(
    $con,
    "SELECT concepto, monto, ano 
    FROM jovenes_costos_variables
    WHERE id_proyecto = $id_proyecto AND ano = 1"
);
while ($fila_conceptos = mysqli_fetch_array($registro_conceptos)) {
    $subtotal_ano1 = $fila_conceptos['monto'] + $subtotal_ano1;

    $html .= '
  <tr>
    <td>' . $contador . ' - ' . $fila_conceptos['concepto'] . '</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">' . $fila_conceptos['monto'] . '</td>
  </tr> ';

    $contador++;
}

$html .= '
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">TOTAL $ <b>' . number_format($subtotal_ano1, 2) . '</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Detalle Año 2</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>';

$subtotal_ano2      = 0;
$total              = 0;
$contador           = 1;
$registro_conceptos = mysqli_query(
    $con,
    "SELECT concepto, monto, ano 
    FROM jovenes_costos_variables
    WHERE id_proyecto = $id_proyecto AND ano = 2"
);
while ($fila_conceptos = mysqli_fetch_array($registro_conceptos)) {
    $subtotal_ano2 = $fila_conceptos['monto'] + $subtotal_ano2;

    $html .= '
  <tr>
    <td>' . $contador . ' - ' . $fila_conceptos['concepto'] . '</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">' . $fila_conceptos['monto'] . '</td>
  </tr>';

    $contador++;
}
$html .= '
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">TOTAL $ <b>' . number_format($subtotal_ano2, 2) . '</b></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">ORIGEN / MONTOS FUENTE DE FINANC. PREVISTAS</td>
    <td align="center">Año 1</td>
    <td align="right">Año 2</td>
  </tr>
  <tr>
    <td colspan = "4">&nbsp;</td>
  </tr>';

$subtotal_ano1    = 0;
$subtotal_ano2    = 0;
$total            = 0;
$contador         = 1;
$registro_fuentes = mysqli_query($con, "SELECT * FROM jovenes_fuente_financiacion fuen, tipo_origen_financiacion tipo 
	WHERE fuen.id_tipo_origen = tipo.id_tipo AND id_proyecto = $id_proyecto order by ano, id_tipo");
while ($fila_fuentes = mysqli_fetch_array($registro_fuentes)) {
    if ($fila_fuentes['ano'] == 1) {
        $subtotal_ano1 = $fila_fuentes['monto'] + $subtotal_ano1;
    } else {
        $subtotal_ano2 = $fila_fuentes['monto'] + $subtotal_ano2;
    }
    $html .= '
  <tr>
    <td colspan="2">' . $fila_fuentes['origen'] . '</td>
    <td align="center">';
    if ($fila_fuentes['ano'] == 1) {
        $html .= $fila_fuentes['monto'];
    } else {
        $html .= '';
    }
    $html .= ' </td>
    <td align="right">';
    if ($fila_fuentes['ano'] == 2) {
        $html .= $fila_fuentes['monto'];
    } else {
        $html .= '';
    }
    $html .= ' </td>
  </tr>
  ';

    $contador++;
}
$html .= '
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  <tr>
    <td>Total $</td>
    <td>&nbsp;</td>
    <td align="center">' . number_format($subtotal_ano1, 2) . '</td>
    <td align="right">' . number_format($subtotal_ano2, 2) . '</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Precio de los productos / servicios por ventas</td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><b>' . $preciosproductos . '</b></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Proyección de ingresos por ventas - Año 1</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">Cantidad</td>
    <td align="center">Precio Unitario</td>
    <td align="right">Subtotal</td>
  </tr>';

$subtotal1         = 0;
$contador          = 1;
$registro_ingresos = mysqli_query($con, "SELECT * FROM jovenes_ingresos_ventas WHERE  id_proyecto = $id_proyecto AND ano = 1");
while ($fila_ingresos = mysqli_fetch_array($registro_ingresos)) {
    $html .= '
	  <tr>
		<td>' . $contador . ' - ' . $fila_ingresos['concepto'] . '</td>
		<td align="center">' . $fila_ingresos['cantidad'] . '</td>
		<td align="center">' . $fila_ingresos['monto'] . '</td>
		<td align="right">' . $fila_ingresos['monto'] * $fila_ingresos['cantidad'] . '</td>
	  </tr> ';

    $subtotal1 = ($fila_ingresos['monto'] * $fila_ingresos['cantidad']) + $subtotal1;
    $contador++;
}

$html .= '
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">Total <b>' . $subtotal1 . '</b></td>
  </tr>
  <tr>
    <td colspan="4">Proyección de ingresos por ventas - Año 2</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">Cantidad</td>
    <td align="center">Precio Unitario </td>
    <td align="right">Subtotal</td>
  </tr>';

$subtotal2         = 0;
$contador          = 1;
$registro_ingresos = mysqli_query($con, "SELECT * FROM jovenes_ingresos_ventas WHERE id_proyecto = $id_proyecto AND ano = 2");
while ($fila_ingresos = mysqli_fetch_array($registro_ingresos)) {
    $html .= '
	  <tr>
		<td>' . $contador . ' - ' . $fila_ingresos['concepto'] . '</td>
		<td align="center">' . $fila_ingresos['cantidad'] . '</td>
		<td align="center">' . $fila_ingresos['monto'] . '</td>
		<td align="right">' . $fila_ingresos['monto'] * $fila_ingresos['cantidad'] . '</td>
	  </tr>';

    $subtotal2 = ($fila_ingresos['monto'] * $fila_ingresos['cantidad']) + $subtotal2;
    $contador++;
}

$html .= '
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">Total <b>' . $subtotal2 . '</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr style="background-color:#CCC">
    <td>PLANILLA DE RESULTADOS</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>INGRESOS</td>
    <td>&nbsp;</td>
    <td align="right">AÑO 1</td>
    <td align="right">AÑO 2</td>
  </tr> ';

$subtotal_ano1_ing  = 0;
$subtotal_ano2_ing  = 0;
$registro_conceptos = mysqli_query($con, "SELECT ano, sum(cantidad*monto) as suma FROM jovenes_ingresos_ventas WHERE id_proyecto = $id_proyecto GROUP BY ano ");
while ($fila_conceptos = mysqli_fetch_array($registro_conceptos)) {
    if ($fila_conceptos['ano'] == 1) {
        $subtotal_ano1_ing = $fila_conceptos['suma'];
    } else {
        $subtotal_ano2_ing = $fila_conceptos['suma'];
    }
}
$html .= '
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  <tr>
    <td>Ingresos x Ventas </td>
    <td>&nbsp;</td>
    <td align="right">' . number_format($subtotal_ano1_ing, 2) . '</td>
    <td align="right">' . number_format($subtotal_ano2_ing, 2) . '</td>
  </tr>';

$subtotal_ano1_ff = 0;
$subtotal_ano2_ff = 0;

$registro_conceptos = mysqli_query(
    $con,
    "SELECT ano, sum(monto) as suma 
  FROM jovenes_fuente_financiacion 
  WHERE id_proyecto = $id_proyecto 
  GROUP BY ano"
);

while ($fila_conceptos = mysqli_fetch_array($registro_conceptos)) {
    if ($fila_conceptos['ano'] == 1) {
        $subtotal_ano1_ff = $fila_conceptos['suma'];
    } else {
        $subtotal_ano2_ff = $fila_conceptos['suma'];
    }
}
$html .= '
  <tr>
    <td>Ingresos x Otras Fuentes (Inc.Préstamos)</td>
    <td>&nbsp;</td>
    <td align="right">' . number_format($subtotal_ano1_ff, 2) . '</td>
    <td align="right">' . number_format($subtotal_ano2_ff, 2) . '</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>INGRESOS TOTALES</b></td>
    <td>&nbsp;</td>
    <td align="right"><b>' . number_format($subtotal_ano1_ing + $subtotal_ano1_ff, 2) . '</b></td>
    <td align="right"><b>' . number_format($subtotal_ano2_ing + $subtotal_ano2_ff, 2) . '</b></td>
  </tr>';

$tot_ingresos_1 = $subtotal_ano1_ing + $subtotal_ano1_ff;
$tot_ingresos_2 = $subtotal_ano2_ing + $subtotal_ano2_ff;

$html .= '
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>EGRESOS</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>';

$subtotal_ano1_fijos = 0;
$subtotal_ano2_fijos = 0;

$registro_conceptos = mysqli_query(
    $con,
    "SELECT ano, sum(monto) as suma 
  FROM jovenes_costos_fijos
  WHERE id_proyecto = $id_proyecto 
  GROUP BY ano"
);

while ($fila_conceptos = mysqli_fetch_array($registro_conceptos)) {
    if ($fila_conceptos['ano'] == 1) {
        $subtotal_ano1_fijos = $fila_conceptos['suma'];
    } else {
        $subtotal_ano2_fijos = $fila_conceptos['suma'];
    }
}
$html .= '
  <tr>
    <td>Costos Fijos</td>
    <td>&nbsp;</td>
    <td align="right">' . number_format($subtotal_ano1_fijos, 2) . '</td>
    <td align="right">' . number_format($subtotal_ano2_fijos, 2) . '</td>
  </tr>';

$subtotal_ano1_variables = 0;
$subtotal_ano2_variables = 0;

$registro_conceptos = mysqli_query(
    $con,
    "SELECT ano, sum(monto) as suma 
    FROM jovenes_costos_variables 
    WHERE id_proyecto = $id_proyecto GROUP BY ano "
);

while ($fila_conceptos = mysqli_fetch_array($registro_conceptos)) {
    if ($fila_conceptos['ano'] == 1) {
        $subtotal_ano1_variables = $fila_conceptos['suma'];
    } else {
        $subtotal_ano2_variables = $fila_conceptos['suma'];
    }
}

$tot_egresos_1 = $subtotal_ano1_variables + $subtotal_ano1_fijos;
$tot_egresos_2 = $subtotal_ano2_variables + $subtotal_ano2_fijos;

$resultados_1 = $tot_ingresos_1 - $tot_egresos_1;
$resultados_2 = $tot_ingresos_2 - $tot_egresos_2;

$html .= '
  <tr>
    <td>Costos Variables</td>
    <td>&nbsp;</td>
    <td align="right">' . number_format($subtotal_ano1_variables, 2) . '</td>
    <td align="right">' . number_format($subtotal_ano2_variables, 2) . '</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>EGRESOS TOTALES</b></td>
    <td>&nbsp;</td>
    <td align="right">' . number_format($tot_egresos_1, 2) . '</td>
    <td align="right">' . number_format($tot_egresos_2, 2) . '</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>RESULTADOS TOTALES</b></td>
    <td>&nbsp;</td>
    <td align="right">' . number_format($resultados_1, 2) . '</td>
    <td align="right">' . number_format($resultados_2, 2) . '</td>
  </tr>  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr style="background-color:#CCC">
    <td colspan = "4">ANALISIS F.O.D.A. DEL PROYECTO </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>FORTALEZAS</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $fodafortalezas . '</b></p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>OPORTUNIDADES</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $fodaoportunidades . '</b></p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>DEBILIDADES</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $fodadebilidades . '</b></p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>AMENAZAS</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><p align="justify"><b>' . $fodaamenazas . '</b></p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  <tr>
    <td>INFORMACION A ADJUNTAR </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">
	<p align="justify">
	La representación de este proyecto en el marco de la Dirección de Políticas de Apoyo Emprendedor implica cumplir con toda la legislación vigente 
	(Municipal, Provincial y/o Nacional) en materia de preservación del medio ambiente, seguridad industrial, impositiva, laboral, etc.
	</p>
	</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">
	<p align="justify">
	La información consignada en esta solicitud tiene carácter de Declaración Jurada y recibirá un tratamiento CONFIDENCIAL por parte de la Dirección 
	de Políticas de Apoyo Emprendedor. 
	</p>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Lugar</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Fecha <b>' . $fnovedad . '</b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center">Firma del Responsable del Proyecto</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center">Aclaración</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center">DNI Nro.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
</table>
';

mysqli_close($con);

require_once $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/public/libreria/TCPDF-main/examples/tcpdf_include.php';

class ConPies extends TCPDF
{
    public function Header()
    {
        // definimos variables con titulo y subtitulo

        $this->Image($_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/public/imagenes/escudo_er.jpg', 15, 4, 40, 11);

        $subtitulo = 'ANEXO I - Formulario Solicitud Jóvenes Emprendedores';
        $this->SetY(8);
        $this->SetFont('times', '', 6, '', true);
        $this->Cell(0, 0, $subtitulo, 0, 1, 'R');
    }

    public function Footer()
    {
        // insertamos numero de pagina y total de paginas
        $this->SetFont('helvetica', '', 6, '', true);
        $this->Cell(0, 10, 'Secretaria Desarrollo Económico y Emprendedor  Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->SetDrawColor(0, 0, 0);
        // dibujamos una linea roja delimitadora del pie de página
        $this->Line(10, 282, 195, 282);
    }
}

$pdf = new ConPies();
$top = 17;
$pdf->SetMargins(PDF_MARGIN_LEFT, $top, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_TOP);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Saltos de página automáticos.
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

$pdf->SetDisplayMode('fullpage');
$pdf->AddPage();
$pdf->writeHTML($html, true, false, true, false, '');

$nombre = 'Solicitud_JE.pdf';
$pdf->Output($nombre, 'I');
exit;
