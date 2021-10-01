<?php
require_once 'accesorios/front-superior.php';
require_once '../accesorios/accesos_bd.php';
$con = conectar();

?>

<form name="formsolicitante" id="formsolicitante" autocomplete="false" action='agregar_solicitantes.php' method="post">

    <div class="card mb-2">

        <div class="card-header bg-info text-white">

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-6 p-3">
                    <i class="fas fa-edit"></i> Registro único de emprendedores
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6 p-3">
                    <small>
                        (*) Completá por favor el siguiente formulario, <b>todos</b> los datos son necesarios.
                    </small>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <input id="id_solicitante" name="id_solicitante" type="hidden" value="0">
                    <input id="tiempo" name="tiempo" type="hidden" value="<?php echo time(); ?>">
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xs-12 col-md-6 col-lg-2 p-3">
                    <label>Dni</label>
                    <input id="dni" name="dni" type="number" class="form-control text-center shadow" autofocus required onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                    <div class="messages"></div>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-5 p-3">
                    <label>Apellido</label>
                    <input id="apellido" name="apellido" type="text" class="form-control mayus shadow" required>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-5 p-3">
                    <label>Nombres</label>
                    <input id="nombres" name="nombres" type="text" class="form-control mayus shadow" required>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12 p-3">
                    <div class="custom-control custom-radio mb-4">
                        <input type="radio" name="genero" id="radio1" value="0" class="custom-control-input ml-3 mr-3" checked onclick="limpiagenero();">
                        <label class="custom-control-label" for="radio1"> Mujer</label>
                    </div>
                    <div class="custom-control custom-radio mb-4">
                        <input type="radio" name="genero" id="radio2" value="1" class="custom-control-input ml-3 mr-3" onclick="limpiagenero();">
                        <label class="custom-control-label" for="radio2"> Varón</label>
                    </div>

                    <div class="custom-control custom-radio mb-4">
                        <input type="radio" name="genero" id="radio3" value="2" class="custom-control-input ml-3 mr-3" onclick="vergenero();">
                        <label class="custom-control-label" for="radio3"> No me identifico con ninguna de las anteriores</label>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <input id="otrogenero" name="otrogenero" type="text" class="form-control shadow d-none mb-4" placeholder="A los fines de identificar poblaciones pasibles de políticas públicas compensatorias específicas, te solicitamos que definas tu identidad de género">
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-3 p-3">
                    <label>Cuit/Cuil</label>
                    <input name="cuit" type="number" id="cuit" class="form-control shadow" required maxlength="11"
                        onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-3 p-3">
                    <label>Fecha Nacimiento</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input id="fecha_nac" name="fecha_nac" type="date" class="form-control text-center shadow"
                            required>
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
                        <input name="email" type="email" id="email" class="form-control minus shadow" required maxlength="150">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12 p-3">
                    <label>Domicilio</label>
                    <input id="direccion" name="direccion" type="text" class="form-control mayus shadow" required maxlength="150" >
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 p-3">
                    <label>Departamento</label>
                    <select name="departamento" id="departamento" onchange="from(this.value,'ciudad','ciudades.php')"
                        class="form-control shadow" required>
                        <option value="" disabled selected></option>
                        <?php
                        $departamentos = "SELECT id, nombre FROM departamentos WHERE provincia_id = 7 ORDER BY nombre";
                        $registro      = mysqli_query($con, $departamentos);
                        while ($fila = mysqli_fetch_array($registro)) {
                            echo "<option value=\"" . $fila[0] . '-id_ciudad' . "\">" . $fila[1] . "</option>\n";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6 p-3">
                    <label>Localidad</label>
                    <div id="ciudad">
                        <select name="id_ciudad" id="id_ciudad" class="form-control shadow" required>
                            <option value="" disabled selected></option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-4 p-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Cod área </span>
                        </div>
                        <input id="cod_area" name="cod_area" type="number" class="form-control shadow" maxlength="5" required placeholder="Por ej. 343 " aria-describedby="basic-addon1">
                    </div>

                </div>
                <div class="col-xs-12 col-md-12 col-lg-4 p-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Celular &nbsp; <i class="fas fa-mobile-alt"></i></span>
                        </div>
                        <input id="celular" name="celular" type="text" class="form-control shadow" required placeholder="Sin 15" aria-describedby="basic-addon2">
                    </div>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-4 p-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Otro &nbsp; <i class="fas fa-phone-alt"></i> </span>
                        </div>
                        <input id="telefono" name="telefono" type="text" class="form-control shadow" required aria-describedby="basic-addon3">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-xs-12 col-sm-6 col-lg-6 mt-3">
                    <div class="g-recaptcha" data-sitekey="6LdxcnUUAAAAAM5R_2E_NknVIft2KxtIiEoJNx3h"></div>
                </div>

                <div class="col-xs-12 col-sm-6 col-lg-6 align-self-center mt-3">
                    <input id="btnguardar" type="submit" class="btn btn-info btn-block" value='Registrarme' />
                </div>
            </div>

        </div>
    </div>

</form>


<?php require 'accesorios/front-scripts.php'; ?>


<?php
mysqli_close($con);
require 'accesorios/front-inferior.php';
