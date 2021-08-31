<?php
    require('../accesorios/admin-superior.php');
    require('../accesorios/accesos_bd.php');
    $con=conectar();
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
                
                <table id="personas" class="table table-condensed table-hover table-bordered" style="font-size: small" >
                    <thead>
                        <tr>
                            <td>Id#</td>               
                            <td>Apellido</td>
                            <td>Nombres</td>
                            <td>Dni</td>
                            <td>Es mujer</td>
                        </tr>
                    </thead>
                </table>
                
            </div>
            
        </div>

    </div>
</div>

<?php
    mysqli_close($con);
    require_once('../accesorios/admin-scripts.php');
?>


<script>

    $(document).ready(function(){

        var table = $('#personas').DataTable({ 

            "lengthMenu"    : [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "dom"           : '<"wrapper"Brpflit>',      
            "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
            "order"         : [[ 0, "asc" ]],
            "stateSave"     : true,
            "processing"    : true,
            "serverSide"    : true,
            "ajax"          : {
                url   : "server-personas.php",
                type  : "post"
            },
            "columnDefs"    : [
                { orderable : true , targets: [0] },
                { className : 'text-center', targets: [0, 3, 4] },
            ],
            "language"      : { "url": "../public/DataTables/spanish.json" }
        })
        
        
        $('#personas').on("click", ".cambiar", function(){

            $.ajax({

                url 	: 'cambiar_genero.php',
                type 	: 'POST',
                dataType: 'json',
                data 	: {id_emprendedor: this.id},
                success: function(data){

                    console.log(data);
                }
            });
            
            toastr.options = { "progressBar": true, "showDuration": "100", "timeOut": "100" };
            toastr.success("&nbsp;", "Cambiado ... ");
                
        });
        
        
    }); 

</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>
