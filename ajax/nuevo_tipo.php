<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nombre'])) {
        $errors[] = "Nombre vacío";
    } else if (
		!empty($_POST['nombre']) 
	){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code

		//Obtener los datos
		$nombre=$_POST["nombre"];
		$nombre=str_replace( "'", "''", $nombre);

		$descripcion=$_POST["descripcion"];
		$descripcion=str_replace( "'", "''", $descripcion);

		//SENTENCIA MySQL
		$sql="INSERT INTO tipos_material (nombre, descripcion, fecha_crea, estado) VALUES ('$nombre','$descripcion', DATE(NOW()), 1)";

		$query_new_insert = mysqli_query($con, $sql);
		if ($query_new_insert) {
			$messages[] = "Tipo de material ingresado satisfactoriamente.";
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