<?php

require('../accesorios/admin-superior.php');

$hoy    = null;
$pasado = null;

?>

<div class="card">
    <div class="card-header">

        <div class="row">
            <div class=" col-xs-12 col-sm-12 col-lg-12">
                ADMINISTRACION DE SOLICITANTES
            </div>
        </div>

    </div>

    <div class="card-body">

        <div class="row mb−3">
            <div class="col-xs-12 col-sm-2 col-lg-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            Desde
                        </span>
                    </div>
                    <input type="date" name="fini" id="fini" value="<?php echo $pasado; ?>" class="form-control" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-2 col-lg-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            Hasta
                        </span>
                    </div>
                    <input type="date" name="ffin" id="ffin" value="<?php echo $hoy; ?>" class="form-control" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-2 col-lg-1">
                <button name="buscar" id="buscar" class="btn btn-info">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>

        <div class="row mb-3 mt-3">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <div class="table-responsive">
                    <table id="solicitantes" class="table table-condensed table-hover " style="font-size: small">
                        <thead>
                            <tr>
                                <th>Borrar</th>
                                <th>Resp</th>
                                <th>id</th>
                                <th>ApellidoNombresRegistrado</th>
                                <th>FechaRegistro</th>
                                <th>Programa</th>
                                <th>Habilitado</th>
                                <th>FechaHabilitac</th>
                                <th>Email</th>
                                <th>CodArea</th>
                                <th>Telefono</th>
                                <th>Dni</th>
                                <th>Inscripcion</th>
                                <th>Entidad</th>
                                <th>Ciudad</th>
                                <th>Dpto</th>
                                <th>Reseña</th>
                                <th>Rubro</th>
                                <th>Estado</th>
                                <th>FechaRelev</th>
                                <th>ObservP</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once('../accesorios/admin-scripts.php'); ?>

<script type="text/javascript">
$(document).ready(function() {

    cargar_datos();
})

function cargar_datos(fini, ffin) {

    var table = $('#solicitantes').DataTable({
        "lengthMenu": [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "Todos"]
        ],
        "dom": '<"wrapper"Brpflit>',
        "buttons": ['copy', 'excel', 'pdf', 'colvis'],
        "order": [
            [4, "desc"]
        ],
        "stateSave": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "server-autogestionados-e.php",
            type: "post",
            data: {
                fini: $("#fini").val(),
                ffin: $("#ffin").val()
            }
        },
        "columnDefs": [{
                orderable: false,
                targets: [0, 1, 6, 11, 12, 16, 17]
            },
            {
                className: 'text-center',
                targets: [0, 1, 4, 18]
            },
            {
                className: 'rowspanning',
                targets: [16]
            },
            {
                className: 'text-center text-danger',
                targets: [6]
            },
            {
                type: 'date',
                targets: [4]
            }
        ],
        "language": {
            "url": "../public/DataTables/spanish.json"
        }
    });
}


$('#buscar').on("click", function() {

    var fini = $("#fini").val();
    var ffin = $("#ffin").val();

    $('#solicitantes').DataTable().destroy();

    cargar_datos(fini, ffin);
})


$('#solicitantes').on("click", ".borrar", function() {


    var texto = '&nbsp; Elimina ? &nbsp;';
    var id = this.id;
    var fila = $(this).parent().parent().parent();

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

                url: 'server-d-autogestionados.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(data) {
                    fila.remove();
                    toastr.options = {
                        "progressBar": true,
                        "showDuration": "300",
                        "timeOut": "1000"
                    };
                    toastr.error("&nbsp;", "Solicitante eliminado ... ");
                }
            });
        }
    });
});


function editar_solicitante(id) {

    window.location = "../personas/registro_edita.php?id_lugar=0&id_solicitante=" + id;
}
</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>