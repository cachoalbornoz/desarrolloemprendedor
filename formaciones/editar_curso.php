<?php require('../accesorios/admin-superior.php');

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$id         = $_GET['id'];

$query      = mysqli_query($con, "SELECT * FROM formacion_cursos WHERE id = $id");

$registro   = mysqli_fetch_array($query);


?>

    <div class="card">

        <div class="card-header">
            <div class="row mb-3">
                <div class="col-xs-12">
                    EDITAR CURSO
                </div>
            </div>
        </div>

        <div class="card-body">

            <form id="cursos" method="POST" action="actualiza_curso.php" class="form-horizontal">

                <input id="id" name="id" type="hidden" value="<?php echo $registro['id'] ?>" />

                <div class="row mb-3">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <label for="nombre">Nombre </label>
                        <input id="nombre" name="nombre" type="text" class="form-control" required value="<?php echo $registro['nombre'] ?>" />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-xs-12 col-sm-6 col-lg-3">
                        <label>Fecha realización</label>
                        <input id="fechaRealizacion" name="fechaRealizacion" type="date" class="form-control" required value="<?php echo $registro['fechaRealizacion'] ?>" />
                    </div>

                    <div class="col-xs-12 col-sm-6 col-lg-3">
                        <label>Ciudad</label>
                        <select name="id_ciudad" size="1" id="id_ciudad" class="form-control" required>
                            <option value="0" disabled selected></option>
                            <?php
                            
                            $ciudades = "SELECT t1.id, t1.nombre, t2.nombre AS dpto
                                FROM localidades t1
                                INNER JOIN departamentos t2 ON t1.departamento_id = t2.id
                                WHERE t2.provincia_id = 7
                                ORDER BY t1.nombre";
                            $record = mysqli_query($con, $ciudades);
                            while ($fila = mysqli_fetch_array($record)) {

                                if ($fila[0] == $registro['id_ciudad']) {

                                    echo "<option value=".$fila[0]." selected >".$fila[1].', '.$fila[2]."</option>";

                                } else {

                                    echo "<option value=".$fila[0].">".$fila[1].', '.$fila[2]."</option>";
                                    
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-lg-3">
                        <label>Lugar</label>
                        <input id="lugar" name="lugar" type="text" class="form-control" required value="<?php echo $registro['lugar'] ?>" />
                    </div>

                    <div class="col-xs-12 col-sm-6 col-lg-3">
                        <label>Hora</label>
                        <input id="hora" name="hora" type="time" class="form-control" value="<?php echo $registro['hora'] ?>" />
                    </div>

                </div>

                <div class="row mb-3">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <label>Reseña</label>
                        <textarea id="resenia" name="resenia" class="form-control" required /><?php echo $registro['resenia'] ?></textarea>
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <label>Destinatarios</label>
                        <input id="destinatarios" name="destinatarios" type="text" class="form-control" required value="<?php echo $registro['destinatarios'] ?>" />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> 
                                    <i class="fas fa-globe-americas"></i> &nbsp;
                                    URL
                                </span>
                            </div>
                            <input id="url" name="url" type="url" class="form-control" value="<?php echo $registro['url'] ?>" required />
                        </div>
                    </div>
                     <div class="col-xs-12 col-sm-3 col-lg-3">
                        <label>
                            <input id="activo" name="activo" type="checkbox" <?php if($registro['activo'] == 1){ echo 'checked';} ?> /> Activo
                        </label>
                    </div>
                
                    <div class="col-xs-12 col-sm-3 col-lg-3">
                        <input type="submit" class="btn btn-info" value="Actualizar" />
                    </div>
                </div>

            </form>
        </div>

    </div>

    <?php require_once('../accesorios/admin-scripts.php'); ?>


    <script type="text/javascript">

    $(function(){

    });

    </script>

    <?php require_once('../accesorios/admin-inferior.php'); ?>
