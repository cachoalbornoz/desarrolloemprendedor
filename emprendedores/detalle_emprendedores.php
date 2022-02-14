<?php
session_start();

include '../accesorios/accesos_bd.php';

?>

<table class="table table-hover table-condensed" style="font-size: small">
  <thead>
    <tr>
      <th>#Nro</th>
      <th>Apellido </th>
      <th>Nombres</th>
      <th>Cuit</th>
      <th>Movil</th>
      <th>Email</th>
      <th>Responsabilidad</th>
      <th>&nbsp;</th>
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
      <td><?php print $fila[0]; ?>
      </td>
      <td><a href="emprendedor.php?id=<?php print $fila[0]; ?>" title='Ver datos del emprendedor'><?php print $fila[1]; ?></a></td>
      <td><?php print $fila[2]; ?>
      </td>
      <td><?php print $fila[4]; ?>
      </td>
      <td>(<?php print $fila[11]; ?>) - 15 (<?php print $fila[12]; ?>)</td>
      <td><?php print $fila[15]; ?>
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
