<?php
	 error_reporting(E_ALL ^ E_DEPRECATED);
	/*-------------------------
	Autor: Marco Amaya
	Web: https://marcoamayaquiroz.com/
	Mail: marco1021tam@gmail.com
	---------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

	if (isset($_GET['id'])) {
		$id_material = $_GET['id'];
		$consulta_sql = "SELECT * FROM materiales WHERE id_material = '$id_material'";
		$query = mysqli_query($con, $consulta_sql);
		$count = mysqli_num_rows($query);

		if ($count > 0) {
			// Intentar eliminar
			$delete = mysqli_query($con, "DELETE FROM materiales WHERE id_material = '$id_material'");
			if ($delete) {
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
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Error!</strong> No se pudo eliminar el registro. No se encontró registro.
			</div>
			<?php
		}
	}

	if ($action == 'ajax') {
		$r_q = $_REQUEST['q'];
		$q = mysqli_real_escape_string($con, $r_q);
	
		$aColumns = array('a.nombre');
		$sTable = "materiales as a";
		$sWhere = "";
	
		if (!empty($q)) {
			$sWhere = "WHERE (";
			foreach ($aColumns as $col) {
				$sWhere .= "$col LIKE '%$q%' OR ";
			}
			$sWhere = substr_replace($sWhere, "", -3);
			$sWhere .= ")";
		}

		include 'pagination.php'; 
	
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
		$per_page = 10;
		$adjacents = 4;
		$offset = ($page - 1) * $per_page;
	
		$count_query = mysqli_query($con, "SELECT COUNT(*) AS numrows FROM $sTable $sWhere");
		$row = mysqli_fetch_assoc($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows / $per_page);
		$reload = './materiales.php';


		$TableJoins = " materiales AS a 
		LEFT OUTER JOIN tipos_material AS b ON b.id_tipo = a.id_tipo
		LEFT OUTER JOIN unidades_medida AS c ON c.id_unidad = a.id_unidad ";
	
		$sql = "SELECT a.id_material, a.nombre, a.descripcion, a.estado, b.id_tipo AS tipo_id, b.nombre AS tipo, c.id_unidad AS unidad_id, c.nombre AS unidad FROM $TableJoins $sWhere ORDER BY a.fecha_crea DESC LIMIT $offset, $per_page";
  		$sql_repor = "SELECT a.id_material, a.nombre, a.descripcion, a.estado, b.nombre AS tipo, c.nombre AS unidad FROM $TableJoins $sWhere ORDER BY a.fecha_crea DESC";
	
		$query = mysqli_query($con, $sql);
	
		if ($numrows > 0) {
			?>
			<div class="table-responsive">
				<div style="margin-bottom: 10px;">
					<a href="ajax/reportemateriales.php?sql=<?php echo urlencode($sql_repor); ?>">
						Descargar Reporte <img src="img/excel.png" />
					</a>
					<a href="ajax/reportemateriales_PDF.php?sql=<?php echo urlencode($sql_repor); ?>">
						Imprimir Reporte <img src="img/pdf.png" />
					</a>
				</div>
				
				<table class="table">
					<thead>
						<tr class="info">
							<th>Código</th>
							<th>Nombre</th>
							<th>Descripción</th>
							<th>Estado</th>
							<th>Tipo</th>
							<th>Unidad</th>
							<th class='text-right'>Acciones</th>
						</tr>
					</thead>
					<tbody>
					<?php
					while ($row = mysqli_fetch_array($query)) {
						$id_tipo = $row['id_material'];
						$nombre_tipo = $row['nombre'];
						$descripcion_tipo = $row['descripcion'];
						$status_tipo = $row['estado'];
						$estado = ($status_tipo == 1) ? "Activo" : "Inactivo";
						$tipo_id = $row['tipo_id'];
						$tipo = $row['tipo'];
						$unidad_id = $row['unidad_id'];
						$unidad = $row['unidad'];
						?>

					<input type="hidden" value="<?php echo $id_tipo;?>" id="id_tipo<?php echo $id_tipo;?>">
					<input type="hidden" value="<?php echo $nombre_tipo;?>" id="nombre_tipo<?php echo $id_tipo;?>">
					<input type="hidden" value="<?php echo $descripcion_tipo;?>" id="descripcion_tipo<?php echo $id_tipo;?>">
					<input type="hidden" value="<?php echo $status_tipo;?>" id="status_tipo<?php echo $id_tipo;?>">
					<input type="hidden" value="<?php echo $tipo_id;?>" id="tipo_id<?php echo $id_tipo;?>">
					<input type="hidden" value="<?php echo $tipo;?>" id="tipo<?php echo $id_tipo;?>">
					<input type="hidden" value="<?php echo $unidad_id;?>" id="unidad_id<?php echo $id_tipo;?>">
					<input type="hidden" value="<?php echo $unidad;?>" id="unidad<?php echo $id_tipo;?>">

						<tr>
							<td><?php echo $id_tipo; ?></td>
							<td><?php echo $nombre_tipo; ?></td>
							<td><?php echo $descripcion_tipo; ?></td>
							<td><?php echo $estado; ?></td>
							<td><?php echo $tipo; ?></td>
							<td><?php echo $unidad; ?></td>
							<td class='text-right'>
								<a href="#" class='btn btn-default' title='Editar Tipo' onclick="obtener_datos('<?php echo $id_tipo; ?>');" data-toggle="modal" data-target="#myModal2">
									<i class="glyphicon glyphicon-edit"></i>
								</a>
								<a href="#" class='btn btn-default' title='Borrar Tipo' onclick="eliminar_dato('<?php echo $id_tipo; ?>')">
									<i class="glyphicon glyphicon-trash"></i>
								</a>
							</td>
						</tr>
						<?php
					}
					?>
					<tr>
						<td colspan="7">
							<span class="pull-right">
								<?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
							</span>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
			<?php
		}
	}
?>