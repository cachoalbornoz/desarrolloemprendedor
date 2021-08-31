<?php 
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');

$con = conectar();

$id_solicitante = $_SESSION['id_usuario'];

$tabla_empresa = mysqli_query($con, "SELECT empresa.* 
FROM proceder_empresas empresa
INNER JOIN rel_proceder relac ON relac.id_empresa = empresa.id_empresa
WHERE relac.id_solicitante = $id_solicitante");

$registro_empresa   = mysqli_fetch_array($tabla_empresa, MYSQLI_BOTH); 

$id_empresa         = $registro_empresa['id_empresa'];
$razon_social       = $registro_empresa['razon_social'];
$cuit               = $registro_empresa['cuit'];
$id_tipo_sociedad   = $registro_empresa['id_tipo_sociedad'];

if(!$id_tipo_sociedad){
    $id_tipo_sociedad   = 0;
}    

$tabla_sociedades   = mysqli_query($con, "select forma from tipo_forma_juridica where id_forma = $id_tipo_sociedad");
$registro_sociedad  = mysqli_fetch_array($tabla_sociedades, MYSQLI_BOTH);
$sociedad           = $registro_sociedad[0];        

if(strtotime($registro_empresa['fecha_inscripcion']) > 0){
    $fecha_inscripcion = $registro_empresa['fecha_inscripcion'];
}else{
    $fecha_inscripcion = NULL;
}

$domicilio         = $registro_empresa['domicilio'];
$nro               = $registro_empresa['nro'];
$id_ciudad         = $registro_empresa['id_localidad'];

$tabla_localidades   = mysqli_query($con, "select loc.nombre, dep.id as id_departamento, dep.nombre as departamento
from localidades loc inner join departamentos dep on loc.departamento_id = dep.id where loc.id = $id_ciudad");
$registro_localidades= mysqli_fetch_array($tabla_localidades, MYSQLI_BOTH);

$ciudad             = $registro_localidades['nombre'];
$id_departamento    = $registro_localidades['id_departamento'];
$departamento       = $registro_localidades['departamento'];

$representante      = $registro_empresa['representante'];

?>

<!-- Datos de la Empresa -->

    <div class="card-header">
        <div class="row">
            <div class="col p-3">
                <h4>Datos de la Empresa</h4>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col p-3">
                <label>Nombre de la Empresa o Razón Social</label>
                <input name="razon_sociali" id="razon_sociali" type="text" class="form-control" value="<?php echo $razon_social ?>">
            </div>
            <div class="col p-3">
                <label>Nro de CUIT</label>
                <input name="cuiti"  type="text" id="cuiti" class="form-control" maxlength="11" value="<?php echo $cuit ?>" placeholder="Ingrese Nro sin puntos" >
            </div>
            <div class="col p-3">
                <label>Tipo Sociedad</label>
                <select id="id_tipo_sociedadi" name="id_tipo_sociedadi" size="1" class="form-control">
                    <?php
                    $tipo_sociedades = "select id_forma, forma from tipo_forma_juridica order by forma";
                    $registro = mysqli_query($con, $tipo_sociedades); 
                    while($fila = mysqli_fetch_array($registro)){

                        if($fila[0] == $id_tipo_sociedad){
                            echo "<option value=".$id_tipo_sociedad." selected \>".$sociedad."</option>\n";
                        }else{
                            echo "<option value=".$fila[0].">".$fila[1]."</option>\n";
                        }  
                    }	
                    ?>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <label>Domicilio</label>
                <input type="text" name="domicilioi" id="domicilioi" value="<?php echo $domicilio ?>" class="form-control">
            </div>
            <div class="col">
                <label>Nro</label>
                <input type="text" name="nroi" id="nroi" value="<?php echo $nro ?>" class="form-control">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <label>Departamento</label>
                <select name="departamentoi" id="departamentoi" onchange="from(this.value,'ciudadi','ciudades.php')" class="form-control">
                <?php
                    $departamentos = "select id, nombre from departamentos where provincia_id = 7 order by nombre";
                    $registro = mysqli_query($con, $departamentos);
                    while ($fila = mysqli_fetch_array($registro)) {
                        
                        if($fila[0] == $id_departamento){
                            echo "<option value=".$id_departamento." selected>".$departamento."</option>\n";
                        }else{
                            echo "<option value=\"".$fila[0]."-id_ciudadi\">".$fila[1]."</option>\n";
                        }  
                    }
                
                    ?>
                </select>
            </div>
            <div class="col">
                <label>Localidad</label>
                <div id="ciudadi">
                    <select name="id_ciudadi"  id="id_ciudadi" class="form-control" >
                        <option value="<?php echo $id_ciudad;?> "><?php echo $ciudad; ?></option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <label>Representante Legal</label>
                <input name="representantei" type="text" id="representantei" value="<?php echo $representante ?>" class="form-control">
            </div>
        </div>    
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <hr style="border-color: grey">
            </div>
        </div> 
    </div>

    
    <div class="form-group">
        <div class="row">            
            <div class="col-3">
                <label>Fecha Inicio Actividades</label>
                <input type="date" name="fecha_inscripcioni" id="fecha_inscripcioni" value="<?php echo $fecha_inscripcion ?>" class="form-control">                                
            </div>
            
        </div>    
    </div>           

<?php    mysqli_close($con);
