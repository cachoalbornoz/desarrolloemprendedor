<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require_once('../accesorios/accesos_bd.php');

$con=conectar();

if(isset($_POST['cadena'])){

    $cadena = split(',',$_POST['cadena']);

    foreach ($cadena as $id) {
        mysqli_query($con, "delete from expedientes_ext_desis where id_expediente = $id");
    }
}

?>

<script>

    $('#proyectosdesis').tableExport({
        formats: ["xlsx"], //Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
        position: 'top',  // Posicion que se muestran los botones puedes ser: (top, bottom)
        bootstrap: false,//Usar lo estilos de css de bootstrap para los botones (true, false)
        fileName: "ProyectosDesistieron<?php echo date('dmY',time())?>",    //Nombre del archivo
    });


    function borrardesis(){

        if (($("input[name*='siguedesis']:checked").length)<=0) {
             alert("Seleccione un elemento por favor");
             return false;
        }else{
            if(confirm("Elimina los seleccionados ? ")){
                var cadena = '';
                $("input[name*='siguedesis']:checked").each(function() {
                    cadena += $(this).val() + ', ';
                });
                $("#detalle_proyectos_desis").load('Detalle_Form2017_Desis.php', {cadena: cadena})
            }
         }
    }
</script>


<div class="table table-responsive">
    <table id="proyectosdesis" class=" table-bordered" style=" font-size: smaller">
    <thead>
        <tr>
            <th class="text-center noExl">
                <a href="#" onclick="borrardesis()">
                    <i class="fas fa-trash"></i> &nbsp; Borrar
                </a>
            </th>
            <?php
            $cont = 0;
            $tabla_relevamiento = mysqli_query($con, "select exped.fecha_relevam as Fecha_registro,desis.*
                from expedientes_ext_desis desis
                inner join seguimiento_expedientes_ext exped on exped.id_expediente = desis.id_expediente
                order by exped.fecha_relevam desc");
                
                while($registro = mysqli_fetch_field($tabla_relevamiento)){

                if($cont == 1){
                    echo '<th>Expediente</th>';
                }else{
                    echo '<th>'.ucwords($registro->name).'</th>';
                }
                $cont ++ ;
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $tabla_relevamiento = mysqli_query($con, "select exped.fecha_relevam as Fecha_registro,desis.*
                from expedientes_ext_desis desis
                inner join seguimiento_expedientes_ext exped on exped.id_expediente = desis.id_expediente
                order by exped.fecha_relevam desc");
        while($registro =  mysqli_fetch_array($tabla_relevamiento, MYSQLI_BOTH)){ ?>

            <tr>
                <td class="text-center">
                    <input type="checkbox" name="siguedesis[]" value="<?php echo $registro[1]?>">
                </td>
                <?php
                for($i=0; $i<$cont;$i++){

                    if($i==1){

                        $id_proyecto = $registro[$i];

                        $tabla_proyecto = mysqli_query($con, "select UPPER(emp.apellido),UPPER(emp.nombres)
                        from expedientes_ext_desis segui
                        inner join rel_expedientes_emprendedores relacion on relacion.id_expediente = segui.id_expediente
                        inner join emprendedores emp on relacion.id_emprendedor = emp.id_emprendedor
                        where segui.id_expediente = $id_proyecto and emp.id_responsabilidad = 1");
                        $registro_proyecto =  mysqli_fetch_array($tabla_proyecto, MYSQLI_BOTH);
                        $registro[$i] = $registro_proyecto[0].', '.$registro_proyecto[1];
                    }?>
                    <td class="text-center"><?php echo $registro[$i]?></td>
                <?php
                }
                ?>
            </tr>
        <?php
        }
        ?>
    </tbody>
    </table>

<?php    mysqli_close($con);
