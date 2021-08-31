<?php
session_start();

include("../accesorios/accesos_bd.php");

$con=conectar();

$id_expediente = $_SESSION['id_expediente'];

if (isset($_POST['operacion'])) {
    $operacion = $_POST['operacion'] ;

    if ($operacion == 1) {
        $fecha  = $_POST['fecha'];
        $monto  = $_POST['monto'];
        $tipo   = $_POST['tipo'];

        mysqli_query($con, "insert into rendiciones (id_expediente, monto, tipo, fecha) values ($id_expediente, $monto, $tipo, '$fecha')");
    } else {
        if ($operacion == 2) {
            $id_rendicion = $_POST['id'];
            mysqli_query($con, "delete from rendiciones where id_rendicion = $id_rendicion");
        }
    }
}


$tabla_rendiciones = mysqli_query($con, "SELECT * FROM rendiciones WHERE id_expediente = $id_expediente ORDER BY fecha desc");
$total_rendido = 0;
while ($fila = mysqli_fetch_array($tabla_rendiciones)) {
    ?>
    <div class="row m-3">
        <div class="col-xs-12 col-sm-12 col-lg-3">
            <?php
            if (isset($fila[4])) {
                echo date('d/m/Y', strtotime($fila[4])) ;
            } 
            ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-lg-3">
            <?php echo number_format($fila[2], 0, ',', '.') ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-lg-3">
            <?php
            if ($fila[3] == 1) {
                echo "Factura";
            } else {
                echo "No válido como Factura";
            } 
            ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-lg-3 text-center">
            <a href='javascript: void(0)' title='Eliminar' onclick="eliminar_rendicion('<?php echo $fila[0] ?>')">
                <i class="fas fa-trash text-danger"></i>
            </a>
        </div>
    </div>
    <?php
    $total_rendido = $total_rendido + $fila[2];
}
?>
    <div class="row m-3">
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <hr/>
        </div>
    </div>
    <div class="row m-3">
        <div class="col-xs-12 col-sm-12 col-lg-3">
        </div>
        <div class="col-xs-12 col-sm-12 col-lg-3 font-weight-bold">
            Total rendido 
        </div>
        <div class="col-xs-12 col-sm-12 col-lg-3 font-weight-bold">
            Porcentaje
        </div>
        <div class="col-xs-12 col-sm-12 col-lg-3 font-weight-bold text-center"> 
            Evaluación rendición   
        </div>
    </div>
    <div class="row m-3">
        <div class="col-xs-12 col-sm-12 col-lg-3">
            
        </div>
        <div class="col-xs-12 col-sm-12 col-lg-3">
            <?php echo  number_format($total_rendido, 0, ',', '.')?>
        </div>
        <div class="col-xs-12 col-sm-12 col-lg-3">
            <?php
            if ($total_rendido > 0) {
                $porcentaje = number_format(($total_rendido/$_SESSION['monto'])*100, 2, ',', '.');
            } else {
                $porcentaje = 0;
            }
            echo $porcentaje;
            ?>
            % 
        </div>
        <div class="col-xs-12 col-sm-12 col-lg-3 text-center <?php if($porcentaje>74){echo "bg-success";}else{if($porcentaje>50){echo "bg-warning";}else{if($porcentaje>0){echo "bg-danger";}else{echo "bg-secondary";}}}?> ">
            <?php
            if ($porcentaje > 74) {
                echo "Total";
            } else {
                if ($porcentaje > 50) {
                    echo "Parcial";
                } else {
                    if ($porcentaje > 0) {
                        echo "Insuficiente";
                    } else {
                        echo "Sin rendición";
                    }
                }
            }
            ?>
        </div>
    </div>

<?php
mysqli_close($con);
