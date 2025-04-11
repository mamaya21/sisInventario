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
		$id_unidad = intval($_GET['id']);

		$query = mysqli_query($con, "SELECT * FROM unidades_medida WHERE id_unidad = '$id_unidad'");
		$count = mysqli_num_rows($query);

		if ($count > 0) {
			// Intentar eliminar
			$delete = mysqli_query($con, "DELETE FROM unidades_medida WHERE id_unidad = '$id_unidad'");
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
			<strong>Error!</strong> No se pudo eliminar, debido a que no se encontró registro.
			</div>
			<?php
		}
	}

	if ($action == 'ajax') {
		$r_q = $_REQUEST['q'];
		$q = mysqli_real_escape_string($con, $r_q);
	
		$aColumns = array('nombre');
		$sTable = "unidades_medida";
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
		$reload = './unidadesMedida.php';
	
		$sql = "SELECT * FROM $sTable $sWhere ORDER BY id_unidad desc LIMIT $offset, $per_page";
		$sql_repor = "SELECT * FROM $sTable $sWhere ORDER BY id_unidad DESC";
	
		$query = mysqli_query($con, $sql);
	
		if ($numrows > 0) {
			?>
			<div class="table-responsive">
				<div style="margin-bottom: 10px;">
					<a href="ajax/reporteunidades.php?sql=<?php echo urlencode($sql_repor); ?>">
						Descargar Reporte <img src="img/excel.png" />
					</a>
					<a href="ajax/reporteunidades_PDF.php?sql=<?php echo urlencode($sql_repor); ?>">
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
						$id_unidad = $row['id_unidad'];
						$nombre_unidad = $row['nombre'];
						$descripcion_unidad = $row['descripcion'];
						$status_unidad = $row['estado'];
						$estado = ($status_unidad == 1) ? "Activo" : "Inactivo";
						?>

					<input type="hidden" value="<?php echo $id_unidad;?>" id="id_unidad<?php echo $id_unidad;?>">
					<input type="hidden" value="<?php echo $nombre_unidad;?>" id="nombre_unidad<?php echo $id_unidad;?>">
					<input type="hidden" value="<?php echo $descripcion_unidad;?>" id="descripcion_unidad<?php echo $id_unidad;?>">
					<input type="hidden" value="<?php echo $status_unidad;?>" id="status_unidad<?php echo $id_unidad;?>">

						<tr>
							<td><?php echo $id_unidad; ?></td>
							<td><?php echo $nombre_unidad; ?></td>
							<td><?php echo $descripcion_unidad; ?></td>
							<td><?php echo $estado; ?></td>
							<td class='text-right'>
								<a href="#" class='btn btn-default' title='Editar Unidad' onclick="obtener_datos('<?php echo $id_unidad; ?>');" data-toggle="modal" data-target="#myModal2">
									<i class="glyphicon glyphicon-edit"></i>
								</a>
								<a href="#" class='btn btn-default' title='Borrar Unidad' onclick="eliminar_dato('<?php echo $id_unidad; ?>')">
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