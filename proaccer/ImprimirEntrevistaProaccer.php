<?php 
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require_once("../accesorios/accesos_bd.php");

$con=conectar();

date_default_timezone_set('America/Argentina/Buenos_Aires');

$id			= $_GET['id'];
$registro	= mysqli_query($con, "SELECT * FROM proaccer_entrevista WHERE id = $id");
$dataset	= mysqli_fetch_array($registro, 3);

// Respuestas de la entrevista
$tipoemprendimiento = $dataset['tipoemprendimiento'];
$productos			= $dataset['productos'];
$inscripcion		= $dataset['inscripcion'];
$objetivos			= $dataset['objetivos'];
$feriaseventos		= $dataset['feriaseventos'];


// Datos del Entrevistador
$id_entrevistador = $dataset['id_entrevistador'];
$registro	= mysqli_query($con, "SELECT apellido, nombres FROM usuarios WHERE id_usuario = $id_entrevistador");
$datasetE	= mysqli_fetch_array($registro, 3);
$apellidoE	= $datasetE[0];
$nombreE	= $datasetE[1];

// Datos del Solicitante
$id_solicitante = $dataset['id_solicitante'];
$registro	= mysqli_query($con, "SELECT apellido, nombres FROM solicitantes WHERE id_solicitante = $id_solicitante");
$datasetS	= mysqli_fetch_array($registro, 3);
$apellidoS	= $datasetS[0];
$nombreS	= $datasetS[1];

// Datos Figura Juridica
$id_formajuridica	= $dataset['id_formajuridica'];
$registro	= mysqli_query($con, "SELECT forma FROM tipo_forma_juridica WHERE id_forma = $id_formajuridica");
$datasetF	= mysqli_fetch_array($registro, 3);
$forma		= $datasetF[0];

$html= '
<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8">
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td width="70%">PLANILLA DE ENTREVISTA - INFORME INICIAL </td>
	<td width="30%">ANEXO I</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
</table>

<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8; padding-top:5px; padding-bottom:5px">
<tr>
	<td><h3>Resultados de la entrevista</h3></td>
</tr>
<tr>
	<td>Emprendedor apellido y nombres </td>
</tr>
<tr>
	<td><b>'.$apellidoS.', '.$nombreS.'</b></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>Entrevistador apellido y nombres </td>
</tr>
<tr>
	<td><b>'.$apellidoE.', '.$nombreE.'</b></td>
</tr>
<tr>
	<td style="border-bottom: 1px solid gray;">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>1) Describir <b>Tipo de Emprendendimiento</b> </td>
</tr>
<tr>
	<td style="border: 1px solid gray;"><b>'.$tipoemprendimiento.'</b></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>2) Describir <b>Productos a ofrecer en eventos</b> </td>
</tr>
<tr>
	<td style="border: 1px solid gray;"><b>'.$productos.'</b></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>3) Describir <b>Figura Legal</b></td>
</tr>
<tr>
	<td style="border: 1px solid gray;"><b>'.strtoupper($forma).'</b></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>4) Describir <b>Inscripciones a organismos dedicados al comercio</b> (solicitar constancias de dichas inscripciones en formato papel). </td>
</tr>
<tr>
	<td style="border: 1px solid gray;"><b>'.$inscripcion.'</b></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>5) Objetivos que le interesa trabajar al emprendedor</td>
</tr>
<tr>
	<td style="border: 1px solid gray;"><b>'.$objetivos.'</b></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>6) Describir <b>Ferias y Eventos</b> referidos al emprendimiento. <br>
		<small>Lo consignado en este apartado no tiene carácter de aprobación previa por parte del técnico o profesional asesor de los gastos consignados como posibles en el apartado en el requerimiento logístico / material gráfico. La definición de los mismos surgirá a partir del trabajo de asesoramiento realizado, y en todos los casos
		será necesario para su aprobación la presentación de la documentación contable y jurídica para habilitarla. Ésto se realizará en el marco de la presentación de la presentación del plan de acción específico definida de manera conjunta entre el emprendedor y el asesor, conforme se detalla en el Anexo I - Apartado "Implementaciómn - IV. 
		Desarrollo de plan específico y suscripción de convenio". </small>
		<br>
		<h5>Nombre feria / evento - Fecha - Localidad - Requerimiento logístico / material gráfico </h5>
	</td>
</tr>
<tr>
	<td style="border: 1px solid gray;"><b>'.$feriaseventos.'</b></td>
</tr>
</table>';



mysqli_close($con);

require_once '../public/libreria/tcpdf/tcpdf.php';
require_once '../public/libreria/tcpdf/config/lang/spa.php';

class ConPies extends TCPDF {
    public function Header() {
        /* definimos variables con titulo y subtitulo */
		$this->Image($_SERVER['DOCUMENT_ROOT']."/desarrolloemprendedor/public/imagenes/escudo_er.jpg", 15, 4, 40, 11);
		
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

$nombre= 'Inscripcion.pdf';
ob_end_clean();
$pdf->Output($nombre,'I');
exit;