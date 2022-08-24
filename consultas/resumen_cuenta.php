<?php
    require '../accesorios/admin-superior.php';
    require_once '../accesorios/accesos_bd.php';
    $con = conectar();

    ?>

<div class="card">
    <div class=" card-header">
        <div class="row">
            <div class=" col-xs-12 col-sm-12 col-lg-10">
                RESUMEN DE CUENTA - PAGOS REALIZADOS
            </div>
            <div class=" col-xs-12 col-sm-12 col-lg-2">
                <select id="id_cuenta" name="id_cuenta" class="form-control">
                    <option value="-1" selected>Nro cta destino</option>
                    <option value="0">090024/7</option>
                    <option value="1">662047/1</option>
                    <option value="2">620230/1</option>
                    <option value="3">622988/5</option>
                </select>
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

                <div class="table-responsive">
                    <table class="table table-striped table-hover text-center" style="font-size: small" id="resumen">
                        <thead>
                            <tr>
                                <td>Fecha</td>
                                <td>Cod_Jov</td>
                                <td>Titular</td>
                                <td>Monto</td>
                                <td>Nro_cuenta</td>
                                <td>Tipo_Movimiento</td>
                                <td>Nro_Operacion</td>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>

    </div>


    <?php
    
    require_once '../accesorios/admin-scripts.php'; ?>

    
    <script type="text/javascript">

        $(document).ready(function() {
            cargar_datos();
        })

        function cargar_datos(id_cuenta) {

            var table = $('#resumen').DataTable({ 
                "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                "dom"           : '<"wrapper"Brflitp>',        
                "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
                "ordering"      : false,
                "language"      : { "url": "../public/DataTables/spanish.json" },
                "stateSave"     : true,
                "processing"    : true,
                "serverSide"    : true,
                "ajax"          : {
                    url     : "detalle_resumen.php",
                    type: "post",
                    data: {id_cuenta},
                },
                columns: [
                    {data: 'fecha'},
                    {data: 'proyecto'},
                    {data: 'titular', 'class': 'text-left'},
                    {data: 'monto'},
                    {data: 'cuenta'},
                    {data: 'pago',   },
                    {data: 'nro_operacion' },
                ]
            });
        }

        $("#id_cuenta").on("change", function() {
            var id_cuenta = $("#id_cuenta").val();
            $('#resumen').DataTable().destroy();
            cargar_datos(id_cuenta);
        })       

    </script>

    <?php require_once '../accesorios/admin-inferior.php';
