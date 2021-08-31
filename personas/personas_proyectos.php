<?php


require_once('../accesorios/admin-superior.php');
require_once("../accesorios/accesos_bd.php");
$con = conectar();

?>

<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                Consulta general de solicitantes
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="row mb-3">
            <div class="col-xs-12 col-sm-12 col-lg-12 mt-3 mb-3 ">
                <input type="hidden" name="dni" id="dni">
                <input type="hidden" name="id_solicitante" id="id_solicitante">
                <p>Ingrese <b>apellido nombres</b> ó el <b>dni</b> de la persona</p>

                <table id="titulares" class="table table-condensed table-hover table-bordered" style="font-size: small">
                    <thead>
                        <tr>
                            <td>#ID</td>
                            <td>Ver datos</td>
                            <td>Apellido y nombres </td>
                            <td>Dni</td>
                            <td>Email</td>
                            <td>Edad</td>
                            <td>Ciudad</td>
                            <td>Departamento</td>
                        </tr>
                    </thead>
                </table>

            </div>

        </div>

        <div class="card p-2">
            <div class="row mb-5 text-info">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <label for="expedientes">Expedientes <b>financiados</b> </label>
                    <div id="expedientes" class="border">

                    </div>
                </div>
            </div>

            <div class="row mb-5" style="color:#1e5571">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <label for="jovenes">Programa <b>Jóvenes emprendedores</b> </label>
                    <div id="jovenes" class="border">

                    </div>
                </div>
            </div>

            <div class="row mb-5" style="color:#1e5571">
                <div class="col-xs-12 col-sm-7 col-lg-7">
                    <label for="solicitantes">Programa <b>Jóvenes emprendedores</b> - integrantes </label>
                    <div id="solicitantes" class="border">

                    </div>
                </div>
                <div class="col-xs-12 col-sm-5 col-lg-5">
                    <p><b>Vincular</b> otra persona al proyecto Jóvenes emprendedores</p>

                    <table id="asociados" class="table table-condensed table-hover" style="font-size: small">
                        <thead>
                            <tr>
                                <td>Apellido y nombres</td>
                                <td>Dni</td>
                                <td>Edad</td>
                                <td>Vincular</td>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>

            <div class="row mb-5" style="color:#c67d26">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <label for="proaceer">Programa <b>Proaceer</b> </label>
                    <div id="proaccer" class="border">

                    </div>
                </div>
            </div>

            <div class="row mb-5" style="color:#9968bc">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <label for="formacion">Programa <b>Formación</b></label>
                    <div id="formacion" class="border">

                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<?php require_once('../accesorios/admin-scripts.php'); ?>

<script>
$(document).ready(function() {

    var table = $('#titulares').DataTable({

        "lengthMenu": [
            [1, 5],
            [1, 5]
        ],
        "lengthChange": true,
        "dom": '<"wrapper"Brflit>',
        "stateSave": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "server-titulares.php",
            type: "post"
        },
        "columnDefs": [{
                orderable: false,
                targets: [0, 1, 2, 3, 4, 5, 6, 7]
            },
            {
                className: 'text-center',
                targets: [0, 1, 3, 5]
            },
            {
                className: 'font-weight-bold',
                targets: 2
            },
        ],
        "language": {
            "url": "../public/DataTables/spanish.json"
        }
    });

    var table = $('#asociados').DataTable({

        "lengthMenu": [
            [1],
            [1]
        ],
        "lengthChange": false,
        "dom": '<"wrapper"bf>',
        "stateSave": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "server-asociados.php",
            type: "post"
        },
        "columnDefs": [{
                orderable: false,
                targets: [0, 1, 2, 3]
            },
            {
                className: 'text-center',
                targets: [2, 3]
            },
        ],
        "language": {
            "url": "../public/DataTables/spanish.json"
        }
    });

});

$(document).on('click', '.ver', function() {

    var dni = this.id;
    $("#dni").val(this.id);
    obtenerDatos();
});


function obtenerDatos() {

    var dni = $("#dni").val();

    var url = 'verificar_expedientes.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            dni: dni
        },
        success: function(resp) {

            if (resp != 0) {
                $("#expedientes").html(resp);
            } else {
                $("#expedientes").html('');
            }
        }
    });

    var url = 'verificar_solicitantes.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            dni: dni
        },
        success: function(resp) {
            if (resp != 0) {
                $("#solicitantes").html(resp);
            } else {
                $("#solicitantes").html('');
            }
        }
    });

    var url = 'verificar_jovenes.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            dni: dni
        },
        success: function(resp) {
            if (resp != 0) {
                $("#jovenes").html(resp);
            } else {
                $("#jovenes").html('');
            }
        }
    });

    var url = 'verificar_proaceer.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            dni: dni
        },
        success: function(resp) {
            $("#proaccer").html(resp);
        }
    });

    var url = 'verificar_formacion.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            dni: dni
        },
        success: function(resp) {
            $("#formacion").html(resp);
        }
    });
}

$(document).on('click', '.asociar', function() {

    var id_solicitante = this.id;
    var id_proyecto = $("#id_proyecto").val();

    if (id_proyecto > 0 && id_solicitante > 0) {

        var url = 'vincular_solicitante.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                id_proyecto: id_proyecto,
                id_solicitante: id_solicitante
            },
            success: function(resp) {

                if (resp == 2) {
                    toastr.options = {
                        "progressBar": true,
                        "showDuration": "300",
                        "timeOut": "1000"
                    };
                    toastr.error("&nbsp;", "Edad supera los 40 años ... ");
                }
                if (resp == 3) {
                    toastr.options = {
                        "progressBar": true,
                        "showDuration": "300",
                        "timeOut": "1000"
                    };
                    toastr.error("&nbsp;", "El asociado ya está en un proyecto ... ");
                }
                obtenerDatos();
            }
        });
    }
})

function titularizar_solicitante(id_solicitante) {

    var id_proyecto = $("#id_proyecto").val();
    var url = 'titularizar_solicitante.php';

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            id_proyecto: id_proyecto,
            id_solicitante: id_solicitante
        },
        success: function(resp) {

            if (resp == 1) {
                obtenerDatos();
            }
        }
    });

}

function desvincular_solicitante(id_solicitante, id_proyecto) {

    var url = 'desvincular_solicitante.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            id_proyecto: id_proyecto,
            id_solicitante: id_solicitante
        },
        success: function(resp) {

            if (resp == 1) {
                obtenerDatos();
            }
        }
    });
}


function editar_solicitante(id) {
    window.location = "../personas/registro_edita.php?id_lugar=0&id_solicitante=" + id;
}
</script>

<?php
mysqli_close($con);
require_once('../accesorios/admin-inferior.php'); ?>