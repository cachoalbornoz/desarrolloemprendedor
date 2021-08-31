<?php 
session_start();

if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

date_default_timezone_set('America/Argentina/Buenos_Aires');

require_once("../accesorios/accesos_bd.php");
$con=conectar();

$id_solicitante  = $_GET['id_solicitante']; 

// INICIALIZO DATOS DE LA EMPRESA
$id_empresa			= NULL;
$razon_social       = NULL;
$cuite              = NULL;
$id_tipo_sociedad   = NULL;
$fecha_inscripcion  = NULL;
$fecha_inicio       = NULL;
$domiciliol         = NULL;
$nrol               = NULL;
$id_ciudadl         = NULL;
$domicilior         = NULL;
$nror               = NULL;
$id_ciudadr         = NULL;
$representante      = NULL;
$codigoafip         = NULL;
$actividadafip      = NULL;
$otrosregistros     = NULL;
$nroexportador      = NULL; 


$html= '
<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8">
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td width="70%">FORMULARIO DE INSCRIPCION DIGITAL </td>
	<td width="30%">ANEXO II</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
</table>';

$query_solicitante		= mysqli_query($con,"SELECT sol.*, loc.nombre as ciudad
FROM solicitantes sol
INNER JOIN localidades loc on loc.id = sol.id_ciudad
WHERE sol.id_solicitante = $id_solicitante");
$registro_solicitante	= mysqli_fetch_array($query_solicitante, MYSQLI_BOTH);


$html.= '
<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8; padding-top:5px">
<tr>
	<td width="15%">&nbsp;</td>
	<td width="35%">&nbsp;</td>
	<td width="15%">&nbsp;</td>
	<td width="35%">&nbsp;</td>
</tr>
<tr>
	<td colspan="4" style="border-bottom: 1px solid gray;"><b>DATOS PERSONALES DEL SOLICITANTE</b></td>
</tr>
<tr>
	<td colspan="4">&nbsp;</td>
</tr>
<tr>
	<td colspan="4">&nbsp;</td>
</tr>
<tr>
	<td>Apellido y Nombres</td>
	<td><b>'.$registro_solicitante['apellido'].', '.$registro_solicitante['nombres'].'</b></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>  
</tr>
<tr>
	<td>Dni</td>
	<td><b>'.$registro_solicitante['dni'].'</b></td>
	<td>Fecha Nacimiento</td>
	<td><b>'.date('d/m/Y', strtotime($registro_solicitante['fecha_nac'])).'</b></td>	
</tr>
<tr>
	<td>Domicilio</td>
	<td><b>'.$registro_solicitante['direccion'].' '.$registro_solicitante['nro'].'</b></td>
	<td>Ciudad</td>
	<td><b>'.$registro_solicitante['ciudad'].'</b></td>  	
</tr>
<tr>
	<td>Telefono</td>
	<td><b>'.$registro_solicitante['telefono'].'</b></td>
	<td>Celular</td>
	<td><b>'.$registro_solicitante['celular'].'</b></td>  	
</tr>
<tr>
	<td>Email</td>
	<td><b>'.$registro_solicitante['email'].'</b></td>
	<td>Cuit</td>
	<td><b>'.$registro_solicitante['cuit'].'</b></td>  	
</tr>
<tr>
	<td colspan="4">&nbsp;</td>
</tr>
</table>';

$query_solicitud= mysqli_query($con,"SELECT * FROM proaccer_inscripcion WHERE id_solicitante = $id_solicitante");
$registro_soli	= mysqli_fetch_array($query_solicitud);

$id_empresa = $registro_soli['id_empresa'];

// LEER DATOS DE LA EMPRESA
$tabla_empresa = mysqli_query($con, "SELECT * FROM maestro_empresas WHERE id = $id_empresa");
if($registro_empresa = mysqli_fetch_array($tabla_empresa)){

    $id_empresa         = $registro_empresa['id'];
    $razon_social       = $registro_empresa['razon_social'];
    $cuite              = $registro_empresa['cuit'];
    $id_tipo_sociedad   = $registro_empresa['id_tipo_sociedad'];
    
    if(!$id_tipo_sociedad){
        $id_tipo_sociedad   = 0;
    }    
    
    $tabla_sociedades   = mysqli_query($con, "SELECT forma FROM tipo_forma_juridica WHERE id_forma = $id_tipo_sociedad");
    $registro_sociedad  = mysqli_fetch_array($tabla_sociedades);
    $sociedad           = $registro_sociedad[0];        

    if(strtotime($registro_empresa['fecha_inscripcion']) > 0){
        $fecha_inscripcion = date('d/m/Y', strtotime($registro_empresa['fecha_inscripcion']));
    }else{
        $fecha_inscripcion = NULL;
    }

    if(strtotime($registro_empresa['fecha_inicio']) > 0){
        $fecha_inicio	= date('d/m/Y', strtotime($registro_empresa['fecha_inicio']));
		$anio_inicio	= date('Y', strtotime($fecha_inicio));
		$anio_actual	= date('Y', time());
		$anio_empresa	= $anio_actual - $anio_inicio;
		
		
		$date1	= new DateTime($registro_empresa['fecha_inicio']);
		$date2	= new DateTime("now");
		$diff	= $date1->diff($date2); 
		
    }else{
        $fecha_inicio	= NULL;
		$anio_inicio	= NULL;
    }
	
	

    $domiciliol         = $registro_empresa['domicilio'];
    $nrol               = $registro_empresa['nro'];
    $id_ciudadl         = $registro_empresa['id_localidad'];
    if(!$id_ciudadl){
        $id_ciudadl = 0;
    }
    $tabla_localidades   = mysqli_query($con, "SELECT loc.nombre, dep.id as id_departamento, dep.nombre as departamento
    FROM localidades loc INNER JOIN departamentos dep on loc.departamento_id = dep.id WHERE loc.id = $id_ciudadl");
    $registro_localidades= mysqli_fetch_array($tabla_localidades);

    $ciudadl = $registro_localidades['nombre'];
    $id_departamentol = $registro_localidades['id_departamento'];
    $departamentol = $registro_localidades['departamento'];


    $domicilior         = $registro_empresa['domicilio_actividad'];
    $nror               = $registro_empresa['nro_actividad'];
    $id_ciudadr         = $registro_empresa['id_localidad_actividad'];

    if(!$id_ciudadr){
        $id_ciudadr = 0;
    }
    
    $tabla_localidades   = mysqli_query($con, "SELECT loc.nombre, dep.id as id_departamento, dep.nombre as departamento
    FROM localidades loc INNER JOIN departamentos dep on loc.departamento_id = dep.id WHERE loc.id = $id_ciudadr");
    $registro_localidades= mysqli_fetch_array($tabla_localidades);

    $ciudadr = $registro_localidades['nombre'];
    $id_departamentor = $registro_localidades['id_departamento'];
    $departamentor = $registro_localidades['departamento'];

    $representante      = $registro_empresa['representante'];
    $codigoafip         = $registro_empresa['codigoafip'];
    $actividadafip      = $registro_empresa['actividadafip'];
    $otrosregistros     = $registro_empresa['otrosregistros'];
    $nroexportador      = $registro_empresa['nroexportador'];          

}else{
	$id_empresa         = NULL;
    $razon_social       = NULL;
    $cuite              = NULL;
    $id_tipo_sociedad   = NULL;
	$sociedad           = NULL;
	$ciudadl			= NULL;
	$date1				= new DateTime("now");
	$date2				= new DateTime("now");
	$diff				= $date1->diff($date2); 
	
}


$html.= '
<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8; padding-top:5px">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td style="border-bottom: 1px solid gray;"><b>DATOS DEL EMPRENDIMIENTO</b></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>Razón social o nombre de la Empresa</td>
</tr>
<tr>
	<td><b>'.$razon_social.'</b></td>
</tr>
<tr>
	<td>CUIT del Emprendimiento</td>
</tr>
<tr>
	<td><b>'.$cuite.'</b></td>
</tr>
<tr>
	<td>Figura Legal</td>
</tr>
<tr>
	<td><b>'.$sociedad.'</b></td>
</tr>
<tr>
	<td>Domicilio legal</td>
</tr>
<tr>
	<td><b>'.$domiciliol.' '.$nrol.' - '.$ciudadl.'</b></td>
</tr>
<tr>
	<td>Representante legal</td>
</tr>
<tr>
	<td><b>'.$representante.'</b></td>
</tr>
<tr>
	<td>Fecha Inicio - Tiempo funcionando / Antigüedad</td>
</tr>
<tr>
	<td>'.$fecha_inicio.' - (<b>'.$diff->y.' años '.$diff->m.' mes </b>)</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
</table>
';

$id_rubro = $registro_soli['id_rubro'];

// LEER DATOS DEL RUBRO
$tabla_rubro 	= mysqli_query($con, "SELECT rubro FROM tipo_rubro_productivos WHERE id_rubro = $id_rubro");
$registro_rubro = mysqli_fetch_array($tabla_rubro);

$html.=
'<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8; padding-top:5px">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td style="border-bottom: 1px solid gray;"><b>PRODUCCION</b></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>Rubro productivo</td>
</tr>
<tr>
	<td><b>'.$registro_rubro['rubro'].'</b></td>
</tr>
</table>';


$html.=
'<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8; padding-top:5px; text-align: center">
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td colspan="2" style="text-align: left">Productos producidos y cantidades mensuales</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
</table>

<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8; padding-top:5px; text-align: center">
<tr>
	<td>#Nro</td>
	<td>Producto</td>
	<td>Cantidad mensual producida</td>
</tr>
<tr>
	<td>1)</td>
	<td><b>'.$registro_soli['prodserv1'].'</b></td>
	<td><b>'.$registro_soli['cantserv1'].'</b></td>	
</tr>
<tr>
	<td>2)</td>
	<td><b>'.$registro_soli['prodserv2'].'</b></td>
	<td><b>'.$registro_soli['cantserv2'].'</b></td>	
</tr>
<tr>
	<td>3)</td>
	<td><b>'.$registro_soli['prodserv3'].'</b></td>
	<td><b>'.$registro_soli['cantserv3'].'</b></td>	
