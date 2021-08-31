<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require_once('../accesorios/accesos_bd.php');

$con=conectar();

if(isset($_POST['cadena'])){

    $cadena = explode(';', $_POST['cadena']);

    foreach ($cadena as $id) {
        mysqli_query($con, "DELETE FROM expedientes_ext_desis WHERE id_expediente = $id");
    }
}

?>

<script>

    $(document).ready(function() {

        var table = $('#proyectodesis').DataTable({ 
            "lengthMenu"    : [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "dom"           : '<"wrapper"Brflit>',        
            "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
            "order"         : [[ 1, "asc" ]],
            "stateSave"     : true,
            "columnDefs"    : [{ orderable:    false   , targets: [0] }, ],
            "language"      : { "url": "../public/DataTables/spanish.json" }
        }); 
    })


    function borrardesis(){

        var aux = '' ;

        if (($("input[name*='siguedesis']:checked").length)<=0) {
            alert("Seleccione un elemento por favor");
            return false;

         }else{

            if(confirm("Elimina los seleccionados ? ")){
            
                $("input[name*='siguedesis']:checked").each(function() {
                    var valor = $(this).val();            
                    aux += valor + ";" ;  
                });

                var aux = aux.substring(0, aux.length-1); // LE QUITO EL ULTIMO PUNTO Y COMA

                $("#detalle_proyectos_desis").load('Detalle_Form2017_Desis.php', {cadena: aux})
            }
        }
    }
</script>

<div class="table-responsive">
    <table id="proyectodesis" class="table table-bordered table-responsive" style=" font-size: smaller">
    <thead>
        <tr>
            <th class="text-center noExl">
                <a href="#" onclick="borrardesis()">
                    <i class="fas fa-trash"></i>
                </a>
            </th>
            <?php
            $cont = 0;
            $tabla_relevamiento = mysqli_query($con, "SELECT exped.fecha_relevam as FechaReg, desis.*
                FROM expedientes_ext_desis desis
                INNER JOIN seguimiento_expedientes_ext exped on exped.id_expediente = desis.id_expediente
                ORDER BY exped.fecha_relevam desc");
                
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
        $tabla_relevamiento = mysqli_query($con, "SELECT exped.fecha_relevam as Fecha_registro,desis.*
                FROM expedientes_ext_desis desis
                INNER JOIN seguimiento_expedientes_ext exped on exped.id_expediente = desis.id_expediente
                ORDER BY exped.fecha_relevam desc");
        while($registro =  mysqli_fetch_array($tabla_relevamiento, MYSQLI_BOTH)){ ?>

            <tr>
                <td class="text-center">
                    <input type="checkbox" name="siguedesis[]" value="<?php echo $registro[1]?>">
                </td>
                <?php
                for($i=0; $i<$cont;$i++){

                    if($i==1){

                        $id_proyecto = $registro[$i];

                        $tabla_proyecto = mysqli_query($con, "SELECT UPPER(emp.apellido),UPPER(emp.nombres)
                        FROM expedientes_ext_desis segui
                        INNER JOIN rel_expedientes_emprendedores relacion on relacion.id_expediente = segui.id_expediente
                        INNER JOIN emprendedores emp on relacion.id_emprendedor = emp.id_emprendedor
                        WHERE segui.id_expediente = $id_proyecto and emp.id_responsabilidad = 1");
                        
                        $registro_proyecto =  mysqli_fetch_array($tabla_proyecto);
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
</div>
<?php    mysqli_close($con);
