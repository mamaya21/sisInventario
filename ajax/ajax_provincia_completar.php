<?php
	 error_reporting(E_ALL ^ E_DEPRECATED);
	/*-------------------------
	Autor: Marco Amaya
	Web: -
	Mail: marco1021tam@gmail.com
	---------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

	if (isset($_POST['id'])){
		$id_depa = $_POST['id'];
		$id_provincia = $_POST['idprovincia'];
		$query=odbc_exec($con, "select * from provincias where departamentos_id='".$id_depa."'");
		?> <option value="0">---SELECCIONAR---</option> <?php
		while ($row=odbc_fetch_array($query)){
			$id=$row['id'];
			$nombre=$row['nombre'];

			if($id == $id_provincia){
				?>
					<option value="<?php echo $id;?>" selected><?php echo $nombre; ?></option>
				<?php
			}else{
				?>
					<option value="<?php echo $id;?>"><?php echo $nombre; ?></option>
				<?php
			}

		}

	}

?>
