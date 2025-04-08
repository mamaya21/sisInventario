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
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_transporte=intval($_GET['id']);
		$query=odbc_exec($con, "select * from t_guias where id_transporte='".$id_transporte."'");
		$count=odbc_num_rows($query);
		if ($count==0){
			if ($delete1=odbc_exec($con,"DELETE FROM t_transportes WHERE id_transporte='".$id_transporte."'")){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar éste  transporte. Existen facturas vinculadas. 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         #$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$r_q=$_REQUEST['q'];
		$q=str_replace( "'", "''", $r_q ); 
		 $aColumns = array('placa');//Columnas de busqueda
		 $sTable = "t_transportes";
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
		#$sWhere.=" group by nombre_cliente ";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = odbc_exec($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere group by placa");
		$row= odbc_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './transportes.php';
		//main query to fetch the data
		$sql="SELECT TOP $per_page * FROM  $sTable $sWhere order by placa ";

		//reporte
		$sql_repor="select * from $sTable $sWhere order by id_transporte desc ";
		$query = odbc_exec($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			<div style="margin-bottom: 10px;"><a href="ajax/reportetransporte.php?sql=<?php echo $sql_repor;?> " style="padding-right: 15px;padding-left: 0px;">
			Descargar Reporte
			<img src="img/excel.png"/> </a>
			<a href="#" title="Descargar Reporte" onclick='imprimir_reporte("<?php echo $q.' ';?>");' style="padding-right: 15px;padding-left: 0px;">Imprimir Reporte
			<img src="img/pdf.png"/> </a></div>
			  <table class="table">
				<tr  class="info">
					<th>Marca</th>
					<th>Placa</th>
					<th>Conductor</th>
					<th>Licencia</th>
					<th>Estado</th>
					<th>Agregado</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=odbc_fetch_array($query)){
						$id_transporte=$row['id_transporte'];
						$marca=$row['marca'];
						$placa=$row['placa'];
						$n_inscripcion=$row['n_inscripcion'];
						$conf_vehicular=$row['conf_vehicular'];
						$lic_conducir=$row['lic_conducir'];
						$conductor=$row['conductor'];
						$status_transporte=$row['estado'];
						if ($status_transporte==1){$estado="Activo";}
						else {$estado="Inactivo";}
						$date_added= date('d/m/Y', strtotime($row['fecha_ingreso']));
						
					?>
					
					<input type="hidden" value="<?php echo $id_transporte;?>" id="id_transporte<?php echo $id_transporte;?>">
					<input type="hidden" value="<?php echo $marca;?>" id="marca<?php echo $id_transporte;?>">
					<input type="hidden" value="<?php echo $placa;?>" id="placa<?php echo $id_transporte;?>">
					<input type="hidden" value="<?php echo $n_inscripcion;?>" id="n_inscripcion<?php echo $id_transporte;?>">
					<input type="hidden" value="<?php echo $conf_vehicular;?>" id="conf_vehicular<?php echo $id_transporte;?>">
					<input type="hidden" value="<?php echo $lic_conducir;?>" id="lic_conducir<?php echo $id_transporte;?>">
					<input type="hidden" value="<?php echo $conductor;?>" id="conductor<?php echo $id_transporte;?>">
					<input type="hidden" value="<?php echo $status_transporte;?>" id="status_transporte<?php echo $id_transporte;?>">
					
					<tr>
						
						<td><?php echo $marca; ?></td>
						<td><?php echo $placa; ?></td>
						<td><?php echo $conductor; ?></td>
						<td><?php echo $lic_conducir;?></td>
						<td><?php echo $estado;?></td>
						<td><?php echo $date_added;?></td>
						
					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar transporte' onclick="obtener_datos('<?php echo $id_transporte;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
					<a href="#" class='btn btn-default' title='Borrar transporte' onclick="eliminar('<?php echo $id_transporte; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
						
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