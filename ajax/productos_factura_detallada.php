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
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = $_REQUEST['q'];
         $q = str_replace("'", "''", $q);
		 $aColumns = array('a.buscador', 'b.nombre_cliente');//Columnas de busqueda
		 $sTable = " t_guias as a ";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		include 'pagination.php'; 

		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 5; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		
		//$remitente_id=$_REQUEST['ad'];
		if (isset($_REQUEST['id_remitente'])) {
			$id_remite = $_REQUEST['id_remitente'];
			} else {
			$id_remite = "#";
			}

		$ssql="SELECT count(*) AS numrows FROM $sTable inner join t_clientes as b on b.id_cliente=a.id_cliente $sWhere and a.add_Fac=0 ";
		?>

		<!--<p><?php echo $ssql; ?></p>-->

		<?php

		$count_query   = odbc_exec($con, $ssql);		
		$row= odbc_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './index.php';
		
		$order=" group by a.id_guia,a.numero_guia,a.buscador,b.nombre_cliente,b.Telefono,b.Correo,c.nombre_remitente,d.placa,a.fecha_guia,d.placa,b.Direccion ";

		$sql=" select a.id_guia as id_guia,a.numero_guia as nguia,b.nombre_cliente as ncliente,a.buscador as buscador,
		b.Telefono as tcliente,b.Correo as ecliente,
		c.nombre_remitente as nremitente,d.placa as placa,
		SUM(e.cantidad_det) as cantidad, SUM(e.peso_det) as peso 
		,convert(varchar(10),convert(date,a.fecha_guia),103) as fecha,d.placa,b.Direccion as dcliente
		from t_guias a 
		inner join t_clientes b on b.id_cliente=a.id_cliente 
		inner join t_remitentes c on c.id_remitente=a.id_remitente 
		inner join t_transportes d on d.id_transporte=a.id_transporte 
		inner join detalle_guia e on e.numero_guia=a.numero_guia $sWhere and c.Raz_Social='$id_remite' and a.add_fac=0 $order";

		$query = odbc_exec($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table" id="tabla_guias">
				<tr  class="warning">
					<th># Guía</th>
					<th>Fecha Guía</th>
					<th>Placa</th>
					<th>Dest. Final</th>
					<th>Dirección</th>
					<th>Cantidad</th>
					<th>Peso</th>
					<th class="text-center">Importe</th>
					<th class='text-center' style="width: 36px;">Agregar</th>
				</tr>
				<?php
				while ($row=odbc_fetch_array($query)){
					$id_guia=$row['id_guia'];
					$n_guia=$row['nguia'];
					$fec_guia=$row['fecha'];
					$placa=$row['placa'];
					$nro_guia=$row['buscador'];
					$des_final=$row['ncliente'];
					$dir_final=$row['dcliente'];
					$cantidad=$row['cantidad'];
					$peso=$row["peso"];
					$peso=number_format($peso,2);
					?>
					<tr>
						<td><?php echo $nro_guia; ?><input type="hidden" id="guia_<?php echo $id_guia; ?>"  value="<?php echo $nro_guia ?>"></td>
						<td><?php echo $fec_guia; ?></td>
						<td><?php echo $placa; ?></td>
						<td><?php echo $des_final; ?><input type="hidden" id="nguia_<?php echo $id_guia; ?>"  value="<?php echo $n_guia ?>"></td>
						
						<!--<td class='col-xs-2'><div class="pull-right">
						<input type="text" class="form-control" style="text-align:right" id="precio_venta_<?php echo $id_producto; ?>"  value="<?php echo $precio_venta;?>" >
						</div></td>-->
						<td><?php echo $dir_final; ?></td>
						<td><?php echo $cantidad; ?><input type="hidden" id="cantidad_<?php echo $id_guia; ?>"  value="<?php echo $cantidad ?>"></td>
						<td><?php echo $peso; ?><input type="hidden" id="peso_<?php echo $id_guia; ?>"  value="<?php echo $peso ?>"></td>
						<td class='col-xs-2'>
						<div class="pull-right">
						<input type="text" class="form-control" style="text-align:center" id="imp_<?php echo $id_guia; ?>"  value="0" >
						</div></td>
						<td class='text-center'><a class='btn btn-info'href="#" onclick="agregar('<?php echo $id_guia ?>')"><i class="glyphicon glyphicon-plus"></i></a></td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=5><span class="pull-right"><?
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>