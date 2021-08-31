<?php
session_start();

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$tabla_formaciones = mysqli_query($con, "SELECT * FROM tipo_formacion ORDER BY formacion asc");

?>

<script type="text/javascript">

    $(document).ready(function() {
        
        var table = $('#formaciones').DataTable({ 
        "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        "dom"           : '<"wrapper"Brflit>',        
        "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
        "order"         : [[2, "desc" ]],
        "stateSave"     : true,
        "columnDefs"    : [{}, ],
        "language"      : { "url": "../public/DataTables/spanish.json" },
        "columnDefs"    : [
                { orderable:    false   , targets: [3,4] },
                { className: 'text-center', targets: [1, 2, 3, 4] },
                { className: 'text-primary', targets: [1] },
            ],
        });
    });   

</script>

<div class="table-responsive">
    <table id="formaciones" class="table table-hover table-striped" style="font-size: small">
        <thead>
        <tr>
            <th>Formación</th>
            <th>Limpiar</th>
            <th>Interesados</th>
            <th>Activo</th>
            <th>Editar</th>
            <th>Borrar</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while($fila = mysqli_fetch_array($tabla_formaciones)){
        ?>
            <tr>
                <td class=" text-left"><?php echo $fila['formacion']; ?></td>
                <td>
                    <a href='javascript:void(0)' onClick="limpiar_formacion(<?php echo $fila['id'] ?>)">
                        <i class="fas fa-broom"></i>
                    </a>
                </td>
                <td>
                <?php

                    $id_formacion = $fila['id'];

                    $query      = mysqli_query($con, "SELECT count(id) as total
                        FROM rel_solicitante_formacion 
                        WHERE id_formacion = $id_formacion") or die('Revisar formaciones');
                    $registro   = mysqli_fetch_array($query);
                    $total      = $registro['total'];
                ?>
                    <a href="padron_interesados.php?id_formacion=<?php echo $id_formacion?>"> 
                        <span class="badge badge-info"> <?php echo $total?> </span>
                    </a>
                </td>
                <td <?php if($fila['activo'] == 1){echo "class='text-danger'";}?>>
                    <?php if($fila['activo'] == 1){echo "S";}else{echo '-';} ?></td>
                <td>
                    <a href="editar_formacion.php?id=<?php echo $fila['id'] ?>">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                </td>
                <td>
                    <a href='javascript:void(0)' onClick="eliminar_formacion(<?php echo $fila['id'] ?>)">
                        <i class="fas fa-trash text-danger"></i>
                    </a>
                </td>
            </tr>
		<?php
        }

        mysqli_close($con);
        ?>
        </tbody>
    </table>
</div>


<script type="text/javascript">

function limpiar_formacion(id){

    $.ajax({
        type    : "POST",
        url     : 'limpiar_formacion.php',
        dataType: 'json',
        data    : {id: id},
        success: function(response) {
        },
    })

    $("#detalle_formacion").load('detalle_formacion.php');

};

function eliminar_formacion(id){

    if(confirm('Seguro que desea eliminar ')){

        $.ajax({
            type    : "POST",
            url     : 'eliminar_formacion.php',
            dataType: 'json',
            data    : {id: id},

            success: function(response) {
            },
        })

        $("#detalle_formacion").load('detalle_formacion.php');

    }else {
        return false;
    }
};

</script>
