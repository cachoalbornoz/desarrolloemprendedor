<?php
    session_start();
    require("../accesorios/accesos_bd.php");
    $con=conectar();

    // BUSCA EXPEDIENTES SIN UBICACIONES
    $tabla_check = mysqli_query($con, "SELECT reu.id_expediente, exped.fecha_otorgamiento
        FROM expedientes exped 
        LEFT JOIN rel_expedientes_ubicacion reu ON exped.id_expediente = reu.id_expediente
        WHERE reu.id_expediente IS NOT NULL 
        AND exped.nro_exp_madre <> 0 
        AND reu.id_ubicacion = 0");

    echo "Expedientes encontrados :" .mysqli_num_rows($tabla_check)."<br>";


    $total = 0;

    while($fila_check = mysqli_fetch_array($tabla_check)){

        $id_expediente      = $fila_check['id_expediente'];
        $fecha_otorgamiento = $fila_check['fecha_otorgamiento'];

        // /////////////////////////////////////////////////////////// EXPEDIENTES - UBICACIONES

        mysqli_query($con, "INSERT INTO expedientes_ubicaciones (fecha, id_tipo_ubicacion, motivo) values ('$fecha_otorgamiento', 1, 'INICIO TRAMITE')")
            or die('Revisar insercion exp - ubicaciones');
        $id_ubicacion = mysqli_insert_id($con) ;

        $id_relacion = mysqli_query($con, "INSERT INTO rel_expedientes_ubicacion (id_expediente, id_ubicacion) values ($id_expediente, $id_ubicacion)") 
            or die('Revisar insercion relac expedientes - ubicaciones');

        $total++;


        echo 'ID_EXPEDIENTE :'. $id_expediente. '<br>';
        echo 'FECHA_EXPEDIENTE :'. $fecha_otorgamiento. '<br>';
        echo 'ID_UBICACION :'. $id_ubicacion . '<br>';
        echo 'ID_RELACION :'. $id_relacion;

        exit;
        
    }

    echo "Expedientes procesados :" .$total;

    mysqli_close($con);
