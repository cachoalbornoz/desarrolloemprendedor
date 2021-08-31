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
        
        mysqli_query($con, "DELETE FROM expedientes_ext_sigue WHERE id_expediente = $id");

    }
}

?>

<script>

    $(document).ready(function() {

        var table = $('#proyectos').DataTable({ 
            "lengthMenu"    : [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "dom"           : '<"wrapper"Brflit>',        
            "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
            "order"         : [[ 1, "asc" ]],
            "stateSave"     : true,
            "columnDefs"    : [{ orderable:    false   , targets: [0] }, ],
            "language"      : { "url": "../public/DataTables/spanish.json" }
        }); 
    })


    function borrar_sigue(){

        var aux = '' ;

        if (($("input[name*='siguesigue']:checked").length)<=0) {
             alert("Seleccione un elemento por favor");
             return false;
         }else{
             if(confirm("Elimina los seleccionados ? ")){
                
                $("input[name*='siguesigue']:checked").each(function() {
                    
                    var valor = $(this).val();            
                    aux += valor + ";" ;  
                });

                var aux = aux.substring(0, aux.length-1); // LE QUITO EL ULTIMO PUNTO Y COMA

                $("#detalle_proyectos_sigue").load('Detalle_Form2017_Sigue.php', {cadena: aux})
             }
         }
    }
</script>


<div class="table-responsive">
    <table class="table table-striped table-hover table-condensed table-sm" style="font-size: small" id="proyectos">
        <thead>
            <tr>
                <th class="noExl">
                    <a href="#" onclick="borrar_sigue()">
                        <i class="fas fa-trash"></i>
                    </a>
                </th>
                <?php
                $cont=0;
                $tabla_relevamiento = mysqli_query($con, "SELECT exped.fecha_relevam AS FechaReg, exped.latitud, exped.longitud, expedi.id_rubro, empren.fecha_nac, sigue.*
                FROM expedientes_ext_sigue sigue
                INNER JOIN expedientes expedi ON expedi.id_expediente = sigue.id_expediente
                INNER JOIN rel_expedientes_emprendedores rel ON rel.id_expediente = expedi.id_expediente
                INNER JOIN emprendedores empren ON empren.id_emprendedor = rel.id_emprendedor
                INNER JOIN seguimiento_expedientes_ext exped ON exped.id_expediente = sigue.id_expediente
                WHERE sigue.id_expediente NOT IN (
                SELECT id_expediente
                FROM expedientes_ext_inicia) AND empren.id_responsabilidad = 1
                ORDER BY exped.fecha_relevam DESC");
                while($registro = mysqli_fetch_field($tabla_relevamiento)){

                    if($cont == 5){
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
            $tabla_relevamiento = mysqli_query($con, "SELECT exped.fecha_relevam AS FechaReg, exped.latitud, exped.longitud, expedi.id_rubro, year(empren.fecha_nac), sigue.*
            FROM expedientes_ext_sigue sigue
            INNER JOIN expedientes expedi ON expedi.id_expediente = sigue.id_expediente
            INNER JOIN rel_expedientes_emprendedores rel ON rel.id_expediente = expedi.id_expediente
            INNER JOIN emprendedores empren ON empren.id_emprendedor = rel.id_emprendedor
            INNER JOIN seguimiento_expedientes_ext exped ON exped.id_expediente = sigue.id_expediente
            WHERE sigue.id_expediente NOT IN (
            SELECT id_expediente
            FROM expedientes_ext_inicia) AND empren.id_responsabilidad = 1
            ORDER BY exped.fecha_relevam DESC");

            while($registro =  mysqli_fetch_array($tabla_relevamiento, MYSQLI_BOTH)){  ?>

            <tr>
                <td class=" text-center">
                    <input type="checkbox" name="siguesigue[]" value="<?php echo $registro[1]?>">
                </td>
                <?php
                for($i=0; $i<$cont;$i++){

                    if($i==5){

                        $id_proyecto = $registro['id_expediente'];

                        $tabla_proyecto = mysqli_query($con, "SELECT UPPER(emp.apellido),UPPER(emp.nombres)
                        FROM expedientes_ext_sigue segui
                        INNER JOIN rel_expedientes_emprendedores relacion on relacion.id_expediente = segui.id_expediente
                        INNER JOIN emprendedores emp on relacion.id_emprendedor = emp.id_emprendedor
                        WHERE segui.id_expediente = $id_proyecto and emp.id_responsabilidad = 1");
                        
                        $registro_proyecto =  mysqli_fetch_array($tabla_proyecto);
                        $registro[$i] = $registro_proyecto[0].', '.$registro_proyecto[1];
                    }

                    if($i==6){
                        switch ($registro[$i]) {
                            case 1:
                                $registro[$i] = 'Agro';
                                break;
                            case 2:
                                $registro[$i] = 'Ind';
                                break;
                            case 3:
                                $registro[$i] = 'Serv';
                                break;
                        }
                    }
                    

                    ?>
                    <td>
                        <?php echo $registro[$i] ?>                        
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
