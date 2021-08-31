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


$query  = mysqli_query($con, 
        "SELECT sol.id_solicitante, concat(sol.apellido, ' ', sol.nombres) as solicitante
        FROM solicitantes sol 
        INNER JOIN proaccer_inscripcion inscpro on inscpro.id_solicitante = sol.id_solicitante
        WHERE  inscpro.id = $id" );

$fila   = mysqli_fetch_array($query, MYSQLI_BOTH);

$solicitante = $fila['solicitante'];


// DATOS DEL SEGUIMIENTO
$query_seg  = mysqli_query($con, "SELECT * FROM proaccer_detalle_seguimiento WHERE  id_proyecto = $id" );
$fila_seg   = mysqli_fetch_array($query_seg, MYSQLI_BOTH);

$presentoexpediente = ($fila_seg['presentoexpediente'] == 0) ? 'NO' : 'SI';
$sepago             = ($fila_seg['sepago'] == 0) ? 'NO' : 'SI';
$solicitovideo      = ($fila_seg['solicitovideo'] == 0) ? 'NO' : 'SI';
$presentorendicion  = ($fila_seg['presentorendicion'] == 0) ? 'NO' : 'SI';



$html= '
<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8">
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td colspan="2">PLANILLA DE SEGUIMIENTO - PROACEER</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td>TITULAR <b>'.$solicitante.'</b></td><td>PROYECTO # <b>'.$id.'</b></td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td>PRESENTÓ EXPEDIENTE </td><td><b>'.$presentoexpediente.'</b></td>
</tr>
<tr>
	<td>SE PAGÓ </td><td><b>'.$sepago.'</b></td>
</tr>
<tr>
	<td>SOLICITO VIDEO </td><td><b>'.$solicitovideo.'</b></td>
</tr>
<tr>
	<td>PRESENTO RENDICIÓN </td><td><b>'.$presentorendicion.'</b></td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
</table>';


// DETALLE DE INVERSIONES

$html .= '
<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8">
<tr>
	<td colspan="2">DETALLE DE INVERSIÓN</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
</table>';

$query  = mysqli_query($con, "SELECT * FROM proaccer_detalle_inversiones WHERE id_proyecto = $id" );

$html.='<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8">
        <tr>
			<td style=" width: 5%;">#</td>
			<td style=" width: 25%;">DESCRIPCIÓN</td>
			<td style=" width: 5%;">FAC</td>
			<td style=" width: 5%;">EJE</td>
			<td style=" width: 60%;">SITUACION ACTUAL</td>
		</tr>
		<tr>
			<td colspan="5"><hr></td>
		</tr>';
		
		$contador = 1;
		while($fila   = mysqli_fetch_array($query, MYSQLI_BOTH)){

		$facturo = ($fila['facturo']==0) ? 'NO' : 'SI';	
		$ejecuto = ($fila['ejecuto']==0) ? 'NO' : 'SI';

$html.='
		<tr>
			<td>'.$contador .'</td>
			<td>'.$fila['descripcion'].'</td>
			<td>'.$facturo.'</td>
			<td>'.$ejecuto.'</td>
			<td>'.$fila['situacion'].'</td>
		</tr>';

		$contador ++;
		}
		
$html.='<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		</table>';


// DETALLE DE OBSERVACIONES

$query  = mysqli_query($con, "SELECT * FROM proaccer_detalle_observaciones WHERE id_proyecto = $id" );

$html .= '
		<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8">
		<tr>
			<td colspan="3">DETALLE DE OBSERVACIÓN</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
        <tr>
			<td style=" width: 5%;">#</td>
			<td style=" width:85%;">OBSERVACIÓN</td>
			<td style=" width:10%;">FECHA</td>
		</tr>
		<tr>
			<td colspan="3"><hr></td>
		</tr>';
		
		$contador = 1;
		while($fila   = mysqli_fetch_array($query, MYSQLI_BOTH)){

$html.='
		<tr>
			<td>'.$contador .'</td>
			<td>'.$fila['observacion'].'</td>
			<td>'.date('d/m/Y', strtotime($fila['updated_at'])).'</td>
		</tr>';

		$contador ++;
		}
		
$html.='</table>';


mysqli_close($con);

require_once '../public/libreria/tcpdf/tcpdf.php';
require_once '../public/libreria/tcpdf/config/lang/spa.php';

class ConPies extends TCPDF {
    public function Header() {
        /* definimos variables con titulo y subtitulo */
		
        $this->Image($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/public/imagenes/escudo_er.jpg', 15, 4, 40, 8, 'JPG', '', '', true, 350, '', false, false, 0, false, false, false);
		
        $subtitulo="Fecha ".date('d/m/Y', time());
        $this->SetY(8);
        $this->SetFont('', '', 6, '', true);
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