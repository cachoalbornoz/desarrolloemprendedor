<?php
session_start();

require_once("../accesorios/accesos_bd.php");

$con=conectar();


$id_curso   = $_POST['id_curso'];

$registro       = mysqli_query($con, "SELECT t2.*, t3.nombre AS ciudad, t4.nombre AS dpto
    FROM rel_solicitante_curso t1
    INNER JOIN solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
    INNER JOIN localidades t3 ON t2.id_ciudad = t3.id
    INNER JOIN departamentos t4 ON t3.departamento_id = t4.id
    WHERE id_curso = $id_curso") or die('Revisar cursos');

?>

<script type="text/javascript">

    $(document).ready(function() {
        
        var table = $('#interesados').DataTable({ 
        "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        "dom"           : '<"wrapper"Brflit>',        
        "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
        "order"         : [[ 1, "asc" ]],
        "stateSave"     : true,
        "columnDefs"    : [{}, ],
        "language"      : { "url": "../public/DataTables/spanish.json" },
        "columnDefs"    : [
                { orderable:    false   , targets: [0, 2, 3, 4] },
                { className: 'text-center', targets: [0, 3] },
                { className: 'text-primary', targets: [1, 2] },
            ],
        });
    });   

</script>

<div class="table-responsive">
    <table id="interesados" class="table table-hover table-striped" style="font-size: small">
        <thead>
        <tr>
            <th>#</th>
            <th>Apellido</th>
            <th>Nombres</th>
            <th>Dni</th>
            <th>E-mail</th>
            <th>Celular</th>
            <th>Telef</th>
            <th>Localidad</th>
            <th>Dpto</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $cont = 1;
        while($fila = mysqli_fetch_array($registro)){
        ?>
            <tr>
                <td><?php echo $cont ?></td>
                <td><?php echo $fila['apellido'] ?></td>
                <td><?php echo $fila['nombres'] ?></td>
                <td><?php echo $fila['dni'] ?></td>
                <td><?php echo $fila['email'] ?></td>
                <td><?php echo $fila['celular'] ?></td>
                <td><?php echo $fila['telefono'] ?></td>
                <td><?php echo $fila['ciudad'] ?></td>
                <td><?php echo $fila['dpto'] ?></td>
            </tr>
		<?php
        }
        $cont++;
        mysqli_close($con);
        ?>
        </tbody>
    </table>
</div>

