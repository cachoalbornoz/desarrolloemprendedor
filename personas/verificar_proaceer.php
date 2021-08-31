<?php
require_once("../accesorios/accesos_bd.php");
$con=conectar();

$dni                = $_POST['dni'];

$tabla_proyectos    = mysqli_query($con,"SELECT t1.id_solicitante, concat(t1.apellido, ' ', t1.nombres) as solicitante, t1.email, t1.dni, t4.nombre as ciudad, rubro, t2.observaciones, t5.habilitado, t1.fecha, t7.fecha as fechai, t6.fecha as fechae, t7.id, t8.resultado_final as nota, t6.adjunto, t6.id as identre
	FROM solicitantes t1
	INNER JOIN registro_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
	INNER JOIN tipo_rubro_productivos t3 ON t2.id_rubro = t3.id_rubro
	INNER JOIN localidades t4 ON t4.id = t1.id_ciudad
	LEFT JOIN (SELECT * FROM habilitaciones WHERE id_programa = 2) t5 ON t1.id_solicitante = t5.id_solicitante
	LEFT JOIN proaccer_entrevista t6 ON t1.id_solicitante = t6.id_solicitante
	LEFT JOIN proaccer_inscripcion t7 ON t1.id_solicitante = t7.id_solicitante
	LEFT JOIN proaccer_seguimientos t8 ON t7.id = t8.id_proyecto 
	WHERE t1.dni = $dni") or die('Revisar proaceer');

$registro = mysqli_fetch_array($tabla_proyectos);

if($registro){

    $fechai = (isset($registro['fechai']))?date('d/m/Y', strtotime($registro['fechai'])):null;
    $fechae = (isset($registro['fechai']))?date('d/m/Y', strtotime($registro['fechai'])):null;

    $habilitado = ($registro['habilitado']==1) ? 'Si': 'No';
    $result =  '<div class=" table-responsive">
                    <table id="proaccer" class="table table-sm table-hover table-bordered text-center" style="font-size: small">
                    <tr style=" background-color:#c67d26">
                        <td class="text-left">Reseña</td>
                        <td>Habilitado</td> 
                        <td>Rubro</td>                         
                        <td>Fecha registro</td>                         
                        <td>Fecha informe</td>                         
                        <td>Fecha evaluacion</td>
                        <td>Nota</td>                         
                    </tr>
                    <tr>
                        <td class="text-left">'.$registro['observaciones'].'</td>                  
                        <td>'.$habilitado.'</td>
                        <td>'.$registro['rubro'].'</td>
                        <td>'.$registro['fecha'].'</td>
                        <td>'.$fechai.'</td>
                        <td>'.$fechae.'</td>
                        <td>'.$registro['nota'].'</td>
                    </tr>
                    </table>
                </div>';
}else{
    $result = '';
}

mysqli_close($con); 

header('Content-Type: application/json');
echo json_encode($result);

?>