</tr>
</table>

<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8; padding-top:5px; text-align: center">
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td colspan="2" style="text-align: left">Productos a exponer en ferias / eventos. Detalles que considere relevantes. </td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td colspan="2" style="text-align: left"><b>'.$registro_soli['detalleproducto'].'</b></td>
</tr>
</table>';

if($registro_soli['vendeafueraprovincia'] == 1){
	$vendeafueraprovincia = 'SI';
	$lugarfueraprovincia  = $registro_soli['lugarfueraprovincia'];
}else{
	$vendeafueraprovincia = 'NO';
	$lugarfueraprovincia  = '-';
}

if($registro_soli['comer_directo'] == 1){
	$comer_directo = 'SI';
}else{
	$comer_directo = 'NO';
}

if($registro_soli['comer_intermediario'] == 1){
	$comer_intermediario = 'SI';
}else{
	$comer_intermediario = 'NO';
}

if($registro_soli['comer_otra'] == 1){
	$comer_otra = 'SI';
}else{
	$comer_otra = 'NO';
}

if(strlen($registro_soli['otraformacomercializacion']) > 0){
	$otraformacomercializacion = $registro_soli['otraformacomercializacion'];
}else{
	$otraformacomercializacion = '';
}

$html.=
'<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8; padding-top:5px">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td style="border-bottom: 1px solid gray;"><b>COMERCIO INTERNO</b></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>Comercializa su producto / servicio a otra provincia ? A cuál ? </td>
</tr>
<tr>
	<td><b>'.$vendeafueraprovincia.' - '.$lugarfueraprovincia.'</b></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>Qué producto pudo comercializar ? Por qué medios ?</td>
