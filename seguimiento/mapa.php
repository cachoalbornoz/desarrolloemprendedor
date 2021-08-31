<!DOCTYPE html>
<html lang="es">

<head>

  	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<meta name="Keywords" content="proyectos,emprendedores,registro,gobierno,entre rios,financiacion" />
	<meta name="description" content="Sistema Administrativo del Ministerio de Producción Entre Rios para registro de Proyectos Productivos" />
	<meta name="robots" content="index,follow">

	<title>Proyectos - Jovenes Emprendedores</title>
    
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">   
       
	<link rel="stylesheet" href="/desarrolloemprendedor/public/font-awesome-5.9.0/css/all.min.css">
	<link rel="stylesheet" href="/desarrolloemprendedor/public/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="/desarrolloemprendedor/public/bootstrap-4.3.1/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="/desarrolloemprendedor/public/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/desarrolloemprendedor/public/css/EstilosJovenes.css">
    
    <!-- jQuery 3 -->
    <script src="/desarrolloemprendedor/public/js/jquery-3.4.1.min.js"></script>
    <!-- Popper -->
    <script src="/desarrolloemprendedor/public/bootstrap-4.3.1/js/dist/popper.min.js"></script>
    <!-- Utils -->
    <script src="/desarrolloemprendedor/public/bootstrap-4.3.1/js/dist/util.js"></script>
    <!-- Bootstrap 4.3.1 -->
    <script src="/desarrolloemprendedor/public/bootstrap-4.3.1/dist/js/bootstrap.min.js"></script>

    <style>
        .leaflet-tooltip{
            width: 650px;
            
        }
        
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
        body,
        #map {
          height: 90%;
          width:  99%;
          margin: 0 auto;
          padding: 0;          
        }
        .leaflet-bottom .leaflet-control-graphicscale {
            background-color: #78a04f ;
        }
    </style>

    <link href="libreria/leaflet/leaflet.css" rel="stylesheet" type="text/css"/>
    <script src="libreria/leaflet/leaflet.js" type="text/javascript"></script>    
   
    <!-- Librerias Mouse Position -->
    <link href="libreria/Leaflet.MousePosition-master/src/L.Control.MousePosition.css" rel="stylesheet" type="text/css"/>
    <script src="libreria/Leaflet.MousePosition-master/src/L.Control.MousePosition.js" type="text/javascript"></script>
   
    <!-- Librerias Print Layer-->    
    <script src="libreria/leaflet-easyPrint-gh-pages/dist/leaflet.easyPrint.js" type="text/javascript"></script>
    
    <!-- Librerias Scale Layer-->
    <script src="libreria/leaflet-graphicscale-master/dist/Leaflet.GraphicScale.min.js" type="text/javascript"></script>
    <link href="libreria/leaflet-graphicscale-master/dist/Leaflet.GraphicScale.min.css" rel="stylesheet" type="text/css"/>    
    
    <!-- Icons-->
    <link href="libreria/leaflet-mapkey-icon-master/dist/L.Icon.Mapkey.css" rel="stylesheet" type="text/css"/>
    <script src="libreria/leaflet-mapkey-icon-master/dist/L.Icon.Mapkey.js" type="text/javascript"></script>
    
    <!-- LayerGroup-->
    <link href="libreria/leaflet-groupedlayercontrol-gh-pages/src/leaflet.groupedlayercontrol.css" rel="stylesheet" type="text/css"/>
    <script src="libreria/leaflet-groupedlayercontrol-gh-pages/src/leaflet.groupedlayercontrol.js" type="text/javascript"></script>
    
    <!-- Bing Layers -->
    <script src="libreria/leaflet-bing-layer-gh-pages/leaflet-bing-layer.js" type="text/javascript"></script>
</head>

