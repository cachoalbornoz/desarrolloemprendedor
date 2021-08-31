<?php 

if(isset($_GET['id_proyecto'])){

  $id_proyecto  = $_GET['id_proyecto'];
      
  $tabla        = mysqli_query($con, "SELECT informe FROM proyectos WHERE id_proyecto = '$id_proyecto'");

  if ($registro = mysqli_fetch_array($tabla)) {
    $informe    = $registro['informe'];
  } 



?>
<div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
  <div class="btn-group mr-2" role="group" aria-label="First group">
    <a class="btn btn-secondary" title="Listado Emprendedores" href="../emprendedores/padron_emprendedores.php?id_proyecto=<?php echo $id_proyecto?>">LE</a>
    <a class="btn btn-secondary" title="Ubicación" href="../ubicaciones/ubicaciones.php?id_proyecto=<?php echo $id_proyecto?>">UB</a>
    <a class="btn btn-secondary" title="Rendición" href="../rendiciones/rendiciones.php?id_proyecto=<?php echo $id_proyecto?>">RE</a>
    <a class="btn btn-secondary" title="Estado" href="../estados/estados.php?id_proyecto=<?php echo $id_proyecto?>">ES</a>
    <a class="btn btn-secondary" title="Forma pago" href="../formaspago/formaspago.php?id_proyecto=<?php echo $id_proyecto?>">FP</a>
    <a class="btn btn-secondary" title="Notificaciones" href="../notificaciones/notificaciones.php?id_proyecto=<?php echo $id_proyecto?>">NO</a>
    <a class="btn btn-secondary" title="Pagos" href="../pagos/pagos.php?id_proyecto=<?php echo $id_proyecto?>">PA</a>
    <a class="btn btn-secondary" title="Visitas" href="../visitas/visitas.php?id_proyecto=<?php echo $id_proyecto?>">VI</a>
    
    <?php

    if (isset($id_proyecto) and $id_proyecto > 0) { ?>
      <a class="btn btn-warning" title="Proyecto" href="../proyectos/detalle_proyecto.php?IdProyecto=<?php echo $id_proyecto ?>">PR</a>
    <?php
    }
    ?>

    <?php if (isset($informe)) { ?>
      <a class="btn btn-danger" title="Informe" href="../evaluaciones/informes/<?php echo $informe ?> ">IN</a>
    <?php
    }
  }
  ?>
  </div>
</div>