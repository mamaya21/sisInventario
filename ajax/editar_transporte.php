<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_idtransporte'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_marca'])) {
           $errors[] = "Marca vacía";
        }else if (empty($_POST['mod_placa'])) {
           $errors[] = "Placa vacía";
        }else if (empty($_POST['mod_licconducir'])) {
           $errors[] = "Licencia de conducir vacío";
        }else if (empty($_POST['mod_conductor'])) {
           $errors[] = "Conductor vacío";
        }else if ($_POST['mod_estado']==""){
			$errors[] = "Selecciona el estado del vehículo";
		}  else if (
			!empty($_POST['mod_idtransporte']) &&
			!empty($_POST['mod_marca']) &&
			!empty($_POST['mod_placa']) &&
			!empty($_POST['mod_licconducir']) &&
			!empty($_POST['mod_conductor']) &&
			$_POST['mod_estado']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$marca=$_POST["mod_marca"];
		$marca=str_replace( "'", "''", $marca);
		$placa=$_POST["mod_placa"];
		$placa=str_replace( "'", "''", $placa);
		$n_inscripcion=$_POST["mod_ninscripcion"];
		$n_inscripcion=str_replace( "'", "''", $n_inscripcion);
		$conf_vehicular=$_POST["mod_confvehicular"];
		$conf_vehicular=str_replace( "'", "''", $conf_vehicular);
		$lic_conducir=$_POST["mod_licconducir"];
		$lic_conducir=str_replace( "'", "''", $lic_conducir);
		$conductor=$_POST["mod_conductor"];
		$conductor=str_replace( "'", "''", $conductor);
		$estado=intval($_POST['mod_estado']);
		
		$id_transporte=intval($_POST['mod_idtransporte']);
		$sql="UPDATE t_transportes SET marca='".$marca."', placa='".$placa."', n_inscripcion='".$n_inscripcion."', conf_vehicular='".$conf_vehicular."', lic_conducir='".$lic_conducir."', conductor='".$conductor."', estado=".$estado." WHERE id_transporte='".$id_transporte."'";
		$query_update = odbc_exec($con,$sql);
			if ($query_update){
				$messages[] = "Transporte ha sido actualizado satisfactoriamente.";
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