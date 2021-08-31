<?php 
    require('../accesorios/admin-superior.php');

    $id_usuario = $_SESSION['id_usuario'];

?>

  
<div class="card">

    <div class="card-header">      
        <div class="row">
            <div class="col-lg-6">
                RELEVAMIENTOS DE PROYECTOS - Form2017          
            </div>
            <div class="col-lg-6">
                &nbsp;
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
                <a class="nav-link" id="tab2" data-toggle="tab" href="#inicia" role="tab" aria-controls="inicia" aria-selected="false">
                    Inician
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab3" data-toggle="tab" href="#desiste" role="tab" aria-controls="desiste" aria-selected="false">
                    Desistieron
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab4" data-toggle="tab" href="#sinrespuesta" role="tab" aria-controls="sinrespuesta" aria-selected="false">
                    No se obtuvo respuesta
                </a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane show active" id="funciona" role="tabpanel" aria-labelledby="tab1">
                <div id="detalle_proyectos_sigue"></div>
            </div>
            <div class="tab-pane" id="inicia" role="tabpanel" aria-labelledby="tab2">
                <div id="detalle_proyectos_inicia"></div>
            </div>
            <div class="tab-pane" id="desiste" role="tabpanel" aria-labelledby="tab3">
                <div id="detalle_proyectos_desis"></div>
            </div>
            <div class="tab-pane" id="sinrespuesta" role="tabpanel" aria-labelledby="tab4">
                <div id="detalle_proyectos_sresp"></div>
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
            url: 'Detalle_Form2017_Sigue.php',
            type: "POST",
            success: function(html) { $("#detalle_proyectos_sigue").html(html); },
            error: function() { }
        });
        
        $.ajax({
            url: 'Detalle_Form2017_Desis.php',
            type: "POST",
            success: function(html) { $("#detalle_proyectos_desis").html(html); },
            error: function() { }
        });
        
        $.ajax({
            url: 'Detalle_Form2017_Inicia.php',
            type: "POST",
            success: function(html) { $("#detalle_proyectos_inicia").html(html); },
            error: function() { }
        });
        $.ajax({
            url: 'Detalle_Form2017_SinResp.php',
            type: "POST",
            success: function(html) { $("#detalle_proyectos_sresp").html(html); },
            error: function() { }
        });
        
    });
      
</script>  


<?php
require_once('../accesorios/admin-inferior.php');