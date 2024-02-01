<!DOCTYPE html>
<html lang="es">

<head>

  	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<meta name="Keywords" content="proyectos,emprendedores,registro,gobierno,entre rios,financiacion" />
	<meta name="description" content="Sistema Administrativo del Ministerio de Producción Entre Rios para registro de Proyectos Productivos" />
	<meta name="robots" content="index,follow">

	<title>Proyectos - Desarrollo Emprendedor</title>
    
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">   
       
	<link rel="stylesheet" href="/desarrolloemprendedor/public/font-awesome-5.9.0/css/all.min.css">
	<link rel="stylesheet" href="/desarrolloemprendedor/public/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="/desarrolloemprendedor/public/bootstrap-4.3.1/dist/css/bootstrap.min.css">

    <style>
        
        .ajustar{
            width: 600px;
            float: left;
            white-space: pre; /* CSS 2.0 */
            white-space: pre-wrap; /* CSS 2.1 */
            white-space: pre-line; /* CSS 3.0 */
            white-space: -pre-wrap; /* Opera 4-6 */
            white-space: -o-pre-wrap; /* Opera 7 */
            white-space: -moz-pre-wrap; /* Mozilla */
            white-space: -hp-pre-wrap; /* HP */
            word-wrap: break-word; /* IE 5+ */
        }
        div.limpiar{
            clear: both;
        }        
        html,
        body {
            width: 100%;
            height: 97%;
            margin: 0;
        }

        #map {
            width: 100%;
            height: 100%;

        }

        .info {
            padding: 6px 8px;
            font: 12px/14px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .info h5 {
            margin: 0 0 5px;
            color: #777;
        }

        /* Para definir el diseño del objeto al pasar el mouse*/
        #sidebar li:hover {
            cursor: pointer;
            font-weight: bold;
        }

        /* Para esconder un objeto*/
        .hidden {
            display: none;
        }
    </style>

    <!-- Librerias LeafLet -->
    <link href="libreria/leaflet/leaflet.css" rel="stylesheet" type="text/css"/>   
    <!-- Librerias Mouse Position -->
    <link href="libreria/Leaflet.MousePosition-master/src/L.Control.MousePosition.css" rel="stylesheet" type="text/css"/>
    <!-- Librerias Print Layer-->    
    <!-- Librerias Scale Layer-->
    <link href="libreria/leaflet-graphicscale-master/dist/Leaflet.GraphicScale.min.css" rel="stylesheet" type="text/css"/> 
    <!-- Icons-->
    <link href="libreria/leaflet-mapkey-icon-master/dist/L.Icon.Mapkey.css" rel="stylesheet" type="text/css"/>
    <!-- LayerGroup-->
    <link href="libreria/leaflet-groupedlayercontrol-gh-pages/src/leaflet.groupedlayercontrol.css" rel="stylesheet" type="text/css"/>
    <!-- Bing Layers -->
</head>

