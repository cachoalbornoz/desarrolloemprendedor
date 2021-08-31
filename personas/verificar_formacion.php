<?php
require_once("../accesorios/accesos_bd.php");
$con = conectar();

$dni   = $_POST['dni'];

$query = mysqli_query($con, "SELECT id_solicitante FROM solicitantes WHERE dni =  $dni");

$fila  = mysqli_fetch_array($query);

$id_solicitante = $fila['id_solicitante'];

$query = mysqli_query($con, "SELECT * 
	FROM formacion_detalle_formaciones t1
    INNER JOIN solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
    WHERE t2.dni =  $dni");

if (mysqli_num_rows($query) > 0) {

    $result =
        '
            <p class="mt-3">Tutorías</p>
            
            <table class="mt-3 table table-sm table-hover table-bordered" style="font-size: small">
            <tr class="table-dark text-dark">
                <th>Problemáticas</th>
                <th>Objetivos</th>
            </tr>';

    while ($fila   = mysqli_fetch_array($query)) {

        $result .=

            '<tr>
                <td class="text-left">' . $fila['objetivos'] . '</td>
                <td class="text-left">' . $fila['acciones'] . '</td>			
            </tr>';
    }

    $result .= '</table>';
} else {

    $result = '<br> Sin datos registrados en <b>Detalle de Problemáticas </b> </br>';
}

$query  = mysqli_query($con, "SELECT obser.id, obser.observacion, obser.updated_at, CONCAT(usu.apellido, ' ',usu.nombres) AS usuario, updated_at
    FROM formacion_detalle_observaciones obser
    INNER JOIN usuarios usu ON usu.id_usuario = obser.id_capacitador
    WHERE id_solicitante =  $id_solicitante
    ORDER BY obser.updated_at DESC");

if (mysqli_num_rows($query) > 0) {

    $result .= '<table class="table table-hover table-bordered text-center" style="font-size: smaller"">
                <tr class="table-dark text-dark">
                    <th> Tutor</th>
                    <th> Acción </th>
                </tr>';

    $contador = 1;
    while ($fila   = mysqli_fetch_array($query)) {


        $result .=
            '<tr>
                <td class="text-left">' . $fila['usuario'] . '</td>				
                <td class="text-left">' . $fila['observacion'] . '</td>
            </tr>';
    }


    $result .= '</table>';
} else {

    $result .= '<br> Sin datos registrados en <b>Detalle de Acciones </b> </br>';
}



// 


$query  = mysqli_query($con, "SELECT t3.nombre, t3.fechaRealizacion 
    FROM rel_solicitante_curso t1 
    INNER JOIN solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
    INNER JOIN formacion_cursos t3 ON t1.id_curso = t3.id 
    WHERE t1.id_solicitante =  $id_solicitante
    ORDER BY t3.fechaRealizacion ASC");

if (mysqli_num_rows($query) > 0) {

    $result .= '<table class="mt-3 table table-hover table-bordered text-center" style="font-size: smaller">
                <tr class="table-dark text-dark">
                    <th> Asistencia a capacitaciones </th>
                    <th> Fecha </th>
                </tr>';

    $contador = 1;
    while ($fila   = mysqli_fetch_array($query)) {


        $result .=
            '<tr>
                <td class="text-left">' . $fila['nombre'] . '</td>				
                <td>' . $fila['fechaRealizacion'] . '</td>
            </tr>';
    }

    $result .= '</table>';
} else {

    $result .= '<br> Sin datos registrados en <b>Detalle de Cursos </b> </br>';
}



mysqli_close($con);

header('Content-Type: application/json');
echo json_encode($result);
