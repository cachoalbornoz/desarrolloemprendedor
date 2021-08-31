<?php 
    require('../accesorios/admin-superior.php');

    require_once('../accesorios/conexion.php');
    $con=conectar();
?>    

<?php require_once('../accesorios/admin-scripts.php'); ?>


<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-xs-12">
				&nbsp;
            </div>
        </div>
    </div>    
    <div class="card-body">

		
	<div class="row">			
			<div class="col">
				<label> Query a correr </label>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div class="form-group">
					<input id="query" name="query" class="form-control" autofocus >
				</div>
			</div>
		</div>
		<div class="row">			
			<div class="col">
				&nbsp;
			</div>
		</div>	
		<div class="row">			
			<div class="col">
				<div class="form-group">
					<?php if($_SESSION['tipo_usuario'] == 'c'){?>
					<button class="btn btn-large btn-info" onclick="ejecutar()" id="ejecutar">
						Ejecutar <i class="fas fa-bolt"></i>
					</button>
					<?php }?>
				</div>
				<div class="form-group">
					<div id="estado" class="d-none">
						Recuperando información, aguarde  <i class="fa fa-spinner fa-spin fa-fw"></i> 
					</div>
				</div>
			</div>
		</div>	

		<div class="row">
			<div class="col" id="query_builder">
				
			</div>					
		</div>
		
        
    </div>
</div>   


<script type="text/javascript">
	
	function ejecutar(){

		$("#estado").removeClass('d-none');
		$("#ejecutar").disabled  = true;
        $("#ejecutar").innerHTML = 'Guardando ... aguarde ';
		
		var query = $("#query").val();

		$.ajax({

			url 	: 'aplicar.php',
			type 	: 'POST',
			data 	: {query: query},
			success: function(data){

				$("#query_builder").html(data);
				$("#estado").addClass('d-none');

				setTimeout(function () {
                    $("#ejecutar").disabled  = false;
                    $("#ejecutar").innerHTML = ' Ejecutar <i class="fas fa-bolt"></i>';

                }, 1000);

				console.log(query);
			}
		});
	}

</script>    

    
<?php require_once('../accesorios/admin-inferior.php'); ?> 