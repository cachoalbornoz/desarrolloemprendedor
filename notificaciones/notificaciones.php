<?php 
    require('../accesorios/admin-superior.php');
    require_once('../accesorios/accesos_bd.php');
    $con=conectar();

    $id_proyecto = $_GET['id_proyecto'];

    $tabla    = mysqli_query($con, "SELECT informe FROM proyectos WHERE id_proyecto = '$id_proyecto'");

    if ($registro = mysqli_fetch_array($tabla)) {
        $informe    = $registro['informe'];
    } ;
?> 

 
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <b><?php echo $_SESSION['titular'] ?> </b> - Notificaciones
                </div>  
                <div class="col-6">    
                    <?php include('../accesorios/menu_expediente.php');?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 text-right" id="estado">
                    
                </div> 
            </div>

            <div class="row m-3">
                <div class="col-xs-12 col-sm-12 col-lg-2">
                    Fecha <input type="date" id="fecha" name="fecha" required class="form-control" placeholder="aaaa/mm/dd"/>
                </div>
            </div>    
            <div class="row m-3">
                <div class="col-xs-12 col-sm-12 col-lg-3">
                    Emprendedor
                    <?php
                    $id_expediente = $_SESSION['id_expediente'];

                    $tabla_emprendedores = mysqli_query($con, "SELECT emp.id_emprendedor, emp.apellido, emp.nombres 
                    FROM emprendedores as emp, rel_expedientes_emprendedores as rel
                    WHERE emp.id_emprendedor = rel.id_emprendedor AND rel.id_expediente = $id_expediente 
                    ORDER BY emp.apellido, emp.nombres asc"); ?>

                    <select id="id_emprendedor" name="id_emprendedor" size="1" class="form-control">
                        <option value="0"></option>
                        <?php
                        while($fila = mysqli_fetch_array($tabla_emprendedores)){?>
                            <option value="<?php echo $fila[0] ?>"><?php echo $fila[1].', '.$fila[2] ?></option>
                        <?php 
                        } 
                        ?>
                    </select>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-3">
                    Recibe
                    <input id="apellido" name="apellido" type="text" placeholder="Apellido Nombres" class="form-control">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-3">
                    Parentesco
                    <select id="id_parentesco" name="id_parentesco" size="1" class="form-control">
                        <option value="0"></option>
                        <?php
                        $tabla = mysqli_query($con, "select * from tipo_parentesco"); 
                        while($fila = mysqli_fetch_array($tabla))
                        {?>
                        <option value="<?php echo $fila[0] ?>"><?php echo $fila[1] ?></option>
                        <?php 
                        }
                        ?>    
                    </select>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-3">
                    Dni
                    <input id="dni" name="dni" type="text" class="form-control">
                </div>
            </div>
            <div class="row m-3">
                <div class="col-xs-12 col-sm-12 col-lg-3">
                    Notificación
                    <?php   $tabla = mysqli_query($con, "select * from tipo_notificacion");     ?>
                    <select id="id_notificacion" name="id_notificacion" size="1"class="form-control">
                    <option value="0"></option>
                    <?php
                    while($fila = mysqli_fetch_array($tabla)){?>
                        <option value="<?php echo $fila[0] ?>"><?php echo $fila[1] ?></option>
                    <?php 
                    } 
                    ?>  
                    </select>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-3">
                    Tipo notificación
                    <select id="id_tipo_postal" name="id_tipo_postal" size="1" class="form-control">
                        <option value="0"></option>
                        <?php
                        $tabla = mysqli_query($con, "select * from tipo_postal"); 
                        while($fila = mysqli_fetch_array($tabla)){?>
                            <option value="<?php echo $fila[0] ?>"><?php echo $fila[1] ?></option>
                        <?php 
                        }
                        ?>  
                    </select>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-3">
                    $ monto
                    <input type="text" id="monto" name="monto" class="form-control" required>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-3 text-center">
                    <br>
                    <button type="button" onClick="mover()" class="btn btn-secondary">
                        Registrar
                    </button>
                </div>

            </div>    
            

            <div id="detalle_notificacion"> </div>
        </div>
    </div>  

<?php 

  mysqli_close($con); 
  require_once('../accesorios/admin-scripts.php'); ?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#detalle_notificacion").load('detalle_notificacion.php');
        $("#fecha").focus();
    });
    
    
    function mover(){
    var fecha           = document.getElementById('fecha').value;
    var apellido        = document.getElementById('apellido').value;
    var dni             = document.getElementById('dni').value;
    var id_emprendedor  = document.getElementById('id_emprendedor').value;
    var id_parentesco   = document.getElementById('id_parentesco').value;
    var id_tipo_postal  = document.getElementById('id_tipo_postal').value;
    var id_notificacion = document.getElementById('id_notificacion').value;
    var monto           = document.getElementById('monto').value;
        
    if(fecha == 0 || monto == 0 || id_emprendedor == 0){
        
        $("#estado").html('<h5>Fecha, Emprendedor y Monto son necesarios </h5>');
        $("#estado").fadeOut(4500);       

    }else{

        $("#detalle_notificacion").load('detalle_notificacion.php', 
        {
            operacion:1, 
            fecha           :fecha, 
            apellido        :apellido, 
            dni             :dni,
            id_emprendedor  :id_emprendedor,
            id_parentesco   :id_parentesco,
            id_tipo_postal  :id_tipo_postal,
            id_notificacion :id_notificacion,
            monto           :monto 
        });
        document.getElementById('id_emprendedor').value = 0;
        document.getElementById('apellido').value = '';
        document.getElementById('dni').value = '';  
    }
    }
    
    function eliminar_notificacion(id){
        if (confirm("Desea eliminar la notificación  ?")){
            $("#detalle_notificacion").load('detalle_notificacion.php', {operacion:2, id: id})
        }   
    }
</script>


<?php require_once('../accesorios/admin-inferior.php'); ?>