<?php
session_start();

require_once("../accesorios/accesos_bd.php");

$con=conectar();

// DESACTIVAR EL CURSO

if(isset($_POST['id']) and $_POST['elimina']){

    $id = $_POST['id'];

    mysqli_query($con, "UPDATE formacion_cursos SET activo = 0 WHERE id = $id");

}

$tabla_registros = mysqli_query($con, "SELECT t1.*, t2.nombre AS ciudad
    FROM formacion_cursos t1 
    INNER JOIN localidades t2 ON t1.id_ciudad = t2.id
    ORDER BY fechaRealizacion DESC");

?>

<script type="text/javascript">

    $(document).ready(function() {
        
        var table = $('#registro').DataTable({ 
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
    <table id="registros" class="table table-hover table-striped text-center" style="font-size: small">
        <thead>
        <tr>
            <th class="text-left">Nombre curso</th>
            <th>Fecha realización</th>
            <th>Ciudad</th>
            <th>Referente</th>
            <th>Capacitador</th>
            <th>Asistentes</th>
            <th>Editar</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while($fila = mysqli_fetch_array($tabla_registros)){
        ?>
            <tr>
                <td class="text-left"><?php echo $fila['nombre'] ?> </td>
                <td><?php echo date('d/m/Y', strtotime($fila['fechaRealizacion'])) ?></td>
                <td><?php echo $fila['ciudad'] ?></td>
                <td class="text-left"><?php echo $fila['referente'] ?></td>
                <td class="text-left"><?php echo $fila['capacitador'] ?></td>
                <td><?php echo $fila['asistentes'] ?></td>
                <td>
                    <a href="editar_registro.php?id=<?php echo $fila['id'] ?>">
                        <i class="fas fa-pencil-alt"></i>
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
