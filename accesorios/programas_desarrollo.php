        <div class="row pb-3">
            <div class="col-xs-4 col-md-5 col-lg-5 text-center">
                <img src="/desarrolloemprendedor/public/imagenes/cabecera.png" class=" img-fluid" />
            </div>
            <div class="col-xs-8 col-md-7 col-lg-7 text-center">
            </div>
        </div>

        <nav id="navbar_top" class="navbar navbar-expand-lg navbar-light bg-light favenir pb-3 navbar-top">
            <a id="navbar_top-brand" class="navbar-brand d-none" href="#">
                <img src="/desarrolloemprendedor/public/imagenes/logo_er.png" alt="logo" style=" width:40px">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav nav-fill w-100">
                    <li class="nav-item active">
                        <a href="/desarrolloemprendedor/index.php" class="nav-link text-black-50">
                            INICIO
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="/desarrolloemprendedor/frontend/registro.php" class="nav-link text-black-50">
                            PRE-Inscripción
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="/desarrolloemprendedor/ingresar" class="nav-link text-black-75">
                            INGRESAR
                        </a>
                    </li>

                    <li class="nav-item dropdown text-black-50">
                        <a class="nav-link dropdown-toggle text-black-50" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            PROGRAMAS
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/desarrolloemprendedor/frontend/programa_jovenes.php">
                                JOVENES EMPRENDEDORES
                            </a>
                            <a class="dropdown-item" href="/desarrolloemprendedor/frontend/programa_proaccer.php">
                                PROACEER
                            </a>
                            <a class="dropdown-item" href="/desarrolloemprendedor/frontend/programa_formacion.php">
                                TALLERES DE FORMACION
                            </a>
                            <a class="dropdown-item" href="/desarrolloemprendedor/frontend/programa_tutorias.php">
                                TUTORIAS
                            </a>
                            <a class="dropdown-item" href="/desarrolloemprendedor/frontend/programa_proceder.php">
                                PROCEDER
                            </a>

                        </div>
                    </li>

                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle text-black-50" href="#" id="navbarDropdownMenuLink1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            ECOSISTEMA
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink1">
                            <a class="dropdown-item" href="/desarrolloemprendedor/frontend/club_emprendedores.php">
                                CLUB DE EMPRENDEDORES
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/desarrolloemprendedor/frontend/integrantes_ecosistema.php">
                                INTEGRANTES ECOSISTEMA
                            </a>

                        </div>
                    </li>

                    <li class="nav-item active">
                        <a href="/desarrolloemprendedor/accesorios/somos.php" class="nav-link text-black-50">
                            SOMOS
                        </a>
                    </li>

                    <li class="nav-item active">
                        <a data-toggle="modal" href="#contactoModal" class="nav-link text-black-50">
                            CONTACTO
                        </a>
                    </li>

                </ul>
            </div>
        </nav>

        <!-- Pantalla Contacto -->
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/contacto.php'; ?>