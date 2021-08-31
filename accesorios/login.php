    <!-- Modal form to add -->
        <div id="logModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action='/desarrolloemprendedor/registro/verifica_usuario.php' role="form" method="post" id="loggin">

                        <div class="modal-header">
                            <img src="/desarrolloemprendedor/public/imagenes/logo_er.png" alt="" style=" width:40px">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>

                        <div class="modal-body">  

                            <div class="row mt-2 mb-5">
                                <div class="col-xs-12 col-sm-12 col-lg-12 text-center">
                                    <p class="text-monospace"><i class="fas fa-lock"></i> ACCESO A USUARIOS</p>
                                </div>
                            </div>   

                            <div class="row m-4">
                                <div class="col-xs-12 col-sm-12 col-lg-12">
                                    <p class="text-monospace">Usuario</p>
                                    <input type="text" class="form-control" placeholder="Usuario" id="usuario" name="usuario" autofocus required>
                                </div>  
                            </div>                   

                            <div class="row m-4">
                                <div class="col-xs-12 col-sm-12 col-lg-12">
                                    <p class="text-monospace">Clave</p>
                                    <input type="password" class="form-control" placeholder="Contraseña" id="password" name="password" required>
                                </div>
                            </div> 
                            
                            <div class="row m-4">
                                <div class="col-xs-12 col-sm-12 col-lg-12">
                                    <div class="mensaje text-danger">
                                        
                                    </div>
                                </div>
                            </div> 

                            <div class="row m-4">
                                <div class="col-xs-12 col-sm-12 col-lg-12">
                                    <hr>
                                </div>
                            </div> 

                            <div class="row m-4">
                                <div class="col-xs-12 col-sm-12 col-lg-12">                 
                                    <input type="submit" class="btn btn-secondary btn-block" id="ingresar" value="INGRESAR" />
                                </div>
                            </div>

                            <div class="row m-4">
                                <div class="col-xs-12 col-sm-12 col-lg-12">                 	
                                    <input type="hidden" name="_token" value="<?php echo md5(time()); ?>">
                                </div>
                            </div>

                        </div>


                    </form>

                </div>
            </div>
        </div>
    <!-- Fin Modal form -->