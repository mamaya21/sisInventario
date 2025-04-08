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

	if($action == 'ajax'){
		$hoy=date("Y/m/d");
		// escaping, additionally removing everything that could be (html/javascript-) code
         //$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$q= $_REQUEST['q'];
		//$remitente= str_replace( "'", "''",$_REQUEST['remitente']);
		$id_remitente= $_REQUEST['remitente'];		
		$desde= $_REQUEST['desde'];
		$hasta= $_REQUEST['hasta'];
		$importe= $_REQUEST['importe'];

		$sWhere = "";
		if ($desde != ""){
			$sWhere.= " where CONVERT(date,a.fecha_factura)>='$desde' ";		
		}else{
			$sWhere.= " where CONVERT(date,a.fecha_factura)>='$hoy' ";
		}

		if($hasta != ""){
			$sWhere.= " and CONVERT(date,a.fecha_factura)<='$hasta' ";
		}else{
			$sWhere.= " and CONVERT(date,a.fecha_factura)<='$hoy' ";
		}

		if($id_remitente !=""){
			$sWhere.= " and b.Raz_Social='$id_remitente' ";
		}

		$operador="";
		if($q !=""){
			if($q=="1"){
				$operador= " < ";
			}else if($q=="2"){
				$operador= " <= ";
			}else if($q=="3"){
				$operador= " = ";
			}else if($q=="4"){
				$operador= " > ";
			}else if($q=="5"){
				$operador= " >= ";
			}	
		}

		if($importe !="0"){
			$sWhere.= " and a.total $operador '$importe' ";
		}
		
		include 'pagination.php'; 
		
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;

		$cons_con="  select COUNT(*) as numrows 
		from t_facturas as a 
		inner join t_remitentes as b on b.id_remitente=a.id_cliente ";
		$count_query   = odbc_exec($con, "$cons_con $sWhere");
		$row=odbc_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './reporte.php';
		//main query to fetch the data
		$sql=" select a.buscador as nfactura,b.Raz_Social as cliente, 
		CONVERT(varchar(10),CONVERT(date,a.fecha_factura),103) as fecha,
		a.importe as subtotal,a.igv as igv, a.total as total 
		from t_facturas as a 
		inner join t_remitentes as b on b.id_remitente=a.id_cliente $sWhere order by nfactura ";
		$query = odbc_exec($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			?>
			<div class="table-responsive">

			<div style="margin-bottom: 10px;"><a href="ajax/reporteexcel.php?sql=<?php echo $sql;?> " style="padding-right: 15px;padding-left: 0px;">
			Descargar Reporte
			<img src="img/excel.png"/> </a></div>
			  <table class="table">
				<tr  class="info">
					<th># de Factura</th>
					<th>Cliente</th>
					<th>Fecha</th>
					<th>Subtotal</th>
					<th>Igv</th>
					<th>Total</th>
					
				</tr>
				<?php
				while ($row=odbc_fetch_array($query)){
						$n_factura=$row['nfactura'];
						$cliente=$row['cliente'];
						$fecha=$row['fecha'];
						$importe=$row['subtotal'];
						//$fecha=date("d/m/Y", strtotime($row['fecha_factura']));
						$igv=$row['igv'];
						$total=$row['total'];
						/*if ($estado_factura==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}
						$total_venta=$row['total_venta'];*/
					?>
					<tr>
						<td><?php echo $n_factura; ?></td>
						<td><?php echo $cliente;?></a></td>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $importe; ?></td>
						<td><?php echo $igv; ?></td>
						<td><?php echo $total; ?></td>						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right"><?
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>