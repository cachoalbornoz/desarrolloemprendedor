<?php
session_start();
require '../accesorios/accesos_bd.php';
$con = conectar();

$tabla_consulta = 'SELECT exped.id_expediente, emp.apellido,emp.nombres,emp.telefono, emp.celular, emp.email,exped.nro_proyecto, YEAR(exped.fecha_otorgamiento) AS ano,rp.id_rubro,rp.rubro,dep.id, dep.nombre AS departamento, loc.nombre AS ciudad, IF(exped.nro_exp_madre = 0 && exped.nro_exp_control = 0,"C.S.",te.icono) AS icono, segexp.funciona, exped.nro_exp_control 
FROM expedientes exped
INNER JOIN rel_expedientes_emprendedores relee ON relee.id_expediente = exped.id_expediente
INNER JOIN emprendedores emp ON emp.id_emprendedor = relee.id_emprendedor
INNER JOIN tipo_rubro_productivos rp ON rp.id_rubro = exped.id_rubro
INNER JOIN localidades loc ON loc.id = exped.id_localidad
INNER JOIN departamentos dep ON dep.id = loc.departamento_id
INNER JOIN tipo_estado te ON te.id_estado = exped.estado
LEFT JOIN seguimiento_expedientes segexp ON segexp.id_expediente = exped.id_expediente
WHERE relee.id_responsabilidad = 1';

if(isset($_POST['id_tipo_financiamiento']) && $_POST['id_tipo_financiamiento'] >= 0) {
    if($_POST['id_tipo_financiamiento'] == 0) {  // JOVENES  EMPRENDEDORES
        $tabla_consulta .= ' and exped.nro_exp_madre > 0 && exped.nro_exp_control > 0';
    } else {                                      // CAPITAL SEMILLA
        $tabla_consulta .= ' and exped.nro_exp_madre = 0 && exped.nro_exp_control = 0';
    }
} else {                                          // NO SELECCIONO NADA
    $tabla_consulta .= '';
}

if(isset($_POST['id_funcionamiento']) && $_POST['id_funcionamiento'] >= 0) {
    if($_POST['id_funcionamiento'] == 1) {       // EN FUNCIONAMIENTO
        $tabla_consulta .= ' and segexp.funciona = 1';
    } else {                                      // SIN FUNCIONAR
        $tabla_consulta .= ' and segexp.funciona = 0';
    }
} else {                                          // NO SELECCIONO NADA
    $tabla_consulta .= '';
}

if(isset($_POST['ano']) && $_POST['ano'] != '') {

    $tabla_consulta .= ' and year(exped.fecha_otorgamiento) = ' . $_POST['ano'];

} else {
    $tabla_consulta .= '';
}

if(isset($_POST['id_estado']) && $_POST['id_estado'] != -1) {
    $tabla_consulta .= ' and exped.estado = ' . $_POST['id_estado'];
}

if(isset($_POST['id_departamento']) && $_POST['id_departamento'] != -1) {
    $tabla_consulta .= ' and dep.id = ' . $_POST['id_departamento'];
} else {
    $tabla_consulta .= ' and dep.id > 0';
}

if(isset($_POST['id_ciudad']) && $_POST['id_ciudad'] != 0) {
    $tabla_consulta .= ' and loc.id = ' . $_POST['id_ciudad'];
} else {
    $tabla_consulta .= ' and loc.id > 0';
}

if(isset($_POST['id_rubro']) && $_POST['id_rubro'] != -1) {
    $tabla_consulta .= ' and rp.id_rubro = ' . $_POST['id_rubro'];
} else {
    $tabla_consulta .= ' and rp.id_rubro > 0';
}

$tabla_consulta .= ' order by emp.apellido, nombres';

$resultado = mysqli_query($con, $tabla_consulta);

?>

<script type="text/javascript">

    var table = $('#consulta').DataTable({ 
        "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        "dom"           : '<"wrapper"Brflitp>',        
        "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
        "order"         : [[ 1, "asc" ]],
        "stateSave"     : true,
        "columnDefs"    : [{}, ],
        "language"      : { "url": "../public/DataTables/spanish.json" }
    });

</script>

<div class="table table-responsive">

    <table id="consulta" class="table table-hover" style="font-size: small">
    <thead>
        <tr>
            <th>Exped</th>
            <th>Titular</th>
            <th>ExpedControl</th>
            <th>Ubicacion</th>
            <th>Rubro</th>
            <th>Departamento</th>
            <th>Ciudad</th>
            <th>Estado</th>
            <th>Fijo</th>
            <th>Móvil</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($resultado)) {
            $contador = 1;
            while ($registro = mysqli_fetch_array($resultado)) {

                $id_expediente   = $registro['id_expediente'];
                $tabla_ubicacion = mysqli_query($con, "SELECT tu.ubicacion
                    FROM rel_expedientes_ubicacion as reu, expedientes_ubicaciones as ubi, tipo_ubicaciones as tu
                    WHERE reu.id_ubicacion = ubi.id_ubicacion AND tu.id_ubicacion = ubi.id_tipo_ubicacion AND reu.id_expediente = $id_expediente
                    ORDER BY fecha DESC 
                    LIMIT 1");

                $registro_ubi = mysqli_fetch_array($tabla_ubicacion);

                $ubicacion = (isset($registro_ubi['ubicacion'])) ? $registro_ubi['ubicacion'] : null;

                ?>

            <tr>
                <td><?php print str_pad($registro['nro_proyecto'], 5, '0', STR_PAD_LEFT); ?>/<?php print $registro['ano']; ?></td>
                <td><?php print substr(strtoupper($registro['apellido'] . ',' . $registro['nombres']), 0, 15); ?></td>
                <td><?php print $registro['nro_exp_control']; ?> </td>
                <td><?php print $ubicacion; ?> </td>
                <td><?php print substr($registro['rubro'], 0, 10); ?> </td>
                <td><?php print substr($registro['departamento'], 0, 10); ?> </td>
                <td><?php print substr($registro['ciudad'], 0, 10); ?> </td>
                <td><?php print $registro['icono']; ?></td>
                <td><?php print $registro['telefono']; ?></td>
                <td><?php print $registro['celular']; ?> </td>
                <td><?php print $registro['email']; ?> </td>
            </tr>
            <?php
                $contador++;
            }
        }
?>
    </tbody>
    </table>
</div>
