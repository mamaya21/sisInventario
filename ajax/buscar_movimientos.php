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
		$id_movimiento = $_GET['id'];
		$consulta_sql = "SELECT * FROM movimientos WHERE id_movimiento = '$id_movimiento'";
		$query = mysqli_query($con, $consulta_sql);
		$count = mysqli_num_rows($query);

		if ($count > 0) {
			// Intentar eliminar
			$delete = mysqli_query($con, "DELETE FROM movimientos WHERE id_movimiento = '$id_movimiento'");
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
	
		$aColumns = array('b.nombre');
		$sTable = " movimientos as a 
		LEFT OUTER JOIN materiales AS b ON b.id_material = a.id_material ";
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
		$reload = './movimientos.php';


		$TableJoins = " movimientos AS a 
		LEFT OUTER JOIN materiales AS b ON b.id_material = a.id_material
		LEFT OUTER JOIN tipos_material AS c ON c.id_tipo = b.id_tipo
		LEFT OUTER JOIN unidades_medida AS d ON d.id_unidad = b.id_unidad ";
	
		$sql = "SELECT a.id_movimiento, a.fecha_crea, a.tipo AS movimiento, a.id_material, b.nombre AS material, a.cantidad, c.nombre AS tipo, d.nombre AS unidad, a.nota FROM $TableJoins $sWhere ORDER BY a.fecha_crea DESC LIMIT $offset, $per_page";
  		$sql_repor = "SELECT a.id_movimiento, a.fecha_crea, a.tipo AS movimiento, a.id_material, b.nombre AS material, a.cantidad, c.nombre AS tipo, d.nombre AS unidad, a.nota FROM $TableJoins $sWhere ORDER BY a.fecha_crea DESC";
	
		$query = mysqli_query($con, $sql);
	
		if ($numrows > 0) {
			?>
			<div class="table-responsive">
				<div style="margin-bottom: 10px;">
					<a href="ajax/reportemovimientos.php?sql=<?php echo urlencode($sql_repor); ?>">
						Descargar Reporte <img src="img/excel.png" />
					</a>
					<a href="ajax/reportemovimientos_PDF.php?sql=<?php echo urlencode($sql_repor); ?>">
						Imprimir Reporte <img src="img/pdf.png" />
					</a>
				</div>
				
				<table class="table">
					<thead>
						<tr class="info">
							<th>Fecha</th>
							<th>Movimiento</th>
							<th>Cód. Material</th>
							<th>Material</th>
							<th>Cantidad</th>
							<th>Tipo</th>
							<th>Unidad</th>
							<th class='text-right'>Acciones</th>
						</tr>
					</thead>
					<tbody>
					<?php
					while ($row = mysqli_fetch_array($query)) {
						$id_movimiento = $row['id_movimiento'];
						$fecha_crea = $row['fecha_crea'];
						$movimiento = $row['movimiento'];
						$id_material = $row['id_material'];
						$material = $row['material'];
						$cantidad = $row['cantidad'];
						$tipo = $row['tipo'];
						$unidad = $row['unidad'];
						$nota = $row['nota'];
						?>

					<input type="hidden" value="<?php echo $id_movimiento;?>" id="id_movimiento<?php echo $id_movimiento;?>">
					<input type="hidden" value="<?php echo $fecha_crea;?>" id="fecha_crea<?php echo $id_movimiento;?>">
					<input type="hidden" value="<?php echo $movimiento;?>" id="movimiento<?php echo $id_movimiento;?>">
					<input type="hidden" value="<?php echo $id_material;?>" id="id_material<?php echo $id_movimiento;?>">
					<input type="hidden" value="<?php echo $material;?>" id="material<?php echo $id_movimiento;?>">
					<input type="hidden" value="<?php echo $cantidad;?>" id="cantidad<?php echo $id_movimiento;?>">
					<input type="hidden" value="<?php echo $tipo;?>" id="tipo<?php echo $id_movimiento;?>">
					<input type="hidden" value="<?php echo $unidad;?>" id="unidad<?php echo $id_movimiento;?>">
					<input type="hidden" value="<?php echo $nota;?>" id="nota<?php echo $id_movimiento;?>">

						<tr>
							<td><?php echo $fecha_crea; ?></td>
							<td><?php echo $movimiento; ?></td>
							<td><?php echo $id_material; ?></td>
							<td><?php echo $material; ?></td>
							<td><?php echo $cantidad; ?></td>
							<td><?php echo $tipo; ?></td>
							<td><?php echo $unidad; ?></td>
							<td class='text-right'>
								<a href="#" class='btn btn-default' title='Editar Tipo' onclick="obtener_datos('<?php echo $id_movimiento; ?>');" data-toggle="modal" data-target="#myModal2">
									<i class="glyphicon glyphicon-edit"></i>
								</a>
								<a href="#" class='btn btn-default' title='Borrar Tipo' onclick="eliminar_dato('<?php echo $id_movimiento; ?>')">
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