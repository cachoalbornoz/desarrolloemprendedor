<?php
require '../accesorios/admin-superior.php';

if (isset($_SESSION['id_expediente'])) {
    unset($_SESSION['id_expediente'], $_SESSION['nro_proyecto'], $_SESSION['titular'], $_SESSION['monto'], $_SESSION['fecha_otorgamiento']);
}

require_once '../accesorios/accesos_bd.php';
$con = conectar();

$fila = mysqli_query($con, 'select min(year(date(fecha_otorgamiento))), max(year(date(fecha_otorgamiento))) from expedientes');
$reg  = mysqli_fetch_array($fila);
$min  = $reg[0];
$max  = $reg[1];

?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                PADRON DE EXPEDIENTES
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12 mb-3 ">
                &nbsp;
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="table-responsive">
                    <table class="records_list table table-hover table-striped" style="font-size: small" id="expedientes">
                        <thead>
                            <tr>
                                <th>NroExpediente</th>
                                <th>Titular</th>
                                <th>
                                    <select id="anio" class="filtro">
                                        <option value="-1" selected="true">Año</option>
                                        <?php
                                $actual = date('Y', time());
$año                                    = $min;
while ($año <= $actual) {
    print '<option value=' . $año . '>' . $año . '</option>';
    $año++;
}
?>
                                    </select>
                                </th>
                                <th>Dni</th>
                                <th>Icono</th>
                                <th>
                                    <select id="estado" class="filtro">
                                        <option value="-1" selected="true">Estado</option>
                                        <?php
$estados  = 'SELECT * FROM tipo_estado WHERE id_estado < 20 ORDER BY estado asc';
$registro = mysqli_query($con, $estados);
while ($fila = mysqli_fetch_array($registro)) {
    print "<option value='" . $fila[0] . "'>" . $fila[1] . '</option>';
}
?>
                                    </select>

                                </th>
                                <th>Finalidad</th>
                                <th>FechaOtorgam</th>
                                <th>Monto</th>
                                <th>Saldo</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once '../accesorios/admin-scripts.php'; ?>


<script type="text/javascript">
    $(document).ready(function() {
        cargar_datos();
    })

    function cargar_datos(anio, estado) {

        var table = $('#expedientes').DataTable({

            "pagingType": 'full_numbers',
            "lengthMenu": [ [10, 25, 50, 500], [10, 25, 50, 500]],
            "paging": true,
            "info": true,
            "buttons": ['copy', 'excel', 'pdf', 'colvis'],
            "ordering": false,
            "stateSave": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "server-expedientes.php",
                type: "post",
                data: {
                    anio: anio,
                    estado: estado
                },
            },
            "language": {
                "url": "../public/DataTables/spanish.json"
            },
        });
    }


    $(".filtro").on("change", function() {

        var anio = $("#anio").val();
        var estado = $("#estado").val();

        $('#expedientes').DataTable().destroy();

        cargar_datos(anio, estado);
    })

    $('#expedientes').on("click", ".borrar", function() {

        var table = $('#expedientes').DataTable();
        var id = this.id;
        var soli = $(this).attr('value');
        var texto = '&nbsp; Elimina expediente de ' + soli + ' ? &nbsp;';

        ymz.jq_confirm({
            title: texto,
            text: "",
            no_btn: "Cancelar",
            yes_btn: "Confirma",
            no_fn: function() {
                return false;
            },
            yes_fn: function() {

                $.ajax({

                    url: 'server-d-expedientes.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(data) {

                        table.clear().draw();
                        toastr.options = {
                            "progressBar": true,
                            "showDuration": "300",
                            "timeOut": "1000"
                        };
                        toastr.error("&nbsp;", "Expediente eliminado ... ");
                    }
                });
            }
        });
    });
</script>

<?php require_once '../accesorios/admin-inferior.php';
