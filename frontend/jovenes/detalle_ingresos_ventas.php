<?php 
session_start();

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');

$con=conectar();


$id_proyecto = $_SESSION['id_proyecto'];

if(isset($_POST['operacion'])){

    $operacion = $_POST['operacion'];

    if($operacion == 1){

        $concepto 	= strtoupper($_POST['concepto']);
        $cantidad	= $_POST['cantidad'];
        $pu			= $_POST['pu'];
        $ano		= $_POST['ano'];

        // INSERTAR TABLA FUENTE FINANCIACION //
        mysqli_query($con,"INSERT INTO jovenes_ingresos_ventas (id_proyecto,concepto,cantidad,monto,ano) VALUES ($id_proyecto,'$concepto',$cantidad,$pu,$ano)");

    }else{

        if($operacion == 2){

            $id_ingreso = $_POST['id_ingreso'];	
            mysqli_query($con,"DELETE FROM jovenes_ingresos_ventas WHERE id_ingreso = $id_ingreso");			
        }
    }
}
// CANTIDAD DE ITEM INGRESOS VENTAS DEL PROYECTO
$tabla_pv   = mysqli_query($con,"SELECT count(id_proyecto) FROM jovenes_ingresos_ventas WHERE id_proyecto = $id_proyecto");
$registro_pv= mysqli_fetch_array($tabla_pv);
$cant_pv    = $registro_pv[0]; 

$subtotal1 = 0;
$subtotal2 = 0;
 
?>


<table class="table text-center" style=" font-size: small">            
<?php
$registro_ingresos = mysqli_query($con, "SELECT * FROM jovenes_ingresos_ventas ing WHERE  id_proyecto = $id_proyecto AND ano = 1");
while($fila_ingresos = mysqli_fetch_array($registro_ingresos)){
?>

    <tr>
        <td class="w-auto text-left">
            <a href="javascript:void(0)"  onclick="borrar_producto_ing(<?php echo $fila_ingresos['id_ingreso']?>)">
                <i class="fas fa-trash text-danger"></i>
            </a>
            &nbsp;
            <?php echo $fila_ingresos['concepto'] ?>
        </td>
        <td style=" width:100px">1°</td>
        <td style=" width:100px">
            <?php echo $fila_ingresos['cantidad']; ?>
        </td>
        <td style=" width:300px">
            <?php echo $fila_ingresos['monto']; ?>
        </td>
        <td style=" width:100px">
            <?php echo  $fila_ingresos['monto']* $fila_ingresos['cantidad']; ?>
        </td>
    </tr>

<?php	
$subtotal1 = ($fila_ingresos['monto'] * $fila_ingresos['cantidad']) + $subtotal1;
	
}
?> 
<tr>
    <td class="w-auto text-left"><b>Total</b></td>
    <td></td>
    <td></td>
    <td></td>
    <td><b><?php echo number_format($subtotal1,2) ?></b></td>
</tr>
</table>   

<table class="table text-center" style=" font-size: small">
<?php
$registro_ingresos = mysqli_query($con, "SELECT * FROM jovenes_ingresos_ventas ing WHERE  id_proyecto = $id_proyecto AND ano = 2");
while($fila_ingresos = mysqli_fetch_array($registro_ingresos)){
?>

    <tr>
        <td class="w-auto text-left">
            <a href="javascript:void(0)"  onclick="borrar_producto_ing(<?php echo $fila_ingresos['id_ingreso']?>)">
                <i class="fas fa-trash text-danger"></i>
            </a>
            &nbsp;
            <?php echo $fila_ingresos['concepto'] ?>
        </td>
        <td style=" width:100px">
            2°
        </td>
        <td style=" width:100px">
            <?php echo $fila_ingresos['cantidad']; ?>
        </td>
        <td style=" width:300px">
            <?php echo $fila_ingresos['monto']; ?>
        </td>
        <td style=" width:100px">
            <?php echo  $fila_ingresos['monto']* $fila_ingresos['cantidad']; ?>
        </td>
    </tr>

    <?php	
    $subtotal2 = ($fila_ingresos['monto'] * $fila_ingresos['cantidad']) + $subtotal2;
        
}
?> 
<tr>
    <th class="w-auto text-left">
        Total
    </th>
    <th>
        <input type="hidden" id="cant_pv" value="<?php echo $cant_pv ?>">
    </th>
    <th>

    </th>
    <th>

    </th>
    <th>
        <?php echo number_format($subtotal2, 2) ?>
    </th>
</tr>
</table>
<?php

mysqli_close($con); 
