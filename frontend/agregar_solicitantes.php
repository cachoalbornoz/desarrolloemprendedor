<?php
session_start();

$response = $_POST["g-recaptcha-response"];
$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array(
	'secret' => '6LdxcnUUAAAAADI2DkqCkGZ1WAp4y8zzG9S2y-Ow',
	'response' => $response
);
$query = http_build_query($data);
$options = array(
	'http' => array (
		'header' => "Content-Type: application/x-www-form-urlencoded\r\n", 
		"Content-Length: ".strlen($query)."\r\n".
		"User-Agent:MyAgent/1.0\r\n",
		'method' => 'POST',
		'content' => $query
	)
);
$context  = stream_context_create($options);
$verify = file_get_contents($url, false, $context);
$captcha_success=json_decode($verify);


require_once('accesorios/front-superior.php');
require('../accesorios/accesos_bd.php');
$con = conectar();

if($captcha_success->success){ 

	$dni        	= $_POST['dni'];
	$apellido   	= strtoupper(ltrim($_POST['apellido']));
	$nombres    	= strtoupper(ltrim($_POST['nombres']));
    $genero  	    = $_POST['genero'];
    $otrogenero  	= $_POST['otrogenero'];
	$fecha_nac  	= $_POST['fecha_nac'];
	$email      	= strtolower($_POST['email']);
	$cuit       	= $_POST['cuit'];
	$direccion  	= strtoupper(ltrim($_POST['direccion']));
	$facebook    	= strtoupper(ltrim($_POST['facebook']));
	$instagram    	= strtoupper(ltrim($_POST['instagram']));
	$id_ciudad  	= $_POST['id_ciudad'];
	$cod_area 		= $_POST['cod_area'];
	$celular    	= $_POST['celular'];
	$telefono   	= $_POST['telefono'];

    $inserta    = "INSERT INTO solicitantes 
		(dni, apellido, nombres, genero, otrogenero, direccion, fecha_nac, facebook, instagram, email, cuit, cod_area, telefono, celular, id_ciudad, observaciones, id_responsabilidad)
    	VALUES 
		('$dni','$apellido','$nombres', $genero, '$otrogenero', '$direccion', '$fecha_nac', '$facebook', '$instagram', '$email', '$cuit', '$cod_area', '$telefono', '$celular', $id_ciudad, '1', 1)";


	mysqli_query($con, $inserta) or die ($inserta);


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

    mysqli_query($con,
    "INSERT INTO registro_solicitantes (id_solicitante, id_rubro, id_medio, id_programa, observaciones, id_empresa, id_entidad) 
        VALUES ($id_solicitante, $id_rubro, $id_medio, $id_programa, '$observaciones', $id_empresa, $id_entidad)" ) or die('Error en la insercion registro_solicitantes');


	mysqli_close($con);


    $_SESSION['id_usuario']     = $id_solicitante;
    $_SESSION['usuario']        = $email;
    $_SESSION['apellido']       = $apellido;
    $_SESSION['nombres']        = $nombres;
    $_SESSION['dni']            = $dni;
    $_SESSION['tipo_usuario']   = 'b';

    header("location:/desarrolloemprendedor/frontend/registro_edita.php?id_solicitante=" . $_SESSION['id_usuario']);
    
	$titulo 	= "correcto";
	$mensaje 	= "<h5><i class='far fa-edit'></i> ".$nombres . " </h5> <br> Tu usuario es  <b>" . $email . " </br> y tu clave <b>" . $dni . "</b>";
	$enlace		= '<a href="/desarrolloemprendedor/frontend/registro_edita.php?id_solicitante='.$id_solicitante.'" class="btn btn-info">Continuar</a>';
	$clase		= 'class="alert alert-info"';
	

}else{

	$titulo 	= "fallido";
	$mensaje 	= "Ha ingresado un código captcha erroneo.";
	$enlace		= "<a href='javascript:history.go(-1);' class='btn btn-warning'> Regresar</a>";
	$clase		= 'class="alert alert-warning"';
}
	?>


	<div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-6">
					<i class='icon fa fa-check'></i> Registro <?php echo $titulo ?>
                </div>
				<div class="col-xs-12 col-sm-6 col-lg-6  text-right">
					<?php echo $enlace ; ?>
                </div>
            </div>
        </div>

        <div class="card-body">

			<div class="form-group">
				<div class="row m-5">                
					<div class="col-xs-12 mx-auto">
						&nbsp;
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row m-3">                
					<div class="col-xs-12 mx-auto">
						<div <?php echo $clase ; ?>>
							<?php echo $mensaje ; ?>
						</div>    
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row m-5">                
					<div class="col-xs-12 mx-auto">
						&nbsp;
					</div>
				</div>
			</div>

		</div>

	</div>


	<?php 

	require('accesorios/front-scripts.php') ; 
    
	require('accesorios/front-inferior.php') ;   
	

?>

