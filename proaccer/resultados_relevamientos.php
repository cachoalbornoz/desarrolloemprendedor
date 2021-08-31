<?php 
    require('../accesorios/admin-superior.php');

    $id_usuario = $_SESSION['id_usuario'];

?>

  
<div class="card">
    <div class="card-header">      
        <div class="row">
            <div class="col">
                RELEVAMIENTOS DE PROYECTOS - PROACCER        
            </div>
        </div>
    </div>
    <div class="card-body">        
        
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tab1" data-toggle="tab" href="#funciona" role="tab" aria-controls="funciona" aria-selected="true">
                Funcionando
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab3" data-toggle="tab" href="#desiste" role="tab" aria-controls="desiste" aria-selected="false">
                Desistieron
            </a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane show active" id="funciona" role="tabpanel" aria-labelledby="tab1">
            <div id="detalle_proyectos_sigue"></div>
        </div>
        <div class="tab-pane" id="desiste" role="tabpanel" aria-labelledby="tab3">
            <div id="detalle_proyectos_desis"></div>
        </div>
    </div>                
           
  </div>
        
    </div>    
</div>

<?php
    require_once('../accesorios/admin-scripts.php'); 
?>

<script>        
        
    $(function(){
        $.ajax({
            async: false,
            url: 'Detalle_Sigue.php',
            type: "POST",
            success: function(html) { $("#detalle_proyectos_sigue").html(html); },
        });
        
        $.ajax({
            async: false,
            url: 'Detalle_Desis.php',
            type: "POST",
            success: function(html) { $("#detalle_proyectos_desis").html(html); },
        });
        
    });
      
</script>  


<?php
require_once('../accesorios/admin-inferior.php');