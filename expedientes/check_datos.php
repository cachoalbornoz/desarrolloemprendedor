<?php
    session_start();
    require("../accesorios/accesos_bd.php");
    $con=conectar();

    // BUSCA EXPEDIENTES SIN UBICACIONES
    $tabla_check = mysqli_query($con, "SELECT exped.id_expediente, exped.fecha_otorgamiento, reu.id_ubicacion  
    FROM expedientes exped 
    INNER JOIN rel_expedientes_ubicacion reu ON exped.id_expediente = reu.id_expediente
    LEFT JOIN expedientes_ubicaciones eu ON reu.id_ubicacion = eu.id_ubicacion
    WHERE YEAR(exped.fecha_otorgamiento) = 2023 AND eu.id_ubicacion IS NULL 
    ORDER BY YEAR(exped.fecha_otorgamiento)");

    echo "Expedientes encontrados :" .mysqli_num_rows($tabla_check)."<br>";

    $total = 0;

    while($fila_check = mysqli_fetch_array($tabla_check)){

        $id_expediente      = $fila_check['id_expediente'];
        $fecha_otorgamiento = $fila_check['fecha_otorgamiento'];
        $id_ubicacion_ant   = $fila_check['id_ubicacion'];

        // /////////////////////////////////////////////////////////// EXPEDIENTES - UBICACIONES

        mysqli_query($con, "INSERT INTO expedientes_ubicaciones (fecha, id_tipo_ubicacion, motivo) values ('$fecha_otorgamiento', 1, 'INICIO TRAMITE')")
            or die('Revisar insercion exp - ubicaciones');
        $id_ubicacion = mysqli_insert_id($con) ;

        $id_relacion = mysqli_query($con, "INSERT INTO rel_expedientes_ubicacion (id_expediente, id_ubicacion) values ($id_expediente, $id_ubicacion)") 
            or die('Revisar insercion relac expedientes - ubicaciones');

        mysqli_query($con, "DELETE FROM rel_expedientes_ubicacion WHERE id_expediente = $id_expediente AND id_ubicacion = $id_ubicacion_ant") 
            or die('Revisar insercion relac expedientes - ubicaciones');            

        $total++;
        
    }

    echo "Expedientes procesados :" .$total;

    mysqli_close($con);
