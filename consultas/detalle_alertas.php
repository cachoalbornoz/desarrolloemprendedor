<?php
    session_start();
    require("../accesorios/accesos_bd.php");
    $con=conectar();
?>


<script type="text/javascript">

    var table = $('#alertas').DataTable({ 
        "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        "dom"           : '<"wrapper"Brflit>',        
        "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
        "order"         : [[ 1, "asc" ]],
        "stateSave"     : true,
        "columnDefs"    : [ ],
        "language"      : { "url": "../public/DataTables/spanish.json" }
    });

</script>


<div class="table table-responsive">
    <table id="alertas" class="table table-hover" style="font-size: small">
    <thead>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>Orden</td>
        <td>Apellido</td>
        <td>Nombres</td>
        <td>Tel fijo</td>
        <td>Movil</td>
        <td>Localidad</td>
    </tr>
    </thead>
        <tbody>
        <?php
        $contador = 1;

            // PREPARAR FECHA ENTRE 6 MESES ANTERIORES
            $fecha_actual = date('Y-m-d',strtotime('-6 month'));
            $fecha = explode('-',$fecha_actual);
            $mes = $fecha[1];
            $año = $fecha[0];
            $fecha = $mes."/"."01"."/".$año;
            $fecha_ini = date('Y-m-d',strtotime($fecha));

            $fecha = date('Y-m-d',strtotime("$fecha_ini + ". 6 ." months"));
            $fecha_fin = date('Y-m-d',strtotime("$fecha - ". 1 ." days"));
            //

            $anio = '= '.$_POST['ano'];

            if($_POST['tipo'] == 1){// EXPEDIENTES CON ESTADO REGULAR
                $estado = 1;
                $tabla_expedientes = mysqli_query($con, "select exped.id_expediente,emp.apellido, emp.nombres, emp.cod_area, emp.telefono, emp.celular, loc.nombre
                from expedientes as exped, rel_expedientes_emprendedores as rel_exped, emprendedores as emp, tipo_rubro_productivos as rp,
                localidades as loc where exped.id_expediente = rel_exped.id_expediente and rel_exped.id_emprendedor = emp.id_emprendedor and exped.id_rubro = rp.id_rubro
                and exped.id_localidad = loc.id and emp.id_responsabilidad = 1 and exped.estado = $estado and year(exped.fecha_otorgamiento) $anio and rp.tipo = 0
                order by emp.apellido, emp.nombres asc");
        }else{// EXPEDIENTES CON ESTADO PRORROGA
            $estado = 6;
            if($_POST['ano'] == date('Y',time())){
                $tabla_expedientes = mysqli_query($con, "select exped.id_expediente,emp.apellido, emp.nombres, emp.cod_area, emp.telefono, emp.celular, loc.nombre
                from expedientes as exped, rel_expedientes_emprendedores as rel_exped, emprendedores as emp, tipo_rubro_productivos as rp,
                localidades as loc where exped.id_expediente = rel_exped.id_expediente and rel_exped.id_emprendedor = emp.id_emprendedor and exped.id_rubro = rp.id_rubro
                and exped.id_localidad = loc.id and emp.id_responsabilidad = 1 and exped.estado = $estado and exped.fecha_otorgamiento <= $fecha_fin and rp.tipo = 0
                order by emp.apellido, emp.nombres asc");
            }else{
                $anio = '= '.$_POST['ano'];

                $tabla_expedientes = mysqli_query($con, "select exped.id_expediente,emp.apellido, emp.nombres, emp.cod_area, emp.telefono, emp.celular, loc.nombre
                from expedientes as exped, rel_expedientes_emprendedores as rel_exped, emprendedores as emp, tipo_rubro_productivos as rp,
                localidades as loc where exped.id_expediente = rel_exped.id_expediente and rel_exped.id_emprendedor = emp.id_emprendedor and exped.id_rubro = rp.id_rubro
                and exped.id_localidad = loc.id and emp.id_responsabilidad = 1 and exped.estado = $estado and year(exped.fecha_otorgamiento) $anio and rp.tipo = 0
                order by emp.apellido, emp.nombres asc");
            }
        }

        while($fila = mysqli_fetch_array($tabla_expedientes)){
            $id_expediente = $fila[0] ;

            $mostrar = true;

            if($estado == 6){
                $fecha_actual = date('Y-m-d',time());
                $tabla_moroso = mysqli_query($con,"select min(fecha_vcto) from expedientes_detalle_cuotas where id_expediente = $id_expediente and estado = 0 ");
                $fila_moroso = mysqli_fetch_array($tabla_moroso);
                if($fecha_actual < $fila_moroso[0]){
                    $mostrar = false;
                }
            }

            if($mostrar){
                ?>
                <tr>
                    <td><?php echo $contador ?></td>
                    <td align="left"><a href='../expedientes/sesion_usuario_expediente.php?id=<?php echo $fila[0] ?>' title='Ver expediente <?php echo $fila[0] ?>'><?php echo $fila[1] ?></a></td>
                    <td align="left"><?php echo $fila[2] ?></td>
                    <td>(<?php echo $fila[3] ?>) <?php echo $fila[4] ?></td>
                    <td><?php echo $fila[5] ?></td>
                    <td align="left"><?php echo $fila[6] ?></td>
                </tr>
                <?php
                $contador ++ ;
            }
        }
        ?>
        </tbody>
    </table>
</div>
<?php mysqli_close($con);
