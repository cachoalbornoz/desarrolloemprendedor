<?php 
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');

$con = conectar();

$id_solicitante = $_SESSION['id_usuario'];

$tabla_inversores = mysqli_query($con, "SELECT inver.* FROM proceder_inversores inver 
INNER JOIN rel_proceder relac ON relac.id_inversor = inver.id_inversor
WHERE relac.id_solicitante = $id_solicitante");

$fila   = mysqli_fetch_array($tabla_inversores, MYSQLI_BOTH); 

$apellidoii  = $fila['apellido'];
$nombresii   = $fila['nombres'];
$dniii       = $fila['dni'];
$cuitii      = $fila['cuit'];
$domicilioii = $fila['direccion'];
$nroii       = $fila['nro'];
$cpii        = $fila['cp'];
$id_ciudadii = $fila['id_ciudad'];
$fecha_nacii = $fila['fecha_nac'];
$cod_areaii  = $fila['cod_area'];
$celularii   = $fila['celular'];
$telefonoii  = $fila['telefono'];
$emailii     = $fila['email'];

$tabla_localidades   = mysqli_query($con, "select loc.nombre, dep.id as id_departamento, dep.nombre as departamento
from localidades loc inner join departamentos dep on loc.departamento_id = dep.id where loc.id = $id_ciudadii");
$registro_localidades= mysqli_fetch_array($tabla_localidades, MYSQLI_BOTH);

$ciudadii            = $registro_localidades['nombre'];
$id_departamentoii   = $registro_localidades['id_departamento'];
$departamentoii      = $registro_localidades['departamento'];

?>
    <div class="card-header">
        <div class="form-group">
            <div class="row">
                <div class="col p3">
                    <h4>Datos Personales</h4>
                </div>
            </div>
        </div>
    </div>    

    <div class="form-group">
        <div class="row">
            <div class="col">
                <label class="p-3">Apellido</label>
                <input name="apellidoii" id="apellidoii" type="text" class="form-control" value="<?php echo $apellidoii ?>">
            </div>
            <div class="col">
                <label class="p-3">Nombres</label>
                <input name="nombresii" id="nombresii" type="text" class="form-control" value="<?php echo $nombresii ?>">
            </div>
            <div class="col">
                <label class="p-3">DNI</label>
                <input name="dniii" id="dniii" type="text" class="form-control" maxlength="8" value="<?php echo $dniii ?>" placeholder="Ingrese Nro sin puntos" >
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <label>CUIT</label>
                <input name="cuitii" id="cuitii" type="text" class="form-control" maxlength="11" value="<?php echo $cuitii ?>" placeholder="Ingrese Nro sin puntos" >
            </div>
            <div class="col">
                <label>FECHA NACIMIENTO <small class=" text-muted">dd/mm/aaaa</small> </label>
                <input id="fecha_nacii" name="fecha_nacii" type="date"  class="form-control" value="<?php echo $fecha_nacii; ?>" >
            </div> 
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <label>Domicilio</label>
                <input name="domicilioii" id="domicilioii"  type="text" value="<?php echo $domicilioii ?>" class="form-control">
            </div>
            <div class="col">
                <label>Nro</label>
                <input name="nroii" id="nroii" type="text" value="<?php echo $nroii ?>" class="form-control">
            </div>
            <div class="col">
                <label>C.P.</label>
                <input name="cpii" id="cpii" type="text" value="<?php echo $cpii ?>" class="form-control">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <label>Departamento</label>
                <select name="departamentoi" id="departamentoi" onchange="from(this.value,'ciudadii','ciudades.php')" class="form-control">
                <?php
                    $departamentos = "select id, nombre from departamentos where provincia_id = 7 order by nombre";
                    $registro = mysqli_query($con, $departamentos);
                    while ($fila = mysqli_fetch_array($registro)) {
                        
                        if($fila[0] == $id_departamentoii){
                            echo "<option value=".$id_departamentoii." selected>".$departamentoii."</option>\n";
                        }else{
                            echo "<option value=\"".$fila[0]."-id_ciudadii\">".$fila[1]."</option>\n";
                        }  
                    }
                
                    ?>
                </select>
            </div>
            <div class="col">
                <label>Localidad</label>
                <div id="ciudadii">
                    <select name="id_ciudadii"  id="id_ciudadii" class="form-control" >
                        <option value="<?php echo $id_ciudadii;?> "><?php echo $ciudadii; ?></option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <label>Cod Area</label>
                <input name="cod_areaii" id="cod_areaii"  type="text" value="<?php echo $cod_areaii ?>" class="form-control">
            </div>
            <div class="col">
                <label>Telefono Móvil</label>
                <input name="celularii" id="celularii"  type="text" value="<?php echo $celularii ?>" class="form-control">
            </div>
            <div class="col">
                <label>Telefono Alternativo</label>
                <input name="telefonoii" id="telefonoii"  type="text" value="<?php echo $telefonoii ?>" class="form-control">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <label>Email</label>
                <input name="emailii" id="emailii"  type="email" value="<?php echo $emailii ?>" class="form-control">
            </div>
        </div>
    </div>    

<?php    mysqli_close($con);