</tr>
<tr>
	<td>'.$registro_soli['productovende'].') </td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td><b>'.$comer_directo.'</b> - Venta Directa</td>
</tr>
<tr>
	<td><b>'.$comer_intermediario.'</b> - Con Intermediarios</td>
</tr>
<tr>
	<td><b>'.$comer_otra.'</b> - Otra : '.$otraformacomercializacion.'</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
</table>';


if($registro_soli['esexportable'] == 1){
	$esexportable = 'SI';
}else{
	$esexportable = 'NO';
}

if($registro_soli['deseaexportar'] == 1){
	$deseaexportar = 'SI';
}else{
	$deseaexportar = 'NO';
}

if($registro_soli['productoexporta'] == 0){
	$registro_soli['productoexporta'] = 'Ninguno';
}


$html.=
'<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8; padding-top:5px">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td style="border-bottom: 1px solid gray;"><b>COMERCIO EXTERIOR</b></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>Tiene conocimiento / experiencia en Exportar ? Es un producto Exportable ?</td>
</tr>
<tr>
	<td><b>'.$esexportable.'</b></td>
</tr>
<tr>
	<td>Desea exportarlo ? </td>
</tr>
<tr>
	<td><b>'.$deseaexportar.'</b></td>
</tr>
<tr>
	<td>Pais que exporta su producto / servicio </td>
</tr>
<tr>
	<td><b>'.$registro_soli['paisexporta'].'</b></td>
</tr>
<tr>
	<td>Qué producto / servicio  exporta ? </td>
</tr>
<tr>
	<td><b>'.$registro_soli['productoexporta'].')</b></td>
</tr>
</table>';

mysqli_close($con);

require_once '../public/libreria/tcpdf/tcpdf.php';
require_once '../public/libreria/tcpdf/config/lang/spa.php';

class ConPies extends TCPDF {
    public function Header() {
        /* definimos variables con titulo y subtitulo */
		
		$this->Image($_SERVER['DOCUMENT_ROOT']."/desarrolloemprendedor/public/imagenes/escudo_er.jpg", 15, 4, 40, 11);
        $subtitulo="ANEXO II - Formulario Inscripcion Digital";
        $this->SetY(8);
        $this->SetFont('times', '', 6, '', true);
        $this->Cell(0, 0,$subtitulo,0,1,'R');
   
    }
	
     public function Footer() {
          /* insertamos numero de pagina y total de paginas*/
          $this->SetFont('helvetica', '', 6, '', true);
		  $this->Cell(0, 10, 'SubSecretaria Desarrollo Emprendedor -  Página '.$this->getAliasNumPage().' de '.$this-> getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
          $this->SetDrawColor(0,0,0);
          /* dibujamos una linea roja delimitadora del pie de página */
          $this->Line(10,282,195,282);
	    }
}

ob_end_clean();

$pdf = new ConPies();
$top=17;
$pdf->SetMargins(PDF_MARGIN_LEFT, $top, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_TOP);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
// Saltos de página automáticos.
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->SetDisplayMode('fullpage');
$pdf->AddPage();
$pdf->writeHTML($html, true, false, true, false, '');

$nombre= 'Inscripcion.pdf';
$pdf->Output($nombre,'I');
exit;


