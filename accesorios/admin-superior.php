<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

  	<meta charset="utf-8">
	<link rel="icon" type="image/png" href="/desarrolloemprendedor/public/imagenes/favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<meta name="Keywords" content="proyectos,emprendedores,registro,gobierno,entre rios,financiacion" />
	<meta name="description" content="Sistema Administrativo del Ministerio de Producción Entre Rios para registro de Proyectos Productivos" />
	<meta name="robots" content="index,follow">

	<title>Desarrollo emprendedor</title>

	<!--Plugin Alert Js	-->
	<link rel="stylesheet" href="/desarrolloemprendedor/public/alert_js/ymz_box.css">
	
	<!--Plugin Select 2	-->
	<link rel="stylesheet" href="/desarrolloemprendedor/public/js/select2/dist/css/select2.min.css">

	<!--Plugin BootStrap -->
	<link rel="stylesheet" href="/desarrolloemprendedor/public/bootstrap-4.3.1/dist/css/bootstrap.min.css">	

	<!--Plugin DataTables -->
	<link rel="stylesheet" href="/desarrolloemprendedor/public/DataTables/datatables.min.css">
	<link rel="stylesheet" href="/desarrolloemprendedor/public/DataTables/DataTables-1.10.20/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="/desarrolloemprendedor/public/DataTables/FixedHeader-3.1.6/css/fixedHeader.bootstrap.min.css">

	<!--Plugin FontAwasome -->
	<link rel="stylesheet" href="/desarrolloemprendedor/public/font-awesome-5.9.0/css/all.min.css">

	<!--Plugin Adicional Toast	-->
	<link rel="stylesheet" href="/desarrolloemprendedor/public/css/toastr.css">
	<link rel="stylesheet" href="/desarrolloemprendedor/public/css/style.css">
	

</head>

<body>		

	<div class="container-fluid">

		<?php
            $habilitados = ['a', 'b', 'c'];
