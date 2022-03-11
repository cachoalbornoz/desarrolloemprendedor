<?php
session_start();

require_once("../accesorios/accesos_bd.php");

$con=conectar();


$tabla_emprendedores = mysqli_query($con, "SELECT exped.id_expediente, exped.nro_proyecto, exped.fecha_otorgamiento, exped.saldo, e.id_emprendedor, e.apellido, e.nombres, e.dni, te.icono, e.id_responsabilidad
FROM emprendedores e
LEFT JOIN rel_expedientes_emprendedores rela ON rela.id_emprendedor = e.id_emprendedor
LEFT JOIN expedientes exped ON exped.id_expediente = rela.id_expediente
LEFT JOIN tipo_estado te ON te.id_estado = exped.estado
ORDER BY apellido, nombres");
?>

<script type="text/javascript">  

    $(document).ready(function() {

        var table = $('#emprendedores').DataTable({ 
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

<div class="table table-responsive">
    <table class="table table-hover table-striped" id="emprendedores">
    <thead>
    <tr>
        <th>#Expediente</th>
        <th>Año</th>
        <th>Estado</th>
        <th>Titular</th>
        <th>Nro Dni</th>
        <th>Saldo</th>
        <th>Titular</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while($fila = mysqli_fetch_array($tabla_emprendedores)){ 

        $id_expediente  = $fila['id_expediente'];
        $dni            = $fila['dni'];


        $tabla_proyecto = mysqli_query($con,
        "SELECT proy.id_proyecto FROM proyectos proy INNER JOIN rel_proyectos_solicitantes relps on relps.id_proyecto = proy.id_proyecto inner join solicitantes soli on soli.id_solicitante = relps.id_solicitante WHERE proy.id_estado = 25 AND soli.dni = $dni");
        $registro_proyecto = mysqli_fetch_array($tabla_proyecto);

        if($registro_proyecto){
            $id_proyecto = $registro_proyecto[0];
        }else{
            $id_proyecto = 0;
        }
    ?>   

        <tr>
            <td>
                <a href="../expedientes/sesion_usuario_expediente.php?id=<?php echo  $fila['id_expediente'] ?>&id_proyecto=<?php echo  $id_proyecto ?>">
                    <?php echo str_pad($fila['nro_proyecto'],4,'0',STR_PAD_LEFT) ?>
                </a>    
            </td>
            <td><?php echo date('Y', strtotime($fila['fecha_otorgamiento'])) ?></td>
            <td><?php echo $fila['icono'];         ?>  </td>
            <td> 
                <a href="emprendedor.php?id=<?php echo  $fila['id_emprendedor'] ?>">
                    <?php echo strtoupper($fila['apellido']); ?>, <?php echo strtoupper($fila['nombres']) ;    ?>
                </a>  
            </td>
            <td> <?php echo $fila['dni'];           ?>  </td>
            <td> <?php echo $fila['saldo'];         ?>  </td>
            <td> <?php if($fila['id_responsabilidad']==1){echo "Tit";}else{echo "Asoc";}           ?>  </td>
        </tr>
    
    <?php
    } 
    ?> 


            
    </tbody>
    </table>
</div>

<?php    mysqli_close($con);
