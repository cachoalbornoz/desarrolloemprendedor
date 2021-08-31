<?php
session_start();

require_once("../accesorios/accesos_bd.php");

$con=conectar();


$id_formacion   = $_POST['id_formacion'];

$registro       = mysqli_query($con, "SELECT t2.*, t3.nombre AS ciudad, t4.nombre AS dpto
    FROM rel_solicitante_formacion t1
    INNER JOIN solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
    INNER JOIN localidades t3 ON t2.id_ciudad = t3.id
    INNER JOIN departamentos t4 ON t3.departamento_id = t4.id
    WHERE id_formacion = $id_formacion") or die('Revisar formaciones');

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
                { orderable:    false   , targets: [0] },
                { className: 'text-center', targets: [0, 2, 3, 4] },
                { className: 'text-primary', targets: [1] },
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
                <th><?php echo $cont ?></th>
                <th><?php echo $fila['apellido'] ?></th>
                <th><?php echo $fila['nombres'] ?></th>
                <th><?php echo $fila['email'] ?></th>
                <th><?php echo $fila['celular'] ?></th>
                <th><?php echo $fila['telefono'] ?></th>
                <th><?php echo $fila['ciudad'] ?></th>
                <th><?php echo $fila['dpto'] ?></th>
            </tr>
		<?php
        }
        $cont++;
        mysqli_close($con);
        ?>
        </tbody>
    </table>
</div>

