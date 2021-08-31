<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}

require_once('../accesorios/accesos_bd.php');

$con=conectar();

$idProyecto = $_GET['IdProyecto'];

$tabla      = mysqli_query($con, "SELECT ps.* , sol.apellido, sol.nombres, usu.apellido as apellido_u, usu.nombres as nombres_u
FROM proaccer_seguimientos ps
INNER JOIN usuarios usu on usu.id_usuario = ps.id_usuario
INNER JOIN proaccer_inscripcion insc on insc.id = ps.id_proyecto
INNER JOIN solicitantes sol on sol.id_solicitante = insc.id_solicitante
WHERE sol.id_responsabilidad = 1 AND ps.id_proyecto = $idProyecto");

$registro   = mysqli_fetch_array($tabla);



date_default_timezone_set('America/Buenos_Aires');
$factual= date('d/m/Y', time());
$feval  = date("d/m/Y", strtotime($registro["fecha"]));
//////////////////////////////////////////////////////////////////////////////

$html= '
<h4><p style="text-align:center"><i>Constancia de Evaluacion de Proyecto</i></p></h4>
<table  width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:9">
<tr>
    <td colspan="4"><b>Nombre y Apellido del Emprendedor</b>: '.$registro['nombres'].', '.$registro['apellido'].'</td>
</tr>
<tr>
    <td colspan="4">&nbsp;</td>
</tr>
<tr>
    <td colspan="4"><b>C&oacute;digo de Sist. Nro.</b>: '.str_pad($idProyecto, 4, '0', STR_PAD_LEFT).' /'.date('Y', time()).'</td>
</tr>
<tr>
    <td colspan="4">&nbsp;</td>
</tr>
</table>
<table cellpadding="6" border="1" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:9">
<tr style="text-align:center">
    <td width="5%"><b>#</b></td>
    <td width="45%"><b>Criterios</b></td>
    <td width="10%"><b>Puntaje</b></td>
    <td width="40%"><b>Observaci&oacute;n</b></td>
</tr>
<tr style="text-align:center">
    <td width="5%">1</td>
    <td width="45%">Tipo de producción (0 a 20)</td>
    <td width="10%">'.$registro["puntaje1"].'</td>
    <td width="40%">'.$registro["observacion1"].'</td>
</tr>
<tr style="text-align:center">
    <td width="5%">2</td>
    <td width="45%">Volumen de Producción (0 a 20)</td>
    <td width="10%">'.$registro["puntaje2"].'</td>
    <td width="40%">'.$registro["observacion2"].'</td>
</tr>
<tr style="text-align:center">
    <td width="5%">3</td>
    <td width="45%">Años que se encuentra en funcionamiento (0 a 10)</td>
    <td width="10%">'.$registro["puntaje3"].'</td>
    <td width="40%">'.$registro["observacion3"].'</td>
</tr>
<tr style="text-align:center">
    <td width="5%">4</td>
    <td width="45%">Experiencia y Capacitacion en la actividad (0 a 20)</td>
    <td width="10%">'.$registro["puntaje4"].'</td>
    <td width="40%">'.$registro["observacion4"].'</td>
</tr>
<tr style="text-align:center">
    <td width="5%">5</td>
    <td width="45%">Modalidades de comercialización actuales y proyectadas (0 a 20)</td>
    <td width="10%">'.$registro["puntaje5"].'</td>
    <td width="40%">'.$registro["observacion5"].'</td>
</tr>
<tr style="text-align:center">
    <td width="5%">6</td>
    <td width="45%">Cantidad de personas que trabajan en el marco del emprendimiento(0 a 10)</td>
    <td width="10%">'.$registro["puntaje6"].'</td>
    <td width="40%">'.$registro["observacion6"].'</td>
</tr>
<tr style="text-align:center">
    <td colspan="2"><b>TOTAL</b></td>
    <td  width="10%"><b>'.$registro["resultado_final"].'</b></td>
    <td width="40%">&nbsp;</td>
</tr>
<tr colspacing="2" style="text-align:center">
    <td colspan="2"><b>Observaciones Finales</b></td>
    <td colspan="2">'.$registro["comentario"].'</td>
</tr>
</table>

<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:10">
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>Datos del Evaluador</td>
    <td><b>'.$registro["apellido_u"].', '.$registro["nombres_u"].'</b></td>
</tr>
<tr>
    <td>Fecha Ult Revision</td>
    <td><b>'.$feval.'</b></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>Firma</td>
    <td>.................................................</td>
</tr>
</table>';

require_once $_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/public/libreria/tcpdf/tcpdf.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/public/libreria/tcpdf/config/lang/spa.php';

class ConPies extends TCPDF
{
    public function Header()
    {
        /* definimos variables con titulo y subtitulo */

        $this->Image($_SERVER['DOCUMENT_ROOT']."/desarrolloemprendedor/public/imagenes/escudo_er.jpg", 15, 4, 40, 11);
        $subtitulo="CONSTANCIA DE EVALUACION";
        $this->SetY(8);
        $this->SetFont('times', '', 6, '', true);
        $this->Cell(0, 0, $subtitulo, 0, 1, 'R');
    }

    public function Footer()
    {
        /* insertamos numero de pagina y total de paginas*/
        $this->SetFont('helvetica', '', 6, '', true);
        $this->Cell(0, 10, 'Secretaria Desarrollo Económico y Emprendedor  Página '.$this->getAliasNumPage().' de '.$this-> getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->SetDrawColor(0, 0, 0);
        /* dibujamos una linea roja delimitadora del pie de página */
        $this->Line(10, 282, 195, 282);
    }
}


$pdf = new ConPies();
$top=17;
$pdf->SetMargins(PDF_MARGIN_LEFT, $top, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_TOP);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Saltos de página automáticos.
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

$pdf->SetDisplayMode('fullpage');
$pdf->AddPage();
$pdf->writeHTML($html, true, false, true, false, '');

$nombre= 'Solicitud_JE.pdf';
ob_end_clean();
$pdf->Output($nombre, 'I');
exit;