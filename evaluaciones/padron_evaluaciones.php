<?php
  require('../accesorios/admin-superior.php');

  $actual = date('Y', time());
  $año = $actual - 2;

?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-2">
                PADRON EVALUACIONES
            </div>

            <div class="col-sm-3">
                  <select id="ano" class="form-control">
                      <option value="<?php echo $año ?>">AÑO EVALUACION</option>
                      <?php
                      while ($año <= $actual) {
                          ?>
                          <option value="<?php echo $año ?>"><?php echo $año ?></option>
                      <?php
                      $año ++;
                      }
                      ?>
                  </select>
            </div>
            <div class="col-sm-6">
                <button class="btn btn-default" onclick="cargar_historico()" >Guardar Historico</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="detalle_evaluaciones"> </div>
    </div>
</div>


<?php require_once('../accesorios/admin-scripts.php'); ?>


<script type="text/javascript">

$(document).ready(function() {

  $("#detalle_evaluaciones").load('detalle_carga_evaluaciones.php');

});


function cargar_historico(){
    var anio = document.getElementById('ano').value;

    $("#detalle_evaluaciones").load('detalle_carga_evaluaciones.php', {opcion: 1, anio: anio});

}

</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>
