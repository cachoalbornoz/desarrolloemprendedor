<?php 
session_start();
require("../accesorios/accesos_bd.php");


$con=conectar();

if(!isset($_POST['ano'])){
  $anio = date('Y',time());
}else{
  $anio = $_POST['ano'];	 
}

//
$tabla_consulta = "SELECT sum(monto), sum(saldo), sum(monto)-sum(saldo) FROM expedientes WHERE year(date(fecha_otorgamiento)) = $anio";
$resultado      = mysqli_query($con,$tabla_consulta);
$registro       = mysqli_fetch_array($resultado);
$total_prestado = $registro[0]; 
$monto_pendiente= $registro[1]; 
$monto_cobrado  = $registro[2];
// REGULAR 
$tabla_consulta = "SELECT count(id_expediente) FROM expedientes WHERE estado = 1 AND year(date(fecha_otorgamiento)) = $anio";
$resultado = mysqli_query($con,$tabla_consulta);
$registro = mysqli_fetch_array($resultado);
$regulares = $registro[0];
// MOROSOS
$tabla_consulta = "SELECT count(id_expediente) FROM expedientes WHERE estado = 2 AND year(date(fecha_otorgamiento)) = $anio";
$resultado = mysqli_query($con,$tabla_consulta);
$registro = mysqli_fetch_array($resultado);
$morosos = $registro[0];
// DEVOLUCION TOTAL
$tabla_consulta = "SELECT count(id_expediente) FROM expedientes WHERE estado = 3 AND year(date(fecha_otorgamiento)) = $anio";
$resultado = mysqli_query($con,$tabla_consulta);
$registro = mysqli_fetch_array($resultado);
$dev_total = $registro[0];
// FRACASOS
$tabla_consulta = "SELECT count(id_expediente) FROM expedientes WHERE estado = 4 AND year(date(fecha_otorgamiento)) = $anio";
$resultado = mysqli_query($con,$tabla_consulta);
$registro = mysqli_fetch_array($resultado);
$fracasos = $registro[0];
// CAMBIO OBJETO
$tabla_consulta = "SELECT count(id_expediente) FROM expedientes WHERE estado = 5 AND year(date(fecha_otorgamiento)) = $anio";
$resultado = mysqli_query($con,$tabla_consulta);
$registro = mysqli_fetch_array($resultado);
$cambios = $registro[0];
// PRORROGAS
$tabla_consulta = "SELECT count(id_expediente) FROM expedientes WHERE estado = 6 AND year(date(fecha_otorgamiento)) = $anio";
$resultado = mysqli_query($con,$tabla_consulta);
$registro = mysqli_fetch_array($resultado);
$prorrogas = $registro[0];
// TOTAL DE EXPEDIENTES
$tabla_consulta = "SELECT count(id_expediente) FROM expedientes WHERE year(date(fecha_otorgamiento)) = $anio";
$resultado = mysqli_query($con,$tabla_consulta);
$registro = mysqli_fetch_array($resultado);
$total_expedientes = $registro[0];
//
$tabla_consulta = "SELECT count(exped.id_expediente) FROM expedientes as exped WHERE exped.id_rubro = 1 AND year(date(fecha_otorgamiento)) = $anio";
$resultado = mysqli_query($con,$tabla_consulta);
$registro = mysqli_fetch_array($resultado);
$apicola = $registro[0];
//
$tabla_consulta = "SELECT count(exped.id_expediente) FROM expedientes as exped WHERE exped.id_rubro = 2 AND year(date(fecha_otorgamiento)) = $anio";
$resultado = mysqli_query($con,$tabla_consulta);
$registro = mysqli_fetch_array($resultado);
$cria = $registro[0];
//
$tabla_consulta = "SELECT count(exped.id_expediente) FROM expedientes as exped WHERE exped.id_rubro = 3 AND year(date(fecha_otorgamiento)) = $anio";
$resultado = mysqli_query($con,$tabla_consulta);
$registro = mysqli_fetch_array($resultado);
$horticola = $registro[0];
//
$tabla_consulta = "SELECT count(exped.id_expediente) FROM expedientes as exped WHERE exped.id_rubro = 4 AND year(date(fecha_otorgamiento)) = $anio";
$resultado = mysqli_query($con,$tabla_consulta);
$registro = mysqli_fetch_array($resultado);
$ovinos = $registro[0];
//
$tabla_consulta = "SELECT count(exped.id_expediente) FROM expedientes as exped WHERE exped.id_rubro = 5 AND year(date(fecha_otorgamiento)) = $anio";
$resultado = mysqli_query($con,$tabla_consulta);
$registro = mysqli_fetch_array($resultado);
$porcinos = $registro[0];
//
$tabla_consulta = "SELECT count(exped.id_expediente) FROM expedientes as exped WHERE exped.id_rubro = 6 AND year(date(fecha_otorgamiento)) = $anio";
$resultado = mysqli_query($con,$tabla_consulta);
$registro = mysqli_fetch_array($resultado);
$pisicultura = $registro[0];
//
$tabla_consulta = "SELECT count(exped.id_expediente) FROM expedientes as exped WHERE exped.id_rubro = 7 AND year(date(fecha_otorgamiento)) = $anio";
$resultado = mysqli_query($con,$tabla_consulta);
$registro = mysqli_fetch_array($resultado);
$servicio = $registro[0];
//
$tabla_consulta = "SELECT count(exped.id_expediente) FROM expedientes as exped WHERE exped.id_rubro = 8 AND year(date(fecha_otorgamiento)) = $anio";
$resultado = mysqli_query($con,$tabla_consulta);
$registro = mysqli_fetch_array($resultado);
$siembra = $registro[0];
//
$tabla_consulta = "SELECT count(exped.id_expediente) FROM expedientes as exped WHERE exped.id_rubro = 9 AND year(date(fecha_otorgamiento)) = $anio";
$resultado = mysqli_query($con,$tabla_consulta);
$registro = mysqli_fetch_array($resultado);
$tambo = $registro[0];
//
$tabla_consulta = "SELECT count(exped.id_expediente) FROM expedientes as exped WHERE exped.id_rubro = 10 AND year(date(fecha_otorgamiento)) = $anio";
$resultado = mysqli_query($con,$tabla_consulta);
$registro = mysqli_fetch_array($resultado);
$vacunos = $registro[0];

