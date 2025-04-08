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
		$numero_factura=intval($_GET['id']);
		$del1="delete from t_fac_almacenaje where numero_factura='".$numero_factura."'";
		$del2="delete from detalle_fac_almacenaje where numero_factura='".$numero_factura."'";

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
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         //$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$hoy=date("Y/m/d");
		$desde= $_REQUEST['desde'];
		$hasta= $_REQUEST['hasta'];

		if($desde==""){
			$desde=$hoy;
		}

		if($hasta==""){
			$hasta=$hoy;
		}

		$sWhere2 = "";
		if ($desde != ""){
			$sWhere2.= " where CONVERT(date,a.fecha_factura)>='$desde' ";		
		}else{
			$sWhere2.= " where CONVERT(date,a.fecha_factura)>='$hoy' ";
		}

		if($hasta != ""){
			$sWhere2.= " and CONVERT(date,a.fecha_factura)<='$hasta' ";
		}else{
			$sWhere2.= " and CONVERT(date,a.fecha_factura)<='$hoy' ";
		}

		$q= str_replace( "'", "''",$_REQUEST['q']);
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (b.rsocialremitente like '%$q%' or a.buscador like '%$q%') and a.tipo='A' ";
			
		}else{
			$sWhere.= " and  a.tipo='A' ";
		}
		
		include 'pagination.php'; 
		
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;

		$cons_con="  select COUNT(*) as numrows, SUM(total) sum_total 
		from t_fac_almacenaje as a 
		left outer join t_remitentes as b on b.id_remitente=a.id_cliente ";
		$count_query   = odbc_exec($con, "$cons_con $sWhere2 $sWhere");
		$row=odbc_fetch_array($count_query);
		$numrows = $row['numrows'];
		$sum_total= $row['sum_total'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './facturas_almacenaje.php';
		//main query to fetch the data
		$sql=" select top $per_page a.id_factura as id_factura,a.numero_factura as nfactura, a.buscador as buscador, 
		convert(varchar(10),convert(date,a.fecha_factura),103) as fecha_factura,b.RUC as ruc,
		b.Raz_Social as rsocialremitente,b.Telefono as tremitente,b.Correo as eremitente,
		a.importe as importe,a.igv as igv,a.total as total,a.estado_factura as  estado
		from t_fac_almacenaje as a  
		left outer join t_remitentes as b on b.id_remitente=a.id_cliente $sWhere2 $sWhere order by a.id_factura desc";

		//reporte
		$sql_repor="  select  a.id_factura as id_factura,a.numero_factura as nfactura, a.buscador as buscador, 
		convert(varchar(10),convert(date,a.fecha_factura),103) as fecha_factura,
		case when b.RUC is not null then b.RUC 
		when b.RUC is null then 'ANULADO' end as ruc,
		case when b.Raz_Social is not null then b.Raz_Social 
		when  b.Raz_Social is null then 'ANULADO' end as rsocialremitente,
		b.Telefono as tremitente,b.Correo as eremitente,
		a.importe as importe,a.igv as igv,a.total as total 
		from t_fac_almacenaje as a  
		left outer join t_remitentes as b on b.id_remitente=a.id_cliente $sWhere2 $sWhere order by a.id_factura ";
		$query = odbc_exec($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			?>
			<div class="table-responsive">
			<div style="margin-bottom: 10px;"><a href="ajax/reportefactura.php?sql=<?php echo $sql_repor;?> " style="padding-right: 15px;padding-left: 0px;">
			Descargar Reporte
			<img src="img/excel.png"/> </a>
			<a href="#" title="Descargar Reporte" onclick='imprimir_reporte("<?php echo $desde;?>","<?php echo $hasta;?>","<?php echo $q.' ';?>");' style="padding-right: 15px;padding-left: 0px;">Imprimir Reporte
			<img src="img/pdf.png"/> </a></div>
			  <table class="table">
				<tr  class="info">
					<th># Factura</th>
					<th>Fecha</th>
					<th>Cliente</th>
					<th>RUC</th>
					<th>Importe</th>
					<th>IGV</th>
					<th>Total</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=odbc_fetch_array($query)){
						$id_factura=$row['id_factura'];
						$fecha_factura=$row['fecha_factura'];
						$numero_factura=$row['nfactura'];
						$buscador=$row['buscador'];
						$telefono_remitente=$row['tremitente'];
						$email_remitente=$row['eremitente'];
						//$fecha=date("d/m/Y", strtotime($row['fecha_factura']));
						$ruc= $row['ruc'];
						$nombre_remitente=$row['rsocialremitente'];
						$importe=$row['importe'];
						$igv=$row['igv'];
						$total=$row['total'];
						$estado= $row['estado'];
						/*if ($estado_factura==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}
						$total_venta=$row['total_venta'];*/
					?>
					<tr>
						<td><?php echo $buscador; ?></td>
						<td><?php echo $fecha_factura; ?></td>
						<?php if($estado=="1"){ ?>
						<td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_remitente;?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $email_remitente;?>" ><?php echo $nombre_remitente;?></a></td>
						<?php }else{ ?> <td><?php echo"ANULADO" ?></td> <?php } ?>
						 <?php if($estado=="1"){ ?>
						<td><?php echo $ruc; ?></td>
						<?php }else{ ?> <td><?php echo"ANULADO" ?></td> <?php } ?>
						<td><?php echo $importe; ?></td>
						<td><?php echo $igv; ?></td>
						<td><?php echo $total; ?></td>
						<!--<td><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
						<td class='text-right'><?php echo number_format ($total_venta,2); ?></td>-->				
					<td class="text-right">
						<!--<a href="editar_factura.php?id_factura=<?php echo $id_factura;?>" class='btn btn-default' title='Editar Factura' ><i class="glyphicon glyphicon-edit"></i></a>-->
						<?php
						if($estado=="1"){

	      					if($_SESSION['facilidad']=="Administrador"){
	    				?>
							<a href="#" class='btn btn-default' title='Replicar Factura' onclick="replicar('<?php echo $id_factura;?>')"><i class="glyphicon glyphicon-edit"></i></a>
							<a href="#" class='btn btn-default' title='Anular Factura' onclick="anular('<?php echo $numero_factura;?>');"><i class="glyphicon glyphicon-warning-sign"></i></a>
						<?php
					      }
					    ?>
						<a href="#" class='btn btn-default' title='Imprimir Factura' onclick="imprimir_factura('<?php echo $id_factura;?>');"><i class="glyphicon glyphicon-download"></i></a> 
						<?php
						      }
						    ?>
						<a href="#" class='btn btn-default' title='Borrar Factura' onclick="eliminar('<?php echo $numero_factura; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
					</td>
						
					</tr>
					<?php
				}
				?>
				<tr>
						<th>&nbsp</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th class='text-right'>SUMA TOTAL: </th>
						<th class='text-right'><?php echo $sum_total;?></th>
					</tr>
				<tr>
					<td colspan=7><span class="pull-right"><?
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
					<th># Factura</th>
					<th>Fecha</th>
					<th>Cliente</th>
					<th>Importe</th>
					<th>IGV</th>
					<th>Total</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php for ($i=0; $i <4 ; $i++) { 
					?>
					<tr>
						<th>&nbsp</th>
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