?>

		<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">

			<a class="navbar-brand" href="#">
				<img src="/desarrolloemprendedor/public/imagenes/favicon.ico" alt="" style=" width:40px">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavDropdown">

				<ul class="navbar-nav">
					<?php if (in_array($_SESSION['tipo_usuario'], $habilitados)) { ?>

                    <!-- MENU CONTROL Y SEGUIMIENTO -->	
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Control/Seguimiento
						</a>
						<ul class="dropdown-menu">
							<li>
								<a class="dropdown-item" href="../expedientes/padron_expedientes.php">Listado expedientes</a>
							</li>
							<li class="dropdown-divider"></li>
							<li>
								<a class="dropdown-item" href="../expedientes/expediente_nuevo.php">Expediente nuevo</a>
							</li>
							<li class="dropdown-divider"></li>
							<li>
								<a class="dropdown-item" href="../expedientes/padron_morosos.php">Expedientes morosos </a>
							</li>
							<li class="dropdown-divider"></li>
							<li>
								<a class="dropdown-item" href="../expedientes/padron_periodo_gracia.php">Expedientes período gracia </a>
							</li>
							<li class="dropdown-divider"></li>
							<li>
								<a class="dropdown-item" href="../expedientes/padron_eliminados.php">Expedientes eliminados </a>
							</li>
							<li class="dropdown-divider"></li>
							<li>
								<a class="dropdown-item" href="../expedientes/padron_ingresos_2448.php">Expedientes vencidos del mes </a>
							</li>								
							<li class="dropdown-divider"></li>
							<li>
								<a class="dropdown-item" href="../expedientes/padron_ingresos_detallado.php">Expedientes a cobrar </a>
							</li>							
							<li class="dropdown-divider"></li>
							
						</ul>
					</li>

					<!-- MENU PROGRAMAS -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Programas
						</a>
						<ul class="dropdown-menu">	
							<li>
								<a class="dropdown-item" href="../personas/personas_proyectos.php">Consulta general de solicitantes</a>
							</li>							
                            <li class="dropdown-divider"></li>
							<li class="dropdown-submenu">
								<a class="dropdown-item dropdown-toggle" href="#">Jóvenes</a>
								<ul class="dropdown-menu">
									<li>
										<a class="dropdown-item" href="../solicitantes/padron_autogestionados.php">Padrón autogestionados</a>
									</li>
									<li>
										<a class="dropdown-item" href="../solicitantes/padron_autorizados.php">Padrón autorizados</a>
									</li>
									<li>
										<a class="dropdown-item" href="../evaluaciones/listado_evaluaciones.php">Proyectos a evaluar</a>
									</li>									
									<li>
										<a class="dropdown-item" href="../personas/personas_generos.php">Actualización género</a>
									</li>
									<li>
										<a class="dropdown-item" href="../entidades/padron_entidades.php">Padrón entidades</a>
									</li>
								</ul>
							</li>
							<li class="dropdown-divider"></li>
							<li class="dropdown-submenu">
								<a class="dropdown-item dropdown-toggle" href="#">Proaceer</a>
								<ul class="dropdown-menu">
									<li>
										<a class="dropdown-item" href="../proaccer/padron_apoyocomercial.php">Padrón autogestionados</a>
									</li>
									<li>
										<a class="dropdown-item" href="../proaccer/padron_autorizados.php">Autorizaciones</a>
									</li>
									<li>
										<a class="dropdown-item" href="../proaccer/InscripcionProaccer.php">Formulario inscripción</a>
									</li>
									<li>
										<a class="dropdown-item" href="../proaccer/EntrevistaProaccer.php">Planilla entrevista / Inf.</a>
									</li>
								</ul>
							</li>
							<li class="dropdown-divider"></li>
							<li class="dropdown-submenu">
								<a class="dropdown-item dropdown-toggle" href="#">Formación</a>
								<ul class="dropdown-menu">
                                    <li>
										<a class="dropdown-item" href="../asesorar/padron_autogestionados.php">Padrón Asesorar</a>
									</li>
									<li class="dropdown-divider"></li>
									<li>
										<a class="dropdown-item" href="../formaciones/padron_autogestionados.php">Padrón autogestionados</a>
									</li>
									<li class="dropdown-divider"></li>
									<li>
										<a class="dropdown-item" href="../formaciones/listado_cursos.php">Listado cursos</a>
									</li>
									<li class="dropdown-divider"></li>
									<li>
										<a class="dropdown-item" href="../formaciones/listado_formaciones.php">Listado de formaciones</a>
									</li>
									<li class="dropdown-divider"></li>
									<li>
										<a class="dropdown-item" href="../formaciones/listado_registros.php">Registro de capacitaciones</a>
									</li>
								</ul>
							</li>
							<li class="dropdown-divider"></li>
							<li>
								<a class="dropdown-item" href="../solicitantes/admin_solicitantes.php">Administración Solicitantes</a>
							</li> 

								
						</ul>
					</li>

					<!-- MENU RELEVAMIENTOS -->					
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Relevamiento
						</a>
						<ul class="dropdown-menu">
							<li class="dropdown-submenu">
								<a class="dropdown-item dropdown-toggle" href="#">Relevamiento OnLine</a>
								<ul class="dropdown-menu">
									<li>
										<a class="dropdown-item" href="../seguimiento/seguimiento_ol.php">Proyectos Financiados</a>
									</li>
									<li>
										<a class="dropdown-item" href="../seguimiento/seguimiento_ol_nuevos.php">Proyectos Autogestionados</a>
									</li>
									<li>
										<a class="dropdown-item" href="../proaccer/seguimiento_proaccer.php">Proyectos ProAccer </a>
									</li>
								</ul>
							</li>
							<li class="dropdown-divider"></li>
							<li class="dropdown-submenu">
								<a class="dropdown-item dropdown-toggle" href="#">Carga de Datos</a>
								<ul class="dropdown-menu">
									<li>
										<a class="dropdown-item" href="../seguimiento/carga_resultados_ext.php">Subir archivos móvil</a>
									</li>
									<li class="dropdown-divider"></li>
									<li>
										<a class="dropdown-item" href="../seguimiento/carga_imagenes.php">Subir imágenes / reseñas</a>
									</li>
								</ul>
							</li>
							<li class="dropdown-divider"></li>
							<li class="dropdown-submenu">
								<a class="dropdown-item dropdown-toggle" href="#">Ver resultados</a>
								<ul class="dropdown-menu">
									<li class="dropdown-submenu">
										<a class="dropdown-item dropdown-toggle" href="#">Proyectos Financiados</a>
										<ul class="dropdown-menu">
											<li>
												<a class="dropdown-item" href="../seguimiento/resultado_expedientes.php">Form-2016</a>
											</li>
											<li>
												<a class="dropdown-item" href="../seguimiento/Mae_Form2017.php">Form-2017</a>
											</li>
										</ul>
									</li>
									<li>
										<a class="dropdown-item" href="../seguimiento/resultado_proyectos.php">Proyectos Autogestionados</a>
									</li>
									<li>
										<a class="dropdown-item" href="../proaccer/resultados_relevamientos.php">Proyectos ProAccer</a>
									</li>
									<li>
										<a class="dropdown-item" href="../seguimiento/mapa.php"> Mapa Georref</a>
									</li>
								</ul>
							</li>
							<li class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="../seguimiento/seguimiento.php">Html Relevamiento Móvil</a></li>
						</ul>
					</li>

					<!-- MENU CONSULTAS -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Consultas
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="../consultas/graficos.php">Gráficos</a></li>
							<li class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="../consultas/base_datos.php">Base de Datos</a></li>
							<li class="dropdown-divider"></li>
							<li class="dropdown-submenu">
								<a class="dropdown-item dropdown-toggle" href="#">Control / Seguimiento</a>
								<ul class="dropdown-menu">
									<li>
										<a class="dropdown-item" href="../consultas/padron_alertas.php">Llamadas a realizar</a>
									</li>
									<li>
										<a class="dropdown-item" href="../consultas/notificaciones.php">Notificación realizar</a>
									</li>
									<li>
										<a class="dropdown-item" href="../consultas/padron_ingresos_futuros.php">Ingresos futuros</a>
									</li>
									<li>
										<a class="dropdown-item" href="../consultas/resumen_cuenta.php">Resumen cuenta</a>
									</li>
									<li>
										<a class="dropdown-item" href="../consultas/cobros_ingresos.php">Cobros - Ingresos </a>
									</li>
									<li>
										<a class="dropdown-item" href="../consultas/padron_rendiciones.php">Rendiciones </a>
									</li>
								</ul>
							</li> 
							<li class="dropdown-divider"></li>
							<li>
								<a class="dropdown-item" href="../emprendedores/admin_emprendedores.php">Administración Emprendedores</a>
							</li>  
								
						</ul>
					</li>

					<!-- INICIO MENU ADMINISTRACION -->				

					<?php if (($_SESSION['tipo_usuario'] == 'c')) {  ?>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Administración
							</a>
							<ul class="dropdown-menu">
								<li>
									<a class="dropdown-item" href="../herramientas/preguntas.php">Consola Query</a>
								</li>
								<li class="dropdown-divider"></li>
								<li>
									<a class="dropdown-item" href="../evaluaciones/padron_evaluaciones.php">Carga Evaluaciones </a>
								</li>		
								<li class="dropdown-divider"></li>
								<li>
									<a class="dropdown-item" href="../registro/usuario_nuevo.php">Administracion de usuarios </a>
								</li>
								<li class="dropdown-divider"></li>
								<li>
									<a class="dropdown-item" href="../desarrollo/desarrollo.php">Entorno Desarrollo</a>
								</li>
								<li class="dropdown-divider"></li>
								<li>
									<a class="dropdown-item" href="../herramientas/info.php">Php Info</a>
								</li>
							</ul>
						</li>
					<!-- FIN MENU ADMINISTRACION -->

					<?php  }
					} else {
					    if ($_SESSION['tipo_usuario'] == 'd') {
					        ?>

							<!-- MENU USUARIOS SOLO CONSULTAS TECNICAS -->
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Cargas
								</a>
								<ul class="dropdown-menu">
									<li>
										<a class="dropdown-item" href="../evaluaciones/listado_evaluaciones.php">Proyectos a Evaluar</a>
									</li>
								</ul>
							</li>	
							<!-- FIN MENU USUARIOS SOLO CONSULTAS TECNICAS -->
						<?php
					    }

					    if ($_SESSION['tipo_usuario'] == 'e') {
					        ?>

							<!-- MENU USUARIOS ENTIDADES -->
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Solicitantes
								</a>
								<ul class="dropdown-menu">
									<li>
										<a class="dropdown-item" href="../entidades/padron_autorizados.php">Verificar</a>
									</li>
								</ul>
							</li>	
							<!-- FIN MENU USUARIOS ENTIDADES -->

						<?php
					    }

					    if ($_SESSION['tipo_usuario'] == 'f') {
					        ?>

							<!-- MENU USUARIOS formadores -->
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Solicitantes
								</a>
								<ul class="dropdown-menu">
									<li>
										<a class="dropdown-item" href="../formaciones/padron_autogestionados.php">Padrón</a>
									</li>
								</ul>
							</li>	
							<!-- FIN MENU USUARIOS formadores -->

						<?php
					    }
					}
?>					

				</ul>

				<ul class="navbar-nav ml-auto">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php print ucwords($_SESSION['usuario']); ?>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="../registro/cambio_clave.php" class="nav-link" onClick="salida()" title="Modificar contraseña">
								<i class="fas fa-user-lock "></i> Cambiar clave
							</a>
							<div class="dropdown-divider" style="border-color:black;"></div>
							<a class="dropdown-item" href="#" class="nav-link" onClick="salida()" title="Salir">
								<i class="fas fa-sign-out-alt"></i> Salir
							</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>



	
		
		

			
		