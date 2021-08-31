<?php

session_start();

if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/frontend/accesorios/front-superior.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');
$con=conectar();


?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <br>        
    </div>
</div>

<div class="card mb-2">
    <div class="card-header">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12 p-3">
                Bienvenido, ya estás registrado ! Pódes recorrer éstas opciones para vos 
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12 p-3">
        &nbsp;
    </div>
</div>

<div class="card mb-3">
    <div class="row no-gutters">
        <div class="col-md-4">
            <a href="/desarrolloemprendedor/frontend/jovenes/bienvenida.php">
                <img src="/desarrolloemprendedor/public/imagenes/prog_jovenes.png" class="card-img" alt="jovenes" />
            </a>    
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title" style="color:#1e5571;">Programa Jóvenes Emprendedores</h5>
                <p class="card-text">
                    El Programa Jóvenes Emprendedores asesora, capacita y financia a emprendimientos en marcha de
					jóvenes residentes en Entre Ríos, con ideas de emprendimientos innovadores, sustentables y con
					potencial para crecer.
					Es una de las herramientas integrales que constituyen el Régimen de Promoción para el
					Emprendedorismo Joven Entrerriano, creado por la ley provincial 10.394.
                </p>
                <p class="card-text">
                    <a href="/desarrolloemprendedor/frontend/jovenes/bienvenida.php">
                        Acceder
                    </a>
                </p>
            </div>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-md-4">
            <a href="/desarrolloemprendedor/frontend/proaccer/bienvenida.php">
                <img src="/desarrolloemprendedor/public/imagenes/prog_proaccer.jpg" class="card-img" alt="proaceer"/>
            </a>    
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title" style="color:#c67d26">Programa de Apoyo al Comercio emprendedor</h5>
                <p class="card-text">
                El Programa de Apoyo al Comercio Emprendedor de Entre Ríos acompaña, asesora y financia la
					participación de emprendimientos o empresas entrerrianas en eventos específicos para impulsar la
					ampliación de sus ventas. El programa apunta a una inserción en el mercado, que permita mejorar su
					sustentabilidad y posibilidades de consolidación.
                </p>
                <p class="card-text">
                    <a href="/desarrolloemprendedor/frontend/proaccer/bienvenida.php">
                        Acceder
                    </a>    
                </p>
            </div>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-md-4">
            <a class="nav-link" href="/desarrolloemprendedor/frontend/formacion/bienvenida.php">
                <img src="/desarrolloemprendedor/public/imagenes/prog_formacion.png" class="card-img" alt="formacion"/>
            </a>    
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title" style="color:#9968bc">Programa de Formación Emprendedora y Fortalecimiento MiPyme</h5>
                <p class="card-text">
                    El Programa de Formación Emprendedora y Fortalecimiento MiPyme impulsa <b>capacitaciones, talleres, 
                    seminarios, y jornadas</b> enfocadas en el desarrollo de actitudes y aptitudes para la consolidación 
                    del empredorismo y crecimiento de Mipymes en Entre Ríos.
                </p>
                <p class="card-text">
                    <a href="/desarrolloemprendedor/frontend/formacion/bienvenida.php">
                        Acceder
                    </a>
                </p>    
            </div>
        </div>
    </div>
</div>

<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/frontend/accesorios/front-scripts.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/frontend/accesorios/front-inferior.php'); ?>
