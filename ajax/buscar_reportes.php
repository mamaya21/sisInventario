<?php

	/*-------------------------
	Autor: Marco Amaya
	Web: -
	Mail: marco1021tam@gmail.com
	---------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");

	$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

	if ($action == 'ajax') {
		$hoy = date("Y/m/d");
		$q = $_REQUEST['q'];
		//$id_remitente = $_REQUEST['remitente'];
		$desde = $_REQUEST['desde'];
		$hasta = $_REQUEST['hasta'];
		$importe = $_REQUEST['importe'];
		$reporte = $_REQUEST['reporte'];

		$sql_report_1 = "SELECT a.fecha, a.id_material, b.nombre, c.nombre AS tipo, d.nombre AS unidad, a.cantidad_actual
			FROM stock AS a 
			LEFT JOIN materiales AS b ON b.id_material = a.id_material
			LEFT JOIN tipos_material AS c ON c.id_tipo = b.id_tipo
			LEFT JOIN unidades_medida AS d ON d.id_unidad = b.id_unidad
			LEFT JOIN movimientos AS e ON e.id_movimiento = a.id_movimiento
			ORDER BY b.nombre ASC";

		$sql_report_1_count = "SELECT COUNT(*) AS numrows
			FROM stock AS a
			LEFT JOIN materiales AS b ON b.id_material = a.id_material
			LEFT JOIN tipos_material AS c ON c.id_tipo = b.id_tipo
			LEFT JOIN unidades_medida AS d ON d.id_unidad = b.id_unidad
			LEFT JOIN movimientos AS e ON e.id_movimiento = a.id_movimiento";

		include 'pagination.php';
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
		$per_page = 10;
		$adjacents = 4;
		$offset = ($page - 1) * $per_page;
		$reload = './reportes.php';

		$count_query = mysqli_query($con, $sql_report_1_count);
		$row = mysqli_fetch_assoc($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows / $per_page);

		$sql_report_1 .= " LIMIT $offset, $per_page";
		$query = mysqli_query($con, $sql_report_1);

		if ($numrows > 0) {
			// echo '<div class="table-responsive">';
			// echo '<div style="margin-bottom: 10px;"><a href="ajax/reporteexcel.php?sql=' . urlencode($sql_report_1) . '" style="padding-right: 15px;padding-left: 0px;">';
			// echo 'Descargar Reporte <img src="img/excel.png"/> </a></div>';

			echo '<table class="table table-bordered table-striped">';
			echo '<thead><tr>';
			while ($fieldinfo = mysqli_fetch_field($query)) {
				echo '<th>' . htmlspecialchars($fieldinfo->name) . '</th>';
			}
			echo '</tr></thead><tbody>';

			mysqli_data_seek($query, 0);
			while ($row = mysqli_fetch_assoc($query)) {
				echo '<tr>';
				foreach ($row as $value) {
					echo '<td>' . htmlspecialchars($value) . '</td>';
				}
				echo '</tr>';
			}

			echo '<tr><td colspan="100%"><span class="pull-right">' . paginate($reload, $page, $total_pages, $adjacents) . '</span></td></tr>';
			echo '</tbody></table>';
			echo '</div>';
		} else {
			echo '<div class="alert alert-info">No se encontraron resultados para este reporte.</div>';
		}
	}
?>