<body>

    <?php
    require_once("../accesorios/accesos_bd.php");
    $con=conectar(); 

    $colores = array("#000000","#F2C357","#FF0000","#04B404","#FE642E", "#FFFF00","#FF00BF","#BDBDBD","#E6E6E6","#B40404","#80FF00","#00FFFF","#FA58F4",
    "#FE2E9A","#F6D8CE","#38610B","#86B404","#8904B1","#F5A9E1","#F5A9A9","#F3F781","#E3CEF6");
    
    ?>  
    
    <div class=" col-xs-12 text-center" style="background-color: #78a04f; color: whitesmoke">
        <h4>Mapas de Créditos otorgados</h4> - <small>según <strong>Rubros Productivos</strong></small> -
    </div>    

    <br/>
    
     
    <div id="map" style="box-shadow: 5px 5px 5px #888;"></div>    
    
    <script>
        
    var mapkey = 'pk.eyJ1IjoiY2FjaG9hbGJvcm5veiIsImEiOiJjaXFuczZudTQwMWJkZ3NqZmg5ZWd1dmljIn0.-2dfXqyCXP-d_ij7Sp1waA';
    
    var bingkey= 'Av1z4G0ITtfkMdxUW0qsvJHvYZbjDXOVibWwMhCmEJxAXf-YHYL1uoRjU9YBE-s6';
    
     var imagerySet = "ROADMAP"; // AerialWithLabels | Birdseye | BirdseyeWithLabels | Road
    
    var base1 = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png'),
        base2 = L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png');
        base3 = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png');
        base4 = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/satellite-v9/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiY2FjaG9hbGJvcm5veiIsImEiOiJjaXFuczZudTQwMWJkZ3NqZmg5ZWd1dmljIn0.-2dfXqyCXP-d_ij7Sp1waA');
        bing  = L.tileLayer.bing(bingkey,{type: imagerySet});
    
    var baseLayers = {
        "TopoGrafico": bing,
        "FondoTipo1": base2,
        "FondoTipo2": base3,        
        "FondoTipo3": base1,
        
    };        
        
    /////////////////////////////////////////////////////////////////
    var map = L.map('map',{
    fullscreenControl: true,
    fullscreenControlOptions: {position: 'topright'}}).setView([-31.95528,-57.97186],7);
    
    bing.addTo(map);
    
    /////////////////////////////////////////////////////////////////
    L.control.mousePosition({position: 'topright'}).addTo(map);
    ////////////////////////////////////////////////////////////////
    var graphicScale = L.control.graphicScale({labelPlacement: 'bottomright',doubleLine:true,fill: 'fill',labelPlacement: 'top'}).addTo(map);        
    /////////////////////////////////////////////////////////////////      
    </script>
  
    <?php  
    
    $indice  = 0;
    
    $seleccion_marcadores = mysqli_query($con, "select sege.latitud, sege.longitud,rub.tipo,if(rub.tipo=0,'AGRO','INDUSTRIA') as tipo,rub.rubro,emp.apellido, emp.nombres, sege.archivo,sege.resena
    from seguimiento_expedientes sege
    inner join expedientes exped on sege.id_expediente = exped.id_expediente
    inner join rel_expedientes_emprendedores relee on relee.id_expediente = exped.id_expediente
    inner join emprendedores emp on emp.id_emprendedor = relee.id_emprendedor
    inner join tipo_rubro_productivos rub on rub.id_rubro = exped.id_rubro
    where sege.latitud < 0 and sege.longitud <0 and emp.id_responsabilidad = 1
    order by rub.tipo,rub.rubro,emp.apellido") or die('Revisar Expedientes funcionando');
    $registro_marcadores = mysqli_fetch_array($seleccion_marcadores, MYSQLI_BOTH);

    $id_rubro   = $registro_marcadores[2];
    
    $latitud    = round($registro_marcadores[0],8);
    $longitud   = round($registro_marcadores[1],8);
    $rotulo     = $registro_marcadores[3];    
    $color      = $colores[$indice];   
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
        var latitud = <?php echo $latitud ?>;
        var longitud= <?php echo $longitud ?>;    
        var <?php echo $rotulo ?> = new L.LayerGroup(); 
        var mki = L.icon.mapkey({icon:"marker",color:'#725139',background:'<?php echo $color ?>',size:15,boxShadow:false}); 
        L.marker([latitud,longitud],{icon:mki}).bindTooltip('<?php echo $tooltip ?>').addTo(<?php echo $rotulo ?>);     
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
                . '<td colspan="2">'.$grafico.'</td>'
            . '</tr>'
            . '</table>';     
        
        ?>
        <script>
            var latitud = <?php echo $latitud ?>;
            var longitud= <?php echo $longitud ?>;
            var mki = L.icon.mapkey({icon:"marker",color:'#725139',background:'<?php echo $color ?>',size:15,boxShadow:false});             
            L.marker([latitud,longitud],{icon:mki}).bindTooltip('<?php echo $tooltip ?>').addTo(<?php echo $rotulo ?>);  
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
                    .'<tr>'
                    .'<td>Emprendedor</td><td><strong>'.$registro_marcadores[4].', '.$registro_marcadores[5].'</strong></td>'
                    .'</tr>'
                    .'<tr>'
                    .'<td>Rubro</td><td><strong>'.$registro_marcadores[3].'</strong></td>'
                    .'</tr>'
                    .'<tr>'
                    .'<td colspan="2">Reseña </br><strong>'.$registro_marcadores[7].'</strong></td>'
                    .'</tr>'
                    .'<tr>'
                    .'<td colspan="2">'.$grafico.'</td>'
                    .'</tr>'
                    .'</table>'
                . '</div>';
    ?>
    <script>  
        var latitud = <?php echo $latitud ?>;
        var longitud= <?php echo $longitud ?>;    
        var <?php echo $rotulo ?> = new L.LayerGroup(); 
        var mki = L.icon.mapkey({icon:"fa-map-marker",color:'#725139',background:'<?php echo $color ?>',size:10,boxShadow:true}); 
        L.marker([latitud,longitud],{icon:mki}).bindTooltip('<?php echo $tooltip ?>').addTo(<?php echo $rotulo ?>);     
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
                    .'<table class="table">'
                    .'<tr>'
                    .'<td class="ajustar">Emprendedor</td><td class="ajustar"><strong>'.$registro_marcadores[4].', '.$registro_marcadores[5].'</strong></td>'
                    .'</tr>'
                    .'<tr>'
                    .'<td class="ajustar">Rubro</td><td class="ajustar"><strong>'.$registro_marcadores[3].'</strong></td>'
                    .'</tr>'
                    .'<tr>'
                    .'<td colspan="2" class="ajustar" style="text-align:justify">Reseña </br><strong>'.$registro_marcadores[7].'</strong></td>'
                    .'</tr>'
                    .'<tr>'
                    .'<td colspan="2" class="ajustar">'.$grafico.'</td>'
                    .'</tr>'
                    .'</table>'
                . '</div>'
                . '<div class="limpiar"><!-- fix --></div>';
        
        ?>
        <script>   
            
            var latitud = <?php echo $latitud ?>;
            var longitud= <?php echo $longitud ?>;
            var mki = L.icon.mapkey({icon:"fa-map-marker",color:'#725139',background:'<?php echo $color ?>',size:10,boxShadow:true});             
            L.marker([latitud,longitud],{icon:mki}).bindTooltip('<?php echo $tooltip ?>').addTo(<?php echo $rotulo ?>);  
            
        </script>
        <?php
        
        $id_rubro   = $registro_marcadores[2];     // LE ASIGNA EL ID AL RUBRO
    }  
    
    ?>        
        
    <script>
   /////////////////////////////////////////////////////////////////    
    var info = new L.control({position: 'bottomleft'});
    info.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend');
        div.innerHTML += '<img src="libreria/isologoER_Gob.png" style="width:10%;" alt="Ministerio">';
        return div;
    };
    info.addTo(map);    
    ////////////////////////////////////////////////////////////////     
        
    // Overlay layers are grouped
    var groupedOverlays = {

        <?php            
        $indice = 2;
        foreach ($otrostitulos as $legenda){  ?>          
            "<i class='fa fa-circle fa' aria-hidden='true' style='color:<?php echo $colores[$indice]?>'></i> <?php echo ucfirst(strtolower($legenda)); ?>": <?php echo $legenda ?>,
            <?php
            $indice ++;
        }
        ?>
               
    };
           
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
            <i class="fa fa-calendar" aria-hidden="true"></i> <?php echo strftime("%A %d de %B %G");  ?> :: SubSecretaria de Desarrollo Emprendedor / Cervantes 69 Parana C.P.(3100) E.Ríos
        </h6>
    </div>     
    
    

</body>
</html> 