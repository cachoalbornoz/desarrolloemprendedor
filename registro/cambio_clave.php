<?php 

require('../accesorios/admin-superior.php'); 

require_once('../accesorios/admin-scripts.php'); 

?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class=" col-xs-12 col-sm-12 col-lg-12">
                CAMBIO CLAVE PERSONAL
            </div>
        </div>
    </div>

    <form id="cambioclave" name="cambioclave" method="post" action="verifica_password.php">

        <div class="card-body">

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <label for="password">Clave actual</label>
                        <input name="password" type="password" id="password" class="form-control" autofocus  required/>
                    </div>                    
                </div>  
            </div>

            <div class="form-group">
                <div class="row"> 
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <label for="password_nueva">Clave nueva</label> 
                        <input name="password_nueva" type="password" id="password_nueva" class="form-control" required/>
                    </div>    
                
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <label for="password_nueva1">Reingrese clave nueva</label>
                        <input name="password_nueva1" type="password" id="password_nueva1"class="form-control" required/>       
                    </div>
                </div>  
            </div>      

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        &nbsp;
                    </div>            
                </div>
            </div>     
    
        </div>

        <div class=" card-footer">
            <div class="form-group">
                <div class="row">   
                    <div class="col-xs-12 col-sm-4 col-lg-4">
                        <small><span class="text-danger">*</span> Todos los datos son necesarios </small>                      
                    </div>
                    <div class="col-xs-12 col-sm-4 col-lg-4">
                        <?php
                        if (isset($_SESSION['verifica']) and (!$_SESSION['verifica'])){

                            echo "<span style='color:red'>Clave actual incorrecta, no se modificó </span>";
                        ?>
                            <script type="text/javascript">

                                toastr.options = { "progressBar": true, "showDuration": "5000", "timeOut": "5000" };
                                toastr.error("&nbsp;", "Clave actual incorrecta ... ");
                            
                            </script>
                        <?php
                        }
                        if (isset($_SESSION['verifica']) and ($_SESSION['verifica'])){

                            echo "<span style='color:green'>Clave modificada correctamente !</span>"; 

                        ?>
                        <script type="text/javascript">

                                toastr.options = { "progressBar": true, "showDuration": "5000", "timeOut": "5000" };
                                toastr.success("&nbsp;", "Clave modificada correctamente ! ");
                            
                            </script> 
                        <?php    
                        }
                        unset($_SESSION['verifica']);
                        ?>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-lg-4 text-right">
                        <button type="submit" class="btn btn-secondary">Cambiar clave</button>
                    </div>
                </div>
            </div>  
        </div>

    </form>

</div>    
  	
<script type="text/javascript">
    
</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>
