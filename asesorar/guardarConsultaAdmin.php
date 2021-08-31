<?php
    require('../accesorios/accesos_bd.php');
    $con = conectar();

    // LEO E INICIALIZO LOS DATOS DEL SOLICITANTES

    $dni                = $_POST['dni'];
    $apellido           = strtoupper(ltrim($_POST['apellido']));
    $nombres            = strtoupper(ltrim($_POST['nombres']));
    $genero             = 0;    // MUJER
    $otrogenero         = null;
    $direccion          = 'Complete';
    $fecha_nac          = '2000-01-01';
    $cuit               = $dni;
    $email              = strtolower($_POST['email']);
    $cod_area           = '000';
    $telefono           = $_POST['telefono'];
    $celular            = $telefono;
    $id_ciudad          = 2548; // PARANA
    $id_responsabilidad = 1;

    // DATOS INICIALIZADOS PARA EL EMPRENDEDOR

    $id_medio      = 6;                 // OTRO MEDIO
    $id_programa   = 5;                 // ASESORAMIENTO
    $id_rubro      = 30;                // AGROINDUSTRIA
    $id_empresa    = 0;                 // EMPRESA RESETEADA
    $id_entidad    = 0;                 // ENTIDAD RESETEADA
    $funciona      = 0;                 // NO FUNCIONA - TIENE QUE CARGAR DATOS DE LA EMPRESA
    $observaciones = 0;                 // NO TIENE OBSERVACIONES

    $select = mysqli_query($con, "SELECT id_solicitante FROM solicitantes WHERE dni = $dni");

    if (mysqli_num_rows($select) > 0) {

        $registro       = mysqli_fetch_array($select);
        $id_solicitante = $registro['id_solicitante'];
        
    } else {

        $inserta = "INSERT INTO solicitantes (dni, apellido, nombres, genero, otrogenero, direccion, fecha_nac, email, cuit, cod_area, telefono, celular, id_ciudad, observaciones, id_responsabilidad)
        VALUES ('$dni','$apellido','$nombres', $genero, '$otrogenero', '$direccion', '$fecha_nac', '$email', '$cuit', '$cod_area','$telefono','$celular',$id_ciudad,'1',1)";

        mysqli_query($con, $inserta) or die($inserta . 'Linea 71');

        $id_solicitante = mysqli_insert_id($con);
    }


    // REVISA DATOS EN EL REGISTRO DEL SOLICITANTE

    $select = mysqli_query(
        $con,

        "SELECT id_solicitante 
            FROM registro_solicitantes 
            WHERE id_solicitante = $id_solicitante AND id_programa = $id_programa"
    );

    if (mysqli_num_rows($select) == 0) {

        $inserta = "INSERT INTO registro_solicitantes (id_solicitante, id_rubro, id_medio, id_programa, observaciones, id_empresa, id_entidad) 
        VALUES ($id_solicitante, $id_rubro, $id_medio, $id_programa, '$observaciones', $id_empresa, $id_entidad)";

        mysqli_query($con, $inserta) or die($inserta . 'Linea 92');
    }

    $categoria          = $_POST['categoria'];

    // REVISA DATOS EN EL REGISTRO DE ASESORAR SEGUIMIENTO

    $select = mysqli_query(
        $con,

        "SELECT id_solicitante 
            FROM asesorar_seguimiento 
            WHERE id_solicitante = $id_solicitante AND categoria = $categoria"
    );

    if (mysqli_num_rows($select) == 0) {

        $inserta = "INSERT INTO asesorar_seguimiento (id_solicitante, categoria) VALUES ($id_solicitante, $categoria)";

        mysqli_query($con, $inserta) or die($inserta);
    }

    mysqli_close($con);

    header("location:indexAdmin.php");
