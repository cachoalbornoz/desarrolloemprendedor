<?php

require_once ("../accesorios/accesos_bd.php");

$con=conectar();

?>

<script type="text/javascript">

$(document).ready(function() {

    var table = $('#expedientes').DataTable({ 
        "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        "dom"           : '<"wrapper"Brflit>',        
        "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
        "order"         : [[ 1, "asc" ]],
        "stateSave"     : true,
        "columnDefs"    : [{ }, ],
        "language"      : { "url": "../public/DataTables/spanish.json" }
    }); 
})

</script>

<div class="table-responsive">
    <table id="rexpedientes" class="table table-hover table-striped" style="font-size: small">
    <thead>
    <tr>
        <th>Titular</th>
        <th>Localidad</th>
        <th>Tipo</th>
        <th>Rubro</th>
        <th>Funciona</th>
        <th>Comercializa</th>
        <th>Cantidades</th>
        <th>Mercado</th>
        <th>Comprador</th>
        <th>PorqueNoRegistraEmp</th>
        <th>Capacitacion</th>
        <th>FormaJuridica</th>
    </tr>
    </thead>

        <tbody>
            <?php
            $seleccion = "select UPPER(emp.apellido),UPPER(emp.nombres),rubgen.detalle,rub.rubro,forma,segui.*,usu.nombre_usuario, loc.nombre
            from seguimiento_expedientes segui
            inner join rel_expedientes_emprendedores relacion on relacion.id_expediente = segui.id_expediente
            inner join emprendedores emp on relacion.id_emprendedor = emp.id_emprendedor
            inner join localidades loc on loc.id = emp.id_ciudad
            inner join expedientes exped on relacion.id_expediente = exped.id_expediente
            inner join tipo_rubro_productivos rub on exped.id_rubro = rub.id_rubro
            inner join rubros_generales rubgen on rub.id_rubro_general = rubgen.id
            inner join usuarios usu on segui.id_usuario = usu.id_usuario
            left join tipo_forma_juridica forma on segui.id_forma_juridica = forma.id_forma
            where emp.id_responsabilidad = 1
            order by emp.apellido, emp.nombres";

            $_SESSION['consulta']=$seleccion;

            $tabla_autogestionados = mysqli_query($con, $seleccion);

            while($fila = mysqli_fetch_array($tabla_autogestionados)){
            ?>
            <tr>
                <td><?php echo $fila[0].', '.$fila[1] ?></td>
                <td><?php echo $fila[33] ?></td>
                <td><?php echo $fila[2] ?></td>
                <td><?php echo $fila[3] ?></td>
                <td style="text-align:center"><?php if ($fila[11] == 1){echo "S";}else{if ($fila[11] == 0){echo "N";}}?></td>
                <?php
                if ($fila[11] == 1) // Si continua muestra todos los datos.
                {?>
                    <td><?php echo $fila[14] ?></td>
                    <td><?php echo $fila[15] ?></td>
                    <td><?php echo $fila[16] ?></td>
                    <td><?php echo $fila[17] ?></td>
                    <td><?php echo $fila[27] ?></td>
                    <td><?php echo $fila[28] ?></td>
                    <td><?php echo $fila[4] ?></td>

                <?php
                }else{
                ?>
                    <td><?php echo $fila[12]?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
<?php
mysqli_close($con);
