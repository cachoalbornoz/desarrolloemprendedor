<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

ob_start();
error_reporting(1);

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');
date_default_timezone_set('America/Buenos_Aires');

$con=conectar();

$html= '
<style>

  .centrado {
    text-align: center;
  }

  .derecho{
    text-align: rigth;
  }

  .justificado{
    text-align: justify;
  }

  .tabla{
    font-family:Arial, Helvetica, sans-serif; 
    font-size:10
  }

  .tabla td{
    height: 20px;
  }

  .bordes{
    border: 1px solid black;
  }

  .bordes td {
    border: 1px solid black;
  }

  .titulo{
    font-size:12;
    font-weight:bold;
  }

  .subtitulo{
    font-size:11;
    font-weight:bold;
  }

</style>';


$id_solicitante = $_SESSION['id_usuario']; 

// LEER DATOS DEL SOLICITANTE
$tabla_datos  = mysqli_query($con, "SELECT *
FROM solicitantes sol 
WHERE id_solicitante = $id_solicitante");

$registro_datos     =  mysqli_fetch_array($tabla_datos);
$apellido_sol       = $registro_datos['apellido'];
$nombres_sol        = $registro_datos['nombres'];
$dni_sol            = $registro_datos['dni'];
$cuit_sol            = $registro_datos['cuit'];
$fechanac_sol       = $registro_datos['fecha_nac'];
$domicilio_sol      = $registro_datos['direccion'];
$nro_sol            = $registro_datos['nro'];
$id_ciudad          = $registro_datos['id_ciudad'];
$cod_area           = $registro_datos['cod_area'];
$telefono           = $registro_datos['telefono'];
$celular            = $registro_datos['celular'];
$email              = $registro_datos['email'];

$tabla_localidades   = mysqli_query($con, "select loc.nombre, dep.id as id_departamento, dep.nombre as departamento
from localidades loc inner join departamentos dep on loc.departamento_id = dep.id where loc.id = $id_ciudad");
$registro_localidades= mysqli_fetch_array($tabla_localidades, MYSQLI_BOTH);

$ciudad_sol         = $registro_localidades['nombre'];
$id_departamento    = $registro_localidades['id_departamento'];
$departamento       = $registro_localidades['departamento'];


$html .='
<table width="100%" class="tabla">
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td width="60%" class="titulo">FORMULARIO DE INSCRIPCION DIGITAL</td>
  <td width="40%" class="derecho">COD 001-05</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</table>

<table width="100%" class="tabla">
<tr>
  <td colspan="4" class="subtitulo">Datos personales y de contacto del titular del emprendimiento</td>
</tr>
<tr>
  <td colspan="4"><hr></td>
</tr>
<tr>
  <td>APELLIDO</td>
  <td><b>'.$apellido_sol.'</b></td>
  <td colspan="2">NOMBRES <b>'.$nombres_sol.'</b></td>
</tr>
<tr>
  <td>DNI</td>
  <td colspan="3"><b>'.$dni_sol.'</b></td>
</tr>
<tr>
  <td>CUIT </td>
  <td><b>'.$cuit_sol.'</b></td>
  <td>FECHA NAC. </td>
  <td><b>'.date('d/m/Y', strtotime($fechanac_sol)).'</b></td>
</tr>
<tr>
  <td>DOMICILIO </td>
  <td colspan="3"><b>'.$domicilio_sol.' '.$nro_sol.' - '.$ciudad_sol.'</b></td>
</tr>
<tr>
  <td>TELEF. </td>
  <td><b>('.$cod_area.') '.$telefono.'</b></td>
  <td>CELULAR </td>
  <td><b>'.$celular.' </b></td>
</tr>
<tr>
  <td>EMAIL</td>
  <td colspan="3"><b>'.$email.'</b></td>
</tr>
<tr>
  <td colspan="4"></td>
</tr>';


// ACCEDO A LOS DATOS DE LA EMPRESA (SI CORRESPONDE)
$tabla_empresa = mysqli_query($con, "SELECT * FROM rel_solicitante_empresas relac INNER JOIN maestro_empresas mae ON relac.id_empresa = mae.id INNER JOIN tipo_sociedad tipo ON mae.id_tipo_sociedad = tipo.id_tipo WHERE relac.id_solicitante = $id_solicitante");
$registro_empresa = mysqli_fetch_array($tabla_empresa);

if (isset($registro_empresa)) {

  $id_empresa         = $registro_empresa['id'];
  $razon_social       = $registro_empresa['razon_social'];
  $cuite              = $registro_empresa['cuit'];
  $id_tipo_sociedad   = $registro_empresa['id_tipo_sociedad'];
  
  if(!$id_tipo_sociedad){
    $id_tipo_sociedad   = 0;
  }    
  
  $tabla_sociedades   = mysqli_query($con, "select forma from tipo_forma_juridica where id_forma = $id_tipo_sociedad");
  $registro_sociedad  = mysqli_fetch_array($tabla_sociedades, MYSQLI_BOTH);
  $sociedad           = $registro_sociedad[0];        

  if(strtotime($registro_empresa['fecha_inscripcion']) > 0){
    $fecha_inscripcion = date('d/m/Y', strtotime($registro_empresa['fecha_inscripcion']));
  }else{
    $fecha_inscripcion = NULL;
  }

  if(strtotime($registro_empresa['fecha_inicio']) > 0){
    $fecha_inicio = date('d/m/Y', strtotime($registro_empresa['fecha_inicio']));
    $tiempo = strtotime($registro_empresa['fecha_inicio']); 
    $ahora = time(); 
    $anioe = ($ahora-$tiempo)/(60*60*24*365.25); 
    $anioe = floor($anioe);
  }else{
    $fecha_inicio = NULL;
    $anioe = NULL;
  }

  $domiciliol         = $registro_empresa['domicilio'];
  $nrol               = $registro_empresa['nro'];
  $id_ciudadl         = $registro_empresa['id_localidad'];
  if(!$id_ciudadl){
    $id_ciudadl = 0;
  }
  $tabla_localidades   = mysqli_query($con, "select loc.nombre, dep.id as id_departamento, dep.nombre as departamento
  from localidades loc inner join departamentos dep on loc.departamento_id = dep.id where loc.id = $id_ciudadl");
  $registro_localidades= mysqli_fetch_array($tabla_localidades, MYSQLI_BOTH);

  $ciudadl = $registro_localidades['nombre'];
  $id_departamentol = $registro_localidades['id_departamento'];
  $departamentol = $registro_localidades['departamento'];

  $representante      = $registro_empresa['representante'];
  $codigoafip         = $registro_empresa['codigoafip'];
  $actividadafip      = $registro_empresa['actividadafip'];
  $otrosregistros     = $registro_empresa['otrosregistros'];
  $nroexportador      = $registro_empresa['nroexportador'];
}

$html .='
<tr>
  <td colspan="4" class="subtitulo">Datos del emprendimiento</td>
</tr>
<tr>
  <td colspan="4"><hr></td>
</tr>
<tr>
  <td colspan="4">NOMBRE DE LA EMPRESA O RAZÓN SOCIAL</td>
</tr>
<tr>
  <td colspan="4"><b>'.$razon_social.'</b></td>
</tr>
<tr>
  <td>CUIT </td><td><b>'.$cuite.'</b></td><td>FIGURA LEGAL</td><td><b>'.$sociedad.'</b></td>
</tr>
<tr>
  <td>DOMCILIO LEGAL</td>
  <td colspan="3"><b>'.$domiciliol.' '.$nrol.' - '.$ciudadl.'</b></td>
</tr>
<tr>
  <td colspan="4"></td>
</tr>
<tr>
  <td colspan="4">NOMBRE DEL REPRESENTANTE LEGAL</td>
</tr>
<tr>
  <td colspan="4"><b>'.$representante.'</b></td>
</tr>
<tr>
  <td>INICIO DE ACTIVIDADES</td>
  <td><b>'.$fecha_inicio.'</b></td>
  <td colspan="2">AÑOS FUNCIONAMIENTO <b>'.$anioe.'</b></td>
</tr>
<tr>
  <td colspan="4"></td>
</tr>';


// ACCEDER AL "PROYECTO PROCEDER"

$tabla_proyecto = mysqli_query($con, "SELECT * FROM rel_proceder rela
INNER JOIN proceder_proyectos proce ON rela.id_proyecto = proce.id_proyecto
WHERE rela.id_solicitante = $id_solicitante");

if($registro_proyecto = mysqli_fetch_array($tabla_proyecto)){

  // DATOS DEL PROYECTO

  $id_proyecto= $registro_proyecto['id_proyecto'];
  $id_inversor= $registro_proyecto['id_inversor'];
  $id_empresa = $registro_proyecto['id_empresa'];

  $detalleser = $registro_proyecto['detalleservicio'];
  $historia   = $registro_proyecto['historia'];
  $detallepro = $registro_proyecto['detalleproducto'];
  $resenia    = $registro_proyecto['resenia'];
  $monto      = $registro_proyecto['monto'];
  $rubro      = $registro_proyecto['rubro'];
  $aspectos   = $registro_proyecto['aspectos'];

}

$html .='
<tr>
  <td colspan="4" class="subtitulo">Producción actual del emprendimiento</td>
</tr>
<tr>
  <td colspan="4"><hr></td>
</tr>
<tr>
  <td colspan="4">RUBRO DEL BIEN, SERVICIO O PROCESO</td>
</tr>
<tr>
  <td colspan="4" class="justificado"><b>'.$detalleser.'</b></td>
</tr>
<tr>
  <td colspan="4"></td>
</tr>
<tr>
  <td colspan="4">BREVE DESCRIPCIÓN DE LA HISTORIA DEL EMPRENDIMIENTO</td>
</tr>
<tr>
  <td colspan="4" class="justificado"><b>'.$historia.'</b></td>
</tr>
<tr>
  <td colspan="4"></td>
</tr>
<tr>
  <td colspan="4">TIPO DE PRODUCTOS ACTUALMENTE PRODUCIDOS, VOLUMEN Y MERCADO (local, regional, nacional, internacional)</td>
</tr>
<tr>
  <td colspan="4"></td>
</tr>
<tr>
  <td colspan="4" class="justificado"><b>'.$detallepro.'</b></td>
</tr>
<tr>
  <td colspan="4"></td>
</tr>';


// DETALLE DEL INVERSOR

$tabla_inversores = mysqli_query($con, "SELECT inver.* FROM proceder_inversores inver 
INNER JOIN rel_proceder relac ON relac.id_inversor = inver.id_inversor
WHERE relac.id_solicitante = $id_solicitante");

$fila   = mysqli_fetch_array($tabla_inversores, MYSQLI_BOTH); 

$apellidoii  = $fila['apellido'];
$nombresii   = $fila['nombres'];
$dniii       = $fila['dni'];
$cuitii      = $fila['cuit'];
$domicilioii = $fila['direccion'];
$nroii       = $fila['nro'];
$cpii        = $fila['cp'];
$id_ciudadii = $fila['id_ciudad'];
$fecha_nacii = $fila['fecha_nac'];
$cod_areaii  = $fila['cod_area'];
$celularii   = $fila['celular'];
$telefonoii  = $fila['telefono'];
$emailii     = $fila['email'];

$tabla_localidades   = mysqli_query($con, "select loc.nombre, dep.id as id_departamento, dep.nombre as departamento
from localidades loc inner join departamentos dep on loc.departamento_id = dep.id where loc.id = $id_ciudadii");
$registro_localidades= mysqli_fetch_array($tabla_localidades, MYSQLI_BOTH);

$ciudadii            = $registro_localidades['nombre'];
$id_departamentoii   = $registro_localidades['id_departamento'];
$departamentoii      = $registro_localidades['departamento'];

$html .='
<tr>
  <td colspan="4" class="subtitulo">Datos del Inversor</td>
</tr>
<tr>
  <td colspan="4"><hr></td>
</tr>
<tr>
  <td>APELLIDO</td>
  <td><b>'.$apellidoii.'</b></td>
  <td colspan="2">NOMBRES <b>'.$nombresii.'</b></td>
</tr>
<tr>
  <td>DNI</td>
  <td colspan="3"><b>'.$dniii.'</b></td>
</tr>
<tr>
  <td>CUIT </td>
  <td><b>'.$cuitii.'</b> </td>
  <td>FECHA NAC. </td>
  <td><b>'.date('d/m/Y', strtotime($fecha_nacii)).'</b></td>
</tr>
<tr>
  <td>DOMICILIO </td>
  <td colspan="3"><b>'.$domicilioii.' '.$nroii.' - '.$ciudadii.' </b></td>
</tr>
<tr>
  <td>TELEF. </td>
  <td><b>('.$cod_areaii.') '.$telefonoii.'</b></td>
  <td>CELULAR </td>
  <td><b>'.$celularii.' </b></td>
</tr>
<tr>
  <td>EMAIL </td>
  <td colspan="3"><b>'.$emailii.'</b></td>
</tr>
<tr>
  <td colspan="4"></td>
</tr>';

// DETALLE DE LA EMPRESA DEL INVERSOR

$tabla_empresa = mysqli_query($con, "SELECT empresa.* 
FROM proceder_empresas empresa
INNER JOIN rel_proceder relac ON relac.id_empresa = empresa.id_empresa
WHERE relac.id_solicitante = $id_solicitante");

$registro_empresa   = mysqli_fetch_array($tabla_empresa, MYSQLI_BOTH); 

$id_empresai         = $registro_empresa['id_empresa'];
$razon_sociali       = $registro_empresa['razon_social'];
$cuiti               = $registro_empresa['cuit'];
$id_tipo_sociedadi   = $registro_empresa['id_tipo_sociedad'];

if(!$id_tipo_sociedadi){
  $id_tipo_sociedadi   = 0;
}    

$tabla_sociedades   = mysqli_query($con, "select forma from tipo_forma_juridica where id_forma = $id_tipo_sociedadi");
$registro_sociedad  = mysqli_fetch_array($tabla_sociedades, MYSQLI_BOTH);
$sociedadi          = $registro_sociedad[0];        

if(strtotime($registro_empresa['fecha_inscripcion']) > 0){
  $fecha_inscripcioni = date('d/m/Y', strtotime($registro_empresa['fecha_inscripcion']));
  $tiempo = strtotime($registro_empresa['fecha_inscripcion']); 
  $ahora = time(); 
  $anioi = ($ahora-$tiempo)/(60*60*24*365.25); 
  $anioi = floor($anioi);

}else{
  $fecha_inscripcioni = NULL;
  $anioi = NULL;
}

$domicilioi         = $registro_empresa['domicilio'];
$nroi               = $registro_empresa['nro'];
$id_ciudadi         = $registro_empresa['id_localidad'];

$tabla_localidades   = mysqli_query($con, "select loc.nombre, dep.id as id_departamento, dep.nombre as departamento
from localidades loc inner join departamentos dep on loc.departamento_id = dep.id where loc.id = $id_ciudadi");
$registro_localidades= mysqli_fetch_array($tabla_localidades, MYSQLI_BOTH);

$ciudadi             = $registro_localidades['nombre'];
$id_departamentoi    = $registro_localidades['id_departamento'];
$departamentoi       = $registro_localidades['departamento'];

$representantei      = $registro_empresa['representante'];


$html .='
<tr>
  <td colspan="4" class="subtitulo">Datos del emprendimiento</td>
</tr>
<tr>
  <td colspan="4"><hr></td>
</tr>
<tr>
  <td colspan="4">NOMBRE DE LA EMPRESA O RAZÓN SOCIAL</td>
</tr>
<tr>
  <td colspan="4"><b>'.$razon_sociali.'</b></td>
</tr>
<tr>
  <td>CUIT </td><td><b>'.$cuiti.'</b></td><td>FIGURA LEGAL </td><td><b>'.$sociedadi.'</b></td>
</tr>
<tr>
  <td colspan="4">DOMICILIO LEGAL</td>
</tr>
<tr>
  <td colspan="4"><b>'.$domicilioi.' '.$nroi.' - '.$ciudadi.'</b></td>
</tr>
<tr>
  <td colspan="4">NOMBRE DEL REPRESENTANTE LEGAL</td>
</tr>
<tr>
  <td colspan="4"><b>'.$representantei.'</b></td>
</tr>
<tr>
  <td>INICIO DE ACTIVIDADES</td>
  <td><b>'.$fecha_inscripcioni.'</b></td>
  <td colspan="2">AÑOS FUNCIONAMIENTO: <b>'.$anioi.'</b></td>
</tr>
<tr>
  <td colspan="4"></td>
</tr>
<tr>
  <td colspan="4" class="subtitulo">Proyecto a Desarrollar</td>
</tr>
<tr>
  <td colspan="4"><hr></td>
</tr>
<tr>
  <td colspan="4">BREVE RESEÑA DEL PROYECTO A DESARROLLAR MEDIANTE LA INVERSIÓN PÚBLICO-PRIVADA</td>
</tr>
<tr>
  <td colspan="4" class="justificado"><b>'.$resenia.'</b></td>
</tr>
<tr>
  <td colspan="4"></td>
</tr>
<tr>
  <td colspan="4">MONTO REQUERIDO</td>
</tr>
<tr>
  <td colspan="4"><b>'.$monto.'</b></td>
</tr>
<tr>
  <td colspan="4"></td>
</tr>
<tr>
  <td colspan="4">RUBROS GENERALES DE UTILIZACIÓN DEL MISMO</td>
</tr>
<tr>
  <td colspan="4" class="justificado"><b>'.$rubro.'</b></td>
</tr>
<tr>
  <td colspan="4"></td>
</tr>
<tr>
  <td colspan="4">¿EN QUÉ ASPECTOS CONSIDERA QUE EL DESARROLLO DEL PROYECTO DE INVERSIÓN REPRESENTARÁ UNA <b>INNOVACIÓN O CRECIMIENTO</b> PARA EL EMPRENDIMIENTO ?</td>
</tr>
<tr>
  <td colspan="4"></td>
</tr>
<tr>
  <td colspan="4" class="justificado"><b>'.$aspectos.'</b></td>
</tr>
<tr>
  <td colspan="4"></td>
</tr>

</table>';


//////////////////////////////////////////////////////////////////////////////

	

mysqli_close($con);

require_once $_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/public/libreria/tcpdf/tcpdf.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/public/libreria/tcpdf/config/lang/spa.php';

class ConPies extends TCPDF {
    public function Header() {
        /* definimos variables con titulo y subtitulo */
		
        $this->Image($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/public/imagenes/escudo_er.jpg', 15, 4, 35, 8, 'JPG', '', '', true, 350, '', false, false, 0, false, false, false);
		
        $subtitulo="ANEXO I - Formulario Entrevista - Informe Inicial";
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

$nombre= 'proyecto.pdf';
$pdf->Output($nombre,'I');
exit;
?>