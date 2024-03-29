<!DOCTYPE html>
<html lang="es">

<head>

	<meta charset="utf-8">
	<link rel="icon" type="image/png" href="/desarrolloemprendedor/public/imagenes/favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="Keywords" content="proyectos,emprendedores,registro,gobierno,entre rios,financiacion" />
	<meta name="description" content="Sistema Administrativo del Ministerio de Producción Entre Rios para registro de Proyectos Productivos" />
	<meta name="robots" content="index,follow">

	<title>Desarrollo Emprendedor</title>

	
	<link rel="stylesheet" href="/desarrolloemprendedor/public/js/select2/dist/css/select2.min.css">
	<link rel="stylesheet" href="/desarrolloemprendedor/public/alert_js/ymz_box.css">
	<link rel="stylesheet" href="/desarrolloemprendedor/public/font-awesome-5.9.0/css/all.min.css">
	<link rel="stylesheet" href="/desarrolloemprendedor/public/bootstrap-4.3.1/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="/desarrolloemprendedor/public/css/styleheader.css">
	<link rel="stylesheet" href="/desarrolloemprendedor/public/css/toastr.css">

	<script src='https://www.google.com/recaptcha/api.js'></script>


</head>

<body>

	<div class="container">

		<div class="row mb-5">
			<div class="col-xs-12 col-md-4 col-lg-4 text-center">
				<img src="/desarrolloemprendedor/public/imagenes/cabecera2024.png" class=" img-fluid" />
			</div>
			<div class="col-xs-12 col-md-4 col-lg-4 text-center">
			</div>
			<div class="col-xs-12 col-md-4 col-lg-4 text-right pt-5">
				MINISTERIO DE <strong> DESARROLLO ECONÓMICO </strong>
			</div>
		</div>

		<?php
            if (!isset($_SESSION['usuario'])) {
                ?>
					<nav class="navbar navbar-expand-lg navbar-light bg-light favenir pb-3">

						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse" id="navbarNavDropdown">
							<ul class="navbar-nav nav-fill">
								<li class="nav-item active">
									<a href="/desarrolloemprendedor/index.php" class="nav-link text-black-50">
										&nbsp;
									</a>
								</li>
							</ul>
						</div>
					</nav>

				<?php
            } else {
                ?>

		<nav class="navbar navbar-expand-lg navbar-light bg-light pb-3 border">

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavDropdown">

				<ul class="navbar-nav nav-fill">
					<li class="nav-item">
						<a class="nav-link" href="/desarrolloemprendedor/frontend/registro_edita.php?id_solicitante=<?php print $_SESSION['id_usuario']; ?>">
							Mis datos
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="/desarrolloemprendedor/frontend/jovenes/bienvenida.php">
							Jovenes Emprendedores
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="/desarrolloemprendedor/frontend/proaccer/bienvenida.php">
							Proaceer
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="/desarrolloemprendedor/frontend/formacion/bienvenida.php">
							Formación
						</a>
					</li>
				</ul>

				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" href="#" onClick="salida()" title="Salir">
							<?php print ucwords(strtolower($_SESSION['nombres'] . ' ' . $_SESSION['apellido'])); ?>
							<i class="fas fa-sign-out-alt"></i>
						</a>
					</li>
				</ul>

			</div>
		</nav>
		<?php
            }