<body>

    <?php
    require_once("../accesorios/accesos_bd.php");
    $con=conectar(); 

    ?>

    <div class="d-flex h-100">

        <div class="row m-0 w-100">

            <div id="sidebar" class="d-flex flex-column justify-content-between col-2 h-100">
                <div id="alert" class="w-100 alert alert-warning fw-bold hidden" role="alert"></div>
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

    <script src="departamentos.js"></script>
    
    <script>

    colores = ["#000000","#F2C357","#FF0000","#04B404","#FE642E", "#FFFF00","#FF00BF","#BDBDBD","#E6E6E6","#B40404","#80FF00","#00FFFF","#FA58F4",
    "#FE2E9A","#F6D8CE","#38610B","#86B404","#8904B1","#F5A9E1","#F5A9A9","#F3F781","#E3CEF6"];
        
    var mapkey = 'pk.eyJ1IjoiY2FjaG9hbGJvcm5veiIsImEiOiJjaXFuczZudTQwMWJkZ3NqZmg5ZWd1dmljIn0.-2dfXqyCXP-d_ij7Sp1waA';    
    var bingkey= 'Av1z4G0ITtfkMdxUW0qsvJHvYZbjDXOVibWwMhCmEJxAXf-YHYL1uoRjU9YBE-s6';    
     var imagerySet = "AerialWithLabels"; // AerialWithLabels | Birdseye | BirdseyeWithLabels | Road
    
    var politico = L.tileLayer('https://wms.ign.gob.ar/geoserver/gwc/service/tms/1.0.0/capabaseargenmap@EPSG%3A3857@png/{z}/{x}/{-y}.png');
    var topografico  = L.tileLayer.bing(bingkey,{type: imagerySet});
    
    var baseLayers = {
        "Politico": politico,       
        "TopoGrafico": topografico,  
    };        
        
    /////////////////////////////////////////////////////////////////
    var map = L.map('map',{
    fullscreenControl: true,
    fullscreenControlOptions: {position: 'topright'}}).setView([-31.95528,-57.97186],8);
    
    politico.addTo(map);
    
    /////////////////////////////////////////////////////////////////
    new L.control.mousePosition({position: 'topright'}).addTo(map);
    new L.control.scale({ imperial: true }).addTo(map);
    /////////////////////////////////////////////////////////////////  
    
    // Referencias
    const sidebar = document.querySelector('#sidebar');
    const alert = document.querySelector('#alert');

    //Crear listado de lugares
    const volar = (lugar) => {
        const zoom = (lugar.nombre == 'Todos') ? 8 : 12;
        map.flyTo(lugar.coordenadas, zoom)
    }

    const definirAlert = ([latitud, longitud]) => {
        alert.classList.remove('hidden');
        alert.innerText = `Lat: ${latitud}, Long: ${longitud}`
    }

    // Primero limpiar el Active de cada item
    const limpiarItems = () => {
        const listadoLi = document.querySelectorAll('li');
        listadoLi.forEach(li => {
            li.classList.remove('active');
        })
    }

    // Crear el listado
    const crearListado = () => {
        const ul = document.createElement('ul');
        ul.classList.add('list-group');
        sidebar.prepend(ul);

        departamentos.forEach(lugar => {
            const li = document.createElement('li');
            li.innerText = lugar.nombre;
            li.classList.add('list-group-item');
            ul.append(li);

            li.addEventListener('click', () => {
                limpiarItems();
                li.classList.add('active');
                volar(lugar);
                definirAlert(lugar.coordenadas);
            })
        })

    }

    crearListado();
    </script>
  
    <?php
    
    $seleccion_marcadores = mysqli_query($con, "SELECT sege.latitud, sege.longitud,rub.tipo,if(rub.tipo=0,'AGRO','INDUSTRIA') as tipo,rub.rubro,emp.apellido, emp.nombres, sege.archivo,sege.resena
    FROM seguimiento_expedientes sege
    INNER JOIN expedientes exped on sege.id_expediente = exped.id_expediente
    INNER JOIN rel_expedientes_emprendedores relee on relee.id_expediente = exped.id_expediente
    INNER JOIN emprendedores emp on emp.id_emprendedor = relee.id_emprendedor
    INNER JOIN tipo_rubro_productivos rub on rub.id_rubro = exped.id_rubro
    WHERE sege.latitud < 0 AND sege.longitud < 0 AND emp.id_responsabilidad = 1
    ORDER BY rub.tipo,rub.rubro,emp.apellido") or die('Revisar Expedientes funcionando');

    $registro_marcadores = mysqli_fetch_array($seleccion_marcadores, MYSQLI_BOTH);

    $id_rubro   = $registro_marcadores[2];
    
    $latitud    = round($registro_marcadores[0],8);
    $longitud   = round($registro_marcadores[1],8);
    $rotulo     = $registro_marcadores[3];       
    $titulos[]  = $rotulo;
    
    if(strlen($registro_marcadores[6]) > 0){
        $grafico = '<img src="images/'.$registro_marcadores[6].'" class="img-responsive" alt="Imagen"> ';          
    }else{
        $grafico = '&nbsp;';
    }
        
    $tooltip    = 
            '<table class="table table-striped">'
            . '<tr>'
                . '<td>Emprendedor</td><td><strong>'.$registro_marcadores[5].', '.$registro_marcadores[6].'</strong></td>'
            . '</tr>'
            . '<tr>'
                . '<td>Rubro</td><td><strong>'.$registro_marcadores[4].'</strong></td>'
            . '</tr>'
            . '<tr>'
                . '<td colspan="2">Reseña </br><strong>'.$registro_marcadores[8].'</strong></td>'
            . '</tr>'
            . '<tr>'
                . '<td colspan="2">'.$registro_marcadores[7].'</td>'
            . '</tr>'
            . '</table>';
    ?>
    <script>  

        let index = 1
        var latitud = <?php echo $latitud ?>;
        var longitud= <?php echo $longitud ?>;    
        var <?php echo $rotulo ?> = new L.LayerGroup(); 

        let opciones = {
            color: colores[index],
            fillColor: colores[index],
            size:15,
            boxShadow:false
        }; 

        L.circleMarker(L.latLng([latitud,longitud], opciones)).bindTooltip('<?php echo $tooltip ?>').addTo(<?php echo $rotulo ?>);     
    </script>
    <?php    
    while($registro_marcadores = mysqli_fetch_array($seleccion_marcadores)){ 
        
        $rotulo     = $registro_marcadores[3];
        $latitud    = round($registro_marcadores[0],8);
        $longitud   = round($registro_marcadores[1],8);
        
        if($id_rubro == $registro_marcadores[2]){        
            $color  = $colores[$indice];        
        }else{
            $indice ++;
            $color = $colores[$indice];
            $titulos[$indice] = $rotulo; ?>
            <script>
                var <?php echo $rotulo ?> = new L.LayerGroup(); 
            </script>
        <?php
        }    
        if(strlen($registro_marcadores[7]) > 0){
            $grafico = '<img src="images/'.$registro_marcadores[7].'" class="img-responsive" alt="Imagen"> ';          
        }else{
            $grafico = '&nbsp;';
        }
        
        
        $tooltip    = 
            '<table class="table table-sm">'
            . '<tr>'
                . '<td>Emprendedor: '.$registro_marcadores[5].', '.$registro_marcadores[6].'</td>'
            . '</tr>'
            . '<tr>'
                . '<td>Rubro :'.$registro_marcadores[4].'</td>'
            . '</tr>'
            . '<tr>'
                . '<td>Reseña :'.$registro_marcadores[8].'</td>'
            . '</tr>'
            . '<tr>'
                . '<td>'.$grafico.'</td>'
            . '</tr>'
            . '</table>';     
        
        ?>
        <script>
            var latitud = <?php echo $latitud ?>;
            var longitud= <?php echo $longitud ?>; 
            opciones = {
                color:'<?php echo $color ?>',
                fillColor:'<?php echo $color ?>',
                size:15,
                boxShadow:false
            }            
            L.circleMarker(L.latLng([latitud,longitud],opciones)).bindTooltip('<?php echo $tooltip ?>').addTo(<?php echo $rotulo ?>);  
        </script>
        <?php
        
        $id_rubro   = $registro_marcadores[2];     // LE ASIGNA EL ID AL RUBRO
    }  
    
    ?>            
    
    <!-- RUBROS PRODUCTIVOS -->
        
    <?php 
    
    $indice ++;
    
    $seleccion_marcadores = mysqli_query($con, "select sege.latitud,sege.longitud,rub.id_rubro,REPLACE(rub.rubro,'/','_') as rubro,emp.apellido, emp.nombres, sege.archivo,sege.resena
    from seguimiento_expedientes sege
    inner join expedientes exped on sege.id_expediente = exped.id_expediente
    inner join rel_expedientes_emprendedores relee on relee.id_expediente = exped.id_expediente
    inner join emprendedores emp on emp.id_emprendedor = relee.id_emprendedor
    inner join tipo_rubro_productivos rub on rub.id_rubro = exped.id_rubro
    where sege.latitud < 0 and sege.longitud <0 and emp.id_responsabilidad = 1 and rub.id_rubro < 14
    order by rub.id_rubro,rub.rubro,emp.apellido") or die('Revisar Expedientes funcionando');
    $registro_marcadores = mysqli_fetch_array($seleccion_marcadores, MYSQLI_BOTH);

    $id_rubro       = $registro_marcadores[2];
    
    $latitud        = round($registro_marcadores[0],8);
    $longitud       = round($registro_marcadores[1],8);
    $rotulo         = ucfirst($registro_marcadores[3]); 
    $color          = $colores[$indice];   
    $otrostitulos[] = $rotulo;
    
    
    if(strlen($registro_marcadores[6]) > 0){
        $grafico = '<img src="images/'.$registro_marcadores[6].'" class="img-responsive" alt="Imagen"> ';          
    }else{
        $grafico = '&nbsp;';
    }
        
    
    $tooltip    = 
                '<div class="table-responsive">'
                    .'<table class="table table-striped table-responsive dt-responsive nowrap">'
                    .'<tr><td>Emprendedor :'.$registro_marcadores[4].', '.$registro_marcadores[5].'</td></tr>'
                    .'<tr><td>Rubro :'.$registro_marcadores[3].'</td></tr>'
                    .'<tr><td>Reseña :'.$registro_marcadores[7].'</td></tr>'
                    .'<tr><td>'.$grafico.'</td></tr>'
                    .'</table>'
                . '</div>';
    ?>
    <script>  
        var latitud = <?php echo $latitud ?>;
        var longitud= <?php echo $longitud ?>;    
        var <?php echo $rotulo ?> = new L.LayerGroup(); 
        opciones = {
            color:'<?php echo $color ?>',
            fillColor:'<?php echo $color ?>',
            size:10,
            boxShadow:true
        } 

        L.circleMarker(L.latLng([latitud,longitud], opciones)).bindTooltip('<?php echo $tooltip ?>').addTo(<?php echo $rotulo ?>); 

    </script> 
    <?php    
    while($registro_marcadores = mysqli_fetch_array($seleccion_marcadores)){ 
        
        $rotulo     = ucfirst($registro_marcadores[3]); 
        $latitud    = round($registro_marcadores[0],8);
        $longitud   = round($registro_marcadores[1],8);
        
        if($id_rubro == $registro_marcadores[2]){        
            $color  = $colores[$indice];        
        }else{
            $indice ++;
            $color          = $colores[$indice];
            $otrostitulos[] = $rotulo; ?>
            <script>
                var <?php echo $rotulo ?> = new L.LayerGroup(); 
            </script>
        <?php
        }    
        
        if(strlen($registro_marcadores[6]) > 0){
            $grafico = '<img src="images/'.$registro_marcadores[6].'" class="img-responsive" alt="Imagen"> ';          
        }else{
            $grafico = '&nbsp;';
        }
        
        
        $tooltip    = 
                '<div>'
                    .'<table class="table table-sm">'
                    .'<tr><td>Emprendedor : '.$registro_marcadores[4].', '.$registro_marcadores[5].'</td></tr>'
                    .'<tr><td>Rubro : '.$registro_marcadores[3].'</tr>'
                    .'<tr><td style="text-align:justify">Reseña : '.$registro_marcadores[7].'</td></tr>'
                    .'<tr><td>'.$grafico.'</td></tr>'
                    .'</table>'
                . '</div>'
                . '<div class="limpiar"><!-- fix --></div>';
        
        ?>
        <script>   
            
            var latitud = <?php echo $latitud ?>;
            var longitud= <?php echo $longitud ?>;
            opciones = {
                color:'<?php echo $color ?>',
                fillColor:'<?php echo $color ?>',
                size:10,
                boxShadow:true
            }
                             
            L.circleMarker(L.latLng([latitud,longitud],opciones)).bindTooltip('<?php echo $tooltip ?>').addTo(<?php echo $rotulo ?>);  
            
        </script>
        <?php
        
        $id_rubro   = $registro_marcadores[2];     // LE ASIGNA EL ID AL RUBRO
    }  
    
    ?>        
        
    <script>
    //    /////////////////////////////////////////////////////////////////    
    //     var info = new L.control({position: 'bottomleft'});
    //     info.onAdd = function (map) {
    //         var div = L.DomUtil.create('div', 'info legend');
    //         div.innerHTML += '<img src="libreria/isologoER_Gob.png" style="width:10%;" alt="Ministerio">';
    //         return div;
    //     };
    //     info.addTo(map);

    // Crear un div con una clase info
    var info = new L.control({position: 'bottomleft'});
    info.onAdd = function (map) {
        this._div = L.DomUtil.create('div', 'info');
        this.update();
        return this._div;
    };

    // Agregar el metodo que actualiza el control segun el puntero vaya pasando
    info.update = function (props) {
        this._div.innerHTML = '<h6>Créditos Productivos - Categorias productivas</h6>';
        //let path = APP_URL + "/public/mapas/libreria/isologoER_Gob.png"
        //this._div.innerHTML += '<img class=" img-thumbnail" src=' + path + ' alt="Ministerio">';
        this._div.innerHTML += '<h4>Ministerio de Desarrollo Económico - Entre Ríos</h4>';
    };
    info.addTo(map);
    ////////////////////////////////////////////////////////////////     
        
    // Overlay layers are grouped
    var groupedOverlays = {

        <?php            
        $indice = 2;
        foreach ($otrostitulos as $legenda){  ?>          
            "<i class='fa fa-circle fa' aria-hidden='true' style='color:<?php echo $colores[$indice]?>'></i> <?php echo ucfirst(strtolower($legenda)); ?>": <?php echo $legenda.', ' ?>
            <?php
            $indice ++;
        }
        ?>
               
    }
           
    var options = {
        collapsed:false,
        position: 'bottomright'
    };
  
    L.control.layers(baseLayers, groupedOverlays,options).addTo(map);  
    
    </script>
    
    
    <?php setlocale(LC_ALL, 'es_ES'); ?>
    
    <br/>

    <div class="col-md-12 text-center">                    
        <h6>
            <i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d-m-Y',time());  ?> :: Subsecretaria de Desarrollo Emprendedor / Cervantes 69 Parana C.P.(3100) E.Ríos
        </h6>
    </div>     
    
    

</body>
</html> 