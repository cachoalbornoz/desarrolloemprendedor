<?php
session_start();

include("../accesorios/accesos_bd.php");
$con = conectar();

?>

<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#rproyectos').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            "dom": '<"wrapper"Brflit>',
            "buttons": ['copy', 'excel', 'pdf', 'colvis'],
            "order": [
                [1, "asc"]
            ],
            "stateSave": true,
            "columnDefs": [{}, ],
            "language": {
                "url": "../public/DataTables/spanish.json"
            }
        });


    });
</script>

<div class="table-responsive">
    <table id="rproyectos" class="table" style="font-size: small">
        <thead>
            <tr>
                <th>Titular</th>
                <th>Programa</th>
                <th>Ciudad</th>
                <th>Dpto</th>
                <th>Funciona</th>
                <th>Comercializa</th>
                <th>Cantidades</th>
                <th>Mercado</th>
                <th>Comprador</th>
                <th>Capacitacion</th>
                <th>FormaJuridica</th>
                <th>EstadoExped</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $contador = 1;

            $seleccion = "SELECT UPPER(soli.apellido) AS apellido, UPPER(soli.nombres) AS nombres, loc.nombre AS ciudad, dep.nombre AS departamento, segui.*,forma,soli.dni, segui.id_seguimiento, tp.abreviatura 
            FROM seguimiento_proyectos segui
            INNER JOIN solicitantes soli on segui.id_solicitante = soli.id_solicitante
            INNER JOIN localidades loc ON loc.id = soli.id_ciudad
            INNER JOIN departamentos dep ON dep.id = loc.departamento_id
            LEFT JOIN tipo_programas tp ON tp.id_programa = segui.id_programa 
            LEFT JOIN  tipo_forma_juridica fj on segui.id_forma_juridica = fj.id_forma
            ORDER BY apellido, nombres";

            $_SESSION['consulta'] = $seleccion;

            $tabla_autogestionados = mysqli_query($con, $seleccion);

            while ($fila = mysqli_fetch_array($tabla_autogestionados)) {

                $dni = $fila['dni'];

                $tabla_proyectos = mysqli_query($con, "SELECT te.icono
                FROM expedientes as exp, rel_expedientes_emprendedores as ree, emprendedores as emp, tipo_estado as te, tipo_rubro_productivos as rp
                WHERE exp.id_expediente = ree.id_expediente AND ree.id_emprendedor = emp.id_emprendedor AND emp.dni = $dni
                AND exp.estado = te.id_estado AND exp.id_rubro = rp.id_rubro
                ORDER BY emp.apellido,emp.nombres asc");

                $registro = mysqli_fetch_array($tabla_proyectos);

                ?>
                <tr>
                    <td>
                        <a href="editar_seguimiento.php?id=<?php echo $fila['id_seguimiento'] ?>">
                            <?php echo $fila['apellido'] . ', ' . $fila['nombres'] ?>
                        </a>
                    </td>
                    <td><?php echo $fila['abreviatura'] ?></td>
                    <td><?php echo $fila['ciudad'] ?></td>
                    <td><?php echo $fila['departamento'] ?></td>
                    <td class="text-center">
                        <?php if ($fila['funciona'] == 1) {
                            echo "S";
                        } else {
                            if ($fila[8] == 0) {
                                echo "N";
                            }
                        } ?>
                    </td>
                    <?php
                    if ($fila['funciona'] == 1) // Si continua muestra todos los datos.
                    { ?>
                        <td><?php echo strtoupper($fila[11]) ?></td>
                        <td><?php echo $fila['cantidadproducida'] ?></td>
                        <td><?php echo $fila['mercado'] ?></td>
                        <td><?php echo $fila['comprador'] ?></td>
                        <td><?php echo $fila['necesitacapacitacion'] ?></td>
                        <td><?php echo $fila['forma'] ?></td>
                        <td style="text-align: center"><?php echo $registro['icono'] ?></td>

                        <?php
                    } else {                  // Si no continua, muestra el motivo porque Abandono.
                        if ($fila['funciona'] == 0) { ?>
                            <td>Motivo: <?php echo strtoupper($fila['porqueabandono']) ?>, Producto: <?php echo strtoupper($fila['productoproducido']) ?></td>
                            <td><?php echo $fila['cantidadproducida'] ?></td>
                            <td><?php echo $fila['mercado'] ?></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td style="text-align: center"><?php echo $registro['icono'] ?></td>
                    <?php
                        }
                    }
                    ?>
                </tr>
            <?php
                $contador++;
            }
            ?>
        </tbody>
    </table>
</div>
<?php mysqli_close($con); ?>