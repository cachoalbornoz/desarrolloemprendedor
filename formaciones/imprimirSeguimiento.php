<?php 
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require_once("../accesorios/accesos_bd.php");

$con=conectar();

date_default_timezone_set('America/Argentina/Buenos_Aires');

$id_solicitante	= $_GET['id'];


$query  = mysqli_query($con, 
	"SELECT id_solicitante, concat(apellido, ' ', nombres) as solicitante, dni, email
    FROM solicitantes         
    WHERE  id_solicitante = $id_solicitante" );

$fila   = mysqli_fetch_array($query);

$solicitante = $fila['solicitante'];


// DATOS DEL SEGUIMIENTO
$query_seg  = mysqli_query($con, "SELECT * FROM formacion_detalle_seguimiento WHERE id_solicitante = $id_solicitante" );
$fila_seg   = mysqli_fetch_array($query_seg);

$asistio1 = ($fila_seg['asistio1'] == 0) ? 'NO' : 'SI';
$asistio2 = ($fila_seg['asistio2'] == 0) ? 'NO' : 'SI';
$asistio3 = ($fila_seg['asistio3'] == 0) ? 'NO' : 'SI';
$asistio4 = ($fila_seg['asistio4'] == 0) ? 'NO' : 'SI';
$asistio5 = ($fila_seg['asistio5'] == 0) ? 'NO' : 'SI';
$asistio6 = ($fila_seg['asistio6'] == 0) ? 'NO' : 'SI';

$html= '
<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8">
<tr>
	<td style=" width:  25%;">&nbsp;</td>
	<td style=" width:  75%;">&nbsp;</td>
</tr>
<tr>
	<td colspan="2">PLANILLA DE SEGUIMIENTO - FORMACION</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td>Apellio y Nombres </td><td><b>'.$solicitante.'</b></td>
</tr>
<tr>
	<td>Dni</td><td> <b>'.$fila['dni'].'</b></td>
</tr>
<tr>
	<td>Email</td><td> <b>'.$fila['email'].'</b></td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td>¿Asistió al encuentro 1 ?</td><td><b>'.$asistio1.'</b></td>
</tr>
<tr>
	<td>¿Asistió al encuentro 2 ?</td><td><b>'.$asistio2.'</b></td>
</tr>
<tr>
	<td>¿Asistió al encuentro 3 ?</td><td><b>'.$asistio3.'</b></td>
</tr>
<tr>
	<td>¿Asistió al encuentro 4 ?</td><td><b>'.$asistio4.'</b></td>
</tr>
<tr>
	<td>¿Asistió al encuentro 5 ?</td><td><b>'.$asistio5.'</b></td>
</tr>
<tr>
	<td>¿Asistió al encuentro 6 ?</td><td><b>'.$asistio6.'</b></td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
</table>';


// DETALLE DE FORMACIONES

$html .= '
<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8">
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="2"><strong>DETALLE DE OBJETIVOS Y ACCIONES PROPUESTAS</strong></td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
</table>';

$query  = mysqli_query($con, "SELECT * FROM formacion_detalle_formaciones WHERE id_solicitante = $id_solicitante" );

$html.='<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8">
		<tr>
			<td style=" width:  5%;">#</td>
			<th style=" width:  40%;">Objetivos</th>
			<th style=" width:  45%;">Acciones</th>
			<th style=" width:  10%;">Cumplió</th>
		</tr>
		<tr>
			<td colspan="4"><hr></td>
		</tr>';
		
		$contador = 1;
		while($fila   = mysqli_fetch_array($query)){

		$cumplio = ($fila['cumplio']==0)?'No':'Si';

		$html.='
				<tr>
					<td>'.$contador.'</td>
					<td>'.ucfirst(strtolower($fila['objetivos'])).'</td>
					<td>'.ucfirst(strtolower($fila['acciones'])).'</td>
					<td>'.$cumplio.'</td>
				</tr>';

			$contador ++;
		}
		
		$html.='<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
			</table>';

// DETALLE DE OBSERVACIONES

$query  = mysqli_query($con, "SELECT obser.id, obser.observacion, obser.updated_at, CONCAT(usu.apellido, ' ',usu.nombres) AS usuario, updated_at
FROM formacion_detalle_observaciones obser
INNER JOIN usuarios usu ON usu.id_usuario = obser.id_capacitador
WHERE id_solicitante =  $id_solicitante
ORDER BY obser.updated_at DESC" );

$html .= '
		<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8">
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4"><strong>DETALLE DE OBSERVACIONES </strong></td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
        <tr>
			<td style=" width: 5%;">#</td>
			<th style=" width: 40%;">Observacion</th>
			<th style=" width: 35%;">Tutor </th>
			<th style=" width: 20%;">Fecha Novedad</th>			
        </tr>
		<tr>
			<td colspan="4"><hr></td>
		</tr>';
		
		$contador = 1;
		while($fila   = mysqli_fetch_array($query)){

$html.='
		<tr>
			<td>'.$contador .'</td>
			<td>'.$fila['observacion'].'</td>
			<td>'.$fila['usuario'].'</td>
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
        		
        $this->Image($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/public/imagenes/escudo_er.jpg', 15, 4, 35, 8, 'JPG', '', '', true, 350, '', false, false, 0, false, false, false);
		
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

$nombre= 'Seguimiento.pdf';
ob_end_clean();
$pdf->Output($nombre,'I');
exit;