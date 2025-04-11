<?php

	/*-------------------------
	Autor: Marco Amaya
	Web: -
	Mail: marco1021tam@gmail.com
	---------------------------*/
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])) {
		$user_id = intval($_GET['id']);
	
		// Consulta para verificar si el usuario existe
		$query = mysqli_query($con, "SELECT * FROM Usuarios WHERE id_usuario = '$user_id'");
		$rw_user = mysqli_fetch_array($query);
	
		if ($rw_user) {
			// Si existe, eliminamos el registro
			$delete = "DELETE FROM Usuarios WHERE id_usuario = '$user_id'";
			$delete_result = mysqli_query($con, $delete);
	
			if ($delete_result) {
				?>
				<div class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Aviso!</strong> Datos eliminados exitosamente.
				</div>
				<?php
			} else {
				?>
				<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Error!</strong> Lo siento, algo ha salido mal. Intenta nuevamente.
				</div>
				<?php
			}
		}
	}
	
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = $_REQUEST['q'];
         $q= str_replace("'", "''", $q);
		 $aColumns = array('usuario');//Columnas de busqueda
		 $sTable = "Usuarios";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		include 'pagination.php'; //include pagination file

		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
		$per_page = 10; // cuántos registros mostrar por página
		$adjacents = 4; // separación entre páginas adyacentes
		$offset = ($page - 1) * $per_page;

		// Contar el total de registros
		$count_query = mysqli_query($con, "SELECT COUNT(*) AS numrows FROM $sTable $sWhere");
		$row = mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows / $per_page);

		$reload = './usuarios.php';

		// Consulta principal con paginación
		$sql = "SELECT * FROM $sTable $sWhere ORDER BY id_usuario LIMIT $offset, $per_page";
		$query = mysqli_query($con, $sql);

		//loop through fetched data
		if ($numrows>0){

			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>ID</th>
					<th>Usuario</th>
					<th>Facilidad</th>
					<th>Email</th>
					<th>Ingresado</th>
					<th><span class="pull-right">Acciones</span></th>

				</tr>
				<?php
				while ($row = mysqli_fetch_array($query)) {
						$user_id=$row['id_usuario'];
						//$fullname=$row['firstname']." ".$row["lastname"];
						$user_name=$row['usuario'];
						$user_email=$row['email'];
						$user_planta=$row['facilidad'];
						$date_added= date('d/m/Y', strtotime($row['fecha_crea']));

					?>

					<!--<input type="hidden" value="<?php echo $row['firstname'];?>" id="nombres<?php echo $user_id;?>">
					<input type="hidden" value="<?php echo $row['lastname'];?>" id="apellidos<?php echo $user_id;?>">-->
					<input type="hidden" value="<?php echo $user_name;?>" id="usuario<?php echo $user_id;?>">
					<input type="hidden" value="<?php echo $user_email;?>" id="email<?php echo $user_id;?>">
					<input type="hidden" value="<?php echo $user_planta;?>" id="facilidad<?php echo $user_id;?>">

					<tr>
						<td><?php echo $user_id; ?></td>
						<td><?php echo $user_name; ?></td>
						<td><?php echo $user_planta; ?></td>
						<td><?php echo $user_email; ?></td>
						<td><?php echo $date_added;?></td>

					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar usuario' onclick="obtener_datos('<?php echo $user_id;?>','<?php echo $user_planta;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>
					<a href="#" class='btn btn-default' title='Cambiar contraseña' onclick="get_user_id('<?php echo $user_id;?>');" data-toggle="modal" data-target="#myModal3"><i class="glyphicon glyphicon-cog"></i></a>
					<a href="#" class='btn btn-default' title='Borrar usuario' onclick="eliminar('<?php echo $user_id;?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>

					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=9><span class="pull-right"><?
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>
