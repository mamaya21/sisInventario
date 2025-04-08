<?php
include('is_logged.php');

require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

$id = $_POST["mod_id"];
$distrito = $_POST["distrito2"];
$desde = floatval($_POST["desde2"])+0;
$hasta = floatval($_POST["hasta2"])+0;
$precio = floatval($_POST["precio2"])+0;


$sql = "update t_tarifarios SET id_distrito=".$distrito.",desde='".$desde."',hasta='".$hasta."',precio='".$precio."' WHERE id='".$id."';";
$query_update = odbc_exec($con,$sql);

if ($query_update) {
  $messages[] = "Tarifario modificado con éxito." ;
} else {
  $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo. $sql";
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
