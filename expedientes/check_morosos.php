<?php
    session_start();
    require("../accesorios/accesos_bd.php");
    $con=conectar();

    $fecha = date('Y').'-'.date('m').'-10';

    $tabla_morosos = mysqli_query($con, "SELECT edc.id_expediente, exped.estado, MIN(edc.fecha_vcto) as fecha
        FROM expedientes exped
        INNER JOIN expedientes_detalle_cuotas edc ON exped.id_expediente = edc.id_expediente
        WHERE edc.fecha_vcto < '$fecha' AND edc.estado = 0 AND (exped.estado = 1 OR exped.estado = 6)
        GROUP BY edc.id_expediente");


    while($fila_morosos = mysqli_fetch_array($tabla_morosos)){

        $id_expediente = $fila_morosos['id_expediente'];        

        // Obtener el estado actual del expediente e insertar el nuevo estado del expediente en la tabla de Estados
        $tabla_estados      = mysqli_query($con,"SELECT id_tipo_estado FROM expedientes_estados WHERE id_expediente = $id_expediente ORDER BY fecha desc limit 1" );
        $fila_estado        = mysqli_fetch_array($tabla_estados);
        $id_tipo_estado_ant = $fila_estado[0];

        $fecha              = $fila_morosos['fecha'];
        $id_tipo_estado     = 2;
        mysqli_query($con, "INSERT INTO expedientes_estados (fecha, id_expediente, id_tipo_estado, id_tipo_estado_ant) VALUES ('$fecha', $id_expediente, $id_tipo_estado, $id_tipo_estado_ant)");	

        // Actualizar el estado del expediente a MOROSO
        mysqli_query($con, "UPDATE expedientes SET estado = $id_tipo_estado WHERE id_expediente = $id_expediente");
    }

    mysqli_close($con);
