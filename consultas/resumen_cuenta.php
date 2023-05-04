<?php
require '../accesorios/admin-superior.php';
?>

<div class="card">
    <div class=" card-header">
        <div class="row">
            <div class=" col-xs-12 col-sm-12 col-lg-12">
                RESUMEN DE CUENTA - PAGOS REALIZADOS
            </div>
        </div>
    </div>


    <div class="card-body">
        <div class="row mb-3">
            <div class=" col-xs-12 col-sm-12 col-lg-12">
                &nbsp;
            </div>
        </div>

        <div class="row mb-3">
            <div class=" col-xs-12 col-sm-12 col-lg-12">
                <table class="table table-striped table-hover text-center table-condensed" id="resumen" style="font-size: small">
                    <thead>
                        <tr>
                            <td>Fecha</td>
                            <td>Cod_Jov</td>
                            <td>Titular</td>
                            <td>Monto</td>
                            <td>Nro Cta</td>
                            <td>Tipo_Movimiento</td>
                            <td>Nro_Operacion</td>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>


<?php require_once '../accesorios/admin-scripts.php'; ?>

<script type="text/javascript">
    $(document).ready(function() {
        cargar_datos();
    })

    function cargar_datos(nro_cuenta) {

        var table = $('#resumen').DataTable({

            "scrollCollapse": true,
            "lengthMenu": [
                [10, 25, 50, 250, -1],
                [10, 25, 50, 250, "Todos"]
            ],
            "dom": '<"wrapper"fliprt>',
            "stateSave": true,
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "ajax": {
                url: "detalle_resumen.php",
                type: "post",
                data: {
                    nro_cuenta
                },
            },
            "columnDefs": [{
                className: 'text-left',
                targets: [2]
            }, ],
            "language": {
                "url": "../public/DataTables/spanish.json"
            },
        });
    }

    $(".filtro").on("change", function() {
        var nro_cuenta = $("#nro_cuenta").val();
        $('#resumen').DataTable().destroy();
        cargar_datos(nro_cuenta);
    })
</script>

<?php require_once '../accesorios/admin-inferior.php';
?>