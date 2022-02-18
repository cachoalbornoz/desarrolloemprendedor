<?php
session_start();

include '../accesorios/accesos_bd.php';

?>

<table class="table table-hover table-condensed" style="font-size: small">
  <thead>
    <tr class=" bg-secondary text-white">
      <td>#Nro</td>
      <td>Apellido </td>
      <td>Nombres</td>
      <td>Cuit</td>
      <td>Movil</td>
      <td>Email</td>
      <td>Responsabilidad</td>
      <td>&nbsp;</td>
    </tr>
  </thead>
  <tbody>
    <?php
      $con = conectar();

      $id_expediente = $_SESSION['id_expediente'];

    $tabla_emprendedores = mysqli_query(
        $con,
        "SELECT t1.*, t3.nombre, t2.id_responsabilidad 
          FROM emprendedores t1
          INNER JOIN rel_expedientes_emprendedores t2 ON t1.id_emprendedor = t2.id_emprendedor
          INNER JOIN localidades t3 ON t1.id_ciudad = t3.id
          WHERE t2.id_expediente = $id_expediente
          ORDER BY t2.id_responsabilidad DESC, apellido ASC "
    );

      while ($fila = mysqli_fetch_array($tabla_emprendedores)) {
          ?>
    <tr>
      <td><?php print $fila['id_emprendedor']; ?>
      </td>
      <td><a href="emprendedor.php?id=<?php print $fila['id_emprendedor']; ?>" title='Ver datos del emprendedor'><?php print $fila['apellido']; ?></a></td>
      <td><?php print $fila['nombres']; ?>
      </td>
      <td><?php print $fila['cuit']; ?>
      </td>
      <td>(<?php print $fila['cod_area']; ?>) - 15 (<?php print $fila['celular']; ?>)</td>
      <td><?php print $fila['email']; ?>
      </td>
      <td>
        <?php
            if ($fila['id_responsabilidad'] == 1) {
                print 'Titular';
            } else {
                print 'Codeudor';
            } ?>
      </td>
      <td>
        <a href='javascript: void(0)' title='Elimina el emprendedor' onclick="eliminar_emprendedor(<?php print $fila[0]; ?>, '<?php print $fila[1] . ', ' . $fila[2]; ?>')">
          <i class="fas fa-trash text-danger"></i>
        </a>
      </td>
    </tr>
    <?php
      }

    ?>
  </tbody>

</table>
<?php mysqli_close($con);
