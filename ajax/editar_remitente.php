<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_idremitente'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_nombre'])) {
           $errors[] = "Nombre vacío";
        }else if (empty($_POST['mod_ruc'])) {
           $errors[] = "Ruc vacío";
        }else if (empty($_POST['mod_razsocial'])) {
           $errors[] = "Razón Social vacío";
        }else if (empty($_POST['mod_contacto'])) {
           $errors[] = "Contacto vacío";
        }else if (empty($_POST['mod_telefono'])) {
           $errors[] = "Teléfono vacío";
        }else if (empty($_POST['mod_email'])) {
           $errors[] = "Email vacío";
        }else if (empty($_POST['mod_direccion'])) {
           $errors[] = "Dirección vacío";
        }  else if ($_POST['mod_estado']==""){
			$errors[] = "Selecciona el estado del remitente";
		}  else if (
			!empty($_POST['mod_idremitente']) &&
			!empty($_POST['mod_nombre']) &&
			!empty($_POST['mod_ruc']) &&
			!empty($_POST['mod_razsocial']) &&
			!empty($_POST['mod_contacto']) &&
			!empty($_POST['mod_telefono']) &&
			!empty($_POST['mod_email']) &&
			!empty($_POST['mod_direccion']) &&
			$_POST['mod_estado']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nombre=$_POST["mod_nombre"];
		$nombre=str_replace( "'", "''", $nombre);
		$ruc=$_POST["mod_ruc"];
		$ruc=str_replace( "'", "''", $ruc);
		$razsocial=$_POST["mod_razsocial"];
		$razsocial=str_replace( "'", "''", $razsocial);
		$contacto=$_POST["mod_contacto"];
		$contacto=str_replace( "'", "''", $contacto);
		$telefono=$_POST["mod_telefono"];
		$telefono=str_replace( "'", "''", $telefono);
		$email=$_POST["mod_email"];
		$email=str_replace( "'", "''", $email);
		$direccion=$_POST["mod_direccion"];
		$direccion=str_replace( "'", "''", $direccion);
		$direccion_a=$_POST["mod_direccion_a"];
		$direccion_a=str_replace( "'", "''", $direccion_a);
		$estado=intval($_POST['mod_estado']);
		
		$id_remitente=intval($_POST['mod_idremitente']);
		$sql="UPDATE t_remitentes SET nombre_remitente='".$nombre."', ruc='".$ruc."', telefono='".$telefono."', raz_social='".$razsocial."', contacto='".$contacto."', correo='".$email."', direccion='".$direccion."', Dir_agrupada='".$direccion_a."', estado=".$estado." WHERE id_remitente='".$id_remitente."'";
		$query_update = odbc_exec($con,$sql);
			if ($query_update){
				$messages[] = "Remitente ha sido actualizado satisfactoriamente.";
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