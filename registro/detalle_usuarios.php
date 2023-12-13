<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}

require_once '../accesorios/accesos_bd.php';

$con = conectar();

if(isset($_POST['id'])) {

    if($_POST['id'] == 1) {

        $usuario  = $_POST['usuario'];
        $apellido = strtoupper($_POST['apellido']);
        $nombres  = strtoupper($_POST['nombres']);
        $clave    = $_POST['clave'];
        $password = md5($_POST['clave']);
        $tipo     = $_POST['tipo'];

        $carga = "INSERT INTO usuarios (nombre_usuario, apellido, nombres, estado, clave, password)
        VALUES ('$usuario', '$apellido', '$nombres', '$tipo', '$clave', '$password')";

        mysqli_query($con, $carga) or die($carga);

    }

    if($_POST['id'] == 2) {

        $id_usuario = $_POST['id_usuario'];

        mysqli_query($con, "DELETE FROM usuarios WHERE id_usuario = $id_usuario") or die('Revisar baja usuarios');
    }

    if($_POST['id'] == 3) {

        $id_usuario = $_POST['id_usuario'];
        $tipo       = $_POST['tipo'];

        mysqli_query($con, "UPDATE usuarios SET estado = '$tipo' WHERE id_usuario = $id_usuario") or die('Revisar cambio estado');
    }

}

?>
<script type="text/javascript">
    
    $(document).ready(function() {

        var table = $('#usuarios').DataTable({ 
            "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            "dom"           : '<"wrapper"Brflit>',        
            "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
            "order"         : [[ 1, "asc" ]],
            "stateSave"     : true,
            "columnDefs"    : [{ className: 'text-center', targets: [4,5,6] },],
            "language"      : { "url": "../public/DataTables/spanish.json" }
        }); 
    }) 

</script> 


<table class="table table-hover table-condensed" style="font-size: small" id="usuarios">
    <thead>
    <tr> 
        <th>Apellido</th>
        <th>Nombres</th>
        <th>Usuario</th>
        <th>Clave</th>
        <th>Estado</th>            
        <th>Cambiar</th>
        <th>Borrar</th>
    </tr>
    </thead>
    <tbody>
        <?php
        $tabla_usuarios = mysqli_query($con, 'SELECT * FROM usuarios ORDER BY apellido, nombres asc');
while($fila = mysqli_fetch_array($tabla_usuarios)) {
    ?>
        <tr>
            <td><?php print  $fila['apellido']; ?></td>
            <td><?php print  $fila['nombres']; ?></td>
            <td><?php print strtoupper($fila['nombre_usuario']); ?></td>
            <td><?php print $fila['clave']; ?></td>                
            <td><?php print  strtoupper($fila['estado']); ?></td>
            <td>
                <?php
            if($_SESSION['id_usuario'] == 2) {
                ?>
                <select name="id_tipo" id="id_tipo" class="form-control" onchange="cambiar_permiso(<?php print $fila['id_usuario']; ?>,this.value)">
                    <option value="x">Tipo usuario</option>
                    <option value="a">a - Administrativo</option>
                    <option value="b">b - Gestión cobranza</option>
                    <option value="c">c - Administrador</option>
                    <option value="d">d - Asesor</option>
                </select>
                <?php
            }
    ?>
            </td>
            <td>
                <?php
    if($_SESSION['id_usuario'] == 2) {
        ?>
                <a href="#" onclick="borrar_usuario(<?php print  $fila['id_usuario']; ?>, '<?php print  $fila['apellido'] . ', ' . $fila['nombres']; ?>')">
                    <i class="fas fa-trash text-danger"></i> 
                </a>
                <?php
    }
    ?>
            </td>
        </tr> 

        <?php
}
mysqli_close($con);
?>
    </tbody>    
</table>

