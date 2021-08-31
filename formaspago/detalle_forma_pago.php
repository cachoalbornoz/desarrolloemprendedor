<?php 
session_start();
date_default_timezone_set('America/Buenos_Aires');
include("../accesorios/accesos_bd.php");

$con=conectar();

$id_expediente = $_SESSION['id_expediente'];

if(isset($_POST['operacion'])){
	$operacion = $_POST['operacion'] ;	
	
	if($operacion == 1)	{
		$cuotas = $_POST['cuotas'];
		
		$seleccion_detalle_cuotas = "SELECT id_expediente FROM expedientes_detalle_cuotas WHERE id_expediente = $id_expediente";
		$registro_detalle_cuotas = mysqli_query($con, $seleccion_detalle_cuotas);
		if(mysqli_num_rows($registro_detalle_cuotas) == 0){
			
			$deuda = $_SESSION['monto'];
			$importe = $deuda/$cuotas;
			
			$fecha = date('Y-m-d',strtotime("$_SESSION[fecha_otorgamiento] + ". 365 ." days"));
			$fecha = date('Y-m-d',strtotime("$fecha + ". 1 ." months"));			
			$fecha = explode('-',$fecha);
			
			$mes = $fecha[1];
			$año = $fecha[0];
						
			$fecha = $mes."/"."10"."/".$año;	
			
			$fecha = date('Y-m-d',strtotime($fecha));
				
			$insercion_detalle = "INSERT INTO expedientes_detalle_cuotas (id_expediente, nro_cuota, fecha_vcto, importe, estado) 
			VALUES ($id_expediente, 1, '$fecha', $importe, 0)";
			mysqli_query($con, $insercion_detalle) or die ("Revisar Insercion Detalle Convenio");	
			
			if($mes == 12){
				$mes = 0;
				$año ++;
			}				
			$mes ++;
			
			if($cuotas == 24){	
				for ($i=2; $i <= $cuotas; $i++){					
					$fecha = date('Y-m-d',strtotime("$fecha + ". 1 ." months"));		
					$fecha = date("Y-m-d",strtotime($fecha));
					$insercion_detalle = "INSERT INTO expedientes_detalle_cuotas (id_expediente, nro_cuota, fecha_vcto, importe, estado) 
					VALUES ($id_expediente, $i, '$fecha', $importe, 0)";
					mysqli_query($con, $insercion_detalle) or die ("Revisar Insercion Detalle Convenio");
				}
			}else{
				for ($i=2; $i <= 3; $i++){					
					$fecha = date('Y-m-d',strtotime("$fecha + ". 6 ." months"));		
					$fecha = date("Y-m-d",strtotime($fecha));
					
					$insercion_detalle = "INSERT INTO expedientes_detalle_cuotas (id_expediente, nro_cuota, fecha_vcto, importe, estado) 
					VALUES ($id_expediente, $i, '$fecha', $importe, 0)";
					mysqli_query($con, $insercion_detalle) or die ("Revisar Insercion Detalle Convenio");
				}
			}
			///ACTUALIZAR EL ESTADO DE LAS CUOTAS
			
			/// CALCULAR EL TOTAL COBRADO

			$resultado = mysqli_query($con,"SELECT sum(monto) FROM expedientes_pagos WHERE id_expediente = $id_expediente");
			$registro = mysqli_fetch_array($resultado);
			$monto_cobrado = $registro[0];	
			///	
			$seleccion = mysqli_query($con, "SELECT entrega_parcial FROM expedientes_detalle_cuotas 
			WHERE id_expediente = $id_expediente and estado = 0 order by nro_cuota limit 1");
			$registro = mysqli_fetch_array($seleccion);
			$total_cobrado = $monto_cobrado + $registro[0];
			
			$seleccion_cuota = mysqli_query($con, "SELECT importe, nro_cuota, entrega_parcial FROM expedientes_detalle_cuotas 
			WHERE id_expediente = $id_expediente and estado = 0");
			$bandera = true;
			
			while($registro_cuota = mysqli_fetch_array($seleccion_cuota) and $bandera){
				$nro_cuota = $registro_cuota[1];
							
				if($total_cobrado >= $registro_cuota[0]){		
					mysqli_query($con, "UPDATE expedientes_detalle_cuotas set id_pago = -1, estado = 1, entrega_parcial = 0 
					WHERE id_expediente = $id_expediente and nro_cuota = $nro_cuota") or die("Revisar actualización de Cuotas");	
				}else{
					mysqli_query($con, "UPDATE expedientes_detalle_cuotas set id_pago = -1, entrega_parcial = $total_cobrado 
					WHERE id_expediente = $id_expediente and nro_cuota = $nro_cuota") or die("Revisar actualización de Entrega Parcial");
					break;
					$bandera = false;
				}			
				$total_cobrado = $total_cobrado - $registro_cuota[0];			
			}		
			
			$saldo = $_SESSION['monto'] - $monto_cobrado;
			
			if($monto_cobrado < $_SESSION['monto']){	
				$edicion = "UPDATE expedientes set saldo = $saldo WHERE id_expediente = $id_expediente";			
			}else{
				
				$edicion = "UPDATE expedientes set saldo = 0, estado = 3 WHERE id_expediente = $id_expediente";	
				//Cargo el Estado como PAGO
				$seleccion   = mysqli_query($con,"SELECT id_tipo_estado FROM expedientes_estados WHERE id_expediente = $id_expediente order by fecha desc limit 1" );
				$fila_estado = mysqli_fetch_array($seleccion);
				$id_tipo_estado_ant = $fila_estado[0];
			
				$insercion = "INSERT INTO expedientes_estados (fecha, id_expediente, id_tipo_estado, id_tipo_estado_ant) VALUES ('$fecha', $id_expediente, 3, $id_tipo_estado_ant)";
				mysqli_query($con, $insercion) or die ("Error en la insercion Estado");				
			}
			mysqli_query($con, $edicion);				
		}
	}else{
		if($operacion == 2){
			$seleccion = mysqli_query($con,"SELECT monto FROM expedientes WHERE id_expediente = $id_expediente");
			$registro  = mysqli_fetch_array($seleccion);
			$saldo = $registro[0];
			$_SESSION['monto'] = $saldo;
			
			mysqli_query($con, "delete FROM expedientes_detalle_cuotas WHERE id_expediente = $id_expediente");

		}else{
			if($operacion == 3){ // BORRA PLAN DE PAGOS GENERADO ANTERIORMENTE
				$id_detalle = $_POST['id_detalle'];
				mysqli_query($con, "delete FROM expedientes_detalle_cuotas WHERE id_detalle = $id_detalle");				
			}else{ 				/// INGRESAR LAS CUOTAS MANUALMENTE 
					
				$cuota = $_POST['cuota'];
				$fecha = $_POST['fecha'];
				$importe = $_POST['importe'];
				$monto_cobrado = 0;
				$entrega_parcial = 0;
				$estado = 0;
				
				$resultado = mysqli_query($con,"SELECT id_detalle FROM expedientes_detalle_cuotas WHERE id_expediente = $id_expediente and nro_cuota = $cuota");
				if(mysqli_num_rows($resultado)== 0){// CONTROLA QUE NO SE INGRESE DOS VECES EL MISMO NRO DE CUOTA				
					if($cuota == 1){				// CALCULAR EL TOTAL COBRADO ANTERIORMENTE SI TIENE				
						$resultado = mysqli_query($con,"SELECT sum(monto) FROM expedientes_pagos WHERE id_expediente = $id_expediente");
						if($registro = mysqli_fetch_array($resultado)){
							if(is_null($registro[0])){
								$monto_cobrado = 0;
							}else{
								$monto_cobrado = $registro[0];	
							}
						}else{
							$monto_cobrado = 0;
						}						
						
						if($monto_cobrado >= $cuota){
							$estado = 1;
							$entrega_parcial = $monto_cobrado - $importe;																		
						}else{
							$estado = 0;
							$entrega_parcial = $monto_cobrado ;	
						}
					}else{				/// CALCULAR EL TOTAL COBRADO						
						$resultado = mysqli_query($con,"SELECT sum(entrega_parcial) FROM expedientes_detalle_cuotas WHERE id_expediente = $id_expediente");
						if($registro = mysqli_fetch_array($resultado)){
							if(is_null($registro[0])){
								$entrega_parcial = 0;
							}else{
								$entrega_parcial = $registro[0];	
							}
						}else{
							$entrega_parcial = 0;
						}
						
						if($entrega_parcial >= $importe){
							$estado = 1;
							$entrega_parcial = $entrega_parcial - $importe;
						}else{
							$estado = 0;
						}
						$actualizar_detalle = "UPDATE expedientes_detalle_cuotas set entrega_parcial = 0 WHERE id_expediente = $id_expediente";
						mysqli_query($con, $actualizar_detalle) or die ("Revisar actualiza Detalle Convenio");	
					}
					
					/// INGRESAR EL MOVIMIENTO
					$insercion_detalle = "INSERT INTO expedientes_detalle_cuotas (id_expediente,nro_cuota,fecha_vcto,importe,estado,manual,entrega_parcial) 
					VALUES ($id_expediente,$cuota,'$fecha',$importe,$estado,1,$entrega_parcial)";
					mysqli_query($con, $insercion_detalle) or die (" Revisar Insercion Detalle Convenio Manual");
				}
			}
		}
	}
}
?>


<table class="table table-hover table-condensed text-center">
  	<thead>
	<tr>
		<td style=" width:120px">
			Nro cuota
		</td>
		<td>
			Vencimiento 
		</td>
		<td>
			$ importe
		</td>
		<td>
			Estado
		</td>
		<td>
			Ent parcial
		</td>
		<td>
			&nbsp;
		</td>             
	</tr>
	</thead>
	<tbody>
		<?php   
		$tabla_forma_pago = mysqli_query($con, "SELECT * FROM expedientes_detalle_cuotas WHERE id_expediente = $id_expediente ORDER BY fecha_vcto asc");
		$filas_forma_pago = mysqli_num_rows($tabla_forma_pago);
		$total_pagado = 0;

		while($fila = mysqli_fetch_array($tabla_forma_pago)){?>
		<tr>
			<td>
				<?php echo $fila[2] ?>
			</td>
			<td>
				<?php echo date('d-m-Y', strtotime($fila[3])); ?>
			</td>
			<td>
				<?php echo number_format($fila[4],2,'.','') ?>
			</td>
			<td <?php if($fila[5] == 0){echo "class='text-danger'";}else{echo "class='text-success'";}?>>
				<?php
				if($fila[5] == 0){
					echo "Debe";   
				}else{
					echo "Pagada";
					$total_pagado = $total_pagado + $fila[4];
				}
				?>
			</td>
			<td>
				<?php echo number_format($fila[8],2,',','.') ?>
			</td>
			<td>
				<?php
				if($fila[7] == 1){?>
					<a href='javascript: void(0)' title='Eliminar' onclick="eliminar_cuota('<?php echo $fila[0] ?>')">
						<i class="fas fa-trash text-danger"></i>
					</a>
				<?php
				}
				?>
			</td>
		</tr>
		<?php  
		}
	?>
	</tbody>
</table>
  		

<?php 

mysqli_close($con);
