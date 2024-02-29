<?php
session_start();

require($_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/accesos_bd.php');
$con = conectar();

$id_solicitante = $_SESSION['id_usuario'];
$id_proyecto    = $_SESSION['id_proyecto'];

$mensaje        = null;

if (isset($_POST['operacion'])) {

    if ($_POST['operacion'] == 1) {         // CARGAR SOLICITANTE

        $dni                = $_POST['dni'];

        // REVISAR SI EL DNI ES UN SOLICITANTE
        $tabla_solicitantes = mysqli_query($con, "SELECT id_solicitante, fecha_nac FROM solicitantes WHERE dni = $dni");

        if ($registro_sol = mysqli_fetch_array($tabla_solicitantes)) {

            $id_solicitante     = $registro_sol['id_solicitante'];
            $fecha_nac          = $registro_sol['fecha_nac'];

            // CALCULAR LA EDAD
            list($ano, $mes, $dia) = explode("-", $fecha_nac);
            $ano_diferencia     = date("Y") - $ano;
            $mes_diferencia     = date("m") - $mes;
            $dia_diferencia     = date("d") - $dia;
            if ($dia_diferencia < 0 || $mes_diferencia < 0)
                $ano_diferencia--;

            // SI TIENE MENOS DE 40 AÑOS 
            if ($ano_diferencia < 41) {

                // REVISAR SI EL ID SOLICITANTE ESTA RELACIONADO
                $tabla_relaciones = mysqli_query($con, "SELECT p.id_proyecto, denominacion, estado, p.id_estado 
                FROM proyectos p 
                INNER JOIN rel_proyectos_solicitantes rps ON rps.id_proyecto  = p.id_proyecto 
                INNER JOIN tipo_estado te ON te.id_estado = p.id_estado 
                WHERE id_solicitante = $id_solicitante");

                if (!$registro_rel = mysqli_fetch_array($tabla_relaciones)) {

                    agregar($con, $id_proyecto, $id_solicitante);

                    $mensaje =
                        '<div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            Asociado vinculado correctamente !
                        </div>';
                } else {

                    $denominacion   = $registro_rel['denominacion'];
                    $id_estado      = $registro_rel['id_estado'];
                    $id_proyecto_r  = $registro_rel['id_proyecto'];
                    $estado         = $registro_rel['estado'];

                    // SI EL DNI A VINCULAR ESTABA EN UN PROYECTO YA FINANCIADO
                    if ($id_estado == '25') {

                        $seleccion_expediente  = mysqli_query($con, "SELECT id_expediente, estado FROM expedientes WHERE id_proyecto = $id_proyecto_r");
                        $registro_expediente   = mysqli_fetch_array($seleccion_expediente);

                        $estado_exp = $registro_expediente['estado'];

                        // SI EL PROYECTO FINANCIADO SE DEVOLVIO COMPLETAMENTE
                        if ($estado_exp == '3') {

                            agregar($con, $id_proyecto, $id_solicitante);

                            $mensaje =
                                '<div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Asociado vinculado correctamente !
                                </div>';
                        } else {

                            $mensaje =

                                '<div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Asociado ID (' . $id_solicitante . ') esta relacionado a un expediente que <b>NO</b> se finalizó de pagar aún.
                                    <p>Expediente con estado :: ' . $estado_exp . '</p>
                                </div>';
                        }
                    } else {

                        $mensaje =

                            '<div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Asociado ID (' . $id_solicitante . ') ya se encuentra vinculado al proyecto <b>' . $denominacion . '</b> 
                                con estado <b>' . $estado . '</b>
                            </div>';
                    }
                }
            } else {

                $mensaje =
                    '<div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Asociado tiene más de 40 años !
                </div>';
            }
        } else {

            $mensaje =
                '<div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Asociado no registrado ! Le recomendamos salir de su sesión, registrarlo y asociarlo.
            </div>';
        }
    } else {

        // DESVINCULAR SOLICITANTE

        if ($_POST['operacion'] == 2) {

            $id_solicitante = $_POST['id_solicitante'];
            $id_proyecto    = $_POST['id_proyecto'];

            mysqli_query($con, "DELETE FROM rel_proyectos_solicitantes WHERE id_solicitante = $id_solicitante AND id_proyecto = $id_proyecto") 
            or die("Error en la eliminacion Rel-proyectos-solicitantes");

            $mensaje =
                '<div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Asociado desvinculado correctamente !
            </div>';
        }
    }
}


echo $mensaje;

function agregar($con, $id_proyecto, $id_solicitante)
{
    // SETEAR SOLICITANTE PARA QUE SEA ASOCIADO
    mysqli_query($con, "INSERT INTO rel_proyectos_solicitantes (id_proyecto, id_solicitante, id_responsabilidad) 
        VALUES ($id_proyecto, $id_solicitante, 0)") or die("Error en la insercion Rel-Solic-Proyectos");

    // DATOS INICIALIZADOS PARA EL SOLICITANTE 

    // $id_medio       = 6;                // OTRO MEDIO
    // $id_programa    = 1;                // JOVENES EMPRENDEDORES
    // $id_rubro       = 30;               // AGROINDUSTRIA
    // $id_empresa     = 0;                // EMPRESA RESETEADA
    // $id_entidad     = 0;                // ENTIDAD RESETEADA
    // $funciona       = 0;                // NO FUNCIONA - TIENE QUE CARGAR DATOS DE LA EMPRESA
    // $observaciones  = 'Completar ';     // RESEÑA DEL PROYECTO

    // AGREGA DATOS AL REGISTRO DEL SOLICITANTE

    // mysqli_query($con, "INSERT INTO registro_solicitantes (id_solicitante, id_rubro, id_medio, id_programa, id_entidad, observaciones, id_empresa) 
    // VALUES ($id_solicitante, $id_rubro, $id_medio, $id_programa, $id_entidad, '$observaciones', $id_empresa)") or
    //     die("Error en la insercion registro_solicitantes");
}

?>

<div class="table-responsive">

    <table id="integrantes" class="table table-striped table-condensed table-hover" style="font-size: small">
        <thead>
            <tr>
                <th></th>
                <th>DNI</th>
                <th>Apellido</th>
                <th>Nombres</th>
                <th>Email</th>
                <th>FechaNac</th>
                <th>Telefono</th>
                <th>Responsabilidad</th>
                <th>Ciudad</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $contador = 1;

            if ($id_proyecto > 0) {       // SE GUARDARON DATOS EN LA "TABLA PROYECTOS"

                $resultado = mysqli_query($con, "SELECT sol.*, loc.nombre as ciudad, dep.id as id_departamento, dep.nombre as departamento, responsabilidad, rel.id_responsabilidad AS id_res
                    FROM solicitantes sol, localidades loc, departamentos dep, tipo_responsabilidad respo, rel_proyectos_solicitantes rel
                    WHERE loc.id = sol.id_ciudad and loc.departamento_id = dep.id and rel.id_solicitante = sol.id_solicitante
                    AND rel.id_responsabilidad = respo.id_responsabilidad and rel.id_proyecto = $id_proyecto
                    ORDER BY rel.id_responsabilidad Desc, apellido Asc ");
            } else {                      // TODAVIA NO SE GUARDARON DATOS EN LA "TABLA PROYECTOS"

                $resultado = mysqli_query($con, "SELECT sol.*, loc.nombre as ciudad, dep.id as id_departamento, dep.nombre as departamento, responsabilidad, rel.id_responsabilidad AS id_res
                    FROM solicitantes sol 
                    INNER JOIN localidades loc ON loc.id = sol.id_solicitante
                    INNER JOIN departamentos dep ON dep.id = loc.departamento_id
                    INNER JOIN tipo_responsabilidad respo ON respo.id_responsabilidad = rel.id_responsabilidad
                    WHERE sol.id_solicitante = $id_solicitante
                    ORDER BY rel.id_responsabilidad DESC, apellido ASC ");
            }

            while ($fila = mysqli_fetch_array($resultado)) {
            ?>
            <tr>
                <td>
                    <?php
                        if ($fila['id_res'] == 0) {
                        ?>
                    <a href="javascript:void(0)" onclick="borrar_solicitante('<?php echo $fila['id_solicitante'] ?>', '<?php echo ucwords($fila['apellido']) . ', ' . ucwords($fila['nombres']) ?>')">
                        <i class="fas fa-trash text-danger" title="Desvincular del proyecto"></i>
                    </a>
                    <?php
                        }
                        ?>
                </td>
                <td><?php echo $fila['dni'] ?> </td>
                <td><?php echo ucwords($fila['apellido']) ?></td>
                <td><?php echo ucwords($fila['nombres']) ?></td>
                <td><?php echo $fila['email'] ?></td>
                <td><?php echo date('d/m/Y', strtotime(($fila['fecha_nac']))) ?></td>
                <td><?php echo $fila['telefono'] ?></td>
                <td><?php echo ucwords($fila['responsabilidad']) ?> </td>
                <td><?php echo ($fila['ciudad']) ?></td>
            </tr>

            <?php
                $contador++;
            }
            ?>
        </tbody>
    </table>
</div>

<?php
mysqli_close($con);