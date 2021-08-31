<?php
session_start();

include("../accesorios/accesos_bd.php");

$con = conectar();

$id_expediente = $_SESSION['id_expediente'];

if (isset($_POST['operacion'])) {

    $operacion = $_POST['operacion'];

    if ($operacion == 1) {

        $fecha          = $_POST['fecha'];
        $monto          = $_POST['monto'];
        $nro_operacion  = $_POST['nro_operacion'];
        $id_cuenta      = $_POST['id_cuenta'];
        $id_tipo_pago   = $_POST['id_tipo_pago'];

        $insercion = "INSERT INTO expedientes_pagos (fecha, id_expediente, monto, nro_operacion, id_cuenta, id_tipo_pago) 
      VALUES ('$fecha', $id_expediente, $monto, '$nro_operacion', $id_cuenta, $id_tipo_pago)";
        mysqli_query($con, $insercion) or die("Error en la insercion Pagos");
        $id_pago = mysqli_insert_id($con);

        /// CALCULAR EL TOTAL COBRADO
        $tabla_consulta = "SELECT sum(monto) FROM expedientes_pagos WHERE id_expediente = $id_expediente";
        $resultado  = mysqli_query($con, $tabla_consulta);
        $registro   = mysqli_fetch_array($resultado);

        if ($registro) {
            $monto_cobrado = $registro[0];
        } else {
            $monto_cobrado = 0;
        }

        $seleccion  = mysqli_query($con, "SELECT entrega_parcial FROM expedientes_detalle_cuotas WHERE id_expediente = $id_expediente and estado = 0 order by nro_cuota asc limit 1");
        $registro   = mysqli_fetch_array($seleccion);

        if ($registro) {
            $entrega_parcial = $registro[0];
        } else {
            $entrega_parcial = 0;
        }

        $total_cobrado = $monto + $entrega_parcial;

        $seleccion_cuota = mysqli_query($con, "SELECT importe, nro_cuota, entrega_parcial, id_detalle FROM expedientes_detalle_cuotas WHERE id_expediente = $id_expediente and estado = 0 order by nro_cuota");
        $bandera = true;

        while ($registro_cuota = mysqli_fetch_array($seleccion_cuota) and $bandera) {

            $id_detalle = $registro_cuota[3];
            $nro_cuota = $registro_cuota[1];

            if ($total_cobrado >= $registro_cuota[0]) {

                mysqli_query($con, "UPDATE expedientes_detalle_cuotas set id_pago = $id_pago, estado = 1, entrega_parcial = 0 WHERE id_detalle = $id_detalle") or die("Revisar actualización de Cuotas");
            } else {

                mysqli_query($con, "UPDATE expedientes_detalle_cuotas set id_pago = $id_pago, entrega_parcial = $total_cobrado WHERE id_detalle = $id_detalle")                or die("Revisar actualización de Entrega Parcial");
                break;
                $bandera = false;
            }

            $total_cobrado = $total_cobrado - $registro_cuota[0];
        }

        $saldo = $_SESSION['monto'] - $monto_cobrado;

        if ($monto_cobrado < $_SESSION['monto']) {

            $edicion = "UPDATE expedientes SET saldo = $saldo WHERE id_expediente = $id_expediente";
        } else {

            $edicion = "UPDATE expedientes SET saldo = 0, estado = 3 WHERE id_expediente = $id_expediente";

            //Cargo el Estado como PAGO

            $seleccion   = mysqli_query($con, "SELECT id_tipo_estado FROM expedientes_estados WHERE id_expediente = $id_expediente order by fecha desc limit 1");

            $fila_estado = mysqli_fetch_array($seleccion);

            $id_tipo_estado_ant = $fila_estado[0];

            $insercion = "INSERT INTO expedientes_estados (fecha, id_expediente, id_tipo_estado, id_tipo_estado_ant) VALUES ('$fecha', $id_expediente, 3, $id_tipo_estado_ant)";
            mysqli_query($con, $insercion) or die("Error en la insercion Estado");
        }

        mysqli_query($con, $edicion);
    } else {

        if ($operacion == 2) {

            $id_pago = $_POST['id'];
            $seleccion = mysqli_query($con, "SELECT monto FROM expedientes_pagos WHERE id_pago = $id_pago");
            $registro = mysqli_fetch_array($seleccion);
            $monto = $registro[0];

            /// VUELVO CUOTAS IMPAGAS
            mysqli_query($con, "UPDATE expedientes_detalle_cuotas SET entrega_parcial = 0, estado = 0, id_pago = 0 WHERE id_pago = $id_pago")
                or die("Revisar actualización de Entrega Parcial");

            $elimina = "DELETE FROM expedientes_pagos WHERE id_pago = $id_pago";
            mysqli_query($con, $elimina) or die("Error en la eliminacion de pagos");

            // ACTUALIZO EL SALDO
            $tabla_consulta = "SELECT sum(monto) FROM expedientes_pagos WHERE id_expediente = $id_expediente";
            $resultado = mysqli_query($con, $tabla_consulta);
            $registro = mysqli_fetch_array($resultado);
            $monto_cobrado = $registro[0];

            $saldo = $_SESSION['monto'] - $monto_cobrado;
            $edicion = "UPDATE expedientes SET saldo = $saldo WHERE id_expediente = $id_expediente";
            mysqli_query($con, $edicion);
        }
    }
}
?>


