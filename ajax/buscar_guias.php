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

		$data2= $_REQUEST['data2'];
		$guias_arr = explode(',' , $data2);

		if($desde==""){ $desde=$hoy; }

		if($hasta==""){	$hasta=$hoy; }

		$sWhere2 = "";
		if ($desde != ""){
			$sWhere2.= " where CONVERT(date,a.fecha_guia)>='$desde' ";
		}else{
			$sWhere2.= " where CONVERT(date,a.fecha_guia)>='$hoy' ";
		}

		if($hasta != ""){
			$sWhere2.= " and CONVERT(date,a.fecha_guia)<='$hasta' ";
		}else{
			$sWhere2.= " and CONVERT(date,a.fecha_guia)<='$hoy' ";
		}

		$q= str_replace( "'", "''",$_REQUEST['q']);
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$qr= strval($q);
			$sWhere.= " and  (b.nombre_cliente like '%$q%' or a.buscador like '%$q%') ";
		}


		include 'pagination.php';

		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 50;
		$adjacents  = 4;
		$offset = ($page - 1) * $per_page;

		$cons_con="  select COUNT(*) as numrows from t_guias a
		left outer join t_clientes b on b.id_cliente=a.id_cliente
		left outer join t_remitentes c on c.id_remitente=a.id_remitente
		left outer join t_transportes d on d.id_transporte=a.id_transporte
		left outer join t_subcontratadas s on s.id_empresa=a.id_empresa ";

		$cons_con.= " $sWhere2 $sWhere ";
		$count_query   = odbc_exec($con, "$cons_con");
		$row=odbc_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './guias.php';
		//main query to fetch the data

		$sWhere.=" group by a.id_guia,a.numero_guia,a.buscador,b.nombre_cliente,b.Telefono,b.Correo,c.Raz_Social,d.placa,a.fecha_guia, s.nombre_empresa,a.estado_guia,c.Direccion,b.Direccion,s.Direccion ";

		$sql=" select
		(case When a.id_guia in (Select id_guia from t_consolidados) then 'si' else 'no' end) consolidado,
		a.id_guia as id_guia,a.numero_guia as nguia,b.nombre_cliente as ncliente,a.buscador,
		convert(varchar(10),convert(date,a.fecha_guia),103) as emision,a.estado_guia as estado,
		b.Telefono as tcliente,b.Correo as ecliente,
		c.Raz_Social as rsocialremitente,d.placa as placa,
		SUM(e.cantidad_det) as cantidad, SUM(e.peso_det) as peso
		from t_guias a
		left outer join t_clientes b on b.id_cliente=a.id_cliente
		left outer join t_remitentes c on c.id_remitente=a.id_remitente
		left outer join t_transportes d on d.id_transporte=a.id_transporte
		left outer join t_subcontratadas s on s.id_empresa=a.id_empresa
		left outer join detalle_guia e on e.numero_guia=a.numero_guia $sWhere2 $sWhere order by id_guia desc
		OFFSET $offset ROWS
		FETCH NEXT $per_page ROWS ONLY ";

		//reporte
		$sql_repor=" $sWhere2 $sWhere ";

		$query = odbc_exec($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			?>
	<div class="table-responsive">
		<div style="margin-bottom: 10px;"><a href="ajax/reporteguias.php?desde=<?php echo $desde;?>&hasta=<?php echo $hasta;?>&q=<?php echo $q;?> " style="padding-right: 15px;padding-left: 0px;">
			Descargar Reporte
			<img src="img/excel.png"/> </a>
			<a href="#" title="Descargar Reporte" onclick='imprimir_reporte("<?php echo $desde;?>","<?php echo $hasta;?>","<?php echo $q.' ';?>");' style="padding-right: 15px;padding-left: 0px;">Imprimir Reporte
			<img src="img/pdf.png"/> </a>

			<a href="#" title="Consolidar Guías" onclick='consolidar_guias();' style="padding-right: 15px;padding-left: 0px;"> Consolidado
			<img src="img/Table.png"/> </a>
		</div>
			  <table class="table" id="tabla_general">
				<tr class="info">
					<th>Cons</th>
					<th style="display: none;">Id</th>
					<th># Guía</th>
					<th>Destinatario</th>
					<th>Cliente</th>
					<th>Emisión</th>
					<th>Cantidad</th>
					<th>Peso</th>
					<th>Placa</th>
					<th class='text-center'>Acciones</th>

				</tr>
				<?php
				while ($row=odbc_fetch_array($query)){
						$id_guia=$row['id_guia'];
						$numero_guia=$row['nguia'];
						$buscador=$row['buscador'];
						$telefono_cliente=$row['tcliente'];
						$email_cliente=$row['ecliente'];
						//$fecha=date("d/m/Y", strtotime($row['fecha_factura']));
						$nombre_cliente=$row['ncliente'];
						$nombre_remitente=$row['rsocialremitente'];
						$placa=$row['placa'];
						$emision= $row['emision'];
						$cantidad=$row['cantidad'];
						$peso=$row['peso'];
						$estado=$row['estado'];
						/*if ($estado_factura==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}
						$total_venta=$row['total_venta'];*/
						$placa=$row['placa'];
						$consolidado = $row['consolidado'];
					?>
					<tr>

						<?php if($estado=="1"){
							if($consolidado=="no"){
								if (in_array($id_guia, $guias_arr)) {
									?>
										<td class='text-center'>
												<input type="checkbox" class="tableid" name="tableid" id="<?php echo $id_guia; ?>" class="click"
													value="<?php echo $id_guia; ?>" onchange="changeChkTbl('<?php echo $id_guia; ?>','<?php echo $buscador; ?>','<?php echo $placa; ?>')" checked>
										</td>
									<?php
								}else{
									?>
									<td class='text-center'>
											<input type="checkbox" class="tableid" name="tableid" id="<?php echo $id_guia; ?>" class="click"
												value="<?php echo $id_guia; ?>" onchange="changeChkTbl('<?php echo $id_guia; ?>','<?php echo $buscador; ?>','<?php echo $placa; ?>')">
									</td>
									<?php
								}
							}else{
						?>
								<td class='text-center'>-</td>

						<?php } ?>

					 <?php }else{ ?>
						 	<td class='text-center'>-</td>
						<?php } ?>

						<td style="display: none;"><?php echo $id_guia; ?></td>
						<td><?php echo $buscador; ?></td>
						<?php if($estado=="1"){ ?>
						<td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_cliente;?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $email_cliente;?>" ><?php echo $nombre_cliente;?></a></td>
						<?php }else{ ?> <td><?php echo"ANULADO" ?></td> <?php } ?>
						 <?php if($estado=="1"){ ?>
						<td><?php echo $nombre_remitente; ?></td>
						<?php }else{ ?> <td><?php echo"ANULADO" ?></td> <?php } ?>
						<td><?php echo $emision; ?></td>
						<td><?php echo $cantidad; ?></td>
						<td><?php echo $peso; ?></td>
						<td><?php echo $placa; ?></td>
						<!--<td><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
						<td class='text-right'><?php echo number_format ($total_venta,2); ?></td>-->

					<td class="text-right">
					<?php

						if($estado=="1"){

      					if($_SESSION['facilidad']=="Administrador"){
			    			?>
									<!-- <a href="#" class='btn btn-default' title='Editar Guía' onclick="obtener_datos('<?php echo $id_guia; ?>');" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> -->
										<a href="editar_guia.php?idguia=<?php echo $id_guia; ?>" class='btn btn-default' title='Editar Guía'><i class="glyphicon glyphicon-edit"></i></a>
										<a href="#" class='btn btn-default' title='Replicar Guía' onclick="replicar('<?php echo $id_guia; ?>');"><i class="glyphicon glyphicon-tags"></i></a>
										<a href="#" class='btn btn-default' title='Anular Guía' onclick="anular('<?php echo $id_guia;?>');"><i class="glyphicon glyphicon-warning-sign"></i></a>
								<?php
							  }
				    ?>
						<a href="#" class='btn btn-default' title='Imprimir Guía' onclick="imprimir_factura('<?php echo $id_guia;?>');"><i class="glyphicon glyphicon-download"></i></a>
					<?php
				    }
				    ?>
						<a href="#" class='btn btn-default' title='Borrar guía' onclick="eliminar('<?php echo $id_guia; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
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
					<th>Cons</th>
					<th># Guía</th>
					<th>Cliente</th>
					<th>Remitente</th>
					<th>Emisión</th>
					<th>Cantidad</th>
					<th>Peso</th>
					<th>Placa</th>
					<th class='text-center'>Acciones</th>

				</tr>
				<?php for ($i=0; $i <4 ; $i++) {
					?>
					<tr>
						<th>&nbsp</th>
						<th>&nbsp</th>
						<th></th>
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
