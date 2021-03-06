<?php
    require('../accesorios/admin-superior.php');
    require_once('../accesorios/accesos_bd.php');
    $con=conectar();
?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class=" col-xs-12 col-sm-12 col-lg-12">
                NOTIFICACIONES
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table table-responsive">
            <table class="table table-hover" id="notificaciones" style="font-size: small">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Apellido</th>
                    <th>Nombres</th>
                    <th>Postal</th>
                    <th>Se envió</th>
                    <th>Monto</th>
                    <th>(Resp.) Notificar</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $tabla_morosos = mysqli_query($con, "SELECT exped.id_expediente,emp.apellido,emp.nombres from expedientes as exped, rel_expedientes_emprendedores as rel_exped, emprendedores as emp
            where exped.id_expediente = rel_exped.id_expediente and rel_exped.id_emprendedor = emp.id_emprendedor and exped.estado = 2
            and emp.id_responsabilidad = 1 order by emp.apellido, emp.nombres asc");
            while($fila_morosos = mysqli_fetch_array($tabla_morosos)){ // CONSULTA EXPEDIENTES MOROSOS

            $id_expediente = $fila_morosos[0];

            $tabla_ubicaciones = mysqli_query($con,"SELECT id_tipo_ubicacion from ubicaciones as ubi, rel_expedientes_ubicacion as rel_ubi
            where ubi.id_ubicacion = rel_ubi.id_ubicacion and rel_ubi.id_expediente = $id_expediente order by fecha desc limit 1");
            $fila_ubicaciones = mysqli_fetch_array($tabla_ubicaciones);

            if($fila_ubicaciones[0] == 1){	// CONSULTA EN DONDE ESTA EL EXPEDIENTE, SI ES MOROSO Y EXPEDIENTE ESTA EN JOVENES EMPRENDEDORES CONTINUA.

            $tabla_notificaciones = mysqli_query($con, "SELECT notif.fecha, emp.apellido, emp.nombres, tp.postal, tn.id_notificacion, tn.notificacion, notif.monto,
            datediff(date(now()),notif.fecha) as dias, exped.id_expediente
            FROM expedientes_notificaciones as notif, emprendedores as emp, tipo_parentesco as pare, tipo_notificacion as tn, tipo_postal as tp, expedientes as exped
            where notif.id_emprendedor = emp.id_emprendedor and notif.id_expediente = exped.id_expediente and notif.id_parentesco = pare.id_parentesco
            and notif.id_tipo_notificacion = tn.id_notificacion and notif.id_tipo_postal = tp.id_tipo_postal
            and exped.id_expediente = $id_expediente
            order by fecha desc limit 1");
            $fila_notificaciones = mysqli_fetch_array($tabla_notificaciones); // CONSULTA SI FUE NOTIFICADO

            $tabla_emprendedores= mysqli_query($con,"SELECT count(id_expediente) from rel_expedientes_emprendedores where id_expediente = $id_expediente");
            $fila_emprendedores = mysqli_fetch_array($tabla_emprendedores);
            ?>
            <tr>
                <td width="14%"><?php if(!is_null($fila_notificaciones[0])){echo fechanormal($fila_notificaciones[0]);} ?></td>
                <td width="14%"><a href='../expedientes/sesion_usuario_expediente.php?id=<?php echo $id_expediente ?>' title='Ver expediente <?php echo $id_expediente ?>'><? echo $fila_morosos[1] ?></a></td>
                <td width="14%"><?php echo substr($fila_morosos[2],0,15) ?></td>
                <td width="14%"><?php echo $fila_notificaciones[3] ?></td>
                <td width="14%"><?php echo $fila_notificaciones[5] ?></td>
                <td width="14%"><?php echo number_format($fila_notificaciones[6],2,',','.') ?></td>
                <td width="16%">(<?php echo $fila_emprendedores[0] ?>)
                <?php
                if($fila_notificaciones[4] == 2){
                    if($fila_notificaciones[7] > 15){
                        ?> <span style="background-color:#FFC"> <?php echo 'C/Interés'; ?></span><?php
                    }
                }else{
                    if($fila_notificaciones[4] == 3){
                        if($fila_notificaciones[7] > 15){
                          ?> <span style="background-color:#FC9"> <?php echo 'Fiscalía'; ?></span><?php
                        }
                    }
                }
                ?>
                </td>
            </tr>
            <?php
            }
            }
            ?>
            </tbody>
            </table>
        </div>
    </div>
</div>

<?php
    mysqli_close($con);
    require_once('../accesorios/admin-scripts.php'); ?>

<script type="text/javascript">

    $(document).ready(function() {

        var table = $('#notificaciones').DataTable({ 
        "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        "dom"           : '<"wrapper"Brflit>',        
        "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
        "order"         : [[ 1, "asc" ]],
        "stateSave"     : true,
        "columnDefs"    : [{}, ],
        "language"      : { "url": "../public/DataTables/spanish.json" }
        });
    }); 

</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>
