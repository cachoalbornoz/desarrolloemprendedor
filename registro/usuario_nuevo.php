<?php 
    require('../accesorios/admin-superior.php');

    require_once('../accesorios/accesos_bd.php');
    $con=conectar();

?>  

    
<div class="card">
    <div class="card-header">      
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                Administración de usuarios del sistema
            </div>                
        </div>
    </div>
    <div class="card-body">   

        <div class="form-group">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12"></div>
            </div>    
        </div>          

        <div class="form-group">
            <div class="row">
                <div class="col-xs-12 col-sm-2 col-lg-2">
                    <label>Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-control" autofocus required >
                </div>
                <div class="col-xs-12 col-sm-2 col-lg-2">
                    <label>Nombres</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" required>
                </div>
                <div class="col-xs-12 col-sm-3 col-lg-3">
                    <label><b>Usuario</b></label>
                    <input type="text" name="usuario" id="usuario" class="form-control" required>
                </div>
                <div class="col-xs-12 col-sm-3 col-lg-3">
                    <label><b>Clave</b></label>
                    <input type="text" name="clave" id="clave" class="form-control" required>
                </div>
                <div class="col-xs-12 col-sm-2 col-lg-2">
                    <label>Tipo usuario</label>
                    <select name="tipo" id="tipo" class="form-control">
                        <option value="a" selected>a - Administrativo</option>
                        <option value="b">b - Gestión cobranza</option>
                        <option value="c">c - Administrador</option>
                        <option value="d">d - Asesor</option>
                        <option value="e">e - Entidad</option>
                        <option value="f">f - Formador</option>
                    </select>    
                </div>
            </div>
        </div>          
        
        <div class="form-group">

            <div class="row">            
                <div class="col-xs-12 col-sm-12 col-lg-12 text-right">
                    <input type="button" class="btn btn-info" value="Guardar" onclick="guardar()">
                </div>
            </div>

        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <hr>
                </div>
            </div>    
        </div>


        <div id="estado" class="bg-success"></div>  

        <br>

        <div class="form-group">

            <div class="row">            
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div id="detalle_usuario"></div>            
                </div>
            </div>

        </div>

    </div>
</div>     

  	
<?php 
    mysqli_close($con);
    require_once('../accesorios/admin-scripts.php'); ?>

<script type="text/javascript">
    
    $(document).ready(function(){
        
        $("#detalle_usuario").load('detalle_usuarios.php',function(){});
    });
    
    
    function guardar(){
        
        var usuario     = $("#usuario").val();
        var apellido    = $("#apellido").val();
        var nombres     = $("#nombres").val();
        var clave       = $("#clave").val();
        var tipo        = $("#tipo").val();
        
        if(usuario == 0 || apellido == 0 || nombres == 0 || clave == 0){
            
            toastr.options = {"progressBar": true, "showDuration": "300", "timeOut": "1000" };
            toastr.error("&nbsp;", "Todos los datos son necesarios ... ");

            $("#apellido").focus();
        }else{    

            $("#detalle_usuario").load('detalle_usuarios.php',{id:1,usuario:usuario,apellido:apellido,nombres:nombres,clave:clave,tipo:tipo});
            
            $("#estado").html('');
            $("#usuario").val('');
            $("#apellido").val('');
            $("#nombres").val('');
            $("#clave").val('');
            $("#tipo").val('');
            
            $("#apellido").focus();

            toastr.options = {"progressBar": true, "showDuration": "300", "timeOut": "1000" };
            toastr.success("&nbsp;", "Usuario agregado correctamente ");
        }  
    }
    
    function cambiar_permiso(id_usuario,tipo){

        var texto = "<div class='text-center'> CAMBIO ESTADO ==>  " + tipo.toUpperCase() + " ?</b></div>  ";

        ymz.jq_confirm({
            title:'', 
            text: texto, 
            no_btn:"Cancelar", 
            yes_btn:"Confirma", 
            no_fn:function(){
                return false;
            },
            yes_fn:function(){
                $("#detalle_usuario").load('detalle_usuarios.php',{id:3,id_usuario:id_usuario, tipo:tipo});
                toastr.options = {"progressBar": true, "showDuration": "300", "timeOut": "1000" };
                toastr.success("&nbsp;", "Usuario modificado ... ");                    
            }
        }); 
    }
    
    
    function borrar_usuario(id,nombres){

        var texto = "<div class=' text-center'> <b>Desea eliminar usuario ? </b></div>  ";

        ymz.jq_confirm({
            title:'', 
            text: texto, 
            no_btn:"Cancelar", 
            yes_btn:"Confirma", 
            no_fn:function(){
                return false;
            },
            yes_fn:function(){
                $("#detalle_usuario").load('detalle_usuarios.php',{id:2,id_usuario:id});
                toastr.options = {"progressBar": true, "showDuration": "300", "timeOut": "1000" };
                toastr.error("&nbsp;", "Usuario eliminado ... ");                    
            }
        });     
        
    }
    
    function ver_usuario(){
        
        usuario = $("#usuario").val();
        
        if(usuario != 0){
            
            var url='ver_usuario.php';

            $.ajax({   
                type: 'GET',
                url:url,
                data:{usuario:usuario},
                success: function(resp){   
                    if(resp == 1){    
                        $("#estado").html("<b>Nombre Usuario</b> registrado !");
                        setTimeout(function(){document.getElementById("usuario").focus();}, 0);
                        return false;
                    }
                }
            });

            document.getElementById("estado").innerHTML="";
            return true;

        }else{

            $("#estado").html("Nombre usuario <b> VACIO </b>!");
            setTimeout(function(){document.getElementById("usuario").focus();}, 0);
            return false;
        }
           
    }
    
</script>


<?php require_once('../accesorios/admin-inferior.php'); ?>  