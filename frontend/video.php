	<?php 
	include $_SERVER['DOCUMENT_ROOT'] .'/desarrolloemprendedor/accesorios/header.php' ; 

	require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');
	$con=conectar();
	?>

		

		<?php include $_SERVER['DOCUMENT_ROOT'] .'/desarrolloemprendedor/accesorios/programas_desarrollo.php' ?>
		
	
		<div class="row mb-5">
			<div class="col-xs-12 col-sm-12 col-lg-12">
                <p>
                    Videos
                </p>

			</div>
		</div>
        
        <div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12">
				<br>
			</div>
		</div>
        
        
        <div class="row mt-5 mb-5">
			<div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12">
				&nbsp;
			</div>
		</div>

		<?php

        $contador = 1;
        $tabla_video = mysqli_query($con, "SELECT * FROM videos ORDER BY ciudad asc");
        
        
		if(mysqli_num_rows($tabla_video) > 0){

			while($fila = mysqli_fetch_array($tabla_video)){
            
			?>	
			<div class="row mt-5 mb-2">
				<div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12">
					<h4><?php echo $fila['nombres'] ;?>, <?php echo $fila['apellido'] ;?></h4>
				</div>		
                <div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12">
                    <p><?php echo $fila['ciudad'] ;?></p>
                </div>
            </div>
            
            <div class="row mb-2">
				<div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/v/<?php echo $fila['video'] ;?>?loop=1&autoplay=1&playlist=<?php echo $fila['video'] ;?>" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>								    
                </div>
            </div>
            <div class="row mb-5">
				<div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12 text-justify">
                    <?php echo $fila['resena'] ;?>
                </div>
            </div>
			
            <?
            
            }
            
		}else{
			echo '';
        }        

        
        
		?>	

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12">
				<br/>
			</div>
		</div>
        
        

	
<?php include $_SERVER['DOCUMENT_ROOT'] .'/desarrolloemprendedor/accesorios/script.php' ; ?>

<script>

    $(document).ready(function() {

    });

</script>
	
<?php include $_SERVER['DOCUMENT_ROOT'] .'/desarrolloemprendedor/accesorios/footer.php';?>