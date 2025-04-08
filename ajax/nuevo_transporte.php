<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['marca'])) {
           $errors[] = "Marca vacía";
        }else if (empty($_POST['placa'])) {
           $errors[] = "Placa vacía";
        }else if (empty($_POST['lic_conducir'])) {
           $errors[] = "Licencia de conducir vacío";
        }else if (empty($_POST['conductor'])) {
           $errors[] = "Conductor vacío";
        }else if ($_POST['estado']==""){
			$errors[] = "Selecciona el estado del vehículo";
		}  else if (
			!empty($_POST['marca']) &&
			!empty($_POST['placa']) &&
			!empty($_POST['lic_conducir']) &&
			!empty($_POST['conductor']) &&
			$_POST['estado']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$marca=$_POST["marca"];
		$marca=str_replace( "'", "''", $marca);
		$placa=$_POST["placa"];
		$placa=str_replace( "'", "''", $placa);
		$n_inscripcion=$_POST["n_inscripcion"];
		$n_inscripcion=str_replace( "'", "''", $n_inscripcion);
		$conf_vehicular=$_POST["conf_vehicular"];
		$conf_vehicular=str_replace( "'", "''", $conf_vehicular);
		$lic_conducir=$_POST["lic_conducir"];
		$lic_conducir=str_replace( "'", "''", $lic_conducir);
		$conductor=$_POST["conductor"];
		$conductor=str_replace( "'", "''", $conductor);
		$estado=intval($_POST['estado']);
		$date_added=date("Y-m-d H:i:s");
		$sql="INSERT INTO t_transportes VALUES ('$marca','$placa','$n_inscripcion','$conf_vehicular','$lic_conducir','$conductor',$estado,GETDATE())";
		$query_new_insert = odbc_exec($con,$sql);
			if ($query_new_insert){
				$messages[] = "Vehículo ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.";
			}
		} else {
			$errors []= "Error desconocido.";
		}
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>