<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_idtipo'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_nombre'])) {
           $errors[] = "Nombre vacío";
        }else if (empty($_POST['mod_descripcion'])) {
           $errors[] = "Descripción vacía";
        }else if ($_POST['mod_estado']==""){
			$errors[] = "Selecciona el estado del remitente";
		}  else if (
			!empty($_POST['mod_idtipo']) &&
			!empty($_POST['mod_nombre']) &&
			!empty($_POST['mod_descripcion']) &&
			$_POST['mod_estado']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nombre=$_POST["mod_nombre"];
		$nombre=str_replace( "'", "''", $nombre);
		$descripcion=$_POST["mod_descripcion"];
		$descripcion=str_replace( "'", "''", $descripcion);
		$estado=intval($_POST['mod_estado']);
		
		$id_tipo=intval($_POST['mod_idtipo']);

		$sql="UPDATE tipos_material SET nombre='".$nombre."', descripcion='".$descripcion."', fecha_modifica= DATE(NOW()), estado=".$estado." WHERE id_tipo='".$id_tipo."'";

		$query_update = mysqli_query($con, $sql);
		if ($query_update) {
			$messages[] = "El tipo de material se ha sido actualizado satisfactoriamente.";
		} else {
			$errors[] = "Lo siento, algo ha salido mal. Intenta nuevamente. Error: " . mysqli_error($con);
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