<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-superior.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/accesos_bd.php';
$con = conectar();

$id_solicitante = $_SESSION['id_usuario'];

// COMPROBAR SI EL USUARIO LOGUEADO TIENE UN PROYECTO

$tabla = mysqli_query(
    $con,
    "SELECT t1.*
    FROM proyectos t1
    INNER JOIN rel_proyectos_solicitantes t2 ON t1.id_proyecto = t2.id_proyecto
    INNER JOIN solicitantes t3 ON t2.id_solicitante = t3.id_solicitante
    WHERE t1.id_estado <> 25 AND t2.id_solicitante = $id_solicitante"
);

if ($registro = mysqli_fetch_array($tabla)) {

    // DATOS DEL PROYECTO
    $id_proyecto            = $registro['id_proyecto'];
    $denominacion           = $registro['denominacion'];
    $resumen_ejecutivo      = $registro['resumen_ejecutivo'];
    $monto                  = $registro['monto'];
    $descripcion            = $registro['descripcion'];
    $objetivos              = $registro['objetivos'];
    $oportunidades          = $registro['oportunidades'];
    $desarrollo             = $registro['desarrollo'];
    $historia               = $registro['historia'];
    $presente               = $registro['presente'];
    $lugardesarrollo        = $registro['lugardesarrollo'];
    $detallelugar           = $registro['detallelugar'];
    $caratecnicas           = $registro['caratecnicas'];
    $caratecnologicas       = $registro['caratecnologicas'];
    $caraprocesos           = $registro['caraprocesos'];
    $caramateriasprimas     = $registro['caramateriasprimas'];
    $caradesechos           = $registro['caradesechos'];
    $mercado                = $registro['mercado'];
    $caraclientes           = $registro['caraclientes'];
    $caracompetencia        = $registro['caracompetencia'];
    $caraproveedores        = $registro['caraproveedores'];
    $carariesgosestrategias = $registro['carariesgosestrategias'];
    $destinomonto           = $registro['destinomonto'];
    $personal               = $registro['personal'];
    $interaccion            = $registro['interaccion'];
    $impacto                = $registro['impacto'];
    $preciosproductos       = $registro['preciosproductos'];
    $origenfinanciacion     = $registro['origenfinanciacion'];
    $fodafortalezas         = $registro['fodafortalezas'];
    $fodaoportunidades      = $registro['fodaoportunidades'];
    $fodadebilidades        = $registro['fodadebilidades'];
    $fodaamenazas           = $registro['fodaamenazas'];
    $latitud                = $registro['latitud'];
    $longitud               = $registro['longitud'];
} else {
    mysqli_query($con, 'INSERT INTO proyectos (id_estado) VALUES (20)') or die('Error inserción proyectos');

    $id_proyecto = mysqli_insert_id($con);

    mysqli_query($con, "INSERT INTO rel_proyectos_solicitantes (id_proyecto,id_solicitante) VALUES ($id_proyecto, $id_solicitante)");

    // INICIALIZO VARIABLES DEL PROYECTO
    $denominacion           = '';
    $resumen_ejecutivo      = '';
    $monto                  = 0;
    $descripcion            = '';
    $objetivos              = '';
    $oportunidades          = '';
    $desarrollo             = '';
    $historia               = '';
    $presente               = '';
    $lugardesarrollo        = 0;
    $detallelugar           = '';
    $caratecnicas           = '';
    $caratecnologicas       = '';
    $caraprocesos           = '';
    $caramateriasprimas     = '';
    $caradesechos           = '';
    $mercado                = '';
    $caraclientes           = '';
    $caracompetencia        = '';
    $caraproveedores        = '';
    $carariesgosestrategias = '';
    $destinomonto           = '';
    $personal               = '';
    $interaccion            = '';
    $impacto                = '';
    $preciosproductos       = '';
    $origenfinanciacion     = '';
    $fodafortalezas         = '';
    $fodaoportunidades      = '';
    $fodadebilidades        = '';
    $fodaamenazas           = '';
    $latitud                = 0;
    $longitud               = 0;
}

// DATOS DEL REGISTRO INICIAL

$tabla = mysqli_query($con, "SELECT * FROM registro_solicitantes WHERE id_solicitante = $id_solicitante");

if ($registro = mysqli_fetch_array($tabla)) {
    $id_rubro      = $registro['id_rubro'];
    $id_medio      = $registro['id_medio'];
    $id_programa   = $registro['id_programa'];
    $observaciones = $registro['observaciones'];
}

$_SESSION['id_proyecto'] = $id_proyecto;

?>

