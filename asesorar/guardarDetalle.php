<?php

    require $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/accesos_bd.php';
    
    $con = conectar();

    if(isset($_POST['id_seguimiento'])){

        if(isset($_POST['movimiento']) AND $_POST['movimiento'] == 1){

            // CARGAR DE OBSERVACIONES

            $id_seguimiento = $_POST['id_seguimiento'];
            $observacion    = $_POST['observacion'];
            $tipo_estado    = $_POST['tipo_estado'];  

            mysqli_query($con, "INSERT INTO asesorar_detalle (seguimiento, observacion, tipo_estado) 
            VALUES ($id_seguimiento, '$observacion', $tipo_estado)");

        }else{

            if(isset($_POST['movimiento']) AND $_POST['movimiento'] == 2){

                $id = $_POST['id'];
                mysqli_query($con, "DELETE FROM asesorar_detalle WHERE id = $id");

            }

        }

        ?>

        <table class="table table-hover table-sm table-borderless">
        <?php

        $id_seguimiento = $_POST['id_seguimiento'];
        
        $select = mysqli_query($con, "SELECT ad.*, tes.estado, tes.color 
            FROM asesorar_detalle ad
            INNER JOIN tipo_estado_seguimiento tes on ad.tipo_estado = tes.id   
            WHERE ad.seguimiento = $id_seguimiento
            ORDER BY ad.updated_at DESC");

        while ($fila = mysqli_fetch_array($select)) {
        ?>

            <tr>
                <td class="w-50">
                    <?php echo $fila['observacion']?>
                </td>
                <td style="width:250px; color:<?php echo $fila['color']?>; background-color:<?php echo $fila['color']?>">
                    <?php echo $fila['estado']?>
                </td>
                <td class="text-center" style=" width:150px">
                    <?php echo $fila['updated_at']?>
                </td>
                <td style=" width:15px">
                    <i class="fas fa-trash text-secondary" onclick="borrar(<?php echo $fila['id']?>)"></i>
                </div>
            </tr>

        <?php

        }

        ?>

        </table>


        <?php




    mysqli_close($con);
}
?>