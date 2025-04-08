<?php
	/*-------------------------
	Autor: Marco Amaya
	Web: -
	Mail: marco1021tam@gmail.com
	---------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_guia=intval($_GET['id']);

		$queryx=odbc_exec($con, "select * from detalle_factura where id_guia='".$id_guia."'");
		$count=odbc_num_rows($queryx);
	if ($count==0){
			$extra=" select numero_guia from t_guias where id_guia='$id_guia';";
			$count_query_ex = odbc_exec($con, $extra);
			$row_extra=odbc_fetch_array($count_query_ex);
			$num_guia = $row_extra['numero_guia'];
			$del1="delete from t_guias where id_guia='".$id_guia."'";
			$del2="delete from detalle_guia where numero_guia='".$num_guia."'";

		if ($delete1=odbc_exec($con,$del1) and $delete2=odbc_exec($con,$del2)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente
			</div>
			<?php
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo eliminar los datos
			</div>
			<?php

		}
	} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar ésta guía. Existen facturas vinculadas a ella.
			</div>
			<?php
		}

	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         //$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$hoy=date("Y/m/d");
		$desde= $_REQUEST['desde'];
		$hasta= $_REQUEST['hasta'];
		$qr= "";

		if($desde==""){ $desde=$hoy; }

		if($hasta==""){ $hasta=$hoy; }

		$sWhere2 = "";
		if ($desde != ""){
			$sWhere2.= " where CONVERT(date,a.fecha)>='$desde' ";
		}else{
			$sWhere2.= " where CONVERT(date,a.fecha)>='$hoy' ";
		}

		if($hasta != ""){
			$sWhere2.= " and CONVERT(date,a.fecha)<='$hasta' ";
		}else{
			$sWhere2.= " and CONVERT(date,a.fecha)<='$hoy' ";
		}

		$q= str_replace( "'", "''",$_REQUEST['q']);
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$qr= strval($q);
			$sWhere.= " and (a.Consolidado like '%$q%') ";
		}

		//$sWhere.=" Order by a.Consolidado desc ";
		include 'pagination.php';

		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 50;
		$adjacents  = 4;
		$offset = ($page - 1) * $per_page;

		$cons_con=" select count(*)  as numrows  from (select distinct nro_consolidado from t_consolidados as a $sWhere2 $sWhere) as a  ";

		//$cons_con.= " $sWhere2 $sWhere ";
		$count_query = odbc_exec($con, "$cons_con");
		$row=odbc_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './consolidados.php';
		//main query to fetch the data
		$sql=" Select Consolidado, nro_consolidado , fecha, Cantidad, Peso, Cant_guias, placa
						From
							(
								Select 'CONS' + '' + RIGHT('00000' + Ltrim(Rtrim(a.nro_consolidado)),5) [Consolidado], a.nro_consolidado,
									convert(varchar(10),a.fecha,103) [fecha], sum(b.cantidad) [Cantidad], sum(b.peso) [Peso], count(b.id_guia) [Cant_guias], placa
								From t_consolidados as a
								inner join (
									Select a.id_guia, sum(b.cantidad_det) cantidad, sum(peso_det) peso, c.placa
									From t_guias as a
									Inner Join detalle_guia as b on b.numero_guia = a.numero_guia
									Inner Join t_transportes as c on c.id_transporte = a.id_transporte
									Where a.id_guia in (Select id_guia From t_consolidados Where estado_guia =1)
									Group by a.id_guia,  c.placa
								) as b on b.id_guia = a.id_guia

								Group by a.nro_consolidado, convert(varchar(10),a.fecha,103), placa
							) as a $sWhere2 $sWhere order by Consolidado desc
							OFFSET $offset ROWS
							FETCH NEXT $per_page ROWS ONLY ";

		//reporte
		$sql_repor="  $sWhere2 $sWhere ";

		$query = odbc_exec($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			?>
			<div class="table-responsive">
		<div style="margin-bottom: 10px;"><a href="ajax/reporteconsolidados.php?where=<?php echo $sql_repor;?> " style="padding-right: 15px;padding-left: 0px;">
			Descargar Reporte <?php echo $qr;?>
			<img src="img/excel.png"/> </a>
			<!-- <a href="#" title="Descargar Reporte" onclick='imprimir_reporte("<?php echo $desde;?>","<?php echo $hasta;?>","<?php echo $q.' ';?>");' style="padding-right: 15px;padding-left: 0px;">Imprimir Reporte
			<img src="img/pdf.png"/> </a> -->

		</div>
			  <table class="table" id="tabla_general">
				<tr class="info">
					<th>Consolidado</th>
					<th style="display: none;">Id</th>
					<th>Fecha</th>
					<th>Tot. Cantidad</th>
					<th>Tot. Peso</th>
					<th>Tot. guias</th>
					<th>Placa</th>
					<th class='text-center'>Acciones</th>

				</tr>
				<?php
				while ($row=odbc_fetch_array($query)){
						$consolidado			= $row['Consolidado'];
						$id_consolidado		= $row['nro_consolidado'];
						$fecha						= $row['fecha'];
						$cantidad					=	$row['Cantidad'];
						$peso							= $row['Peso'];
						//$fecha=date("d/m/Y", strtotime($row['fecha_factura']));
						$cant_guias				= $row['Cant_guias'];
						$placa						= $row['placa'];

					?>
					<tr>
						<td><?php echo $consolidado; ?></td>

						<td style="display: none;"><?php echo $id_consolidado; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $cantidad; ?></td>
						<td><?php echo $peso; ?></td>
						<td><?php echo $cant_guias; ?></td>
						<td><?php echo $placa; ?></td>

						<!-- <?php if($estado=="1"){ ?>
						<td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_cliente;?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $email_cliente;?>" ><?php echo $nombre_cliente;?></a></td>
						<?php }else{ ?> <td><?php echo"ANULADO" ?></td> <?php } ?> -->

					<td class="text-center">
					<?php

				if($_SESSION['facilidad']=="Administrador"){
    				?>
						<!-- <a href="#" class='btn btn-default' title='Editar Guía' onclick="obtener_datos('<?php echo $id_guia; ?>');" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> -->
							<a href="previa_consolidado.php?idconsolidado=<?php echo $id_consolidado; ?>" class='btn btn-default' title='Vista previa'><i class="glyphicon glyphicon-eye-open"></i></a>
							<a href="editar_consolidado.php?idconsolidado=<?php echo $id_consolidado; ?>" class='btn btn-default' title='Editar Consolidado'><i class="glyphicon glyphicon-edit"></i></a>
							<a href="#" class='btn btn-default' title='Eliminar Consolidado' onclick="anular('<?php echo $id_consolidado;?>');"><i class="glyphicon glyphicon-trash"></i></a>
					<?php
				} else{
				    ?>
						<a href="previa_consolidado.php?idconsolidado=<?php echo $id_consolidado; ?>" class='btn btn-default' title='Vista previa'><i class="glyphicon glyphicon-eye-open"></i></a>
					<?php
				}
				    ?>

					</td>

					</tr>
					<?php
				}
				?>
				<tr>
					<td class='text-center' colspan=7><span class="pull-center"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}else{
			?>
			<div style="margin-bottom: 10px;"><a href="#" style="padding-right: 15px;padding-left: 0px;">
			No hay datos para exportar </a></div>
			<table class="table">
				<tr  class="info">
					<th>Consolidado</th>
					<th style="display: none;">Id</th>
					<th>Fecha</th>
					<th>Tot. Cantidad</th>
					<th>Tot. Peso</th>
					<th>Tot. guias</th>
					<th>Placa</th>
					<th class='text-center'>Acciones</th>

				</tr>
				<?php for ($i=0; $i <4 ; $i++) {
					?>
					<tr>
						<th>&nbsp</th>
						<th style="display: none;"></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th class='text-right'></th>
					</tr>
					<?php
				}?>

				</table>
				<br>
			<?php
		}
	}
?>
