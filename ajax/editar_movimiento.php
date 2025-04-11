<?php
	require_once("../classes/Login.php");
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_idmovimiento'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_materialid'])) {
           $errors[] = "Material vacío";
        }else if (empty($_POST['mod_cantidad'])) {
           $errors[] = "Cantidad vacía";
        }else if (
			!empty($_POST['mod_idmovimiento']) &&
			!empty($_POST['mod_materialid']) &&
			!empty($_POST['mod_cantidad'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code

		$tipo=$_POST["mod_tipomovimiento"];
		$id_material= $_POST["mod_materialid"];
		$cantidad= $_POST["mod_cantidad"];
		$nota=$_POST["mod_nota"];
		$nota=str_replace( "'", "''", $nota);

		$usuario = $_SESSION['user_id'];
		$id_movimiento = $_POST["mod_idmovimiento"];

		$sql="UPDATE movimientos SET tipo='".$tipo."', id_material='".$id_material."', cantidad='".$cantidad."', nota='".$nota."', fecha_modifica= NOW(), usuario_modifica =".$usuario." WHERE id_movimiento='".$id_movimiento."'";

		$query_update = mysqli_query($con, $sql);
		if ($query_update) {
			$messages[] = "El registro se ha sido actualizado satisfactoriamente.";
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