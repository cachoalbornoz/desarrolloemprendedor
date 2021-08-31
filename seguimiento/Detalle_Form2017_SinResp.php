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
        mysqli_query($con, "DELETE FROM seguimiento_expedientes_ext WHERE id_seguimiento = $id");
    }
}

?>

<script>

    $(document).ready(function() {

        var table = $('#proyectosresp').DataTable({ 
            "lengthMenu"    : [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "dom"           : '<"wrapper"Brflit>',        
            "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
            "order"         : [[ 1, "asc" ]],
            "stateSave"     : true,
            "columnDefs"    : [{ orderable:    false   , targets: [0] }, ],
            "language"      : { "url": "../public/DataTables/spanish.json" }
        }); 
    })

</script>

<table id="proyectosresp" class="table table-bordered" style=" font-size: smaller">
    <thead>
        <tr>
            <th class="text-center">
                <a href="#" onclick="borrarsr()">
                    <i class="fas fa-trash"></i>
                </a>                
            </th>
            <th>FechaReg</th>
            <th>Expediente</th>
            <th>Latitud</th>
            <th>Longitud</th>
            <th>Relevador</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $tabla_relevamiento = mysqli_query($con, "SELECT UPPER(emp.apellido),UPPER(emp.nombres), segui.latitud, segui.longitud, usu.nombre_usuario, segui.fecha_relevam, segui.id_seguimiento
        FROM seguimiento_expedientes_ext segui
        INNER JOIN rel_expedientes_emprendedores relacion on relacion.id_expediente = segui.id_expediente
        INNER JOIN emprendedores emp on relacion.id_emprendedor = emp.id_emprendedor
        INNER JOIN usuarios usu on usu.id_usuario = segui.id_usuario
        WHERE emp.id_responsabilidad = 1 AND segui.estado = 4 
        GROUP BY segui.id_seguimiento
        ORDER BY segui.fecha_relevam desc");

        while($registro =  mysqli_fetch_array($tabla_relevamiento)){?>
            <tr>
                <td class="text-center">
                    <input type="checkbox" name="siguesr[]" value="<?php echo $registro[6]?>">
                </td>
                <td><?php echo $registro[5]?></td>
                <td><?php echo $registro[0].', '.$registro[1]?></td>
                <td><?php echo $registro[2]?></td>
                <td><?php echo $registro[3]?></td>
                <td><?php echo $registro[4]?></td>
            </tr>
            <?php
        }?>
    </tbody>
</table>

<script type="text/javascript">

    function borrarsr(){

        var aux = '' ;

        if (($("input[name*='siguesr']:checked").length)<=0) {
            alert("Seleccione un elemento por favor");
            return false;

         }else{
            if(confirm("Elimina los seleccionados ? ")){
                
                $("input[name*='siguesr']:checked").each(function() {
                    var valor = $(this).val();            
                    aux += valor + ";" ;  
                });

                var aux = aux.substring(0, aux.length-1); // LE QUITO EL ULTIMO PUNTO Y COMA

                $("#detalle_proyectos_sresp").load('Detalle_Form2017_SinResp.php', {cadena: aux});

            }
        }
    }

</script>


<?php    mysqli_close($con);
