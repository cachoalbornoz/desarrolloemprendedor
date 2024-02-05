<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    
	<link rel="icon" type="image/png" href="/desarrolloemprendedor/public/imagenes/favicon.ico">
	<meta name="robots" content="index,follow">

	<title>Mapa expedientes - Desarrollo Emprendedor</title>
    
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">   
       
	<link rel="stylesheet" href="/desarrolloemprendedor/public/font-awesome-5.9.0/css/all.min.css">
	<link rel="stylesheet" href="/desarrolloemprendedor/public/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="/desarrolloemprendedor/public/bootstrap-4.3.1/dist/css/bootstrap.min.css">

    <link href="mapa.css" rel="stylesheet" type="text/css"/>   
    <link href="libreria/leaflet/leaflet.css" rel="stylesheet" type="text/css"/>
    <link href="libreria/Leaflet.MousePosition-master/src/L.Control.MousePosition.css" rel="stylesheet" type="text/css"/>
    <link href="libreria/Leaflet.StyledLayerControl-master/Leaflet.StyledLayerControl-master/css/styledLayerControl.css" rel="stylesheet" type="text/css"/>
   
    <?php

    require_once "../accesorios/accesos_bd.php";
    $con=conectar(); 

    // Determinar los años a mostrar dinamicamente
    $fila = mysqli_query($con, 'SELECT min(year(date(fecha_otorgamiento))), max(year(date(fecha_otorgamiento))) FROM expedientes WHERE estado <> 99');
    $reg  = mysqli_fetch_array($fila);
    $min  = $reg[0];
    $max  = $reg[1];

    
    // Crear Expedientes
    include ('crearExpedientes.php');

    // Crear Rubros
    include ('crearRubros.php');

    // // Data estados
    include ('crearEstados.php');

    // // Data Años otorgamiento
    include ('crearAnios.php');

    ?>

</head>

<body>

    <div class="d-flex h-100">

        <div class="row m-0 w-100">

            <div id="sidebar" class="d-flex flex-column justify-content-between col-2 h-100">
                
                <div class="w-100">
                    Año de otorgamiento del crédito
                    <select class="form-control" name="anio" id="anio">
                        <option value="" disabled selected>Seleccione ...</option>
                        <option value="0">Todos</option>
                        <?php
                        $actual = date('Y', time());
                        $año  = $actual;
                        while ($año >= $min) {
                            print '<option value=' . $año . '>' . $año . '</option>';
                            $año --;
                        }
                        ?>
                    </select>
                </div>

                <div id="alert" class="w-100 alert alert-warning fw-bold" role="alert"> </div>

            </div>

            <div id="map" class="col" style="box-shadow: 5px 5px 5px #888;"></div> 

        </div>

    </div>      

    <script src="/desarrolloemprendedor/public/js/jquery-3.4.1.min.js"></script>
    <script src="/desarrolloemprendedor/public/bootstrap-4.3.1/js/dist/popper.min.js"></script>
    <script src="/desarrolloemprendedor/public/bootstrap-4.3.1/js/dist/util.js"></script>
    <script src="/desarrolloemprendedor/public/bootstrap-4.3.1/dist/js/bootstrap.min.js"></script>

    <script src="libreria/leaflet/leaflet.js" type="text/javascript"></script> 
    <script src="libreria/Leaflet.MousePosition-master/src/L.Control.MousePosition.js" type="text/javascript"></script>
    <script src="libreria/leaflet-bing-layer-gh-pages/leaflet-bing-layer.js" type="text/javascript"></script>
    <script src="libreria/Leaflet.StyledLayerControl-master/Leaflet.StyledLayerControl-master/src/styledLayerControl.js" type="text/javascript"></script>

    <script src="colores.js"></script>
    <script src="departamentos.js"></script>
    <script src="expedientes.js"></script>
    <script src="rubros.js"></script>
    <script src="estados.js"></script>
    <script src="mapa-rubros.js"></script>
  

</body>
</html> 