<?php  require('../accesorios/admin-superior.php');    ?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class=" col-xs-12 col-sm-12 col-lg-12">
                PADRON APOYO COMERCIAL
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
                    <table id="proaccer" class="table table-condensed table-hover" style="font-size: small" >
                        <thead>
                        <tr>
                            <th>Borrar</th>
                            <th>Id</th>
                            <th>Solicitante</th>
                            <th>FechaAlta</th>
                            <th>Habilitado</th>
                            <th>Email</th>
                            <th>Dni</th>
                            <th>Seguimiento</th>
                            <th>Ciudad</th>
                            <th>Rubro</th>
                            <th>Resenia</th>
                            <th>FechaInsc</th>
                            <th>Evaluar</th>
                            <th>Nota</th>
                            <th>Informe</th>
                            <th>Pdf</th>
                            <th>FechaEnt</th>
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
         
        var table = $('#proaccer').DataTable({ 
            "lengthMenu"    : [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "dom"           : '<"wrapper"Brflit>',        
            "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
            "order"         : [[3, "desc" ]],
            "stateSave"     : true,
            "processing"    : true,
            "serverSide"    : true,
            "ajax"          : {
                url   : "server-autogestionados.php",
                type  : "post"
            },
            "columnDefs"    : [
                { orderable:    false   , targets: [0, 1, 4, 5, 6, 7, 10, 12, 13, 14, 15] },
                { className: 'text-center', targets: [0, 1, 3, 6, 7, 11, 12, 14, 15, 16] },
                { className: 'rowspanning', targets: [10] },
                { className: 'text-center text-danger', targets: [4] }
            ],
            "language"      : { "url": "../public/DataTables/spanish.json" }
        }); 
    });

    $('#proaccer').on("click", ".borrar", function(){


        var texto   = '&nbsp; Elimina ? &nbsp;';
        var id      = this.id;
        var fila    = $(this).parent().parent().parent();

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

                    url 	: 'server-d-autogestionados.php',
                    type 	: 'POST',
                    dataType: 'json',
                    data 	: {id: id},
                    success: function(data){
                        fila.remove();
                        toastr.options = { "progressBar": true, "showDuration": "300", "timeOut": "1000" };
                        toastr.error("&nbsp;", "Solicitante eliminado ... ");
                    }
                });                 
            }
        });
    });
    

    function editar_solicitante(id){
        window.location="../personas/registro_edita.php?id_lugar=0&id_solicitante=" + id;
    }

    

</script>

 <?php require_once('../accesorios/admin-inferior.php'); ?>
