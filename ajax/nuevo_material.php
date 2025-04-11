<?php

	function generarIdMaterialUnico($conexion) {
		do {
			// Genera un número aleatorio entre 1 y 999999
			$numero = rand(1, 999999);
			// Rellena con ceros a la izquierda hasta tener 6 dígitos
			$numeroFormateado = str_pad($numero, 6, '0', STR_PAD_LEFT);
			// Concatena con el prefijo 'MAT'
			$id_material = 'MAT' . $numeroFormateado;

			// Consulta para verificar si ya existe en la base de datos
			$query = "SELECT COUNT(*) as total FROM materiales WHERE id_material = '$id_material'";
			$resultado = mysqli_query($conexion, $query);
			$fila = mysqli_fetch_assoc($resultado);

		} while ($fila['total'] > 0); // Si existe, repetir

		return $id_material;
	}

	require_once("../classes/Login.php");
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nombre'])) {
        $errors[] = "Nombre vacío";
    } else if (empty($_POST['id_tipo'])) {
        $errors[] = "Tipo de material vacío";
    } else if (empty($_POST['id_unidad'])) {
        $errors[] = "Unidad de medida vacía";
    } else if (
		!empty($_POST['nombre']) &&
		!empty($_POST['id_tipo']) &&
		!empty($_POST['id_unidad'])
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

		$usuario = $_SESSION['user_id'];
		$id_tipo=$_POST["id_tipo"];
		$id_unidad=$_POST["id_unidad"];

		$id_generado = generarIdMaterialUnico($con);

		//SENTENCIA MySQL
		$sql="INSERT INTO materiales (id_material, nombre, descripcion, fecha_crea, usuario_crea, estado, id_tipo, id_unidad) 
		 VALUES ('$id_generado','$nombre','$descripcion', NOW(), $usuario,1, $id_tipo, $id_unidad)";

		$query_new_insert = mysqli_query($con, $sql);
		if ($query_new_insert) {
			$messages[] = "Material ingresado satisfactoriamente.";
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