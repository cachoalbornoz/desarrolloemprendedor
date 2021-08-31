<?php
session_start();

require_once("../accesorios/accesos_bd.php");

$con=conectar();

// DESACTIVAR EL CURSO

if(isset($_POST['id']) and $_POST['elimina']){

    $id = $_POST['id'];

    mysqli_query($con, "UPDATE formacion_cursos SET activo = 0 WHERE id = $id");

}

$tabla_cursos = mysqli_query($con, "SELECT t1.*, t2.nombre AS ciudad 
    FROM formacion_cursos t1
    INNER JOIN localidades t2 ON t1.id_ciudad = t2.id
    ORDER BY t1.nombre asc");

?>

<script type="text/javascript">

    $(document).ready(function() {
        
        var table = $('#cursos').DataTable({ 
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

<div class="table-responsive">
    <table id="cursos" class="table table-hover table-striped text-center" style="font-size: small">
        <thead>
        <tr>
            <th>Nombre curso</th>
            <th>Interesados</th>
            <th>Fecha realización</th>
            <th>Ciudad</th>
            <th>Lugar</th>
            <th>Hora</th>
            <th>Activo</th>
            <th>Editar</th>
            <th>Borrar</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while($fila = mysqli_fetch_array($tabla_cursos)){
        ?>
            <tr>
                <td class=" text-left"><?php echo $fila['nombre'] ?> </td>
                <td>
                <?php

                    $id_curso = $fila['id'];

                    $query      = mysqli_query($con, "SELECT count(id) as total
                        FROM rel_solicitante_curso 
                        WHERE id_curso = $id_curso") or die('Revisar cursos');
                    $registro   = mysqli_fetch_array($query);
                    $total      = $registro['total'];
                ?>
                    <a href="padron_interesados_c.php?id_curso=<?php echo $id_curso?>"> 
                        <span class="badge badge-info"> <?php echo $total?> </span>
                    </a>
                </td>    
                <td><?php echo date('d/m/Y', strtotime($fila['fechaRealizacion'])) ?></td>
                <td class=" text-left"><?php echo $fila['ciudad'] ?></td>
                <td class=" text-left"><?php echo $fila['lugar'] ?></td>
                <td><?php echo $fila['hora'] ?></td>
                <td class="text-green"><?php if($fila['activo'] == 1){echo "S";} ?></td>
                <td>
                    <a href="editar_curso.php?id=<?php echo $fila['id'] ?>">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                </td>
                <td>
                    <?php 
                        if($fila['activo'] == 1){ ?>
                            <a href='javascript:void(0)' onClick="eliminar_curso(<?php echo $fila['id'] ?>)">
                                <i class="fas fa-trash text-danger"></i>
                            </a>
                        <?php
                        } 
                    ?>
                </td>
            </tr>
		<?php
        }

        mysqli_close($con);
        ?>
        </tbody>
    </table>
</div>