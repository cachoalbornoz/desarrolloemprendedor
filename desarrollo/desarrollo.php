<?php
require '../accesorios/admin-superior.php';

require_once '../accesorios/accesos_bd.php';
require '../accesorios/mailer.php';
$con = conectar();

$query = 'SELECT edc.id_expediente, edc.fecha_vcto, edc.estado, emp.apellido, emp.nombres, emp.email
    FROM expedientes exped
    INNER JOIN rel_expedientes_emprendedores rel ON exped.id_expediente = rel.id_expediente 
    INNER JOIN emprendedores emp ON rel.id_emprendedor = emp.id_emprendedor
    INNER JOIN expedientes_detalle_cuotas edc ON exped.id_expediente = edc.id_expediente
    WHERE exped.estado = 6 AND edc.estado = 0 
    AND YEAR(edc.fecha_vcto)=YEAR(NOW())
    AND MONTH(edc.fecha_vcto) = MONTH(NOW()) + 1
    AND rel.id_responsabilidad = 1';

$tabla_prorroga = mysqli_query($con, $query);

// Testo de envío de mail
$email   = 'cachoalbornoz@gmail.com';
$titulo  = 'Programa Jovenes Emprendedores - Aviso Vcto Prorroga -';
$titular = 'Guillermo  Albornoz';
$mensaje = '<br>' . $titular . ' te comentamos x medio de este mail que el período de prórroga ha finalizado y el próximo mes comienzan los vencimientos de cuotas de tu Crédito. Saludos <br>';
$logo    = null;

enviar($email, $titulo, $titular, $mensaje, $logo);

?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                AMBIENTE DESARROLLO
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="row mt-5 mb-5">
            <div class="col-xs-12 col-md-12 col-lg-12">

                <div class="table-responsive">
                    <table class="table table-hover" style="font-size: small" >
                    <thead>
                        <tr>
                            <td>Expediente</td>
                            <td>Apellido</td>
                            <td>Nombres</td>
                            <td>Email</td>                    
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    while($registro = mysqli_fetch_array($tabla_prorroga)) {

                        $expediente = $registro['id_expediente'];
                        $apellido   = $registro['apellido'];
                        $nombres    = $registro['nombres'];
                        $email      = $registro['email'];
                        $titular    = $registro['nombres'] . ', ' . $registro['apellido'];

                        $titulo  = 'Programa Jovenes Emprendedores - Aviso Vcto Prorroga -';
                        $mensaje = '<br>' . $titular . ' te comentamos x medio de este mail que el período de prórroga ha finalizado y el próximo mes comienzan los vencimientos de cuotas de tu Crédito. Saludos <br>';
                        $logo    = null;
                        ?>
                        <tr>
                            <td><?php print $expediente; ?></td>
                            <td><?php print $apellido; ?></td>
                            <td><?php print $nombres; ?></td>
                            <td><?php print $email; ?></td>                    
                        </tr>
                    <?php
                    }
?>
                    </tbody>
                    
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php require_once '../accesorios/admin-scripts.php'; ?>


<script type="text/javascript">
    $(document).ready(function() {
        
    })    
</script>

<?php require_once '../accesorios/admin-inferior.php';