<form id="solicitud" name="solicitud">

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <br>
        </div>
    </div>

    <div class="card mb-2 bg-info text-white" id="encabezado">

        <div class="card-header">

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-prepend1">Nro proyecto</span>
                        </div>
                        <input type="text" id="id_proyecto" name="id_proyecto" class="form-control text-center bg-white" readonly value="<?php print $id_proyecto; ?>">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <button type="button" class="btn btn-info float-right" onclick="guardar(this);">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="javascript:void(0)" onclick="ir_planillas()" class="btn btn-default float-right" title="Ir a planillas">
                        <i class="fas fa-arrow-alt-circle-right"></i>
                    </a>
                    <a href="#planillas" class="btn btn-default float-right" title="Ir al final">
                        <i class="fas fa-arrow-alt-circle-down"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="spopup" style="display: none;">
        <div class="btn-group bg-secondary" role="group" aria-label="botones">
            <a href="#encabezado" class="btn btn-default" title="Ir a principio">
                <i class="fas fa-arrow-alt-circle-up"></i>
            </a>
            <a href="#planillas" class="btn btn-default" title="Ir al final">
                <i class="fas fa-arrow-alt-circle-down"></i>
            </a>
            <a href="javascript:void(0)" onclick="ir_planillas()" class="btn btn-default float-right" title="Ir a planillas">
                <i class="fas fa-arrow-alt-circle-right"></i>
            </a>
            <button type="button" class="btn btn-info" id="enviar" onclick="guardar(this);">
                <i class="fas fa-save"></i> Guardar (F10)
            </button>
            <a href="#" class="btn btn-default" onClick="salida()" title="Salir">
                <i class="fas fa-sign-out-alt"></i> (salir)
            </a>
        </div>
    </div>

    <!-- Menu Ayuda -->
    <div class="card mb-4">

        <div class="card-body">

            <div class="row">
                <div class="col mx-auto jumbotron">
                    <h4 class="text-center">Ayuda - ¿Cómo completo el siguiente formulario ?</h4>

                    <p class="p-1"><u> Obligatoriedad de los datos </u></p>
                    <p class="p-1"> a) Lea atentamente lo solicitado en cada ítem.</p>
                    <p class="p-1"> b) Recuerde que todos los datos son obligatorios <span class="text-danger"> (*) </span>, salvo que se indique lo contrario.</p>
                    <p class="p-1"> c) Resguarde sus datos presionando Guardar o tecla <b>F10</b>. Una vez completado el formulario, continúe con las <b>Planillas Contables</b>.</p>
                    <br>
                    <p class="p-1"><u>Estado e Impresión del Proyecto</u></p>
                    <p class="p-1"> a) Una vez completo el formulario, se podrá Enviar e Imprimir, pero <strong>no podrán realizarse más cambios.</strong></p>
                    <p class="p-1"> b) Cuando se envía el Proyecto, debe aguardarse los resultados hasta la fecha que oportunamente informe la Dirección de Políticas de Apoyo Emprendedor.</p>
                    <p class="p-1"> c) El Estado del Proyecto se reflejará cada vez que UD. ingrese al sistema.</p>
                    <br>
                    <p class="p-1"><u>Latitud y Longitud - Geo Referenciación del Proyecto </u></p>
                    <p class="p-1"> a) Si no está ubicado en el lugar donde desarrollará el emprendimiento, ó al presionar <b>aquí</b> no obtuvo (Latitud ni Longitud), <br> lea <a href="Obtener ubicación GPS.pdf">Guía para obtención de Coordenadas GPS con Android</a>, y transcríbalas al formulario.</p>
                    <p class="p-1"> b) En el caso que esté ubicado en el territorio de su emprendimiento, haga click en <a href="javascript:void(0)" onclick="getLocation()">Obtener Ubicación GPS</a>
                    <p>
                </div>
            </div>

        </div>

    </div>

    <div class="card mb-2 bg-info text-white">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12-col-lg-12">
                    <i class="fas fa-edit"></i> - COMPLETE EL SIGUIENTE FORMULARIO
                </div>
            </div>
        </div>
    </div>

    <!-- Menu GeoLocalización -->
    <div class="card mb-4">
        <div class="card-header text-right border border-primary">
            <h4 class="card-title"> <i class="fas fa-globe-africa"></i> Geo referencia de tu proyecto</h4>
        </div>
        <div class="card-body text-center">

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-info text-white">Latitud</span>
                        </div>
                        <input id="latitud" name="latitud" type="number" class="form-control text-center empty" placeholder="Ej. -31.24139513" value=<?php print $latitud; ?>>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-info text-white">Longitud</span>
                        </div>
                        <input id="longitud" name="longitud" type="number" class="form-control text-center empty" placeholder="Ej. -59.8765868" value=<?php print $longitud; ?>>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    Nos interesa conocer dónde se realiza o realizará tu proyecto, presiona
                    <a href="javascript:void(0)" class="btn btn-link" onclick="getLocation()">aquí</a> y
                    obtendrás latitud y longitud de tu emprendimiento.
                </div>
            </div>

            <br />

        </div>
    </div>

    <!-- Denominacion del Proyecto -->
    <div class="card mb-4">
        <div class="card-header text-right border border-primary">
            <h4 class="card-title">Denominación del proyecto</h4>
        </div>

        <div class="card-body">

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <label for="denominacion">Denominación</label>
                    <input id="denominacion" name="denominacion" type="text" value="<?php print $denominacion; ?>" class="form-control mayus empty" maxlength="100">
                    <small>
                        Referencia e identificación de la idea de negocio; Referencia al proceso o producto que se pretende desarrollar.
                        <span class="text-muted">
                            (máx 100 caract.)
                        </span>
                    </small>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-6">

                    <label class=" text-danger">Importe solicitado</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-dollar-sign"></i>
                            </span>
                        </div>
                        <input id="monto" name="monto" type="number" value="<?php print $monto; ?>" class="form-control shadow text-center" onkeydown="noPuntoComa( event )">
                    </div>
                </div>
                <small class="ml-3 mt-3">
                    <span class="text-muted">
                        Importe solicitado a la Dirección de Desarrollo Emprendedor. Ingrese el valor sin puntos ni comas.
                    </span>
                </small>
            </div>


            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <label>Resumen ejecutivo</label>
                    <textarea id="resumen_ejecutivo" name="resumen_ejecutivo" rows="2" class="form-control mayus empty" maxlength="500"><?php print $resumen_ejecutivo; ?></textarea>
                    <small>Resumen descriptivo de la idea de negocio, de los rasgos sobresalientes y toda la información relevante que permita tener una idea acabada del proyecto.
                        <span class="text-muted">(máx 500 caracteres)</span>
                    </small>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="2" class="form-control mayus empty" maxlength="500"><?php print $descripcion; ?></textarea>
                    <small>Características sobresalientes del emprendimiento.
                        <span class="text-muted">(máx 500 caracteres)</span>
                    </small>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Objetivos</label>
                    <textarea id="objetivos" name="objetivos" rows="2" class="form-control mayus empty" maxlength="500"><?php print $objetivos; ?></textarea>
                    <small>Objetivos que se persiguen con este emprendimiento.
                        <span class="text-muted">(máx 500 caracteres)</span>
                    </small>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Oportunidades que significa</label>
                    <textarea id="oportunidades" name="oportunidades" rows="2" class="form-control mayus empty" maxlength="500"><?php print $oportunidades; ?></textarea>
                    <small>Oportunidades técnicas y/o comerciales existentes en el medio que acrecientan el atractivo general de esta Idea de Negocio.
                        <span class="text-muted">(máx 500 caracteres)</span>
                    </small>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Desarrollo actual</label>
                    <textarea id="desarrollo" name="desarrollo" rows="3" class="form-control mayus empty" maxlength="500"><?php print $desarrollo; ?></textarea>
                    <small>Estado en que se encuentra actualmente la Idea de Negocio.
                        <span class="text-muted">(máx 500 caracteres)</span>
                    </small>

                </div>
            </div>

        </div>
    </div>

    <!-- Presentacion Grupo Emprendedor -->
    <div class="card mb-4">

        <div class="card-header text-right border border-primary">
            <h4 class="card-title">Presentación del grupo emprendedor</h4>
        </div>

        <div class="card-body">

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Historia del proyecto</label>
                    <textarea id="historia" name="historia" rows="2" maxlength="500" class="form-control mayus empty" placeholder="Historia del grupo de emprendedores"><?php print $historia; ?></textarea>
                    <small>Origen del grupo de emprendedores.
                        <span class="text-muted">(máx 500 caracteres)</span>
                    </small>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Presente</label>
                    <textarea id="presente" name="presente" rows="2" maxlength="500" class="form-control mayus empty" placeholder="Presente del grupo de emprendedores"><?php print $presente; ?></textarea>
                    <small>Actualidad del grupo de emprendedores.
                        <span class="text-muted">(máx 500 caracteres)</span>
                    </small>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Ingrese aspectos de los productos y/o servicios; producción de los mismos</label>
                    <select id="lugardesarrollo" name="lugardesarrollo" class="form-control select2">
                        <option value="0" <?php if ($lugardesarrollo == 0) {
    print 'selected';
} ?>>Alquilado / Arrendado
                        </option>
                        <option value="1" <?php if ($lugardesarrollo == 1) {
    print 'selected';
} ?>>Propio
                        </option>
                    </select>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Descripción del lugar</label>
                    <textarea id="detallelugar" name="detallelugar" rows="2" maxlength="500" class="form-control mayus empty" placeholder="Descripción del lugar laboral, años alquiler, dimensiones, etc"><?php print $detallelugar; ?></textarea>
                    <small>Propio o alquiler / arrendamiento. Descripción del mismo, ubicación, etc.
                        <span class="text-muted">(máx 500 caracteres)</span>
                    </small>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Técnicas</label>
                    <textarea id="caratecnicas" name="caratecnicas" rows="2" maxlength="500" class="form-control mayus empty"><?php print $caratecnicas; ?></textarea>
                    <small>Características técnicas, especificaciones, funciones, cualidades, usos y aplicaciones del producto/servicio.
                        <span class="text-muted">(máx 500 caracteres)</span>
                    </small>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Tecnológicas</label>
                    <textarea id="caratecnologicas" name="caratecnologicas" rows="2" maxlength="500" class="form-control mayus empty"><?php print $caratecnologicas; ?></textarea>
                    <small>Estado del arte de la tecnología necesaria para elaborar sus productos y/o prestar sus servicios; ventajas o desventajas que la tecnología escogida presenta sobre otras existentes.
                        <span class="text-muted">(máx 500 caracteres)</span>
                    </small>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Procesos</label>
                    <textarea id="caraprocesos" name="caraprocesos" rows="2" maxlength="500" class="form-control mayus empty"><?php print $caraprocesos; ?></textarea>
                    <small>Etapas de los procesos productivos. Describir las que se realizarán en forma directa y las que serán tercerizadas.
                        <span class="text-muted">(máx 500 caracteres)</span>
                    </small>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Materias primas</label>
                    <textarea id="caramateriasprimas" name="caramateriasprimas" rows="2" maxlength="500" class="form-control mayus empty"><?php print $caramateriasprimas; ?></textarea>
                    <small>Materias primas que utilizará en los procesos productivos; volumen necesario por unidad de producto.
                        <span class="text-muted">(máx 500 caracteres)</span>
                    </small>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Desechos</label>
                    <textarea id="caradesechos" name="caradesechos" rows="2" maxlength="500" class="form-control mayus empty"><?php print $caradesechos; ?></textarea>
                    <small>
                        <span class="text-muted">(máx 500 caracteres)</span>
                    </small>

                </div>
            </div>

        </div>
    </div>

    <!-- Aspectos del Mercado -->
    <div class="card mb-4">
        <div class="card-header text-right border border-primary">
            <h4 class="card-title">Aspectos del mercado</h4>
        </div>

        <div class="card-body">

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Determinación Mercado</label>
                    <textarea id="mercado" name="mercado" maxlength="500" class="form-control mayus empty"><?php print $mercado; ?></textarea>
                    <small>Características del mercado; tamaño y el volumen de ventas en unidades.</small>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Descripción de los clientes</label>
                    <textarea id="caraclientes" name="caraclientes" maxlength="500" class="form-control mayus empty"><?php print $caraclientes; ?></textarea>
                    <small>
                        Rasgos esenciales de los clientes que forman los segmentos del mercado y características
                        principales de los mismos como ser: edad, sexo, nivel socio económico, establecimientos, etc.
                    </small>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Características de la competencia</label>
                    <textarea id="caracompetencia" name="caracompetencia" rows="2" maxlength="500" class="form-control mayus empty"><?php print $caracompetencia; ?></textarea>
                    <small>Características esenciales de los competidores.</small>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Características de los proveedores</label>
                    <textarea id="caraproveedores" name="caraproveedores" rows="2" maxlength="500" class="form-control mayus empty"><?php print $caraproveedores; ?></textarea>
                    <small>Nombrar y caracterizar proveedores de materias primas y otros bienes o servicios.</small>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Riesgos y estrategias de superación de los mismos</label>
                    <textarea id="carariesgosestrategias" name="carariesgosestrategias" rows="2" maxlength="500" class="form-control mayus empty"><?php print $carariesgosestrategias; ?></textarea>
                    <small>
                        Riesgos comerciales o técnicos que pueden surgir durante el desarrollo del emprendimiento, y vías de superación de los mismos previstas.
                    </small>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Destino del monto solicitado</label>
                    <textarea id="destinomonto" name="destinomonto" rows="2" maxlength="500" class="form-control mayus empty" placeholder="Destino del monto solicitado"><?php print $destinomonto; ?></textarea>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Personal</label>
                    <textarea id="personal" name="personal" rows="2" maxlength="500" class="form-control mayus empty" placeholder="Describa personal a emplear"><?php print $personal; ?></textarea>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Interacción prevista con el sector científico-tecnológico regional y nacional</label>
                    <textarea id="interaccion" name="interaccion" rows="2" maxlength="500" class="form-control mayus empty" placeholder="Interacción prevista con el sector Cientif/Tecnológico de la región."><?php print $interaccion; ?></textarea>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Impacto económico y social</label>
                    <textarea id="impacto" name="impacto" rows="2" maxlength="500" class="form-control mayus empty" placeholder="Impacto económico y social"><?php print $impacto; ?></textarea>

                </div>
            </div>

        </div>
    </div>

    <!-- Otros aspectos del Mercado -->
    <div class="card mb-4">
        <div class="card-header text-right border border-primary">
            <h4 class="card-title">Aspectos Económicos - Financieros</h4>
        </div>

        <div class="card-body">

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Precio de los productos</label>
                    <textarea id="preciosproductos" name="preciosproductos" rows="2" maxlength="500" class="form-control mayus empty" placeholder="Precio productos / servicios"><?php print $preciosproductos; ?></textarea>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Origen de la financiación</label>
                    <textarea id="origenfinanciacion" name="origenfinanciacion" rows="2" maxlength="500" class="form-control mayus empty" placeholder="Origen de la Financiación"><?php print $origenfinanciacion; ?></textarea>

                </div>
            </div>

        </div>
    </div>

    <!-- F.o.d.a.  -->
    <div class="card mb-4">

        <div class="card-header text-right border border-primary">
            <h4 class="card-title">F.O.D.A</h4>
        </div>

        <div class="card-body">

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Fortalezas</label>
                    <textarea id="fodafortalezas" name="fodafortalezas" rows="2" maxlength="500" class="form-control mayus empty"><?php print $fodafortalezas; ?></textarea>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Oportunidades</label>
                    <textarea id="fodaoportunidades" name="fodaoportunidades" rows="2" maxlength="500" class="form-control mayus empty"><?php print $fodaoportunidades; ?></textarea>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Debilidades</label>
                    <textarea id="fodadebilidades" name="fodadebilidades" rows="2" maxlength="500" class="form-control mayus empty"><?php print $fodadebilidades; ?></textarea>

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <label>Amenazas</label>
                    <textarea id="fodaamenazas" name="fodaamenazas" rows="2" maxlength="500" class="form-control mayus empty"><?php print $fodaamenazas; ?></textarea>
                    <br />
                    <small>
                        Fortalezas y debilidades propias del emprendimiento, conforme la visión que los
                        emprendedores tienen del mismo; oportunidades y amenazas externas al emprendimiento que pueden condicionar los resultados que se alcancen.
                    </small>

                </div>
            </div>

        </div>
    </div>


    <!-- Datos de la Empresa -->
    <div class="card mb-4">

        <div class="card-header text-right border border-primary">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <h4 class="card-title">Datos de la empresa </h4>
                    <small class=" text-danger">No es obligatorio</small>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div id="detalle_empresa">

            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <button type="button" class="btn btn-default" onclick="eliminarEmpresa()">
                        <i class="fas fa-trash text-danger"></i> Borrar empresa
                    </button>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <button type="button" class="btn btn-default" onclick="guardarEmpresa(this);">
                        <i class="fas fa-save text-info"></i> Guardar empresa
                    </button>
                </div>
            </div>

        </div>

    </div>

    <!-- Datos de Registro -->
    <div class="card mb-4">

        <div class="card-header text-right border border-primary">
            <h4 class="card-title">Datos del registro inicial</h4>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <label> Rubro productivo de interés </label>
                    <select id="id_rubro" name="id_rubro" size="1" class="form-control" readonly>
                        <?php
                        $registro = mysqli_query($con, 'select id_rubro, rubro from tipo_rubro_productivos order by rubro');
                        while ($fila = mysqli_fetch_array($registro)) {
                            if ($id_rubro == $fila[0]) {
                                print '<option value="' . $fila[0] . '" selected>' . $fila[1] . "</option>\n";
                            } else {
                                print '<option value="' . $fila[0] . '">' . $fila[1] . "</option>\n";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row  mb-3">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <label> Cómo se informó acerca del proyecto </label>
                    <select name="id_medio" id="id_medio" size="1" class="form-control" readonly>
                        <?php

                        $registro = mysqli_query($con, 'select id_medio, medio from tipo_medios_contacto');
                        while ($fila = mysqli_fetch_array($registro)) {
                            if ($id_medio == $fila[0]) {
                                print '<option value="' . $fila[0] . '" selected>' . $fila[1] . "</option>\n";
                            } else {
                                print '<option value="' . $fila[0] . '">' . $fila[1] . "</option>\n";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row  mb-3">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <label> Programa registrado </label>
                    <select name="id_programa" id="id_programa" size="1" class="form-control" readonly>
                        <?php
                        $registro = mysqli_query($con, 'select id_programa, programa from tipo_programas');
                        while ($fila = mysqli_fetch_array($registro)) {
                            if ($id_programa == $fila[0]) {
                                print '<option value="' . $fila[0] . '" selected>' . $fila[1] . "</option>\n";
                            } else {
                                print '<option value="' . $fila[0] . '">' . $fila[1] . "</option>\n";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row  mb-3">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <label>Reseña del proyecto</label>
                    <textarea name="observaciones" id="observaciones" rows="2" class="form-control mayus empty"><?php print $observaciones; ?></textarea>
                </div>
            </div>

        </div>
    </div>

</form>

<!-- Lista de Emprendedores -->
<div class="card">
    <div class="card-header border border-primary">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-xs-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">DNI </span>
                    </div>
                    <input id="dni" name="dni" type="number" placeholder="Escriba DNI a asociar " class="form-control shadow">
                    <div class=" input-group-append">
                        <button type="button" id="addAsociado" name="addAsociado" class="btn btn-info">
                            <i class="fa fa-plus"></i> Agregar
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-xs-6 text-right">
                <h4 class="card-title">Datos de los solicitantes</h4>
            </div>
        </div>

    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-xs-12" id="detalle_emprendedores">

            </div>
        </div>
    </div>
</div>


<!-- Lista de Emprendedores -->
<div class="card">
    <div class="card-header border border-primary">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-xs-4">

                <form method="post" action="" enctype="multipart/form-data" id="form">
                    <input type="file" name="image" id="image" class=" form-control-file" accept="image/png, image/jpeg, image/gif">
                    <span class="input-group btn">
                        <button type="submit" class="btn btn-info btn-sm" id="submit">Enviar</button>
                    </span>
                </form>

            </div>
            <div class="col-xs-12 col-sm-4 col-xs-4">
            </div>
            <div class="col-xs-12 col-sm-4 col-xs-4 text-right">
                <h4 class="card-title">Foto del emprendimiento</h4>
                <small>Sólo imagenes JPG, PNG . Tamaño max 3 Mbytes</small>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row mb-5">
            <div class="col-xs-12 col-sm-12 col-xs-12">
                Por favor, obtené una foto lo más clara y representativa posible de tu emprendimiento.
                Recordá que el tamaño de ésta foto <strong>no puede</strong> superar los 3 Mbytes, y
                debe ser tipo <strong>JPG o PNG</strong>.
                En caso de necesitar reducirle el tamaño a la foto, te sugerimos visitar algunos de éstos enlaces para reducirla.

                <ul class="mt-3">
                    <li>
                        <a href="https://www.iloveimg.com/es/redimensionar-imagen" target="_blank">
                            Redimensionar Imagen 1
                        </a>
                    </li>
                    <li>
                        <a href="https://www.achicarimagenes.com.ar" target="_blank">
                            Redimensionar Imagen 2
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-xs-12 text-center">
                <div id="detalle_foto"></div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <br>
    </div>
</div>


<div class="row mt-5 mb-5" id="planillas">
    <div class="col text-center">
        <a href="javascript:void(0)" class="btn btn-info" onclick="ir_planillas()">
            <i class="fas fa-calculator"></i> - Planillas contables
        </a>
    </div>
</div>

<div class="row mt-5 mb-5">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <br>
    </div>
</div>



<?php

mysqli_close($con);
require_once $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-scripts.php'; ?>

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

    .hidden {
        display: none;
    }
</style>

<script>
    var objeto = document.getElementById('enviar');

    const noPuntoComa = (event) => {
        var e = event || window.event;
        var key = e.keyCode || e.which;

        if (key === 110 || key === 190 || key === 188) {
            e.preventDefault();
        }
    }

    $(document).ready(function() {

        $("#monto").bind("cut copy paste", function(e) {
            e.preventDefault();
        });
        $("#detalle_emprendedores").load('detalle_solicitantes.php');
        $("#detalle_empresa").load('detalle_empresa.php');
        $("#detalle_foto").load('detalle_fotos.php');

    });



    const quitarFoto = () => {

        $("#detalle_foto").load('detalle_fotos.php', {
            operacion: 2,
        });
    }

    $("#form").submit(function(event) {
        event.preventDefault();

        $("#detalle_foto").html('Cargando .... <img src="/desarrolloemprendedor/public/imagenes/cargando.gif">');
        var file = $('#image').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file);

        $.ajax({
            type: 'POST',
            url: 'detalle_fotos.php',
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            complete: function() {

                setTimeout(function() {
                    $("#detalle_foto").load('detalle_fotos.php');
                }, 1000);
            }
        });
    })



    $("#addAsociado").on('click', function() {

        var dni = $("#dni").val();

        if (dni > 0) {

            $("#detalle_emprendedores").load('detalle_solicitantes.php', {
                operacion: 1,
                dni: dni
            });

            $("#dni").select();

        }
    })

    function borrar_solicitante(id, solicitante) {

        var id_proyecto = $("#id_proyecto").val();

        ymz.jq_confirm({
            title: "",
            text: "<div class='text-center'>Confirme desvincular a <b>" + solicitante + " </b> ? </div>",
            no_btn: "Cancelar",
            yes_btn: "Ok",
            no_fn: function() {
                return false;
            },
            yes_fn: function() {
                $("#detalle_emprendedores").load('detalle_solicitantes.php', {
                    operacion: 2,
                    id_solicitante: id,
                    id_proyecto: id_proyecto
                });
            }
        });

        $("#dni").select();
    }

    function eliminarEmpresa() {

        var id = $("#id_empresa").val();

        var em = $("#razon_social").val();

        ymz.jq_confirm({
            title: "",
            text: "<div class='text-center'> Confirme borrar empresa: " + em + "? </div>",
            no_btn: "Cancelar",
            yes_btn: "Ok",
            no_fn: function() {
                return false;
            },
            yes_fn: function() {
                $("#detalle_empresa").load('detalle_empresa.php', {
                    eliminar: 1,
                    id_empresa: id
                });
            }
        });
    }

    function guardarEmpresa(this1) {

        var validado = true;
        elementos = document.getElementsByClassName("formu");

        for (i = 0; i < elementos.length; i++) {
            if (elementos[i].value == "" || elementos[i].value == null) {
                validado = false
            }
        }

        if (validado) {

            this1.disabled = true;
            this1.innerHTML = 'Guardando empresa... aguarde ';

            var url = 'actualiza_empresa.php';

            $.ajax({
                type: 'POST',
                url: url,
                data: $("#solicitud").serialize(),
                success: function(response) {

                    setTimeout(function() {
                        this1.disabled = false;
                        this1.innerHTML = '<i class="fas fa-save text-info"></i> Guardar empresa';
                    }, 1000);

                    $("#detalle_empresa").load('detalle_empresa.php');

                }
            })

        } else {

            toastr.options = {
                "progressBar": true,
                "showDuration": "800",
                "timeOut": "3000"
            };
            toastr.warning("Complete todos los datos", "No se guardó la empresa ... ");

        }
    }

    $(document).on('keydown', function(e) {

        if (e.keyCode === 121) { // F10

            guardar(objeto);

        }

    });

    function guardar(this1) {

        this1.disabled = true;
        this1.innerHTML = 'Guardando ... aguarde ';

        var url = "editar_proyectos.php";
        $.ajax({
            type: "POST",
            url: url,
            data: $("#solicitud").serialize(),

            success: function(data) {

                console.log(data);

                toastr.options = {
                    "progressBar": true,
                    "showDuration": "800",
                    "timeOut": "3000"
                };
                setTimeout(function() {
                    this1.disabled = false;
                    this1.innerHTML = ' <i class="fas fa-save"></i> Guardar (F10)';
                }, 1000);
                toastr.info("Datos actualizados ! ");

            }
        });

        return false;
    }

    $(window).scroll(function() {
        if ($(document).scrollTop() >= ($(document).height() / 50))
            $("#spopup").show("slow");
        else
            $("#spopup").hide("slow");
    });

    // Funcion incorporada de Internet para que no metan espacios en blancos y parezca un campo completado
    // Devuelve String sin espacios
    String.prototype.trimstring = function() {
        return this.replace(/^\s+|\s+$/g, "");
    };
    //

    function ir_planillas() {

        var latitud = document.getElementById('latitud').value;
        var longitud = document.getElementById('longitud').value;
        var denominacion = document.getElementById('denominacion').value;
        var resumen_ejecutivo = document.getElementById('resumen_ejecutivo').value;
        var monto = document.getElementById('monto').value;
        var id_rubro = document.getElementById('id_rubro').value;
        var descripcion = document.getElementById('descripcion').value;
        var objetivos = document.getElementById('objetivos').value;
        var oportunidades = document.getElementById('oportunidades').value;
        var desarrollo = document.getElementById('desarrollo').value;
        var historia = document.getElementById('historia').value;
        var presente = document.getElementById('presente').value;
        var lugardesarrollo = document.getElementById('lugardesarrollo').value;
        var detallelugar = document.getElementById('detallelugar').value;
        var caratecnicas = document.getElementById('caratecnicas').value;
        var caratecnologicas = document.getElementById('caratecnologicas').value;
        var caraprocesos = document.getElementById('caraprocesos').value;
        var caramateriasprimas = document.getElementById('caramateriasprimas').value;
        var caradesechos = document.getElementById('caradesechos').value;
        var mercado = document.getElementById('mercado').value;
        var caraclientes = document.getElementById('caraclientes').value;
        var caracompetencia = document.getElementById('caracompetencia').value;
        var caraproveedores = document.getElementById('caraproveedores').value;
        var carariesgosestrategias = document.getElementById('carariesgosestrategias').value;
        var destinomonto = document.getElementById('destinomonto').value;
        var personal = document.getElementById('personal').value;
        var interaccion = document.getElementById('interaccion').value;
        var impacto = document.getElementById('impacto').value;
        var preciosproductos = document.getElementById('preciosproductos').value;
        var origenfinanciacion = document.getElementById('origenfinanciacion').value;
        var fodafortalezas = document.getElementById('fodafortalezas').value;
        var fodaoportunidades = document.getElementById('fodaoportunidades').value;
        var fodadebilidades = document.getElementById('fodadebilidades').value;
        var fodaamenazas = document.getElementById('fodaamenazas').value;
        var observaciones = document.getElementById('observaciones').value;
        var id_medio = document.getElementById('id_medio').value;

        var valido = 1;

        if (latitud.trimstring().length == 0 || longitud.trimstring().length == 0) {
            var valido = 0;
            $("#latitud").focus();
            var texto =
                '<div class="card card-warning"><div class="card-header border border-primary"><h3 class="card-title">&nbsp;</div><div class="card-body"><div class="row"><label> Geolocalización - presione obtener por favor </label></div></div></div>';
            ymz.jq_alert({
                title: "&nbsp; Complete los siguientes <b>items</b>  &nbsp;",
                text: texto,
                ok_btn: "Aceptar",
                close_fn: null
            });
        }

        if (denominacion.trimstring().length == 0 || resumen_ejecutivo.trimstring().length == 0 || monto == 0 || descripcion.trimstring().length == 0 || objetivos.trimstring().length == 0 ||
            oportunidades.trimstring().length == 0 || desarrollo.trimstring().length == 0) {
            var valido = 0;
            $("#denominacion").focus();

            var texto =
                '<div class="card card-warning"><div class="card-header border border-primary"><div class="card-body"><div class="row"><label> <li>Denominación del proyecto</li></label></div></div></div>';
            ymz.jq_alert({
                title: "&nbsp; Complete los siguientes <b>items</b> &nbsp;",
                text: texto,
                ok_btn: "Aceptar",
                close_fn: null
            });
        }

        if (historia.trimstring().length == 0 || presente.trimstring().length == 0 || lugardesarrollo.trimstring().length == 0 || detallelugar.trimstring().length == 0 || caratecnicas.trimstring().length == 0 ||
            caratecnologicas.trimstring().length == 0 || caraprocesos.trimstring().length == 0 || caramateriasprimas.trimstring().length == 0 || caradesechos.trimstring().length == 0) {
            var valido = 0;
            $("#historia").focus();
            var texto =
                '<div class="card card-warning"><div class="card-header border border-primary"><h3 class="card-title">&nbsp;</div><div class="card-body"><div class="row"><label> Presentacion grupo emprendedor</label></div></div></div>';
            ymz.jq_alert({
                title: "&nbsp; Complete los siguientes <b>items</b> &nbsp;",
                text: texto,
                ok_btn: "Aceptar",
                close_fn: null
            });
        }

        if (mercado.trimstring().length == 0 || caraclientes.trimstring().length == 0 || caracompetencia.trimstring().length == 0 || caraproveedores.trimstring().length == 0 || carariesgosestrategias.trimstring().length == 0 ||
            destinomonto.trimstring().length == 0 || personal.trimstring().length == 0 || interaccion.trimstring().length == 0 || impacto.trimstring().length == 0) {

            var valido = 0;
            $("#mercado").focus();
            var texto =
                '<div class="card card-warning"><div class="card-header border border-primary"><h3 class="card-title">&nbsp;</div><div class="card-body"><div class="row"><label> Aspectos del mercado</label></div></div></div>';
            ymz.jq_alert({
                title: "&nbsp; Complete los siguientes <b>items</b>  &nbsp;",
                text: texto,
                ok_btn: "Aceptar",
                close_fn: null
            });
        }

        if (preciosproductos.trimstring().length == 0 || origenfinanciacion.trimstring().length == 0) {

            var valido = 0;
            $("#preciosproductos").focus();
            var texto =
                '<div class="card card-warning"><div class="card-header border border-primary"><h3 class="card-title">&nbsp;</div><div class="card-body"><div class="row"><label> Aspectos económicos - financieros </label></div></div></div>';
            ymz.jq_alert({
                title: "&nbsp; Complete los siguientes <b>items</b>  &nbsp;",
                text: texto,
                ok_btn: "Aceptar",
                close_fn: null
            });
        }

        if (fodafortalezas.trimstring().length == 0 || fodaoportunidades.trimstring().length == 0 || fodadebilidades.trimstring().length == 0 || fodaamenazas.trimstring().length == 0) {

            var valido = 0;
            $("#fodafortalezas").focus();
            var texto =
                '<div class="card card-warning"><div class="card-header border border-primary"><h3 class="card-title">&nbsp;</div><div class="card-body"><div class="row"><label> Aspectos económicos y financieros</label></div></div></div>';
            ymz.jq_alert({
                title: "&nbsp; Complete los siguientes <b>items</b>  &nbsp;",
                text: texto,
                ok_btn: "Aceptar",
                close_fn: null
            });
        }

        if (observaciones.trimstring().length == 0) {
            var valido = 0;
            var texto =
                '<div class="card card-warning"><div class="card-header border border-primary"><h3 class="card-title">&nbsp;</div><div class="card-body"><div class="row"><label> Reseña del proyecto </label></div></div></div>';
            ymz.jq_alert({
                title: "&nbsp; Complete los siguientes <b>items</b>  &nbsp;",
                text: texto,
                ok_btn: "Aceptar",
                close_fn: null
            });
        }

        if (valido == 1) {
            window.location = 'planillas.php';
        }

    }

    function getLocation() {
        if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(showPosition);

        } else {

            var texto = 'Geolocación no identificada por su navegador';
            ymz.jq_alert({
                title: "Información",
                text: texto,
                ok_btn: "Ok",
                close_fn: null
            });
        }
    }

    function showPosition(position) {
        document.getElementById('latitud').value = position.coords.latitude;
        document.getElementById('longitud').value = position.coords.longitude;
    }
</script>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-inferior.php';
