<?php
require '../accesorios/admin-superior.php';
require_once '../accesorios/accesos_bd.php';
$con = conectar();

$id_proyecto = $_GET['id_proyecto'];

$tabla = mysqli_query($con, "SELECT informe FROM proyectos WHERE id_proyecto = '$id_proyecto'");

if ($registro = mysqli_fetch_array($tabla)) {
    $informe = $registro['informe'];
}

?>


<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <b><?php print $_SESSION['titular']; ?> </b> - Forma de pago
            </div>
            <div class="col-6">
                <?php include '../accesorios/menu_expediente.php'; ?>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="row m-3">
            <div class="col-xs-12 col-sm-12 col-lg-4">
                Monto crédito <b><?php print number_format($_SESSION['monto'], 2, ',', '.'); ?></b>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-4">
                Fecha otorgamiento <b><?php print date('d/m/Y', strtotime($_SESSION['fecha_otorgamiento'])); ?></b>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-4">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <br />
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <br />
            </div>
        </div>

        <div class="row m-3">
            <table class="table table-condensed text-center">
                <tr>
                    <td style=" width:120px">
                        Nro cuota
                    </td>
                    <td>
                        Vencimiento
                    </td>
                    <td>
                        $ importe
                    </td>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        <button class="btn btn-danger" onClick="eliminar_plan()">Borrar plan</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <select id="nro_cuota" name="nro_cuota" class="form-control">
                            <?php
                        $nro = 1;
                        while ($nro <= 60) {
                            print '<option value=' . $nro . '>' . $nro . '</option>';
                            $nro++;
                        }
                        ?>
                        </select>
                    </td>
                    <td>
                        <input type="date" name="fecha" id="fecha" required class="form-control">
                    </td>
                    <td>
                        <input type="number" name="monto" id="monto" required class="form-control">
                    </td>
                    <td>
                        <button class="btn btn-secondary" onClick="registrar()">Crear cuota</button>
                    </td>
                    <td>
                        <button class="btn btn-secondary" onClick="generar_cuotas_semestral()">Semestral</button>
                    </td>
                    <td>
                        <button class="btn btn-secondary" onClick="generar_cuotas()">24 Cuotas</button>
                    </td>
                </tr>

            </table>
        </div>

        <div id="forma_pago"> </div>

    </div>
</div>

<?php require_once '../accesorios/admin-scripts.php'; ?>

<script type="text/javascript">
    const procesando = () => {
        let imgProcessing = '<img src="/desarrolloemprendedor/public/imagenes/cargando.gif"/>';
        $("#forma_pago").html('Procesando, aguarde por favor... ' + imgProcessing);
    }

    $(document).ready(function() {
        procesando();
        $("#forma_pago").load('detalle_forma_pago.php');
        $("#nro_cuota").focus()

    });

    function generar_cuotas() {
        procesando();
        $("#forma_pago").load('detalle_forma_pago.php', {
                operacion: 1,
                cuotas: 24
            },
            function(response, status, xhr) {
                if (status == "success") {
                    console.log('Ok')
                }
                if (status == "error") {
                    var msg = "Error!, algo ha sucedido: ";
                    $("#forma_pago").html(msg + xhr.status + " " + xhr.statusText);
                }
            });
    }

    function generar_cuotas_semestral() {
        procesando();
        $("#forma_pago").load('detalle_forma_pago.php', {
            operacion: 1,
            cuotas: 3
        });
    }

    function registrar() {
        var cuota = document.getElementById('nro_cuota').value
        var importe = document.getElementById('monto').value
        var fecha = document.getElementById('fecha').value

        if (cuota == 0 || importe == 0 || fecha == 0) {
            $("#estado").show();
            $("#estado").text("Ingrese Nro Cuota ó Importe ");
            $("#estado").toggle('slow');
            $("#estado").toggle('slow');
            $("#estado").fadeOut(5000);
        } else {
            $("#forma_pago").load('detalle_forma_pago.php', {
                operacion: 4,
                cuota: cuota,
                importe: importe,
                fecha: fecha
            });
            document.getElementById('nro_cuota').value = 1
            document.getElementById('monto').value = ''
            document.getElementById('fecha').value = ''
            document.getElementById('nro_cuota').select()
        }
    }

    function eliminar_plan() {
        if (confirm("Esta seguro que desea eliminar el Plan Pago ")) {
            procesando();
            $("#forma_pago").load('detalle_forma_pago.php', {
                operacion: 2
            });
        }
    }

    function eliminar_cuota(id) {
        if (confirm("Desea eliminar Cuota ")) {
            procesando();
            $("#forma_pago").load('detalle_forma_pago.php', {
                operacion: 3,
                id_detalle: id
            });
        }
    }
</script>

<?php require_once '../accesorios/admin-inferior.php';
