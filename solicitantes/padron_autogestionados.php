<?php  require('../accesorios/admin-superior.php');    ?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class=" col-xs-12 col-sm-12 col-lg-12">
                PADRON AUTOGESTIONADOS
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
                    <table id="autogestionados" class="table table-condensed table-hover" style="font-size: small" >
                        <thead>
                            <tr>
                                <th>Borrar</th>
                                <th>Id</th>
                                <th>Solicitante</th>                  
                                <th>FechaAlta</th>
                                <th>Habilitado</th>
                                <th>Email</th>
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
         
        var table = $('#autogestionados').DataTable({ 
            
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
                { orderable : false   , targets: [0, 1, 4, 5, 6, 7, 11, 13] },
                { className : 'text-center', targets: [0,1,3,13] },
                { className : 'rowspanning', targets: [11] },
                { className : 'text-center text-danger', targets: [4] }
            ],
            "language"      : { "url": "../public/DataTables/spanish.json" }
        }); 
    });

    $('#autogestionados').on("click", ".borrar", function(){


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
    

</script>

 <?php require_once('../accesorios/admin-inferior.php'); ?>
