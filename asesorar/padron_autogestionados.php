<?php  require '../accesorios/admin-superior.php'; ?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class=" col-xs-12 col-sm-11 col-lg-11">
                PADRON AUTOGESTIONADOS
            </div>
            <div class=" col-xs-12 col-sm-1 col-lg-1">
                <a href="../asesorar/indexAdmin.php">Nuevo contacto</a>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="row mb-3">
            <div class="col">
                &nbsp;
            </div>
        </div>


        <div class="row mb-3">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <div class="table-responsive">
                    <table id="asesorados" class="table table-condensed table-hover" style="font-size: small">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Apellido, Nombres</th>
                                <th>Dni</th>
                                <th>Seguimiento</th>
                                <th>Categoria</th>
                                <th><i class="far fa-calendar-alt"></i> Consulta</th>
                                <th>Color</th>
                                <th>Usuario</th>
                                <th><i class="far fa-calendar-alt"></i> Inicio</th>
                                <th><i class="far fa-calendar-alt"></i> Fin</th>
                                <th>Borrar</th>
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

    var table = $('#asesorados').DataTable({
        "lengthMenu": [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "Todos"]
        ],
        "dom": '<"wrapper"Brflit>',
        "buttons": ['copy', 'excel', 'pdf', 'colvis'],
        "order": [
            [1, "desc"]
        ],
        "stateSave": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "server-autogestionados.php",
            type: "post"
        },
        "columnDefs": [{
                orderable: false, targets: [0, 3, 4, 5, 6, 7, 10]
            },
            {
                className: 'text-center',
                targets: [0, 3, 4, 5, 8, 9, 10]
            },
        ],
        "language": {
            "url": "../public/DataTables/spanish.json"
        }
    });
    

    $('#asesorados').on("click", ".borrar", function(){

        var table = $('#asesorados').DataTable();
        var id      = this.id;
        var soli    = $(this).attr('value');
        var texto   = '&nbsp; Anula asesoramiento  ? &nbsp;';

        ymz.jq_confirm({
            title:texto, 
            text:"", 
            no_btn:"Cancelar", 
            yes_btn:"Confirma", 
            no_fn:function(){
                return false;
            },
            yes_fn:function(){    

                $.ajax({

                    url 	: 'server-d-asesoramiento.php',
                    type 	: 'POST',
                    dataType: 'json',
                    data 	: {id: id},
                    success: function(data){  
                        table.clear().draw();                      
                        toastr.options = { "progressBar": true, "showDuration": "300", "timeOut": "1000" };
                        toastr.error("&nbsp;", "Asesoramiento anulado ... ");
                    }
                });                 
            }
        });
    });


    function editar_solicitante(id) {

        window.location = "../personas/registro_edita.php?id_lugar=0&id_solicitante=" + id;
    }





</script>

<?php require_once '../accesorios/admin-inferior.php';