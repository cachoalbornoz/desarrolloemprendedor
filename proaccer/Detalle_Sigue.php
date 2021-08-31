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
        mysqli_query($con, "delete from proaccer_sigue where id_expediente = $id");
    }
}

?>

<script>

    $('#proyectosiguen').tableExport({
    	formats: ["xlsx","txt", "csv", "xls"], //Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
    	position: 'top',  // Posicion que se muestran los botones puedes ser: (top, bottom)
    	bootstrap: false,//Usar lo estilos de css de bootstrap para los botones (true, false)
    	fileName: "ProySiguen<?php echo date('dmY',time())?>",    //Nombre del archivo
    });


    function borrar_sigue(){

        if (($("input[name*='siguesigue']:checked").length)<=0) {
             alert("Seleccione un elemento por favor");
             return false;
         }else{
             if(confirm("Elimina los seleccionados ? ")){
             var cadena = '';
                 $("input[name*='siguesigue']:checked").each(function() {
                     cadena += $(this).val() + ', ';
                 });
                 $("#detalle_proyectos_sigue").load('Detalle_Form2017_Sigue.php', {cadena: cadena})
             }
         }
    }
</script>

<div class="table table-responsive">
    <table id="proyectosiguen" class=" table-bordered" style=" font-size: smaller">
        <thead>
            <tr>
                <?php
                $cont=0;
                $tabla_relevamiento = mysqli_query($con, "select * from proaccer_sigue");
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
            $tabla_relevamiento = mysqli_query($con, "select * from proaccer_sigue");

            while($registro =  mysqli_fetch_array($tabla_relevamiento, MYSQLI_BOTH)){  ?>

            <tr>
                <?php
                for($i=0; $i<$cont;$i++){

                    if($i==1){

                        $id_proyecto = $registro['id_proyecto'];

                        $tabla_proyecto = mysqli_query($con, "select UPPER(sol.apellido),UPPER(sol.nombres)
                        from proaccer_sigue segui
                        inner join rel_proyectos_solicitantes relacion on relacion.id_proyecto = segui.id_proyecto
                        inner join solicitantes sol on relacion.id_solicitante = sol.id_solicitante
                        where segui.id_proyecto = $id_proyecto and sol.id_responsabilidad = 1");

                        $registro_proyecto =  mysqli_fetch_array($tabla_proyecto, MYSQLI_BOTH);
                        $registro[$i] = $registro_proyecto[0].', '.$registro_proyecto[1];
                    }
                    if($i==39){
                        switch ($registro[$i]) {
                            case 1:
                                $registro[$i] = 'Agro';
                                break;
                            case 2:
                                $registro[$i] = 'Ind';
                                break;
                            case 3:
                                $registro[$i] = 'Servicios';
                                break;
                        }
                    }

                ?>
                <td class="rowspanning text-center">
                    <div style="max-width: 15em; max-height: 5em">
                        <?php echo $registro[$i] ?>
                    </div>
                </td>
                <?php
                }
                ?>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<?php    mysqli_close($con);
