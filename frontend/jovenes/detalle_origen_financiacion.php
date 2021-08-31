<?php 
session_start();

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');

$con=conectar();

$id_proyecto	= $_SESSION['id_proyecto'];

if(isset($_POST['operacion'])){

    $operacion = $_POST['operacion'];		

    if($operacion == 1){

        $id_tipo 	= $_POST['id_tipo'];
        $monto		= $_POST['monto'];
        $ano		= $_POST['ano'];

        // INSERTAR TABLA FUENTE FINANCIACION //
        mysqli_query($con, "INSERT INTO jovenes_fuente_financiacion (id_proyecto, id_tipo_origen, monto, ano) VALUES ($id_proyecto, $id_tipo ,$monto, $ano)") or die("Revisar insercion Fuente Financ");

    }else{

        if($operacion == 2){
            $id_fuente = $_POST['id_fuente'];	
            mysqli_query($con, "DELETE FROM jovenes_fuente_financiacion WHERE id_fuente = $id_fuente");			
        }
    }
}

// CANTIDAD DE ITEM FUENTE FINANCIACION DEL PROYECTO
$tabla_ff   = mysqli_query($con,"SELECT count(id_proyecto) FROM jovenes_fuente_financiacion WHERE id_proyecto = $id_proyecto");
$registro_ff= mysqli_fetch_array($tabla_ff);
$cant_ff    = $registro_ff[0]; 
?>

<table class="table text-center" style=" font-size: small">   
<?php
$subtotal_ano1 = 0;
$total = 0;

$registro_conceptos = mysqli_query($con, "SELECT * FROM jovenes_fuente_financiacion fuen, tipo_origen_financiacion tipo WHERE fuen.id_tipo_origen = tipo.id_tipo and id_proyecto = $id_proyecto and ano = 1");
while($fila_conceptos = mysqli_fetch_array($registro_conceptos)){
    $subtotal_ano1 = $fila_conceptos['monto'] + $subtotal_ano1 ;
    ?>
    <tr>
        <td class="w-auto text-left">
            <a href="javascript:void(0)"  onclick="borrar_producto_o(<?php echo $fila_conceptos['id_fuente']?>)">
                <i class="fas fa-trash text-danger"></i>
            </a>
            &nbsp;
            <?php echo $fila_conceptos['origen'] ?>
        </td>
        <td style=" width:100px">
            1°
        </td>
        <td style=" width:300px">
            <?php  echo $fila_conceptos['monto'];  ?>
        </td>
        <td style=" width:100px">
            &nbsp;            
        </td>
    </tr>
    <?php		
}
?>
<tr>
    <th class="w-auto text-left">
        Total
    </th>
    <th>
        <input type="hidden" id="cant_ff" value="<?php echo $cant_ff ?>">
    </th>
    <th>
        <?php echo number_format($subtotal_ano1,2) ?>
    </th>
    <th>

    </th>
</tr>
</table>


<table class="table text-center" style=" font-size: small">   
<?php
$subtotal_ano2 = 0;
$total = 0;
 
$registro_conceptos = mysqli_query($con, "SELECT * FROM jovenes_fuente_financiacion fuen, tipo_origen_financiacion tipo WHERE fuen.id_tipo_origen = tipo.id_tipo and id_proyecto = $id_proyecto and ano = 2");
while($fila_conceptos = mysqli_fetch_array($registro_conceptos)){
    $subtotal_ano2 = $fila_conceptos['monto'] + $subtotal_ano2 ;
    ?>
    <tr>
        <td class="w-auto text-left">
            <a href="javascript:void(0)"  onclick="borrar_producto_o(<?php echo $fila_conceptos['id_fuente']?>)">
                <i class="fas fa-trash text-danger"></i>
            </a>
            &nbsp;
            <?php echo $fila_conceptos['origen'] ?>
        </td>
        <td style=" width:100px">
            2°
        </td>
        <td style=" width:300px">
            <?php  echo $fila_conceptos['monto'];  ?>
        </td>
        <td style=" width:100px">
            &nbsp;            
        </td>
    </tr>
    <?php	
}
?>
<tr>
    <td class="w-auto text-left"><b>Total</b></td>
    <td></td>
    <td><b><?php echo number_format($subtotal_ano2,2) ?></b></td>
    <td></td>
</tr>
</table>
<?php

mysqli_close($con); 