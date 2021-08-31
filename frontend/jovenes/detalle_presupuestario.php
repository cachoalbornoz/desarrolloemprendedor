<?php 
session_start();

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');

$con=conectar();

$id_proyecto	= $_SESSION['id_proyecto'];

if(isset($_POST['operacion'])){

    $operacion = $_POST['operacion'];

    if($operacion == 1){

        $descripcion 	= strtoupper($_POST['descripcion']);
        $cantidades		= $_POST['cantidades'];
        $costounitario	= $_POST['costounitario'];

        // INSERTAR TABLA PRODUCTOS -- RESUMEN PRESUPUESTO //

        mysqli_query($con,"INSERT INTO jovenes_resumen_presupuestario (id_proyecto, descripcion, cantidades, costounitario) 
            VALUES ($id_proyecto, '$descripcion', $cantidades, $costounitario)") or die("Revisar insercion productos");	

    }else{

        if($operacion == 2){

            $id_producto = $_POST['id_producto'];

            mysqli_query($con,"DELETE FROM jovenes_resumen_presupuestario WHERE id_producto = $id_producto");			
        }
    }
}
    
// CANTIDAD DE PRODUC RESUMEN PRESUPUESTARIO DEL PROYECTO
$tabla_rp   = mysqli_query($con,"SELECT count(id_proyecto) FROM jovenes_resumen_presupuestario WHERE id_proyecto = $id_proyecto");
$registro_rp= mysqli_fetch_array($tabla_rp);
$cant_rp    = $registro_rp[0];     
//
$total = 0;

?>

<table class="table text-center" style=" font-size: small">

    <?php
    $registro_productos = mysqli_query($con, "SELECT * FROM jovenes_resumen_presupuestario WHERE id_proyecto = $id_proyecto");    
    while($fila_productos = mysqli_fetch_array($registro_productos)){

        $subtotal = $fila_productos['cantidades']*$fila_productos['costounitario'];
        ?>
        <tr>       
            <td class="w-auto text-left">
                <a href="javascript:void(0)"  onclick="borrar_producto_resumen(<?php echo $fila_productos['id_producto']?>)">
                    <i class="fas fa-trash text-danger"></i>
                </a>                    
                &nbsp;
                <?php echo $fila_productos['descripcion'] ?> </td>
            <td style=" width:100px"><?php echo $fila_productos['cantidades'] ?> </td>
            <td style=" width:300px"><?php echo $fila_productos['costounitario'] ?> </td>
            <td style=" width:100px"><?php echo number_format($subtotal,2) ?> </td>  
        </tr>
        <?php 

        $total = $subtotal + $total; 
    }
    mysqli_close($con); 
    ?>

    <tr>
        <th>
            Total</th>
        <th>
            <input type="hidden" id="cant_rp" value="<?php echo $cant_rp ?>">
        </th>
        <th>

        </th>
        <th>
            <?php echo number_format($total,2) ?>
        </th>
    </tr>
</table>

