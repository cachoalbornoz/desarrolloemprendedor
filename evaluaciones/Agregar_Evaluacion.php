<?php

require('../accesorios/admin-superior.php');

require_once('../accesorios/accesos_bd.php');

$con=conectar();

$idProyecto = $_GET['IdProyecto'];
$solicitante= $_GET['solicitante']; 

?>

  	
<div class="card">
    <div class="card-header">      
        <div class="row">
            <div class="col-lg-12">
                EVALUAR PROYECTO - Corresponde a <strong><?php echo $solicitante ?> </strong> - IdProyecto <i class="fas fa-chevron-right"></i> <?php echo str_pad($idProyecto,4,'0',STR_PAD_LEFT)?>          
            </div>
        </div>
    </div>

    <div class="card-body">
        <form method="post" role="form" action="Agregar_Evaluacion_Final.php?id_proyecto=<?php echo $idProyecto ;?>">
            <ul class="list-group">
            <li class="list-group-item">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-md-2 col-lg-2 p-3">
                            Fecha de Evaluacion
                        </div>
                        <div class="col-xs-12 col-md-4 col-lg-4 p-3 text-center">    
                            <input type="date" name="fecha" required class="form-control">
                        </div>    
                    </div>
                </div>
            </li>
            </ul>
            <li class="list-group-item">

                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-1 col-lg-1 p-3 text-center">1</div>

                        <div class="col-xs-12 col-md-4 col-lg-5 p-3">Es de carácter asociativo (2 personas <b>10 puntos</b>, más de 2 <b>20 puntos</b>)</div>
                        
                        <div class="col-xs-12 col-md-4 col-lg-6 p-3">
                            <select name="pto_preg_1" id="pto_preg_1" size="1" class="form-control" onChange="">
                                <?php for ($i=1; $i < 21; $i++): ?>
                                    <option value="<?php echo $i?>"><?php echo $i?></option>  
                                <?php endfor;?>            
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <textarea name="obs_1" id="obs_1" size="1" class="form-control" placeholder="Observaciones 1"></textarea>
                        </div>
                    </div>    
                </div>                

                <div class="form-group">	
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-1 col-lg-1 p-3 text-center">2</div>
                        <div class="col-xs-12 col-md-4 col-lg-5 p-3">Se encuentra ya en marcha (<b>10 puntos</b>)</div>
                        <div class="col-xs-12 col-md-4 col-lg-6 p-3">
                            <select name="pto_preg_2" id="pto_preg_2" size="1" class="form-control" onChange="">
                                <?php for ($i=1; $i < 11; $i++): ?>
                                <option value="<?php echo $i?>"><?php echo $i?></option>  
                                <?php endfor;?>            
                            </select>
                        </div>	
                    </div>    
                </div>
                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <textarea name="obs_2" id="obs_2" size="1" class="form-control" placeholder="Observaciones 2"></textarea>
                        </div>
                    </div>    
                </div>

                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-1 col-lg-1 p-3 text-center">3</div>
                        <div class="col-xs-12 col-md-4 col-lg-5 p-3">Cuenta con una propuesta económicamente viable (<b>10 puntos</b>)</div>
                        <div class="col-xs-12 col-md-4 col-lg-6 p-3">
                            <select name="pto_preg_3" id="pto_preg_3" size="1" class="form-control" onChange="">
                                <?php for ($i=1; $i < 11; $i++): ?>
                                <option value="<?php echo $i?>"><?php echo $i?></option>  
                                <?php endfor;?>            
                            </select>
                        </div>
                    </div>    
                </div>
                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <textarea name="obs_3" id="obs_3" size="1" class="form-control" placeholder="Observaciones 3"></textarea>
                        </div>
                    </div>    
                </div>

                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-1 col-lg-1 p-3 text-center">4</div>
                        <div class="col-xs-12 col-md-4 col-lg-5 p-3">El emprendedor/es tiene experiencia en la actividad objeto del proyecto (<b>10 puntos</b>)</div>
                        <div class="col-xs-12 col-md-4 col-lg-6 p-3">
                            <select name="pto_preg_4" id="pto_preg_4" size="1" class="form-control" onChange="">
                                <?php for ($i=1; $i < 11; $i++): ?>
                                <option value="<?php echo $i?>"><?php echo $i?></option>  
                                <?php endfor;?>            
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <textarea name="obs_4" id="obs_4" size="1" class="form-control" placeholder="Observaciones 4"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-1 col-lg-1 p-3 text-center">5</div>
                        <div class="col-xs-12 col-md-4 col-lg-5 p-3">Realiza aportes de capital propios en una proporción significativa del proyecto (<b>10 puntos</b>)</div>
                        <div class="col-xs-12 col-md-4 col-lg-6 p-3">
                            <select name="pto_preg_5" id="pto_preg_5" size="1" class="form-control" onChange="">
                                <?php for ($i=1; $i < 11; $i++): ?>
                                <option value="<?php echo $i?>"><?php echo $i?></option>  
                                <?php endfor;?>            
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <textarea name="obs_5" id="obs_5" size="1" class="form-control" placeholder="Observaciones 5"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-1 col-lg-1 p-3 text-center">6</div>
                        <div class="col-xs-12 col-md-4 col-lg-5 p-3">Genera empleo permanente(<b>10 puntos</b>)</div>
                        <div class="col-xs-12 col-md-4 col-lg-6 p-3">
                            <select name="pto_preg_6" id="pto_preg_6" size="1" class="form-control" onChange="">
                                <?php for ($i=1; $i < 11; $i++): ?>
                                <option value="<?php echo $i?>"><?php echo $i?></option>  
                                <?php endfor;?>            
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <textarea name="obs_6" id="obs_6" size="1" class="form-control" placeholder="Observaciones 6"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-1 col-lg-1 p-3 text-center">7</div>
                        <div class="col-xs-12 col-md-4 col-lg-5 p-3">Tiene impacto local (<b>10 puntos</b>)</div>
                        <div class="col-xs-12 col-md-4 col-lg-6 p-3">
                            <select name="pto_preg_7" id="pto_preg_7" size="1" class="form-control" onChange="">
                                <?php for ($i=1; $i < 11; $i++): ?>
                                <option value="<?php echo $i?>"><?php echo $i?></option>  
                                <?php endfor;?>            
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <textarea name="obs_7" id="obs_7" size="1" class="form-control" placeholder="Observaciones 7"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-1 col-lg-1 p-3 text-center">8</div>	
                        <div class="col-xs-12 col-md-4 col-lg-5 p-3">Contribuye al cuidado del medio ambiente (<b>10 puntos</b>)</div>
                        <div class="col-xs-12 col-md-4 col-lg-6 p-3">
                            <select name="pto_preg_8" id="pto_preg_8" size="1" class="form-control" onChange="">
                                <?php for ($i=1; $i < 11; $i++): ?>
                                <option value="<?php echo $i?>"><?php echo $i?></option>  
                                <?php endfor;?>            
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <textarea name="obs_8" id="obs_8" size="1" class="form-control" placeholder="Observaciones 8"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-1 col-lg-1 p-3 text-center">9</div>
                        <div class="col-xs-12 col-md-4 col-lg-5 p-3">Es un proyecto innovador (<b>10 puntos</b>)</div>
                        <div class="col-xs-12 col-md-4 col-lg-6 p-3">
                            <select name="pto_preg_9" id="pto_preg_9" size="1" class="form-control" onChange="">
                                <?php for ($i=1; $i < 11; $i++): ?>
                                <option value="<?php echo $i?>"><?php echo $i?></option>  
                                <?php endfor;?>            
                            </select>
                        </div>
                    </div>	      			
                </div>
                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <textarea name="obs_9" id="obs_9" size="1" class="form-control" placeholder="Observaciones 9"></textarea>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="form-group">
                    <div class="row p-5">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <textarea name="observaciones" id="observaciones" size="1" class="form-control" placeholder="Ingrese alguna observaci&oacute;n"></textarea>
                        </div>
                    </div>	      			
                </div>
            </li>
            <li class="list-group-item">
                <input type="button" onclick="history.back()" class="btn btn-default" value="&laquo; Volver">
                <input type="submit" class="btn btn-info" value="Agregar Evaluacion  &raquo;">
            </li>
        </form>      	
    </div>
</div>

<?php require_once('../accesorios/admin-scripts.php'); ?>

<?php require_once('../accesorios/admin-inferior.php'); ?>

