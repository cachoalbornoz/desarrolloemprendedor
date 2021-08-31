<?php  require('../accesorios/admin-superior.php');    ?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class=" col-xs-12 col-sm-12 col-lg-12">
                PADRON ENTIDADES <a href="crear_entidad.php"> (+) Agregar </a>
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

                    <table id="entidades" class="table table-condensed table-hover" style="font-size: small" >
                        <thead>
                            <tr>
                                <th>Borrar</th>
                                <th>Nro</th>
                                <th>Entidad</th>
                                <th>Usuario</th>
                                <th>Clave</th>   
                                <th>Foto</th>                   
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
         
        var table = $('#entidades').DataTable({ 
            "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            "dom"           : '<"wrapper"Brflit>',      
            "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
            "order"         : [[1, "asc" ]],
            "stateSave"     : true,
            "processing"    : true,
            "serverSide"    : true,
            "ajax"          : {
                url   : "server-entidades.php",
                type  : "post"
            },
            "columnDefs"    : [
                { orderable:    false   , targets: [0] },
                { className: 'text-center', targets: [0, 1] },
            ],
            "language"      : { "url": "../public/DataTables/spanish.json" }
        }); 
    });
    
    $('#entidades').on("click", ".borrar", function(){


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

                    url 	: 'server-d-entidades.php',
                    type 	: 'POST',
                    dataType: 'json',
                    data 	: {id: id},
                    success: function(data){
                        if(data == 1){
                            fila.remove();
                            toastr.options = { "progressBar": true, "showDuration": "300", "timeOut": "1000" };
                            toastr.error("&nbsp;", "Entidad eliminada ... ");
                        }else{
                            toastr.options = { "progressBar": true, "showDuration": "300", "timeOut": "1000" };
                            toastr.warning("&nbsp;", "Entidad bloqueada ... ");
                        }
                        
                    }
                });                 
            }
        });
    });
    

    function editar_entidad(id){

        window.location="../entidades/editar_entidad.php?id_entidad=" + id;
    }

    

</script>

 <?php require_once('../accesorios/admin-inferior.php'); ?>
