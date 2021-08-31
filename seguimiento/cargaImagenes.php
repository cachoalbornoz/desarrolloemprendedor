<?php
require_once("../accesorios/accesos_bd.php");

$con = conectar();

$id_expediente  = $_GET['id'];

$archivo = NULL;

if(isset($_GET['accion'])){
    
    $registro   = mysqli_query($con,"select segexped.id_expediente, segexped.archivo, segexped.resena, rub.rubro
    from seguimiento_expedientes segexped
    inner join expedientes exped on segexped.id_expediente = exped.id_expediente 
    inner join tipo_rubro_productivos rub on rub.id_rubro = exped.id_rubro where segexped.id_expediente = $id_expediente") or die ('Ver Ingreso Foto / Reseña');   

    if($fila = mysqli_fetch_array($registro, MYSQLI_BOTH)){

        $archivo    = $fila['archivo'];
        mysqli_query($con,"update seguimiento_expedientes set archivo = '' where id_expediente = $id_expediente") or die ('Ver eliminar foto');   
        unlink('images/'.$archivo);
    }  
}


$registro   = mysqli_query($con,"select segexped.id_expediente, segexped.archivo, segexped.resena, rub.rubro
from seguimiento_expedientes segexped
inner join expedientes exped on segexped.id_expediente = exped.id_expediente 
inner join tipo_rubro_productivos rub on rub.id_rubro = exped.id_rubro where segexped.id_expediente = $id_expediente") or die ('Ver Ingreso Foto / Reseña');   

if($fila = mysqli_fetch_array($registro, MYSQLI_BOTH)){
    
    $resena     = $fila['resena'];
    $archivo    = $fila['archivo'];
    $rubro      = $fila['rubro'];
    
}
?>

<div class="row">
    <div class="col-lg-12">
        <label for="resena">Reseña del Proyecto</label>
        <textarea name="resena" id="resena" placeholder="Describa el proyecto productivo" class="form-control"><?php echo $resena ?> </textarea>
    </div>
</div>    


<div class="row">
    <div class="col-lg-12">
        <label for="archivo_foto">Imagen</label>                
        <input id="archivo_foto" name="archivo_foto" type="file" class="form-control">
    </div>
</div>
<br>    
<div class="row">
    <div class="col-xs-12">         
        <table class="table table-striped">
            <tr>
                <td>
                    Imagen 
                </td>
                <td>
                    Rubro
                </td>
            </tr>
            <tr>
                <td>
                    <?php 
                        if (strlen($archivo) > 0){ ?>
                            
                            <img src="images/<?php echo $archivo?>" class="img-responsive" height="100" width="100">

                    <?php } else{ ?>
                
                            <img src="/desarrolloemprendedor/public/imagenes/imagen-no-disponible.png" class="img-responsive" height="100" width="100">
                    <?php    
                    }
                    ?>
                    
                </td>
                <td>
                    <span class="label label-success"> <?php echo $rubro ?> </span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php if($archivo){ ?>
                    <a href="#" title="Eliminar la imagen cargada" onclick="elimina_imagen(<?php echo $id_expediente ?>)"> <i class="fas fa-trash"></i></a>
                    <?php    
                    } 
                    ?>
                </td>
            </tr>
        </table>        
    </div>    
</div>





<?php
mysqli_close($con);		






