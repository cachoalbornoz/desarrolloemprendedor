<?php
require('../accesorios/admin-superior.php');
?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class=" col-xs-12 col-sm-12 col-lg-12">
                EVALUACION DE PROYECTOS
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
                    <table class="table table-hover table-striped table-bordered" style="font-size: small" id="evaluaciones">
                        <thead>
                            <th>#Nro</th>
                            <th>Titular_proyecto</th>
                            <th title="Nro asociados">Asoc</th>
                            <th>Denominacion</th>
                            <th>Monto</th>
                            <th title="Forma juridica">Forma</th>
                            <th>Entidad</th>
                            <th>Sector</th>
                            <th>Rubro</th>
                            <th title="0 => No funciona / 1 => Si  ">Func</th>
                            <th>Localidad</th>
                            <th>Dpto</th>
                            <th>Lat </th>
                            <th>Long </th>
                            <th>I</th>
                            <th title="Fecha novedad ">FechaNov</th>
                            <th>Obs</th>
                            <th>Estado</th>
                            <th>Puntaje</th>
                            <th>FechaEval</th>
                            <th title="Agrega o modifica evaluación"><i class="fas fa-th-list"></i></th>
                            <th title="Imprime evaluación"><i class="fas fa-print"></i></th>
                            <th title="Lee evaluación"><i class="far fa-eye"></i></th>
                            <th title="Anula evaluación"><i class="fas fa-exclamation-triangle"></i></th>
                            <th title="Financia"><i class="fas fa-dollar-sign"></i></th>
                        </thead>
                    </table>
                </div>
            </div>        
        </div>

    </div>
</div>

<?php require_once('../accesorios/admin-scripts.php'); ?>

<script>

    $(document).ready(function(){

        var table = $('#evaluaciones').DataTable({ 
            "scrollY"       : "50vh",
            "sScrollX"      : "100%",
            "scrollCollapse": true,
                "fixedColumns":   {
                    leftColumns: 2,
            },
            "lengthMenu"    : [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "dom"           : '<"wrapper"Brflit>',      
            "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
            "order"         : [[ 1, "asc" ]],
            "stateSave"     : true,
            "processing"    : true,
            "serverSide"    : true,
            "ajax"          : {
                url   : "server-evaluaciones.php",
                type  : "post"
            },
            "columnDefs"    : [
                { orderable:    false   ,   targets: [0, 2, 4, 5, 10, 11, 12, 14, 16, 17, 18, 20, 21, 22, 23, 24] },
                { className: 'text-center', targets: [0, 2, 4, 5, 7, 10, 11, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24] },
                { className: 'rowspanning', targets: [3] }
            ],
            "language"      : { "url": "../public/DataTables/spanish.json" }
        }); 
    });

    $('#evaluaciones').on("click", ".borrar", function(){

        var table = $('#evaluaciones').DataTable();
        var id      = this.id;
        var soli    = $(this).attr('value');
        var texto   = '&nbsp; Anula la evaluación de '+ soli +' ? &nbsp;';

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

                    url 	: 'server-d-evaluaciones.php',
                    type 	: 'POST',
                    dataType: 'json',
                    data 	: {id: id},
                    success: function(data){  
                        table.clear().draw();                      
                        toastr.options = { "progressBar": true, "showDuration": "300", "timeOut": "1000" };
                        toastr.error("&nbsp;", "Evaluacion anulada ... ");
                    }
                });                 
            }
        });
    });

    $('#evaluaciones').on("click", ".borrari", function(){

        var table = $('#evaluaciones').DataTable();

        var id      = this.id;
        var soli    = $(this).attr('value');
        var texto   = '&nbsp; Anula la evaluación de '+ soli +' ? &nbsp;';
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

                    url 	: 'server-d-informes.php',
                    type 	: 'POST',
                    dataType: 'json',
                    data 	: {id: id},
                    success: function(data){  
                        table.clear().draw();                      
                        toastr.options = { "progressBar": true, "showDuration": "300", "timeOut": "1000" };
                        toastr.error("&nbsp;", "Evaluacion anulada ... ");
                    }
                });                 
            }
        });
    });



</script>


<?php require_once('../accesorios/admin-inferior.php'); ?>
