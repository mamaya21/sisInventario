<?php
	require_once("../classes/Login.php");
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['tipo_movimiento'])) {
        $errors[] = "No seleccionó el tipo de movimiento";
    } else if (empty($_POST['material_id'])) {
        $errors[] = "Material vacío";
    } else if (empty($_POST['cantidad'])) {
        $errors[] = "Cantidad no ingresada";
    } else if (
		!empty($_POST['tipo_movimiento']) &&
		!empty($_POST['material_id']) &&
		!empty($_POST['cantidad'])
	){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code

		//Obtener los datos
		$tipo_movimiento=$_POST["tipo_movimiento"];
		$tipo_movimiento=str_replace( "'", "''", $tipo_movimiento);

		$material_id=$_POST["material_id"];
		$cantidad=$_POST["cantidad"];

		$nota=$_POST["nota"];
		$nota=str_replace( "'", "''", $nota);

		$usuario = $_SESSION['user_id'];

		//SENTENCIA MySQL
		$sql="INSERT INTO movimientos (tipo, id_material, cantidad, nota, fecha_crea, usuario_crea) 
		 VALUES ('$tipo_movimiento', '$material_id', '$cantidad','$nota', NOW(), $usuario)";

		$query_new_insert = mysqli_query($con, $sql);
		if ($query_new_insert) {
			$messages[] = "Movimiento ingresado satisfactoriamente.";
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