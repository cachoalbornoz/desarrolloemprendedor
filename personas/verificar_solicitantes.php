<?php
require_once("../accesorios/accesos_bd.php");
$con = conectar();

$dni            = $_POST['dni'];

// BUSCAR ID PROYECTO POR EL DNI DEL SOLICITANTE
$tabla_relacion = mysqli_query($con, "SELECT id_proyecto 
    FROM solicitantes t1
    INNER JOIN rel_proyectos_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
    WHERE t1.dni = $dni");

if ($registro       = mysqli_fetch_array($tabla_relacion)) {
    $id_proyecto    = $registro['id_proyecto'];
} else {
    $id_proyecto    = -1;
}

//

// BUSCAR TODOS LOS SOLICITANTES RELACIONADO AL ID PROYECTO
$tabla_proyectos    = mysqli_query($con, "SELECT t1.*, t2.nombre as ciudad, t3.nombre as departamento, responsabilidad
    FROM solicitantes t1
    INNER JOIN localidades t2 ON t1.id_ciudad = t2.id 
    INNER JOIN departamentos t3 ON t2.departamento_id = t3.id
    INNER JOIN tipo_responsabilidad t4 ON t1.id_responsabilidad = t4.id_responsabilidad
    INNER JOIN rel_proyectos_solicitantes t5 ON t1.id_solicitante = t5.id_solicitante
    WHERE t5.id_proyecto = $id_proyecto
    ORDER BY t1.id_responsabilidad Desc, apellido Asc  ");

if (mysqli_num_rows($tabla_proyectos) > 0) {

    $result =
        '<div class="table-responsive">   
        <caption> Nro proyecto ' . $id_proyecto . '</caption> 
        <table id="integrantes" class="table table-condensed table-hover" style="font-size: small" >
        <thead>
            <tr>
                <td class="text-center">Desvinc.</td>
                <td>Responsabilidad</td>    
                <td class="text-center">Titularizar</td>
                <td>#ID</td>
                <td>Solicitante</td> 
                <td>DNI</td>
                <td>Email</td>
                <td>Ciudad</td>
                <td>Dpto</td>
            </tr>
        </thead>
        <tbody>';

    while ($fila = mysqli_fetch_array($tabla_proyectos)) {

        $desvincular    = ($fila['id_responsabilidad'] == 0) ? '<a href="javascript:void(0)" onclick="desvincular_solicitante(' . $fila['id_solicitante'] . ',' . $id_proyecto . ')">
        <i class="fas fa-unlink text-info" title="Desvincular del proyecto"></i>
    </a>' : null;
        $titularizar    = ($fila['id_responsabilidad'] == 0) ? '<a href="javascript:void(0)"  onclick="titularizar_solicitante(' . $fila['id_solicitante'] . ')">
        <i class="fas fa-arrow-up" title="Titularizar éste solicitante "></i>
    </a>' : null;

        $responsabilidad = ($fila['id_responsabilidad'] == 1) ? '<i class="fas fa-user"></i>' : '<i class="far fa-user text-secondary"></i>';

        $result .= '

        <tr>
            <td class="text-center">' . $desvincular . '</td>
            <td>' . $responsabilidad . ' (' . ucwords($fila['responsabilidad']) . ')' . '</td>
            <td class="text-center">' . $titularizar . '</td>
            <td>' . str_pad($fila['id_solicitante'], 6, '0', STR_PAD_LEFT) . '</td>
            <td>' . '<a href="javascript:void(0)" title="Editar datos" onclick="editar_solicitante(' . $fila['id_solicitante'] . ')">' . ucwords($fila['apellido']) . ' ' . ucwords($fila['nombres']) . '</a>' . '</td>
            <td>' . $fila['dni'] . '</td>
            <td>' . $fila['email'] . '</td>
            <td>' . $fila['ciudad'] . '</td>
            <td>' . $fila['departamento'] . '</td>
        </tr>';
    }

    $result .= '
        </tbody>
        </table>
    </div>';
} else {
    $result = 0;
}

mysqli_close($con);

header('Content-Type: application/json');
echo json_encode($result);