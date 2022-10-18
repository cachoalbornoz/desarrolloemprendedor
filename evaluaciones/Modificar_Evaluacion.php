<?php
require('../accesorios/admin-superior.php');

require_once('../accesorios/accesos_bd.php');

$con=conectar();

$idProyecto = $_GET['IdProyecto'];
$solicitante= $_GET['solicitante'];

$tabla      = mysqli_query($con, "SELECT * from proyectos_seguimientos WHERE id_proyecto = $idProyecto");
$registro   = mysqli_fetch_array($tabla);

?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-12">
                MODIFICACION EVALUACION - Corresponde a <strong><?php echo $solicitante ?> </strong> - IdProyecto <i class="fas fa-chevron-right"></i> <?php echo str_pad($idProyecto, 4, '0', STR_PAD_LEFT)?>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="post" action="Modificar_Evaluacion_Final.php?id_proyecto=<?php echo $idProyecto ;?>" role="form">

            <ul class="list-group">
                <li class="list-group-item bg-info text-white">

                    <div class="row mt-3 mb-3">
                        <div class="col-2">
                            <label for="fecha">Fecha evaluación</label>
                        </div>
                        <div class="col-2">
                            <input type="date" name="fecha" value="<?php echo $registro['fecha']?>" required class="form-control">
                        </div>
                    </div>

                </li>
            </ul>

            <li class="list-group-item mt-5">

                <div class="row mt-5">
                    <div class="col-1 text-center">1</div>
                    <div class="col-7">Es de carácter asociativo (2 personas <b>10 puntos</b>, más de 2 equivale a <b>20 puntos</b>)</div>
                    <div class="col-2">
                        <select name="pto_preg_1" id="pto_preg_1" size="1" class="form-control">
                            <?php
                        for ($i=0; $i < 21; $i++) {
                            if ($registro['puntaje1'] == $i) {
                                echo "<option value=".$i." selected \>".$i."</option>\n";
                            } else {
                                echo "<option value=".$i.">".$i."</option>\n";
                            }
                        }
                        ;
                        ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-2 mb-2">
                    <div class="col-1 text-center">&nbsp;</div>
                    <div class="col-9">
                        <textarea name="obs_1" id="obs_1" size="1" class="form-control" placeholder="Observaciones 1"><?php echo $registro['observacion1']?></textarea>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-1 text-center">2</div>
                    <div class="col-7">Se encuentra ya en marcha (<b>10 puntos</b>)</div>
                    <div class="col-2">
                        <select name="pto_preg_2" id="pto_preg_2" size="1" class="form-control">
                            <?php
                                for ($i=0; $i < 11; $i++) {
                                    if ($registro['puntaje2'] == $i) {
                                        echo "<option value=".$i." selected \>".$i."</option>\n";
                                    } else {
                                        echo "<option value=".$i.">".$i."</option>\n";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-2 mb-2">
                    <div class="col-1 text-center">&nbsp;</div>
                    <div class="col-9">
                        <textarea name="obs_2" id="obs_2" size="1" class="form-control" placeholder="Observaciones 2"><?php echo $registro['observacion2']?></textarea>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-1 text-center">3</div>
                    <div class="col-7">Cuenta con una propuesta econ&oacute;micamente viable (<b>10 puntos</b>)</div>
                    <div class="col-2">
                        <select name="pto_preg_3" id="pto_preg_3" size="1" class="form-control">
                            <?php
                                for ($i=0; $i < 11; $i++) {
                                    if ($registro['puntaje3'] == $i) {
                                        echo "<option value=".$i." selected \>".$i."</option>\n";
                                    } else {
                                        echo "<option value=".$i.">".$i."</option>\n";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-2 mb-2">
                    <div class="col-1 text-center">&nbsp;</div>
                    <div class="col-9">
                        <textarea name="obs_3" id="obs_3" size="1" class="form-control" placeholder="Observaciones 3"><?php echo $registro['observacion3']?></textarea>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-1 text-center">4</div>
                    <div class="col-7">El emprendedor/es tiene experiencia en la actividad objeto del proyecto (<b>10 puntos</b>)</div>
                    <div class="col-2">
                        <select name="pto_preg_4" id="pto_preg_4" size="1" class="form-control">
                            <?php
                                for ($i=0; $i < 11; $i++) {
                                    if ($registro['puntaje4'] == $i) {
                                        echo "<option value=".$i." selected \>".$i."</option>\n";
                                    } else {
                                        echo "<option value=".$i.">".$i."</option>\n";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-2 mb-2">
                    <div class="col-1 text-center">&nbsp;</div>
                    <div class="col-9">
                        <textarea name="obs_4" id="obs_4" size="1" class="form-control" placeholder="Observaciones 4"><?php echo $registro['observacion4']?></textarea>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-1 text-center">5</div>
                    <div class="col-7">Realiza aportes de capital propios en una proporci&oacute;n significativa del proyecto (<b>10 puntos</b>)</div>
                    <div class="col-2">
                        <select name="pto_preg_5" id="pto_preg_5" size="1" class="form-control">
                            <?php
                                for ($i=0; $i < 11; $i++) {
                                    if ($registro['puntaje5'] == $i) {
                                        echo "<option value=".$i." selected \>".$i."</option>\n";
                                    } else {
                                        echo "<option value=".$i.">".$i."</option>\n";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-2 mb-2">
                    <div class="col-1 text-center">&nbsp;</div>
                    <div class="col-9">
                        <textarea name="obs_5" id="obs_5" size="1" class="form-control" placeholder="Observaciones 5"><?php echo $registro['observacion5']?></textarea>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-1 text-center">6</div>
                    <div class="col-7">Genera empleo permanente(<b>10 puntos</b>)</div>
                    <div class="col-2">
                        <select name="pto_preg_6" id="pto_preg_6" size="1" class="form-control">
                            <?php
                                for ($i=0; $i < 11; $i++) {
                                    if ($registro['puntaje6'] == $i) {
                                        echo "<option value=".$i." selected \>".$i."</option>\n";
                                    } else {
                                        echo "<option value=".$i.">".$i."</option>\n";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-2 mb-2">
                    <div class="col-1 text-center">&nbsp;</div>
                    <div class="col-9">
                        <textarea name="obs_6" id="obs_6" size="1" class="form-control" placeholder="Observaciones 6"><?php echo $registro['observacion6']?></textarea>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-1 text-center">7</div>
                    <div class="col-7">Tiene impacto local (<b>10 puntos</b>)</div>
                    <div class="col-2">
                        <select name="pto_preg_7" id="pto_preg_7" size="1" class="form-control">
                            <?php
                                for ($i=0; $i < 11; $i++) {
                                    if ($registro['puntaje7'] == $i) {
                                        echo "<option value=".$i." selected \>".$i."</option>\n";
                                    } else {
                                        echo "<option value=".$i.">".$i."</option>\n";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-2 mb-2">
                    <div class="col-1 text-center">&nbsp;</div>
                    <div class="col-9">
                        <textarea name="obs_7" id="obs_7" size="1" class="form-control" placeholder="Observaciones 7"><?php echo $registro['observacion7']?></textarea>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-1 text-center">8</div>
                    <div class="col-7">Contribuye al cuidado del medio ambiente (<b>10 puntos</b>)</div>
                    <div class="col-2">
                        <select name="pto_preg_8" id="pto_preg_8" size="1" class="form-control">
                            <?php
                                for ($i=0; $i < 11; $i++) {
                                    if ($registro['puntaje8'] == $i) {
                                        echo "<option value=".$i." selected \>".$i."</option>\n";
                                    } else {
                                        echo "<option value=".$i.">".$i."</option>\n";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-2 mb-2">
                    <div class="col-1 text-center">&nbsp;</div>
                    <div class="col-9">
                        <textarea name="obs_8" id="obs_8" size="1" class="form-control" placeholder="Observaciones 8"><?php echo $registro['observacion8']?></textarea>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-1 text-center">9</div>
                    <div class="col-7">Es un proyecto innovador (<b>10 puntos</b>)</div>
                    <div class="col-2">
                        <select name="pto_preg_9" id="pto_preg_9" size="1" class="form-control">
                            <?php
                                for ($i=0; $i < 11; $i++) {
                                    if ($registro['puntaje9'] == $i) {
                                        echo "<option value=".$i." selected \>".$i."</option>\n";
                                    } else {
                                        echo "<option value=".$i.">".$i."</option>\n";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-2 mb-2">
                    <div class="col-1 text-center">&nbsp;</div>
                    <div class="col-9">
                        <textarea name="obs_9" id="obs_9" size="1" class="form-control" placeholder="Observaciones 9"><?php echo $registro['observacion9']?></textarea>
                    </div>
                </div>
            </li>

            <li class="list-group-item">
                <div class="row mt-5">
                    <div class="col-1 text-center"></div>
                    <div class="col-9">
                        <textarea name="observaciones" id="observaciones" size="1" class="form-control" placeholder="Ingrese alguna observación"><?php echo $registro['comentario']?></textarea>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <input type="button" onclick="history.back()" class="btn btn-default" value="&laquo; Volver">
                <input type="submit" class="btn btn-info" value="MODIFICAR  &raquo;">
            </li>
        </form>

    </div>
</div>


<?php require_once('../accesorios/admin-scripts.php'); ?>

<?php require_once('../accesorios/admin-inferior.php');
