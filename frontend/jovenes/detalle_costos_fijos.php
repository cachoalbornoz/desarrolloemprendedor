<?php 
session_start();

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');

$con=conectar();

$id_proyecto	= $_SESSION['id_proyecto'];


if(isset($_POST['operacion'])){

    $operacion = $_POST['operacion'];

    if($operacion == 1){

        $concepto 	= strtoupper($_POST['concepto']);
        $monto		= $_POST['monto'];
        $ano		= $_POST['ano'];

        mysqli_query($con,"INSERT INTO jovenes_costos_fijos (id_proyecto, concepto, monto, ano) VALUES ($id_proyecto, '$concepto', $monto, $ano)") or die("Revisar insercion costos");	

    }else{

        if($operacion == 2){

            $id_concepto = $_POST['id_concepto'];	

            mysqli_query($con,"DELETE FROM jovenes_costos_fijos WHERE id_concepto = $id_concepto");
            
        }
    }
}
// CANTIDAD DE ITEM COSTOS FIJOS DEL PROYECTO
$tabla_cf   = mysqli_query($con,"SELECT count(id_proyecto) FROM jovenes_costos_fijos WHERE id_proyecto = $id_proyecto");
$registro_cf= mysqli_fetch_array($tabla_cf);
$cant_cf    = $registro_cf[0];
?>

<table class="table text-center" style=" font-size: small">
    <?php
    $subtotal_ano1  = 0;
    $total          = 0; 

    $registro_conceptos = mysqli_query($con, "SELECT id_concepto, concepto, monto, ano FROM jovenes_costos_fijos WHERE id_proyecto = $id_proyecto and ano = 1");

    while($fila_conceptos = mysqli_fetch_array($registro_conceptos)){

        $subtotal_ano1 = $fila_conceptos['monto'] + $subtotal_ano1 ;
        ?>
        <tr>       
            <td class="w-auto text-left">
                <a href="javascript:void(0)"  onclick="borrar_producto_f(<?php echo $fila_conceptos['id_concepto']?>)">
                    <i class="fas fa-trash text-danger"></i>
                </a>                  
                &nbsp;
                <?php echo $fila_conceptos['concepto'] ?> 
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
        <td class="w-auto text-left"><b>Total</b></td>
        <td></td>
        <td><b><?php echo number_format($subtotal_ano1,2) ?></b></td>
        <td></td>
    </tr>
</table>


<table class="table text-center" style=" font-size: small">

    <?php
    $subtotal_ano2  = 0;
    $total          = 0;
 
    $registro_conceptos = mysqli_query($con, "SELECT id_concepto, concepto, monto, ano FROM jovenes_costos_fijos WHERE id_proyecto = $id_proyecto and ano = 2");
    while($fila_conceptos = mysqli_fetch_array($registro_conceptos)){

        $subtotal_ano2 = $fila_conceptos['monto'] + $subtotal_ano2 ;
        ?>
        <tr>       
            <td class="w-auto text-left">
                <a href="javascript:void(0)"  onclick="borrar_producto_f(<?php echo $fila_conceptos['id_concepto']?>)">
                    <i class="fas fa-trash text-danger"></i>
                </a>                  
                &nbsp;
                <?php echo $fila_conceptos['concepto'] ?> 
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
        <th class="w-auto text-left">
            Total
        </th>
        <th>
            <input type="hidden" id="cant_cf" value="<?php echo $cant_cf ?>">
        </th>
        <th>
            <?php echo number_format($subtotal_ano2,2) ?>
        </th>
        <th>

        </th>
    </tr>
</table>  
    
<?php

mysqli_close($con); 