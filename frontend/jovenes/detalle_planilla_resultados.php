<?php 
session_start();

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');

$con=conectar();

$id_proyecto	= $_SESSION['id_proyecto'];

?>
<table class="table table-hover text-center">
	<tr>
		<th class="w-auto">INGRESOS</th>
		<th style=" width:100px">AÑO 1</th>
		<th style=" width:100px">AÑO 2</th>
	</tr>
	<?php
	$subtotal_ano1_ing = 0;
	$subtotal_ano2_ing = 0;
	$registro_conceptos = mysqli_query($con, "SELECT ano, sum(cantidad*monto) as suma FROM jovenes_ingresos_ventas WHERE id_proyecto = $id_proyecto GROUP BY ano ");
	while($fila_conceptos = mysqli_fetch_array($registro_conceptos)){

		if($fila_conceptos['ano'] == 1){
			$subtotal_ano1_ing = $fila_conceptos['suma'];
		}else{
			$subtotal_ano2_ing = $fila_conceptos['suma'];
		}		
	}
	?>
	<tr>
		<td class="text-left">Ingresos x ventas</td>
		<td><?php echo number_format($subtotal_ano1_ing,2) ?></td>
		<td><?php echo number_format($subtotal_ano2_ing,2) ?></td>
	</tr>
	<?php
	$subtotal_ano1_ff = 0;
	$subtotal_ano2_ff = 0;
	$registro_conceptos = mysqli_query($con, "SELECT ano, sum(monto) as suma FROM jovenes_fuente_financiacion WHERE id_proyecto = $id_proyecto GROUP BY ano");
	while($fila_conceptos = mysqli_fetch_array($registro_conceptos)){

		if($fila_conceptos['ano'] == 1){
			$subtotal_ano1_ff = $fila_conceptos['suma'];
		}else{
			$subtotal_ano2_ff = $fila_conceptos['suma'];
		}		
	}
	?>
	<tr>
		<td class="text-left">Ingresos x Otras Fuentes (Inc.Préstamos)</td>
		<td><?php echo number_format($subtotal_ano1_ff,2) ?></td>
		<td><?php echo number_format($subtotal_ano2_ff,2) ?></td>
	</tr>
	<tr>
		<td class="text-left">Ingresos totales</td>
		<td><?php echo number_format($subtotal_ano1_ing+$subtotal_ano1_ff,2) ?></td>
		<td><?php echo number_format($subtotal_ano2_ing+$subtotal_ano2_ff,2) ?></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>

	<tr>
		<th>EGRESOS</th>
		<th></th>
		<th></th>
	</tr>
	<?php
	$subtotal_ano1_fijos = 0;
	$subtotal_ano2_fijos = 0;
	$registro_conceptos = mysqli_query($con, "SELECT ano, sum(monto) as suma FROM jovenes_costos_fijos	WHERE id_proyecto = $id_proyecto GROUP BY ano");
	while($fila_conceptos = mysqli_fetch_array($registro_conceptos)){

		if($fila_conceptos['ano'] == 1){
			$subtotal_ano1_fijos = $fila_conceptos['suma'];
		}else{
			$subtotal_ano2_fijos = $fila_conceptos['suma'];
		}		
	}
	?>
	<tr>
		<td class="text-left">Costos fijos</td>
		<td><?php echo number_format($subtotal_ano1_fijos,2) ?></td>
		<td><?php echo number_format($subtotal_ano2_fijos,2) ?></td>
	</tr>
	
	<?php
	$subtotal_ano1_variables = 0;
	$subtotal_ano2_variables = 0;
	$registro_conceptos = mysqli_query($con, "SELECT ano, sum(monto) as suma FROM jovenes_costos_variables	WHERE id_proyecto = $id_proyecto GROUP BY ano");
	while($fila_conceptos = mysqli_fetch_array($registro_conceptos)){

		if($fila_conceptos['ano'] == 1){
			$subtotal_ano1_variables = $fila_conceptos['suma'];
		}else{
			$subtotal_ano2_variables = $fila_conceptos['suma'];
		}		
	}
	?>
	<tr>
		<td class="text-left">Costos variables</td>
		<td><?php echo number_format($subtotal_ano1_variables,2) ?></td>
		<td><?php echo number_format($subtotal_ano2_variables,2) ?></td>
	</tr>
	<tr>
		<td class="text-left">Egresos totales</td>
		<td><?php echo number_format($subtotal_ano1_fijos+$subtotal_ano1_variables,2) ?></td>
		<td><?php echo number_format($subtotal_ano2_fijos+$subtotal_ano2_variables,2) ?></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<th class="text-left">RESULTADO FINAL</th>
		<th><?php echo number_format(($subtotal_ano1_ing+$subtotal_ano1_ff)-($subtotal_ano1_fijos+$subtotal_ano1_variables),2) ?></th>
		<th><?php echo number_format(($subtotal_ano2_ing+$subtotal_ano2_ff)-($subtotal_ano2_fijos+$subtotal_ano2_variables),2) ?></th>
	</tr>
</table>  
    
<?php
mysqli_close($con); 

