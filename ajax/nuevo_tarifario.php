<?php
include('is_logged.php');

require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

$distrito = $_POST["distrito"];
$desde = floatval($_POST["desde"])+0;
$hasta = floatval($_POST["hasta"])+0;
$precio = floatval($_POST["precio"])+0;

              /*
                $sql = "select * FROM Usuarios WHERE usuario = '" . $user_name . "' ;";
                $query_check_user_name = odbc_exec($con,$sql);
				        $query_check_user=odbc_num_rows($query_check_user_name);
                if ($query_check_user == 1) {
                    $errors[] = "Lo sentimos , el nombre de usuario ya está en uso.";
                } else {
                    $sql = "insert into Usuarios (usuario,pass,usuario_crea,fecha_crea,facilidad,email)
                            VALUES('" . $user_name . "', '" . $user_password_hash . "','".$_SESSION['user_id']."','".$date_added."','".$user_facilidad."','" . $user_email . "');";
                    $query_new_user_insert = odbc_exec($con,$sql);

                    if ($query_new_user_insert) {
                        $messages[] = "La cuenta ha sido creada con éxito.";
                    } else {
                        $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
                    }
                }*/
$sql = " insert into t_tarifarios (id_distrito, desde, hasta, precio)
          VALUES(".$distrito.", '".$desde."','".$hasta."','".$precio."'); ";

$query_new_user_insert = odbc_exec($con,$sql);

if ($query_new_user_insert) {
  $messages[] = "Tarifario registrado con éxito.";
} else {
  $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
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
