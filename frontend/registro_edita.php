<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/frontend/accesorios/front-superior.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php';

$con = conectar();

// INICIALIZO DATOS DEL EMPRENDEDOR
$cuit               = null;
$sociedad           = null;
$id_departamentol   = null;
$departamentol      = null;
$ciudadl            = null;
$id_departamentor   = null;
$departamentor      = null;
$ciudadr            = null;

// INICIALIZO DATOS DEL EMPRENDIMIENTO
$id_medio           = 6;
$id_programa        = 1;
$id_rubro           = 14;
$id_entidad         = 0;
$programa           = null;
$medio              = null;
$rubro              = null;

// INICIALIZO DATOS DE LA EMPRESA
$id_empresa         = 0;
$razon_social       = null;
$cuite              = null;
$id_tipo_sociedad   = null;
$fecha_inscripcion  = null;
$fecha_inicio       = null;
$domiciliol         = null;
$nrol               = null;
$id_ciudadl         = null;
$domicilior         = null;
$nror               = null;
$id_ciudadr         = null;
$representante      = null;
$codigoafip         = null;
$actividadafip      = null;
$otrosregistros     = null;
$nroexportador      = 0;

$id_solicitante = $_SESSION['id_usuario'];

if (isset($_SESSION['es_expediente']) and $_SESSION['es_expediente']) {
    // LEER DATOS DEL EMPRENDEDOR
    $tabla_solicitantes = mysqli_query($con, "SELECT * FROM emprendedores WHERE id_emprendedor = $id_solicitante");
    $registro_solicitantes = mysqli_fetch_array($tabla_solicitantes);

    $dni            = $registro_solicitantes['dni'];
    $apellido       = $registro_solicitantes['apellido'];
    $nombres        = $registro_solicitantes['nombres'];
    $genero         = $registro_solicitantes['genero'];
    $otrogenero     = $registro_solicitantes['otrogenero'];
    $direccion      = $registro_solicitantes['direccion'];
    $email          = $registro_solicitantes['email'];
    $cuit           = $registro_solicitantes['cuit'];
    $telefono       = $registro_solicitantes['telefono'];
    $cod_area       = $registro_solicitantes['cod_area'];
    $celular        = $registro_solicitantes['celular'];
    $id_ciudad      = $registro_solicitantes['id_ciudad'];
    $fecha_nac      = $registro_solicitantes['fecha_nac'];

    $query = "INSERT INTO solicitantes (dni, apellido, nombres, genero, otrogenero, email, cuit, cod_area, telefono, celular, id_responsabilidad, observaciones, id_ciudad, direccion, fecha_nac)
        VALUES ($dni,'$apellido','$nombres', $genero, '$otrogenero', '$email', '$cuit', '$cod_area', '$telefono', '$celular', 1, 1, $id_ciudad, '$direccion', '$fecha_nac')";

    mysqli_query($con, $query) or die('Error en la insercion solicitantes expedientes');

    $id_solicitante = mysqli_insert_id($con);

    $_SESSION['id_usuario'] = $id_solicitante;

    // DATOS INICIALIZADOS PARA EL EMPRENDEDOR

    $id_medio       = 6;                // OTRO MEDIO
    $id_programa    = 1;                // JOVENES EMPRENDEDORES
    $id_rubro       = 30;               // AGROINDUSTRIA
    $id_empresa     = 0;                // EMPRESA RESETEADA
    $id_entidad     = 0;                // ENTIDAD RESETEADA
    $funciona       = 0;                // NO FUNCIONA - TIENE QUE CARGAR DATOS DE LA EMPRESA
    $observaciones  = 'COMPLETE';       // RESEÑA DEL PROYECTO

    // AGREGA DATOS AL REGISTRO DEL SOLICITANTE

    mysqli_query($con,
    "INSERT INTO registro_solicitantes (id_solicitante, id_rubro, id_medio, id_programa, observaciones, id_empresa, id_entidad) 
        VALUES ($id_solicitante, $id_rubro, $id_medio, $id_programa, '$observaciones', $id_empresa, $id_entidad)" ) or die('Error en la insercion registro_solicitantes');

    // ANULA LA VARIABLE
    unset($_SESSION['es_expediente']);
}

$id_solicitante = $_SESSION['id_usuario'];

$tabla_empresa = mysqli_query($con,
"SELECT t2.* 
    FROM registro_solicitantes t1
    INNER JOIN maestro_empresas t2 ON t1.id_empresa = t2.id
    WHERE t1.id_solicitante = $id_solicitante");

$tabla_solicitantes     = mysqli_query($con, "SELECT * FROM solicitantes WHERE id_solicitante = $id_solicitante");
$registro_solicitantes  = mysqli_fetch_array($tabla_solicitantes);

$dni            = $registro_solicitantes['dni'];
$apellido       = $registro_solicitantes['apellido'];
$nombres        = $registro_solicitantes['nombres'];
$genero         = $registro_solicitantes['genero'];
$otrogenero     = $registro_solicitantes['otrogenero'];
$email          = $registro_solicitantes['email'];
$cuit           = $registro_solicitantes['cuit'];
$direccion      = $registro_solicitantes['direccion'];
$cod_area       = $registro_solicitantes['cod_area'];
$telefono       = $registro_solicitantes['telefono'];
$celular        = $registro_solicitantes['celular'];
$id_ciudad      = $registro_solicitantes['id_ciudad'];
$fecha_nac      = $registro_solicitantes['fecha_nac'];
$observaciones  = $registro_solicitantes['observaciones'];

$tabla_observaciones = mysqli_query($con, "SELECT observaciones, observacionesp FROM registro_solicitantes WHERE id_solicitante = $id_solicitante");

if ($registro_observaciones = mysqli_fetch_array($tabla_observaciones)) {
    $texto_observaciones = $registro_observaciones[0];
    $texto_observacionesp = $registro_observaciones[1];
} else {
    $texto_observaciones = 'COMPLETE';
    $texto_observacionesp = '';
}

$tabla_localidades = mysqli_query($con,
"SELECT loc.nombre, dep.id as id_departamento, dep.nombre as departamento
    FROM localidades loc 
    INNER JOIN departamentos dep on loc.departamento_id = dep.id 
    WHERE loc.id = $id_ciudad");
$registro_localidades = mysqli_fetch_array($tabla_localidades);

$ciudad         = $registro_localidades['nombre'];
$id_departamento= $registro_localidades['id_departamento'];
$departamento   = $registro_localidades['departamento'];

// LEER MEDIO / PROGRAMA / RUBRO / EMPRESA

$tabla_registro = mysqli_query($con, "SELECT * FROM registro_solicitantes WHERE id_solicitante = $id_solicitante"
);

if ($registro_mp = mysqli_fetch_array($tabla_registro)) {

    $id_programa= $registro_mp['id_programa'];;
    $id_medio   = $registro_mp['id_medio'];
    $id_rubro   = $registro_mp['id_rubro'];
    $id_entidad = $registro_mp['id_entidad'];
    $id_empresa = $registro_mp['id_empresa'];

}else{

    $inserta = "INSERT INTO registro_solicitantes (id_solicitante, id_rubro, id_medio, id_programa, observaciones, id_empresa, id_entidad) 
    VALUES ($id_solicitante, $id_rubro, $id_medio, $id_programa, '$observaciones', $id_empresa, $id_entidad)";

    mysqli_query($con, $inserta) or die($inserta);
}

// LEER DATOS DE LA EMPRESA

if ($registro_empresa = mysqli_fetch_array($tabla_empresa)) {
    $id_empresa = $registro_empresa['id'];
    $razon_social = $registro_empresa['razon_social'];
    $cuite = $registro_empresa['cuit'];
    $id_tipo_sociedad = $registro_empresa['id_tipo_sociedad'];

    if (!$id_tipo_sociedad) {
        $id_tipo_sociedad = 0;
    }

    $tabla_sociedades   = mysqli_query($con, "SELECT forma FROM tipo_forma_juridica WHERE id_forma = $id_tipo_sociedad");
    $registro_sociedad  = mysqli_fetch_array($tabla_sociedades);
    $sociedad           = $registro_sociedad[0];
    $fecha_inscripcion  = $registro_empresa['fecha_inscripcion'];
    $fecha_inicio       = $registro_empresa['fecha_inicio'];

    $domiciliol = $registro_empresa['domicilio'];
    $nrol       = $registro_empresa['nro'];
    $id_ciudadl = $registro_empresa['id_localidad'];

    $tabla_localidades = mysqli_query($con,
    "SELECT loc.nombre, dep.id as id_departamento, dep.nombre as departamento
        FROM localidades loc 
        INNER JOIN departamentos dep on loc.departamento_id = dep.id 
        WHERE loc.id = $id_ciudadl" );

    $registro_localidades = mysqli_fetch_array($tabla_localidades);

    $ciudadl            = $registro_localidades['nombre'];
    $id_departamentol   = $registro_localidades['id_departamento'];
    $departamentol      = $registro_localidades['departamento'];

    $domicilior         = $registro_empresa['domicilio_actividad'];
    $nror               = $registro_empresa['nro_actividad'];
    $id_ciudadr         = $registro_empresa['id_localidad_actividad'];

    $tabla_localidades = mysqli_query($con,
    "SELECT loc.nombre, dep.id as id_departamento, dep.nombre as departamento
        FROM localidades loc 
        INNER JOIN departamentos dep on loc.departamento_id = dep.id 
        WHERE loc.id = $id_ciudadr" );

    $registro_localidades = mysqli_fetch_array($tabla_localidades);

    $ciudadr            = $registro_localidades['nombre'];
    $id_departamentor   = $registro_localidades['id_departamento'];
    $departamentor      = $registro_localidades['departamento'];

    $representante  = $registro_empresa['representante'];
    $codigoafip     = $registro_empresa['codigoafip'];
    $actividadafip  = $registro_empresa['actividadafip'];
    $otrosregistros = $registro_empresa['otrosregistros'];
    $nroexportador  = $registro_empresa['nroexportador'];
}

?>

<style>
    #spopup {
        opacity: 0.8;
        width: auto;
        position: fixed;
        bottom: 13px;
        right: 25px;
        display: none;
        z-index: 90;
    }
</style>

<form name="formsolicitantedit" id="formsolicitantedit">

    <div id="spopup" style="display: none;">
        <div class="btn-group bg-secondary" role="group" aria-label="botones">
            <button type="button" class="btn btn-info" id="enviar" onclick="guardar();">
                <i class="fas fa-save"></i> Actualizar mis datos (F10)
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <br>
        </div>
    </div>

    <div class="card mb-2">
        <div class="card-header bg-info text-white">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 p-3">
                    &nbsp;
                </div>
            </div>
        </div>

        <div class="card-body">

            
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Recordá los datos de acceso al sistema: 
                <li class="ml-4">Usuario <b>correo electrónico</b></li>
                <li class="ml-4">Clave   <b>dni</b></li>
            </div>            

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <input id="id_solicitante" name="id_solicitante" type="hidden" value="<?php echo $id_solicitante; ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-2 p-3">
                    <label>DNI</label>
                    <input id="dni" name="dni" type="text" autofocus="true" class="form-control" value="<?php echo  $dni; ?>" required>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-5 p-3">
                    <label>Apellido</label>
                    <input id="apellido" name="apellido" type="text" class="form-control mayus" value="<?php echo  $apellido; ?>" required>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-5 p-3">
                    <label>Nombres</label>
                    <input id="nombres" name="nombres" type="text" class="form-control mayus" value="<?php echo  $nombres; ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12 p-3">
                    <div class="custom-control custom-radio mb-4">
                        <input type="radio" name="genero" id="radio1genero" value="0" class="custom-control-input ml-3 mr-3" <?php if ($genero == 0) { echo 'checked';} ?> onclick="limpiagenero();">
                        <label class="custom-control-label" for="radio1genero"> 
                            Mujer
                        </label>
                    </div>
                    <div class="custom-control custom-radio mb-4">
                        <input type="radio" name="genero" id="radio2genero" value="1" class="custom-control-input ml-3 mr-3" <?php if ($genero == 1) { echo 'checked';} ?> onclick="limpiagenero();">
                        <label class="custom-control-label" for="radio2genero"> 
                            Varón
                        </label>
                    </div>
                    <div class="custom-control custom-radio col-md-6 col-lg-6">
                        <input type="radio" name="genero" id="radio3genero" value="2" class="custom-control-input ml-3 mr-3" <?php if ($genero == 2) { echo 'checked';} ?> onclick="vergenero();">
                        <label class="custom-control-label" for="radio3genero"> 
                            No me identifico con ninguna opción
                        </label>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input id="otrogenero" name="otrogenero" value="<?php echo $otrogenero; ?>" type="text" class="form-control shadow <?php if ($genero == 0 or $genero == 1) { echo 'd-none';} ?>" placeholder="A los fines de identificar poblaciones pasibles de políticas públicas compensatorias específicas, te solicitamos que definas tu identidad de género">
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-3 p-3">
                    <label>Cuit/Cuil</label>
                    <input name="cuit" type="number" id="cuit" class="form-control"
                        value="<?php echo  $cuit; ?>" required
                        maxlength="11">
                </div>
                <div class="col-xs-12 col-md-6 col-lg-3 p-3">
                    <label>Fecha Nacimiento</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="date" id="fecha_nac" name="fecha_nac" class="form-control text-center" required
                            value="<?php echo $fecha_nac; ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-6 p-3">
                    <label>Email</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-envelope"></i>
                            </span>
                        </div>
                        <input name="email" type="email" id="email" class="form-control minus" value="<?php echo $email; ?>" required maxlength="150">
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12 p-3">
                    <label>Domicilio</label>
                    <input id="direccion" name="direccion" type="text" class="form-control mayus" value="<?php echo  $direccion; ?>" required maxlength="150">
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 p-3">
                    <label>Departamento</label>
                    <select name="departamento" id="departamento" onchange="from(this.value,'ciudad','ciudades.php')"
                        class="form-control" required>
                        <option
                            value="<?php echo $id_departamento; ?>"
                            selected><?php echo  $departamento; ?>
                        </option>
                        <?php
                        $departamentos = 'SELECT id, nombre FROM departamentos WHERE provincia_id = 7 order by nombre';
                        $registro = mysqli_query($con, $departamentos);
                        while ($fila = mysqli_fetch_array($registro)) {
                            echo '<option value="'.$fila[0].'">'.$fila[1]."</option>\n";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6 p-3">
                    <label>Localidad</label>
                    <div id="ciudad">
                        <select name="id_ciudad" id="id_ciudad" class="form-control" required>
                            <option
                                value="<?php echo  $id_ciudad; ?>"
                                selected><?php echo  $ciudad; ?>
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-4 p-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Codigo área </span>
                        </div>
                        <input id="cod_area" name="cod_area" type="number"
                            value="<?php echo $cod_area; ?>"
                            class="form-control" maxlength="5" required placeholder="Ej 343">
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-4 p-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Celular &nbsp; <i class="fas fa-mobile-alt"></i></span>
                        </div>
                        <input id="celular" name="celular" type="text"
                            value="<?php echo  $celular; ?>"
                            class="form-control" required>
                    </div>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-4 p-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Fijo &nbsp; <i class="fas fa-phone-alt"></i> </span>
                        </div>
                        <input id="telefono" name="telefono" type="text" class="form-control"
                            value="<?php echo $telefono; ?>" required>
                    </div>
                </div>
            </div>


            <div class="card card-body border border-info">

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label class="pb-2 ">Rubro productivo de interés</label>

                        <select name="id_rubro" id="id_rubro" class="form-control" size="9" required>
                            <?php
                            $rubros = 'SELECT id_rubro, rubro FROM tipo_rubro_productivos ORDER BY rubro';
                            $registro = mysqli_query($con, $rubros);
                            while ($fila = mysqli_fetch_array($registro)) {
                                if ($fila[0] == $id_rubro) {
                                    echo '<option value='.$id_rubro." selected \>".$fila['rubro'].'</option>';
                                } else {
                                    echo '<option value='.$fila[0].'>'.$fila['rubro'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">

                        <label class="pb-2 pt-4">¿Cómo te enteraste de éstos Programas ?</label>

                        <div class="custom-control custom-radio mb-4 ml-3 mr-3">
                            <input type="radio" name="id_medio" id="radiom1" value="1" <?php if ($id_medio == 1) { echo 'checked'; } ?> class="custom-control-input" required>
                            <label class="custom-control-label" for="radiom1"> 
                                <i class="fab fa-facebook-f ml-3 mb-3"></i> Facebook 
                            </label>
                        </div>
                        <div class="custom-control custom-radio mb-4 ml-3 mr-3">
                            <input type="radio" name="id_medio" id="radiom2" value="2" <?php if ($id_medio == 2) { echo 'checked'; } ?> class="custom-control-input">
                            <label class="custom-control-label" for="radiom2"> 
                                <i class="fas fa-tv ml-3 mb-3"></i> Televisión 
                            </label>
                        </div>
                        <div class="custom-control custom-radio mb-4 ml-3 mr-3">
                            <input type="radio" name="id_medio" id="radiom3" value="3" <?php if ($id_medio == 3) { echo 'checked'; } ?> class="custom-control-input">
                            <label class="custom-control-label" for="radiom3"> 
                                <i class="fas fa-broadcast-tower ml-3 mb-3"></i> Radio 
                            </label>
                        </div>
                        <div class="custom-control custom-radio mb-4 ml-3 mr-3">
                            <input type="radio" name="id_medio" id="radiom4" value="4" <?php if ($id_medio == 4) {  echo 'checked'; } ?> class="custom-control-input">
                            <label class="custom-control-label" for="radiom4"> 
                                <i class="fab fa-chrome ml-3 mb-3"></i> Internet 
                            </label>
                        </div>
                        <div class="custom-control custom-radio mb-4 ml-3 mr-3">
                            <input type="radio" name="id_medio" id="radiom5" value="5" <?php if ($id_medio == 5) { echo 'checked'; } ?> class="custom-control-input">
                            <label class="custom-control-label" for="radiom5"> 
                                <i class="far fa-newspaper ml-3 mb-3"></i> Diarios 
                            </label>
                        </div>
                        <div class="custom-control custom-radio mb-4 ml-3 mr-3">
                            <input type="radio" name="id_medio" id="radiom6" value="6" <?php if ($id_medio == 6) { echo 'checked';  } ?> class="custom-control-input">
                            <label class="custom-control-label" for="radiom6"> 
                                <i class="fas fa-info ml-3 mb-3"></i>  Otros 
                            </label>
                        </div>

                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">

                        <label class="pb-2 pt-4">En qué programa estás interesado ?</label>

                        <?php

                        $programas  = 'SELECT id_programa, programa FROM tipo_programas WHERE estado = 1 ORDER BY id_programa';
                        $registro   = mysqli_query($con, $programas);
                        $contador   = 1;

                        while ($fila = mysqli_fetch_array($registro)) {

                            $id_programa    = $fila['id_programa'];

                            $select         = mysqli_query($con, 
                            "SELECT id FROM registro_solicitantes WHERE id_solicitante = $id_solicitante AND id_programa = $id_programa");
                            $checked = (mysqli_num_rows($select) > 0)?$checked='checked':null;

                            ?>    

                            <div class="form-check mb-4 ml-3 mr-3">
                                <input class="form-check-input programa" name="id_programa[]" type="checkbox" <?php echo $checked; ?> value="<?php echo $id_programa; ?>" id="programaCheck<?php echo $contador; ?>">
                                <label class="form-check-label" for="programaCheck<?php echo $contador; ?>">
                                    <?php echo $fila['programa']; ?>
                                </label>
                            </div>

                            <?php

                            $contador++;
                        }

                        ?>
                        
                    </div>
                </div>

                <div class="row pt-5 pb-5">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <label>Reseña breve del proyecto</label>
                        <textarea name="idea" id="idea" class="form-control"
                            title="Describa las cualidades principales. Máx 1800 caracteres"
                            required><?php echo $texto_observaciones; ?></textarea>
                    </div>
                </div>

                <div class="row pb-2">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <label>Entidad vinculada al Ecosistema Emprendedor</label>
                    </div>
                </div>

                <div class="row pb-3">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="radio">
                            <label>
                                <input type="radio" name="opc_entidad" onclick="ocultar_entidad()" <?php if ($id_entidad == 0) {echo 'checked'; } ?>> No
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="opc_entidad" onclick="ver_entidad()" <?php if ($id_entidad != 0) { echo 'checked'; } ?>> Si
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row <?php if ($id_entidad == 0) { echo 'd-none'; } ?>" id="div_ecosistema">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <select name="id_entidad" id="id_entidad" class="form-control" size="5">
                            <option value="0" selected>Seleccione la entidad por favor </option>
                            <?php
                            $entidades = 'SELECT * FROM maestro_entidades WHERE estado <> 1 AND id_entidad > 0 ORDER BY entidad ASC';
                            $registro = mysqli_query($con, $entidades);
                            while ($fila = mysqli_fetch_array($registro)) {
                                if ($fila[0] == $id_entidad) {
                                    echo '<option value='.$fila[0].' selected>'.$fila[1].'</option>';
                                } else {
                                    echo '<option value='.$fila[0].'>'.$fila[1].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row pt-4 pb-2">
                    <div class="col">
                        <input type="checkbox" name="funciona" id="funciona" <?php if ($id_empresa > 0) { echo 'checked'; } ?>> Tengo un proyecto en marcha
                        <span class="text-info" id="msjopcional" <?php if ($id_empresa > 0) { echo 'style=" display: none" ';} ?>>
                        </span>
                        <span class="text-danger" id="msjobligatorio" <?php if ($id_empresa == 0) { echo 'style=" display: none" '; } ?>> 
                            (todos los datos son obligatorios)
                        </span>
                    </div>
                </div>

                <br />

                <div id="empresa" <?php if ($id_empresa == 0) {
                            echo 'style=" display: none" ';
                        } else {
                            echo 'class="card card-body border border-info"';
                        } ?>>

                    <div class="row pt-3 pb-2">
                        <div class="col">
                            <label>Nombre de la Empresa o Razón Social</label>
                            <input name="id_empresa" id="id_empresa" type="hidden" value="<?php echo $id_empresa; ?>">
                            <input name="razon_social" id="razon_social" type="text" class="form-control"value="<?php echo $razon_social; ?>">
                        </div>
                        <div class="col">
                            <label>Nro de CUIT</label>
                            <input name="cuite" type="text" id="cuite" class="form-control" maxlength="11" value="<?php echo $cuite; ?>" placeholder="Ingrese Nro sin puntos">
                        </div>
                        <div class="col">
                            <label>Tipo Sociedad</label>
                            <select id="id_tipo_sociedad" name="id_tipo_sociedad" size="1" class="form-control">
                                <?php
                                $tipo_sociedades = 'SELECT * FROM tipo_forma_juridica order by id_forma';
                                $registro = mysqli_query($con, $tipo_sociedades);
                                while ($fila = mysqli_fetch_array($registro)) {
                                    if ($fila[0] == $id_tipo_sociedad) {
                                        echo '<option value='.$id_tipo_sociedad." selected \>".$sociedad."</option>\n";
                                    } else {
                                        echo '<option value='.$fila[0].'>'.$fila[1]."</option>\n";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label>Domicilio Legal</label>
                            <input type="text" name="domiciliol" id="domiciliol" value="<?php echo $domiciliol; ?>" class="form-control">
                        </div>
                        <div class="col">
                            <label>Nro</label>
                            <input type="text" name="nrol" id="nrol" value="<?php echo $nrol; ?>" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label>Departamento</label>
                            <select name="departamentol" id="departamentol"
                                onchange="from(this.value,'ciudadl','ciudades.php')" class="form-control">
                                <option value="" disabled selected></option>
                                <?php

                            $departamentos = 'SELECT id, nombre FROM departamentos WHERE provincia_id = 7 order by nombre';
                            $registro = mysqli_query($con, $departamentos);
                            while ($fila = mysqli_fetch_array($registro)) {
                                if ($fila[0] == $id_departamentol) {
                                    echo '<option value='.$id_departamentol." selected \>".$departamentol."</option>\n";
                                } else {
                                    echo '<option value='.$fila[0].'-id_ciudadl'.'>'.$fila[1].'</option>';
                                }
                            }
                            ?>
                            </select>
                        </div>
                        <div class="col">
                            <label>Localidad</label>
                            <div id="ciudadl">
                                <select name="id_ciudadl" id="id_ciudadl" class="form-control">
                                    <option value="<?php echo $id_ciudadl; ?> " selected><?php echo $ciudadl; ?> </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label>Representante Legal</label>
                            <input name="representante" type="text" id="representante" value="<?php echo $representante; ?>" class="form-control" placeholder="Datos del representante">
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col">
                            <hr style="border-color: grey">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label>Domicilio radicación de la empresa</label>
                            <input type="text" name="domicilior" id="domicilior" value="<?php echo $domicilior; ?>" class="form-control">
                        </div>
                        <div class="col">
                            <label>Nro</label>
                            <input type="text" name="nror" id="nror" value="<?php echo $nror; ?>" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label>Departamento</label>
                            <select name="departamentor" id="departamentor" onchange="from(this.value,'ciudadr','ciudades.php')" class="form-control">
                                <option value="" disabled selected></option>
                                <?php
                                $departamentos = 'SELECT id, nombre FROM departamentos WHERE provincia_id = 7 order by nombre';
                                $registro = mysqli_query($con, $departamentos);

                                while ($fila = mysqli_fetch_array($registro)) {
                                    if ($fila[0] == $id_departamentor) {
                                        echo '<option value='.$id_departamentor." selected \>".$departamentor."</option>\n";
                                    } else {
                                        echo '<option value='.$fila[0].'-id_ciudadr'.'>'.$fila[1].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <label>Localidad</label>
                            <div id="ciudadr">
                                <select name="id_ciudadr" id="id_ciudadr" class="form-control">
                                    <option
                                        value="<?php echo $id_ciudadr; ?> "
                                        selected><?php echo $ciudadr; ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col">
                            <hr style="border-color: grey">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2">
                            <label>Codigo Afip</label>
                            <input name="codigoafip" type="text" id="codigoafip"
                                value="<?php echo $codigoafip; ?>"
                                class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <label>Actividad Codigo Afip</label>
                            <input name="actividadafip" type="text" id="actividadafip"
                                value="<?php echo $codigoafip; ?>"
                                class="form-control">
                        </div>
                        <div class="col-lg-3">
                            <label>Fecha Inscripción</label>
                            <input type="date" name="fecha_inscripcion" id="fecha_inscripcion"
                                value="<?php echo $fecha_inscripcion; ?>"
                                class="form-control">
                        </div>
                        <div class="col-lg-3">
                            <label>Fecha Inicio Actividad</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio"
                                value="<?php echo $fecha_inicio; ?>"
                                class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-9">
                            <label> Tiene inscripción en otros organismos, cuáles ?</label>
                            <input name="otrosregistros" id="otrosregistros" type="text"
                                value="<?php echo $otrosregistros; ?>"
                                class="form-control"
                                placeholder="Indique en que otros organismos, ej. ATER, Municipalidad, Otros.">
                        </div>
                        <div class="col-lg-3">
                            <label> Nro Exportador, si lo es.</label>
                            <input name="nroexportador" id="nroexportador" type="text"
                                value="<?php echo $nroexportador; ?>"
                                class="form-control">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-lg-8 mt-3">
                    </div>
                    <div class="col-xs-12 col-sm-4 col-lg-4 mt-3">
                        <input type="hidden" class="form-control btn-info" value="Actualizar mis datos">
                    </div>
                </div>
            </div>



        </div>


</form>

<?php mysqli_close($con); ?>

<?php require 'accesorios/front-scripts.php'; ?>

<script>
    var boton = $("#enviar");

    $(window).scroll(function() {
        if ($(document).scrollTop() >= ($(document).height() / 50))
            $("#spopup").show("slow");
        else
            $("#spopup").hide("slow");
    });

    function guardar() {
        $("#formsolicitantedit").submit();
    }

    $(document).on('keydown', function(e) {
        if (e.keyCode === 121) { // F10   
            guardar();
        }
    });

    $(function() {

        $("#formsolicitantedit").validate({
            rules: {
            "id_programa[]": {
                    required: true,
                    minlength: 1
                },
            },
            messages: {
                "id_programa[]": {
                    required: 'Seleccione un programa por favor',
                },
            },
            submitHandler: function(form) {
                
                enviar.disabled = true;
                enviar.innerHTML = 'Actualizando Mis Datos ... aguarde ';

                chequear_empresa();

                var form    = $('#formsolicitantedit');
                var url     = 'editar_solicitantes.php';
                var d       = new Date();
                var n       = d.getTime();

                $.ajax({
                    type: 'post',
                    url: url,
                    data: form.serialize(),
                    success: function(response) {

                        console.log(response);

                        if (response == 1) {

                            setTimeout(function() {
                                enviar.disabled = false;
                                enviar.innerHTML =
                                    ' <i class="fas fa-save"></i> Guardar (F10)';

                            }, 1000);
                        }
                    }
                })
            }
        });
    });
</script>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/frontend/accesorios/front-inferior.php';
