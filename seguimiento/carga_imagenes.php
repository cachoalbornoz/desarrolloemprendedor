<?php 
    require('../accesorios/admin-superior.php');
    require_once("../accesorios/accesos_bd.php");

    $id_usuario = $_SESSION['id_usuario'];

?>

	
<form id="relevamiento" method="post" action="agregar_imagen.php" enctype="multipart/form-data">
    <div class="card">                    
        <div class="card-header">      
            <div class="row">
                <div class="col-lg-12">
                    CARGA DE IMAGENES Y RESEÑAS A PROYECTOS FINANCIADOS 
                </div>
            </div>
        </div>
        <div class="card-body"> 
            
            <div class="row"> 
                <div class="col-lg-12">     
                    <label for="id_expediente">Proyecto financiado</label>
                    <select id="id_expediente" name="id_expediente" class="form-control" required onchange="from(this.value,'carga','cargaImagenes.php')">
                    <option value="-1" disabled selected>Seleccione el proyecto</option>
                    <?php
                    $con=conectar();
                    $registro  = mysqli_query($con, "select exp.id_expediente,emp.apellido,emp.nombres,emp.cuit,te.estado,rp.rubro   
                    from expedientes as exp
                    inner join rel_expedientes_emprendedores as ree on exp.id_expediente = ree.id_expediente
                    inner join emprendedores as emp on ree.id_emprendedor = emp.id_emprendedor
                    inner join seguimiento_expedientes as seg on exp.id_expediente = seg.id_expediente
                    inner join tipo_estado as te on exp.estado = te.id_estado 
                    inner join tipo_rubro_productivos as rp on exp.id_rubro = rp.id_rubro
                    where  emp.id_responsabilidad = 1 and round(seg.latitud) < 0 
                    group by exp.id_expediente order by emp.apellido,emp.nombres asc");

                    while($fila = mysqli_fetch_array($registro)){ ?>
                        <option value=<?php echo $fila[0] ?>><?php echo $fila[1].', '.$fila[2].'('.$fila[3].') '.$fila[5] ?></option>
                    <?php
                    }
                    ?> 
                    </select>
                </div>
                <br>
                <br>
            </div> 
            <div class="row"> 
                <div class="col-lg-12">     
                    <div id="carga">

                    </div>    
                </div>
            </div> 
              
        </div> 
        
        <div class="panel-footer" style="text-align: right">
            <input type="submit" value="Guardar" class="btn btn-default" required>
       </div>          
    </div>
</form>  
  
<?php 
    require_once('../accesorios/admin-scripts.php'); 
    mysqli_close($con);
?>

<script type="text/javascript"> 

    $(document).ready(function(){
        $("#id_expediente").select2();
        $("#id_expediente").focus();
    });    
    
    function elimina_imagen(id){
        
        if(confirm('Confirma que borra la imagen ?')){
            
            var url='cargaImagenes.php';
            $.ajax({   
                type: 'GET',
                url:url,
                data:{accion:2 , id:id},
                success: function(resp){   
                    $("#carga").html(resp);                    
                }
            });
        }
    }
</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>