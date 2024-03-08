<?php

require '../accesorios/accesos_bd.php';

$con = conectar();

function CambiarEstado($con, $id_expediente, $id_nuevo_estado, $fecha)
{
    // Obtener el estado actual del expediente e insertar el nuevo estado del expediente en la tabla de Estados
    $tabla_estados      = mysqli_query($con, "SELECT id_tipo_estado FROM expedientes_estados WHERE id_expediente = $id_expediente ORDER BY fecha desc limit 1");
    $fila_estado        = mysqli_fetch_array($tabla_estados);
    $id_tipo_estado_ant = $fila_estado[0];

    mysqli_query($con, "INSERT INTO expedientes_estados (fecha, id_expediente, id_tipo_estado, id_tipo_estado_ant) VALUES ('$fecha', $id_expediente, $id_nuevo_estado, $id_tipo_estado_ant)");

    mysqli_query($con, "UPDATE expedientes SET estado = $id_nuevo_estado WHERE id_expediente = $id_expediente");
}

// BUSCA EXPEDIENTES REGULARES.  CONTROLA LAS FECHAS / ESTADO DE LAS CUOTAS
$fecha = date('Y') . '-' . date('m') . '-11';
$tabla_morosos = mysqli_query($con, "SELECT edc.id_expediente, exped.estado, MIN(edc.fecha_vcto) as fecha
    FROM expedientes exped
    INNER JOIN expedientes_detalle_cuotas edc ON exped.id_expediente = edc.id_expediente
    WHERE edc.fecha_vcto < '$fecha' AND edc.estado = 0 AND exped.estado = 1
    GROUP BY edc.id_expediente");

while($fila_morosos = mysqli_fetch_array($tabla_morosos)) {

    $id_expediente = $fila_morosos['id_expediente'];
    $fecha         = $fila_morosos['fecha'];
    CambiarEstado($con, $id_expediente, 2, $fecha);

}

// BUSCA EXPEDIENTES MOROSOS.  CONTROLA LAS FECHAS / ESTADO DE LAS CUOTAS  // PASA A ESTADO REGULAR PORQUE ESTAN AL DIA CON LA CUOTA
$fecha         = date('Y-m-d');
$tabla_morosos = mysqli_query($con, 'SELECT edc.id_expediente, exped.estado, MAX(edc.fecha_vcto) as fecha
    FROM expedientes exped
    INNER JOIN expedientes_detalle_cuotas edc ON exped.id_expediente = edc.id_expediente
    WHERE exped.estado = 2 AND (YEAR(edc.fecha_vcto)=YEAR(NOW())) AND (MONTH(edc.fecha_vcto))=MONTH(NOW()) AND edc.estado = 1 
    GROUP BY edc.id_expediente   
    ORDER BY fecha DESC');

while($fila_morosos = mysqli_fetch_array($tabla_morosos)) {

    $id_expediente = $fila_morosos['id_expediente'];
    CambiarEstado($con, $id_expediente, 1, $fecha);
}

// BUSCA EXPEDIENTES PRORROGA Y REVISA LA FECHA MAX PRORROGA. CONTROLA LAS FECHAS / ESTADO DE LAS CUOTAS
$fecha_control_prorroga = date('Y') . '-' . date('m') . '-01';
$tabla_prorroga = mysqli_query($con, "SELECT exped.id_expediente
    FROM expedientes exped
    INNER JOIN expedientes_estados est ON exped.id_expediente = est.id_expediente
    WHERE est.fecha_prorroga < '$fecha_control_prorroga' AND exped.estado = 6");

while($fila_prorroga = mysqli_fetch_array($tabla_prorroga)) {

    $id_expediente = $fila_prorroga['id_expediente'];

    // Comprobar el estado de la ultima cuota
    $tabla_pagos = mysqli_query($con, "SELECT estado
        FROM expedientes_detalle_cuotas edc
        WHERE edc.id_expediente = $id_expediente AND edc.fecha_vcto < '$fecha_control_prorroga'
        ORDER BY fecha_vcto DESC LIMIT 1");
    $fila_pago    = mysqli_fetch_array($tabla_pagos);
    $estado_cuota = $fila_pago['estado'];

    // Obtener el estado actual del expediente
    $tabla_estados = mysqli_query($con, "SELECT id_tipo_estado 
        FROM expedientes_estados 
        WHERE id_expediente = $id_expediente 
        ORDER BY fecha DESC LIMIT 1");
    $fila_estado = mysqli_fetch_array($tabla_estados);

    $fecha              = $fecha_control_prorroga;
    $id_tipo_estado_act = ($estado_cuota == 0) ? 2 : 1;
    $id_tipo_estado_ant = $fila_estado['id_tipo_estado'];

    mysqli_query($con, "INSERT INTO expedientes_estados (fecha, id_expediente, id_tipo_estado, id_tipo_estado_ant) 
    VALUES ('$fecha', $id_expediente, $id_tipo_estado_act, $id_tipo_estado_ant)");

    // Actualizar el estado del expediente a MOROSO
    mysqli_query($con, "UPDATE expedientes SET estado = $id_tipo_estado_act WHERE id_expediente = $id_expediente");

}
