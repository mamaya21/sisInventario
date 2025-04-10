<?php
	 error_reporting(E_ALL ^ E_DEPRECATED);
	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

	if (isset($_GET['id'])) {
		$id_tipo = intval($_GET['id']);

		// Verificar si el tipo está relacionado con otras tablas (ejemplo simulado, puedes modificarlo)
		$query = mysqli_query($con, "SELECT * FROM tipos_material WHERE id_tipo = '$id_tipo'");
		$count = mysqli_num_rows($query);

		if ($count > 0) {
			// Intentar eliminar
			$delete = mysqli_query($con, "DELETE FROM tipos_material WHERE id_tipo = '$id_tipo'");
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
			<strong>Error!</strong> No se pudo eliminar este tipo de material. No se encontró registro.
			</div>
			<?php
		}
	}

	if ($action == 'ajax') {
		$r_q = $_REQUEST['q'];
		$q = mysqli_real_escape_string($con, $r_q);
	
		$aColumns = array('nombre');
		$sTable = "tipos_material";
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
		$reload = './tipoMateriales.php';
	
		$sql = "SELECT * FROM $sTable $sWhere ORDER BY id_tipo desc LIMIT $offset, $per_page";
		$sql_repor = "SELECT * FROM $sTable $sWhere ORDER BY id_tipo DESC";
	
		$query = mysqli_query($con, $sql);
	
		if ($numrows > 0) {
			?>
			<div class="table-responsive">
				<div style="margin-bottom: 10px;">
					<a href="ajax/reporteremite.php?sql=<?php echo urlencode($sql_repor); ?>">
						Descargar Reporte <img src="img/excel.png" />
					</a>
					<a href="#" onclick='imprimir_reporte("<?php echo $q; ?>");'>
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
							<th class='text-right'>Acciones</th>
						</tr>
					</thead>
					<tbody>
					<?php
					while ($row = mysqli_fetch_array($query)) {
						$id_tipo = $row['id_tipo'];
						$nombre_tipo = $row['nombre'];
						$descripcion_tipo = $row['descripcion'];
						$status_tipo = $row['estado'];
						$estado = ($status_tipo == 1) ? "Activo" : "Inactivo";
						?>

					<input type="hidden" value="<?php echo $id_tipo;?>" id="id_tipo<?php echo $id_tipo;?>">
					<input type="hidden" value="<?php echo $nombre_tipo;?>" id="nombre_tipo<?php echo $id_tipo;?>">
					<input type="hidden" value="<?php echo $descripcion_tipo;?>" id="descripcion_tipo<?php echo $id_tipo;?>">
					<input type="hidden" value="<?php echo $status_tipo;?>" id="status_tipo<?php echo $id_tipo;?>">

						<tr>
							<td><?php echo $id_tipo; ?></td>
							<td><?php echo $nombre_tipo; ?></td>
							<td><?php echo $descripcion_tipo; ?></td>
							<td><?php echo $estado; ?></td>
							<td class='text-right'>
								<a href="#" class='btn btn-default' title='Editar Tipo' onclick="obtener_datos('<?php echo $id_tipo; ?>');" data-toggle="modal" data-target="#myModal2">
									<i class="glyphicon glyphicon-edit"></i>
								</a>
								<a href="#" class='btn btn-default' title='Borrar Tipo' onclick="eliminar_tipo('<?php echo $id_tipo; ?>')">
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