<?php
$resultado = mysqli_query($con, "SELECT saldo FROM expedientes WHERE id_expediente = $id_expediente");
$registro  = mysqli_fetch_array($resultado);
$saldo     = $registro[0];

if (isset($_POST['id_pago'])) {
    $id_pago = $_POST['id_pago'];

    $tabla_pagos = mysqli_query($con, "SELECT exp.id_pago, exp.id_cuenta, exp.fecha, exp.monto, exp.nro_operacion, tp.pago FROM expedientes_pagos as exp, tipo_pago as tp 
    WHERE tp.id_tipo_pago = exp.id_tipo_pago and exp.id_pago = $id_pago order by exp.fecha desc, exp.id_pago desc");
} else {
    $tabla_pagos = mysqli_query($con, "SELECT exp.id_pago, exp.id_cuenta, exp.fecha, exp.monto, exp.nro_operacion, tp.pago FROM expedientes_pagos as exp, tipo_pago as tp 
    WHERE tp.id_tipo_pago = exp.id_tipo_pago and exp.id_expediente = $id_expediente order by exp.fecha desc, exp.id_pago desc");
}

$filas_pagos = mysqli_num_rows($tabla_pagos);

$total_pagado = 0;

while ($fila = mysqli_fetch_array($tabla_pagos)) { ?>
<div class="row m-3">
    <div class="col-xs-12 col-sm-12 col-lg-2">
        <?php echo date('d-m-Y', strtotime($fila[2])); ?>
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-2">
        <?php echo $fila[3] ?>
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-2">
        <?php
            if ($fila[1] == 0) {
                echo "090024/7";
            } else {
                if ($fila[1] == 1) {
                    echo "662047/1";
                } else {
                    if ($fila[1] == 2) {
                        echo "620230/1";
                    } else {
                        echo "622988/5";
                    }
                }
            }
            ?>
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-2">
        <?php echo $fila[5] ?>
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-2">
        <?php echo $fila[4] ?>
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-2 text-center">
        <a href='javascript: void(0)' title='Elimina el pago actual' onclick="eliminar_pago('<?php echo $fila[0] ?>')">
            <i class="fas fa-trash text-danger"></i>
        </a>
    </div>
</div>
<?php
    $total_pagado = $total_pagado + $fila[3];
}


if (!isset($_POST['id_pago'])) { ?>
<div class="row m-3">
    <div class="col-xs-12 col-sm-12 col-lg-12">

    </div>
</div>

<div class="row m-3">
    <div class="col-xs-12 col-sm-8 col-lg-8">

    </div>
    <div class="col-xs-12 col-sm-2 col-lg-2">
        Monto prestado
    </div>
    <div class="col-xs-12 col-sm-2 col-lg-2 text-center">
        <b> <?php echo number_format($_SESSION['monto'], 2, ",", "."); ?></b>
    </div>
</div>

<div class="row m-3">
    <div class="col-xs-12 col-sm-8 col-lg-8">

    </div>
    <div class="col-xs-12 col-sm-2 col-lg-2">
        Total pagado
    </div>
    <div class="col-xs-12 col-sm-2 col-lg-2 text-center">
        <b> <?php echo number_format($total_pagado, 2, ",", "."); ?></b>
    </div>
</div>
<div class="row m-3">
    <div class="col-xs-12 col-sm-8 col-lg-8">

    </div>
    <div class="col-xs-12 col-sm-2 col-lg-2">
        Saldo
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-2 text-center" style="color:#FF0000">
        <b> <?php echo number_format($saldo, 2, ",", "."); ?></b>
    </div>
</div>
<?php
}

mysqli_close($con); ?>