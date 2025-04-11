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

		$accion ="";
		//Antes se valida que ya tenga registro en stock, porque si no tiene registro y es de tipo SALIDA, es inconsistencia
		if($tipo_movimiento == "salida"){
			$accion = "update";
			$sql_validacionStock = "SELECT * FROM stock WHERE id_material = '$material_id'";
			$query_validacionStock  = mysqli_query($con, $sql_validacionStock);
			$count_validacionStock  = mysqli_num_rows($query_validacionStock);

			if ($count_validacionStock < 1) {
				$accion = "";

				?>
				<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Error!</strong> EL material no ha tenido ingreso a stock y no se puede ingresar la salida y dejar un stock EN NEGATIVO.
				</div>
				<?php
			}

		}else{
			//Ingreso
			$accion = "insert";
		}

		//SENTENCIA MySQL
		if ($accion != ""){
			$sql="INSERT INTO movimientos (tipo, id_material, cantidad, nota, fecha_crea, usuario_crea) 
			VALUES ('$tipo_movimiento', '$material_id', '$cantidad','$nota', NOW(), $usuario)";

			$query_new_insert = mysqli_query($con, $sql);

			if ($query_new_insert) {
				$messages[] = "Movimiento ingresado satisfactoriamente.";

				//Recuperando el id_movimiento
				$sql_movimiento = "SELECT * FROM movimientos WHERE id_material = '$material_id' and tipo = '$tipo_movimiento' ORDER BY id_movimiento DESC LIMIT 1";
				$query_movimiento = mysqli_query($con, $sql_movimiento);
				$count_movimiento = mysqli_num_rows($query_movimiento);
				$id_ultimo_movimiento = null;

				if ($count_movimiento > 0) {
					$row = mysqli_fetch_assoc($query_movimiento);
					$id_ultimo_movimiento = $row['id_movimiento'];
				}

				$sql_stock = "";
				$sql_stock_historico = "";
				//Ingresa el manejo de stock
				if ($accion == "insert"){
					$sql_stock = " INSERT INTO stock (id_material, cantidad_actual, id_movimiento, fecha, usuario)
					VALUES ('$material_id', '$cantidad', $id_ultimo_movimiento, NOW(), $usuario)
					ON DUPLICATE KEY UPDATE
						cantidad_actual = cantidad_actual + $cantidad,
						id_movimiento = $id_ultimo_movimiento,
						fecha = NOW(),
						usuario = $usuario;
					 ";

					$query_stock = mysqli_query($con, $sql_stock);

					//ingreso de stock historico
					$sql_stock_historico = " INSERT INTO stock_historico (id_material, cantidad_actual, id_movimiento, fecha, usuario)
					VALUES ('$material_id', 
					(SELECT cantidad_actual FROM stock WHERE id_material = '$material_id' ORDER BY fecha DESC LIMIT 1)
					, $id_ultimo_movimiento, NOW(), $usuario) ";
					$query_stock_historico = mysqli_query($con, $sql_stock_historico);


				}else if ($accion == "update"){

					$sql_stock = " UPDATE stock 
					SET cantidad_actual = cantidad_actual - $cantidad,
					id_movimiento = $id_ultimo_movimiento, 
					fecha = NOW(),
					usuario = $usuario; ";
		
					$query_stock = mysqli_query($con, $sql_stock);

					//ingreso de stock historico
					$sql_stock_historico = " INSERT INTO stock_historico (id_material, cantidad_actual, id_movimiento, fecha, usuario)
					VALUES ('$material_id', 
					(SELECT cantidad_actual FROM stock WHERE id_material = '$material_id' ORDER BY fecha DESC LIMIT 1)
					, $id_ultimo_movimiento, NOW(), $usuario) ";
					$query_stock_historico = mysqli_query($con, $sql_stock_historico);
				}
				

				//Ingresa Log de auditoria


			} else {
				$errors[] = "Lo siento, algo ha salido mal. Intenta nuevamente. Error: " . mysqli_error($con);
			}
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