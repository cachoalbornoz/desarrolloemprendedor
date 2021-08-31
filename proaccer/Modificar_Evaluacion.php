<?php
require('../accesorios/admin-superior.php');
require('../accesorios/accesos_bd.php');
$con=conectar(); 

$idProyecto = $_GET['id_proyecto'];
$solicitante= $_GET['solicitante'];

$tabla      = mysqli_query($con, "SELECT * from proaccer_seguimientos WHERE id_proyecto = $idProyecto");
$registro   = mysqli_fetch_array($tabla);

?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-12">
                MODIFICACION EVALUACION - Corresponde a <strong><?php echo $solicitante ?> </strong> - IdProyecto <i class="fas fa-chevron-right"></i> <?php echo str_pad($idProyecto, 4, '0', STR_PAD_LEFT)?>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="post" action="Modificar_Evaluacion_Final.php?id_proyecto=<?php echo $idProyecto ;?>" >

        
            <div class="form-group">
                <label class=" col-2">Fecha evaluación</label>
                <div class="col-4">
                    <input  type="date" name="fecha" value="<?php echo $registro['fecha']?>" required class="form-control">
                </div>
            </div>

            <div class="form-group">
                <div class="col">
                    <br/>
                </div>
            </div>
        
            <div class="form-group">
                <label class="col-6"> 1 - Tipo de producción (0 a 20) </label>
                <div class="col-md-2">
                    <select name="pto_preg_1" id="pto_preg_1" size="1" class="form-control" onChange="">
                        <?php for ($i = 0; $i < 21; $i++): ?>
                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col">
                    <textarea name="obs_1" id="obs_1" size="1" class="form-control" placeholder="Observaciones 1"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col">
                    <br/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4"> 2 - Volumen de Producción (0 a 20)</label>
                <div class="col-md-2">
                    <select name="pto_preg_2" id="pto_preg_2" size="1" class="form-control" onChange="">
                        <?php for ($i = 0; $i < 21; $i++): ?>
                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col">
                    <textarea name="obs_2" id="obs_2" size="1" class="form-control" placeholder="Observaciones 2"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col">
                    <br/>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4"> 3 - Años que se encuentra en funcionamiento (0 a 10)</div>
                <div class="col-md-2">
                    <select name="pto_preg_3" id="pto_preg_3" size="1" class="form-control" onChange="">
                        <?php for ($i = 0; $i < 11; $i++): ?>
                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col">
                    <textarea name="obs_3" id="obs_3" size="1" class="form-control" placeholder="Observaciones 3"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col">
                    <br/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4"> 4 - Experiencia y Capacitacion en la actividad (0 a 20)</label>
                <div class="col-md-2">
                    <select name="pto_preg_4" id="pto_preg_4" size="1" class="form-control" onChange="">
                        <?php for ($i = 0; $i < 21; $i++): ?>
                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col">
                    <textarea name="obs_4" id="obs_4" size="1" class="form-control" placeholder="Observaciones 4"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4"> 5 - Modalidades de comercialización actuales y proyectadas (0 a 20)</div>
                <div class="col-md-2">
                    <select name="pto_preg_5" id="pto_preg_5" size="1" class="form-control" onChange="">
                        <?php for ($i = 0; $i < 21; $i++): ?>
                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col">
                    <textarea name="obs_5" id="obs_5" size="1" class="form-control" placeholder="Observaciones 5"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col">
                    <br/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4"> 6 - Cantidad de personas que trabajan en el marco del emprendimiento (10 puntos)</label>
                <div class="col-md-2">
                    <select name="pto_preg_6" id="pto_preg_6" size="1" class="form-control" onChange="">
                        <?php for ($i = 0; $i < 11; $i++): ?>
                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col">
                    <textarea name="obs_6" id="obs_6" size="1" class="form-control" placeholder="Observaciones 6"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col">
                    <br/>
                </div>
            </div>
        
            <div class="form-group">
                <div class="col">
                    <hr/>
                </div>
            </div>

            <div class="form-group">
                <div class="col">
                    <textarea name="observaciones" id="observaciones" size="1" class="form-control" placeholder="Ingrese alguna observación"><?php echo $registro['comentario']?></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col">
                    <br/>
                </div>
            </div>

            <div class="form-group">
                <div class="col">
                    <hr/>
                </div>
            </div>
        
            <div class="form-group">
                <div class="col">
                    <input type="submit" class="btn btn-info" value="MODIFICAR">
                </div>    
            </div>
        </form>

    </div>
</div>

<?php require_once('../accesorios/admin-scripts.php'); ?>

<?php require('../accesorios/admin-inferior.php'); ?>
