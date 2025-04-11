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

	if ($action == 'ajax') {
		$r_q = $_REQUEST['q'];
		$q = mysqli_real_escape_string($con, $r_q);
	
		$aColumns = array('b.nombre', 'a.id_material');
		$sTable = " stock_historico AS a 
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
		$reload = './stockdetallado.php';


		$TableJoins = " stock_historico AS a 
		LEFT OUTER JOIN materiales AS b ON b.id_material = a.id_material
		LEFT OUTER JOIN tipos_material AS c ON c.id_tipo = b.id_tipo
		LEFT OUTER JOIN unidades_medida AS d ON d.id_unidad = b.id_unidad
		LEFT OUTER JOIN movimientos AS e ON e.id_movimiento = a.id_movimiento ";
	
		$sql = "SELECT a.fecha, a.id_material, b.nombre, c.nombre AS tipo, d.nombre AS unidad, a.cantidad_actual, e.tipo AS ultimo_movimiento, e.cantidad AS ultima_cantidad_movimiento FROM $TableJoins $sWhere ORDER BY a.fecha DESC LIMIT $offset, $per_page";
  		$sql_repor = "SELECT a.fecha, a.id_material, b.nombre, c.nombre AS tipo, d.nombre AS unidad, a.cantidad_actual, e.tipo AS ultimo_movimiento, e.cantidad AS ultima_cantidad_movimiento FROM $TableJoins $sWhere ORDER BY a.fecha DESC";
	
		$query = mysqli_query($con, $sql);
	
		if ($numrows > 0) {
			?>
			<div class="table-responsive">
				<div style="margin-bottom: 10px;">
					<a href="ajax/reportestock.php?sql=<?php echo urlencode($sql_repor); ?>">
						Descargar Reporte <img src="img/excel.png" />
					</a>
					<a href="ajax/reportestock_PDF.php?sql=<?php echo urlencode($sql_repor); ?>">
						Imprimir Reporte <img src="img/pdf.png" />
					</a>
				</div>
				
				<table class="table">
					<thead>
						<tr class="info">
							<th>Fecha</th>
							<th>Cód. Material</th>
							<th>Material</th>
							<th>Tipo</th>
							<th>Unidad</th>
							<th>Cant. actual</th>
							<th>Ult. movimiento</th>
							<th>Ult. Cant. movimiento</th>
						</tr>
					</thead>
					<tbody>
					<?php
					while ($row = mysqli_fetch_array($query)) {
						$fecha = $row['fecha'];
						$id_material = $row['id_material'];
						$nombre = $row['nombre'];
						$tipo = $row['tipo'];
						$unidad = $row['unidad'];
						$cantidad_actual = $row['cantidad_actual'];
						$ultimo_movimiento = $row['ultimo_movimiento'];
						$ultima_cantidad_movimiento = $row['ultima_cantidad_movimiento'];
						?>

						<tr>
							<td><?php echo $fecha; ?></td>
							<td><?php echo $id_material; ?></td>
							<td><?php echo $nombre; ?></td>
							<td><?php echo $tipo; ?></td>
							<td><?php echo $unidad; ?></td>
							<td><?php echo $cantidad_actual; ?></td>
							<td><?php echo $ultimo_movimiento; ?></td>
							<td><?php echo $ultima_cantidad_movimiento; ?></td>
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