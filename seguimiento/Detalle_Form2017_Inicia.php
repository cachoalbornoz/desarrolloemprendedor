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
        mysqli_query($con, "DELETE FROM expedientes_ext_incia WHERE id_expediente = $id");
    }
}

?>

<script>

    $(document).ready(function() {

        var table = $('#proyectoinicia').DataTable({ 
            "lengthMenu"    : [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "dom"           : '<"wrapper"Brflit>',        
            "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
            "order"         : [[ 1, "asc" ]],
            "stateSave"     : true,
            "columnDefs"    : [{ orderable:    false   , targets: [0] }, ],
            "language"      : { "url": "../public/DataTables/spanish.json" }
        }); 
    })

    function borrar_inicia(){

        var aux = '' ;

        if (($("input[name*='sigueinicia']:checked").length)<=0) {
             alert("Seleccione un elemento por favor");
             return false;
        }else{
            if(confirm("Elimina los seleccionados ? ")){
            
                $("input[name*='sigueinicia']:checked").each(function() {
                    var valor = $(this).val();            
                    aux += valor + ";" ;  
                });

                var aux = aux.substring(0, aux.length-1); // LE QUITO EL ULTIMO PUNTO Y COMA

                $("#detalle_proyectos_inicia").load('Detalle_Form2017_Inicia.php', {cadena: aux})
            }
        }
    }
</script>

<div class="table-responsive">
    <table id="proyectoinicia" class="table table-bordered table-responsive" style=" font-size: smaller">
        <thead>
            <tr>
                <th class="text-center noExl">
                    <a href="#" onclick="borrar_inicia()">
                       <i class="fas fa-trash"></i>
                    </a>
                </th>
                <?php
                $cont=0;
                $tabla_relevamiento = mysqli_query($con, "SELECT exped.fecha_relevam as FechaReg,ini.*,segui.*
                    FROM expedientes_ext_inicia ini
                    INNER JOIN seguimiento_expedientes_ext exped on exped.id_expediente = ini.id_expediente
                    INNER JOIN expedientes_ext_sigue segui on segui.id_expediente = ini.id_expediente
                    GROUP BY ini.id_expediente
                    ORDER BY exped.fecha_relevam DESC");
                    
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
            $tabla_relevamiento = mysqli_query($con, "SELECT exped.fecha_relevam as registro,ini.*,segui.*
                FROM expedientes_ext_inicia ini
                INNER JOIN seguimiento_expedientes_ext exped on exped.id_expediente = ini.id_expediente
                INNER JOIN expedientes_ext_sigue segui on segui.id_expediente = ini.id_expediente
                GROUP BY ini.id_expediente
                ORDER BY exped.fecha_relevam desc");
            while($registro     = mysqli_fetch_array($tabla_relevamiento, MYSQLI_BOTH)){ ?>

            <tr>
                <td class="text-center">
                    <input type="checkbox" name="sigueinicia[]" value="<?php echo $registro[1]?>">
                </td>
                <?php
                for($i=0; $i< $cont ;$i++){

                    if($i==1){

                        $id_proyecto = $registro[$i];

                        $tabla_proyecto = mysqli_query($con, "SELECT UPPER(emp.apellido),UPPER(emp.nombres)
                        FROM expedientes_ext_inicia segui
                        INNER JOIN rel_expedientes_emprendedores relacion on relacion.id_expediente = segui.id_expediente
                        INNER JOIN emprendedores emp on relacion.id_emprendedor = emp.id_emprendedor
                        WHERE segui.id_expediente = $id_proyecto and emp.id_responsabilidad = 1");
                        $registro_proyecto =  mysqli_fetch_array($tabla_proyecto, MYSQLI_BOTH);
                        $registro[$i] = $registro_proyecto[0].', '.$registro_proyecto[1];
                    }
                    if($i==9){
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