?>

<div class="row">  
  <div class="col-xs-12 col-sm-12 col-lg-12 text-center jumbotron">
    <h4>Datos estadísticos - Año <b><?php echo $anio?></b> </h4>
  </div>
</div>

<div class="row shadow pt-3 pb-3">
  <div class="col-xs-12 col-sm-12 col-lg-12 text-center">
    <h5>Total de Expedientes <b><?php echo $total_expedientes?></b></h5>
  </div>
</div>

<div class="row mt-3 mb-3">
  <div class="col-xs-12 col-sm-12 col-lg-12">
    <br>
  </div>
</div>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-lg-12" id="grafico1" style="width: 900px; height: 500px;">

    <script type="text/javascript">

      google.charts.load('current', { packages: ['corechart'] });
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Expedientes', 'Nro expedientes'],
          ['Regular', <?php echo $regulares ?> ],
          ['Morosos', <?php echo $morosos ?> ],
          ['Devolución', <?php echo $dev_total ?> ],
          ['Fracaso', <?php echo $fracasos ?> ],
          ['Cambio objeto', <?php echo $cambios ?> ],
          ['Prorroga', <?php echo $prorrogas ?> ]
        ]);

        var options = {
          title: 'Cantidad expedientes x estado',
          legend: {
            position: 'bottom'
          },
          is3D: true,
          hAxis: {
            title: "Rotulo de eje X"
          },
          vAxis: {
            title: "Rotulo de eje Y"
          }
        }

        var chart = new google.visualization.PieChart(document.getElementById('grafico1'));

        /*
        var chart = new google.visualization.LineChart(document.getElementById('grafico'));
        var chart = new google.visualization.ColumnChart(document.getElementById('grafico'));
        var chart = new google.visualization.PieChart(document.getElementById('grafico'));
        var chart = new google.visualization.BarChart(document.getElementById('grafico'));
        */

        chart.draw(data, options);

      }

    </script>
  </div>

  <div class="col-xs-12 col-sm-12 col-lg-12" id="grafico2" style="width: 900px; height: 500px;">

    <script type="text/javascript">

      google.charts.load('current', { packages: ['corechart'] });
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        <?php
          $tabla_consulta = "SELECT rp.rubro, count(exped.id_rubro) 
          FROM expedientes as exped, tipo_rubro_productivos as rp 
          WHERE exped.id_rubro = rp.id_rubro AND rp.tipo = 0 AND year(date(exped.fecha_otorgamiento)) = $anio
          GROUP BY exped.id_rubro 
          ORDER BY rubro";

          $resultado      = mysqli_query($con,$tabla_consulta);

        ?>

        var data = google.visualization.arrayToDataTable([

          ['Rubro', 'Cantidad'],

          <?php
          while($fila = mysqli_fetch_array($resultado)){
          ?>

            ['<?php echo substr(strtolower($fila[0]),0,8) ?>', <?php echo $fila[1] ?> ],

          <?php  
          }
          ?>

        ]);

        var options = {
          title: 'Cantidad expedientes x rubro',
          legend: {
            position: 'left'
          },
          is3D: true,
          hAxis: {
            title: "Tipo de rubro"
          },
          vAxis: {
            title: "Cantidad de expedientes"
          }
        }

        var chart = new google.visualization.LineChart(document.getElementById('grafico2'));

        /*
        var chart = new google.visualization.LineChart(document.getElementById('grafico'));
        var chart = new google.visualization.ColumnChart(document.getElementById('grafico'));
        var chart = new google.visualization.PieChart(document.getElementById('grafico'));
        var chart = new google.visualization.BarChart(document.getElementById('grafico'));
        var chart = new google.visualization.ComboChart(document.getElementById('grafico'));
        */

        chart.draw(data, options);

      }

    </script>

  </div>

  <div class="col-xs-12 col-sm-12 col-lg-12 text-center jumbotron">
    <h5> Datos estadísticos - <b>Sin</b> tener en Cta el Año </h5>
  </div>


  <div class="col-xs-12 col-sm-12 col-lg-12" id="grafico3" style="width: 900px; height: 500px;">

      <script type="text/javascript">

        google.charts.load('current', { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

          <?php
            $tabla_consulta = "SELECT dep.nombre, count(dep.id) 
            FROM expedientes exped, localidades loc, departamentos dep
            WHERE exped.id_localidad = loc.id AND loc.departamento_id = dep.id 
            GROUP BY dep.id 
            ORDER BY dep.nombre";

            $resultado      = mysqli_query($con,$tabla_consulta);

          ?>

          var data = google.visualization.arrayToDataTable([

            ['Departamento', 'Cantidad'],

            <?php
            while($fila = mysqli_fetch_array($resultado)){
            ?>

              ['<?php echo substr(strtolower($fila[0]),0,8) ?>', <?php echo $fila[1] ?> ],

            <?php  
            }
            ?>

          ]);

          var options = {
            title: 'Cantidad expedientes x departamento',
            legend: {
              position: 'left'
            },
            is3D: true,
            hAxis: {
              title: "Departamentos"
            },
            vAxis: {
              title: "Cantidad de expedientes"
            }
          }

          var chart = new google.visualization.LineChart(document.getElementById('grafico3'));

          /*
          var chart = new google.visualization.LineChart(document.getElementById('grafico'));
          var chart = new google.visualization.ColumnChart(document.getElementById('grafico'));
          var chart = new google.visualization.PieChart(document.getElementById('grafico'));
          var chart = new google.visualization.BarChart(document.getElementById('grafico'));
          */

          chart.draw(data, options);

        }

      </script>

    </div>

    <div class="col-xs-12 col-sm-12 col-lg-12" id="grafico4" style="width: 900px; height: 500px;">

      <script type="text/javascript">

        google.charts.load('current', { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

          <?php
            $tabla_consulta = "SELECT if(tipo=0,'Sin comprobantes','Factura') as comprobante,count(id_expediente) as cantidad 
            FROM rendiciones 
            GROUP BY tipo";

            $resultado      = mysqli_query($con,$tabla_consulta);

          ?>

          var data = google.visualization.arrayToDataTable([

            ['Tipo', 'Cantidad'],

            <?php
            while($fila = mysqli_fetch_array($resultado)){
            ?>

              ['<?php echo $fila[0] ?>', <?php echo $fila[1] ?> ],

            <?php  
            }
            ?>

          ]);

          var options = {
            title: 'Cantidad expedientes x comprobante',
            legend: {
              position: 'left'
            },
            is3D: true,
            hAxis: {
              title: "Tipo"
            },
            vAxis: {
              title: "Cantidad de expedientes"
            }
          }

          var chart = new google.visualization.ColumnChart(document.getElementById('grafico4'));

          /*
          var chart = new google.visualization.LineChart(document.getElementById('grafico'));
          var chart = new google.visualization.ColumnChart(document.getElementById('grafico'));
          var chart = new google.visualization.PieChart(document.getElementById('grafico'));
          var chart = new google.visualization.BarChart(document.getElementById('grafico'));
          */

          chart.draw(data, options);

        }

      </script>

    </div>

</div>


<div class="row">

  <div class="col-xs-12 col-sm-12 col-lg-12 text-center jumbotron">
    <h5>Resumen de Expedientes</h5>
  </div>

  <div class="col-xs-12 col-sm-12 col-lg-12">
    <div class="table-responsive">
      <table class="table table-hover table-stripe">
        <tr>
          <td>Otorgado </td>
          <td>$ <b><?php echo number_format($total_prestado, 2, ",", ".") ?></b></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Cobrado</td>
          <td>$ <?php echo number_format($monto_cobrado, 2, ",", ".") ?></b></td>
          <td><?php if($total_prestado>0){echo number_format(($monto_cobrado/$total_prestado)*100, 2, ",", ".");} ?>%</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Pendiente Cobro</td>
          <td>$ <?php echo number_format($monto_pendiente, 2, ",", ".") ?></td>
          <td><?php if($total_prestado>0){echo number_format(($monto_pendiente/$total_prestado)*100, 2, ",", ".");} ?>%</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>

    <div class="col-xs-12 col-sm-12 col-lg-12 text-center jumbotron">
      <h5>Detalle por Estado de Expedientes</h5>
    </div>

      <table class="table table-hover table-stripe">
        <tr>
          <td>Regular</td>
          <td><?php echo $regulares ?></td>
          <td><?php if($total_expedientes>0){echo number_format(($regulares/$total_expedientes)*100, 2, ",", ".");} ?> %</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Morosos</td>
          <td><?php echo $morosos ?></td>
          <td><?php if($total_expedientes>0){echo number_format(($morosos/$total_expedientes)*100, 2, ",", ".");} ?> %</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Devolución Total</td>
          <td><?php echo $dev_total ?></td>
          <td><?php if($total_expedientes>0){echo number_format(($dev_total/$total_expedientes)*100, 2, ",", ".");} ?> %</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Fracaso</td>
          <td><?php echo $fracasos ?></td>
          <td><?php if($total_expedientes>0){echo number_format(($fracasos/$total_expedientes)*100, 2, ",", ".");} ?> %</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Prórroga</td>
          <td><?php echo $prorrogas ?></td>
          <td><?php if($total_expedientes>0){echo number_format(($prorrogas/$total_expedientes)*100, 2, ",", ".");} ?> %</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Cambio Objeto</td>
          <td><?php echo $cambios ?></td>
          <td><?php if($total_expedientes>0){echo number_format(($cambios/$total_expedientes)*100, 2, ",", ".");} ?> %</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><b>Cant total expedientes en cartera</b></td>
          <td><b><?php echo $total_expedientes ?></b></td>
          <td><?php if($total_expedientes>0){echo number_format(($total_expedientes/$total_expedientes)*100, 2, ",", ".");} ?>
            %</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
    </div>
  </div>
</div>
