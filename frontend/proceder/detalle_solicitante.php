<?php 
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');

$con = conectar();

$id_solicitante = $_SESSION['id_usuario'];

$tabla_solicitantes = mysqli_query($con, "select proy.id_proyecto, proy.id_estado,est.icono, sol.apellido, sol.nombres, sol.nombres, sol.email, sol.dni,sol.id_solicitante, sol.cuit
from solicitantes sol
inner join rel_proceder relps on sol.id_solicitante = relps.id_solicitante
inner join proceder_proyectos proy on proy.id_proyecto = relps.id_proyecto
inner join tipo_estado est on proy.id_estado = est.id_estado
where sol.id_solicitante = $id_solicitante
order by sol.apellido, sol.nombres");

?>

<div class="card-header">
    <div class="row">
        <div class="col p3">
            <h4>Datos personales</h4>
        </div>
    </div>
</div>    

<div class="form-group">
    <div class="row">
        <div class="col">
            <div class="table table-responsive">
                <table class="table table-hover table-bordered">
                <tr>
                    <th>
                        Cuit
                    </th>
                    <th>
                        Apellido
                    </th>
                    <th>
                        Nombres
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Dni
                    </th>
                </tr>
                <?php
                while($fila = mysqli_fetch_array($tabla_solicitantes, MYSQLI_BOTH)){ 
                ?>
                <tr>
                    <td>
                        # <?php echo $fila['cuit'];?>
                    </td>
                    <td>
                        <?php echo $fila['apellido'];?>
                    </td>
                    <td>
                        <?php echo $fila['nombres'];?>
                    </td>
                    <td>
                        <?php echo $fila['email'];?>
                    </td>
                    <td>
                        <?php echo $fila['dni'];?>
                    </td>
                </tr>
                <?php
                }
                ?>
                </table>
            </div>    
        </div>
    </div>
</div>    

<?php    mysqli_close($con);
