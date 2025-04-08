<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nombre'])) {
           $errors[] = "Nombre vacío";
        }else if (empty($_POST['ruc'])) {
           $errors[] = "Ruc vacío";
        }else if (empty($_POST['direccion'])) {
           $errors[] = "Dirección vacía";
        }else if (empty($_POST['telefono'])) {
           $errors[] = "Teléfono vacío";
        }else if (empty($_POST['email'])) {
           $errors[] = "Email vacío";
        }else if (empty($_POST['contacto'])) {
           $errors[] = "Contacto vacío";
        }else if (empty($_POST['razonsocial'])) {
           $errors[] = "Razon Social vacío";
        }  else if ($_POST['estado']==""){
			$errors[] = "Selecciona el estado de la empresa";
		} else if (
			!empty($_POST['nombre']) &&
			!empty($_POST['ruc']) &&
			!empty($_POST['direccion']) &&
			!empty($_POST['telefono']) &&
			!empty($_POST['razonsocial']) &&
			!empty($_POST['contacto']) &&
			!empty($_POST['email']) &&
			$_POST['estado']!="" 
			){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nombre=$_POST["nombre"];
		$nombre=str_replace( "'", "''", $nombre);
		$ruc=$_POST["ruc"];
		$ruc=str_replace( "'", "''", $ruc);
		$razsocial=$_POST["razonsocial"];
		$razsocial=str_replace( "'", "''", $razsocial);
		$contacto=$_POST["contacto"];
		$contacto=str_replace( "'", "''", $contacto);
		$telefono=$_POST["telefono"];
		$telefono=str_replace( "'", "''", $telefono);
		$email=$_POST["email"];
		$email=str_replace( "'", "''", $email);
		$direccion=$_POST["direccion"];
		$direccion=str_replace( "'", "''", $direccion);
		$estado=intval($_POST['estado']);
		$date_added=date("Y-m-d H:i:s");
		$sql="INSERT INTO t_subcontratadas VALUES ('$nombre','$ruc','$direccion','$telefono','$razsocial','$contacto','$email',$estado,GETDATE())";
		$query_new_insert = odbc_exec($con,$sql);
			if ($query_new_insert){
				$messages[] = "Empresa Sub.contratada ha sido ingresado satisfactoriamente.";
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