<?php include $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/header.php'; ?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/programas_desarrollo.php'; ?>


<div class="container mt-5 mb-5">
    <div class="row ">
        <div class="col-xs-12 col-md-12 col-lg-4">
            <span style="font-size: 60px;">ENTRE RÍOS</span>
        </div>
        <div class="col-xs-12 col-md-12 col-lg-4">
            
        </div>
        <div class="col-xs-12 col-md-12 col-lg-4">
            
        </div>        
    </div>
    <div class="row ">
        <div class="col-xs-12 col-md-12 col-lg-12 text-center">
            <span style="font-size: 60px;">PRODUCTIVA Y</span>
        </div>      
    </div>
    <div class="row ">
        <div class="col-xs-12 col-md-12 col-lg-4">
            
        </div>
        <div class="col-xs-12 col-md-12 col-lg-4">
            
        </div>
        <div class="col-xs-12 col-md-12 col-lg-4">
            <span style="font-size: 60px;">EMPRENDEDORA </span>
        </div>               
    </div>
</div>

<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <img src="/desarrolloemprendedor/public/imagenes/portada-2024.png" class="img-fluid" />
        </div>
    </div>
</div>

<div class="container">

    <div class="row mt-5 mb-5">
        <div class="col-xs-12 col-md-12 col-lg-12 text-black-50">
            <p style=" font-size: 24px;">
            La Secretaría de Desarrollo Productivo y Emprendedor es un 
            organismo dependiente del Ministerio de Desarrollo Económico del 
            Gobierno de la provincia de Entre Ríos que trabaja en <strong>pos del 
            desarrollo económico y empresarial en todo el territorio 
            provincial.</strong>
            </p>
        </div>
    </div>    

    <div class="row mt-5 mb-5">
        <div class="col-xs-12 col-md-6 col-lg-3 gothan text-center">
            <a href="/desarrolloemprendedor/frontend/programa_jovenes.php">
                <img src="/desarrolloemprendedor/public/imagenes/semiesfera4-2024.png" class="img-fluid mb-2" />
                <span style="color:black; font-size: 24px;"> Programas de Financiamiento </span>
            </a>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3 gothan text-center">
            <a href="/desarrolloemprendedor/frontend/programa_proaccer.php">
                <img src="/desarrolloemprendedor/public/imagenes/semiesfera3-2024.png" class="img-fluid mb-2" />
                <span style="color:black; font-size: 24px;">Impulso a la comercialización </span>
            </a>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3 gothan text-center">
            <a href="/desarrolloemprendedor/frontend/programa_formacion.php">
                <img src="/desarrolloemprendedor/public/imagenes/semiesfera2-2024.png" class="img-fluid mb-2" />
                <span style="color:black; font-size: 24px;">Formación y asistencia </span>
            </a>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3 gothan text-center">
            <a href="/desarrolloemprendedor/frontend/programa_proceder.php">
                <img src="/desarrolloemprendedor/public/imagenes/semiesfera1-2024.png" class="img-fluid mb-2" />
                <span style="color:black; font-size: 24px;">Innovación</span>
            </a>
        </div>
    </div>

    <div class="row mt-5 mb-5">
        <div class="col-xs-12 col-md-12 col-lg-12">
            &nbsp;
        </div>
    </div>

    <div class="row mt-5 mb-5">
        <div class="col-xs-12 col-md-12 col-lg-12 gothan text-center text-black-50 font-weight-bold">
            <p style="color: #88B64C; font-size: 36px;">PROGRAMAS</p>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-xs-12 col-md-6 col-lg-6 text-center">
            <a href="frontend/programa_jovenes.php">
                <span style="color:black; font-size: 24px;">
                    JÓVENES EMPRENDEDORES
                </span>
                <p class="text-center mt-3">
                    <img src="/desarrolloemprendedor/public/imagenes/jovenesprog-2024.png" class="img-fluid shadow" />
                </p>
            </a>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-6 text-center">
            <a href="/desarrolloemprendedor/frontend/programa_proaccer.php">
                <span style="color:black; font-size: 24px;">
                    APOYO COMERCIO EMPRENDEDOR
                </span>            
                <p class="text-center mt-3">
                    <img src="/desarrolloemprendedor/public/imagenes/proaceerprog-2024.png" class="img-fluid shadow" />
                </p>
            </a>
        </div>
        
    </div>


    <div class="row mt-5 mb-5">
        <div class="col-xs-12">
            <br />
        </div>
    </div>

</div>


<?php include $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/script.php'; ?>

<script>
    $(document).ready(function() {
        $('#logModal').on('shown.bs.modal', function() {
            $('#usuario').trigger('focus');
        });
    });
</script>


<?php include $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/footer.php';
?>