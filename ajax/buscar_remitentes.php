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
		$id_remitente=intval($_GET['id']);
		$query=odbc_exec($con, "select * from t_guias where id_remitente='".$id_remitente."'");
		$count=odbc_num_rows($query);
		if ($count==0){
			if ($delete1=odbc_exec($con,"DELETE FROM t_remitentes WHERE id_remitente='".$id_remitente."'")){
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
			  <strong>Error!</strong> No se pudo eliminar éste  remitente. Existen facturas vinculadas. 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         #$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$r_q=$_REQUEST['q'];
		$q=str_replace( "'", "''", $r_q ); 
		 $aColumns = array('nombre_remitente');//Columnas de busqueda
		 $sTable = "t_remitentes";
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
		$count_query   = odbc_exec($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere group by nombre_remitente");
		$row= odbc_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './remitentes.php';
		//main query to fetch the data
		$sql="SELECT TOP $per_page * FROM  $sTable $sWhere order by nombre_remitente ";

		//reporte
		$sql_repor="SELECT * FROM  $sTable $sWhere order by id_remitente desc ";
		$query = odbc_exec($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			<div style="margin-bottom: 10px;"><a href="ajax/reporteremite.php?sql=<?php echo $sql_repor;?> " style="padding-right: 15px;padding-left: 0px;">
			Descargar Reporte
			<img src="img/excel.png"/> </a>
			<a href="#" title="Descargar Reporte" onclick='imprimir_reporte("<?php echo $q.' ';?>");' style="padding-right: 15px;padding-left: 0px;">Imprimir Reporte
			<img src="img/pdf.png"/> </a></div>
			  <table class="table">
				<tr  class="info">
					<th>Nombre</th>
					<th>RUC</th>
					<th>Teléfono</th>
					<th>Email</th>
					<th>Estado</th>
					<th>Agregado</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=odbc_fetch_array($query)){
						$id_remitente=$row['id_remitente'];
						$nombre_remitente=$row['nombre_remitente'];
						$ruc_remitente=$row['RUC'];
						$telefono_remitente=$row['Telefono'];
						$razon_social=$row['Raz_Social'];
						$contacto_remitente=$row['Contacto'];
						$email_remitente=$row['Correo'];
						$direccion_remitente=$row['Direccion'];
						$status_remitente=$row['Estado'];
						if ($status_remitente==1){$estado="Activo";}
						else {$estado="Inactivo";}
						$date_added= date('d/m/Y', strtotime($row['Fecha_ingreso']));
						$direccion_remitente_a=$row['Dir_agrupada'];
						
					?>
					
					<input type="hidden" value="<?php echo $id_remitente;?>" id="id_remitente<?php echo $id_remitente;?>">
					<input type="hidden" value="<?php echo $nombre_remitente;?>" id="nombre_remitente<?php echo $id_remitente;?>">
					<input type="hidden" value="<?php echo $ruc_remitente;?>" id="ruc_remitente<?php echo $id_remitente;?>">
					<input type="hidden" value="<?php echo $telefono_remitente;?>" id="telefono_remitente<?php echo $id_remitente;?>">
					<input type="hidden" value="<?php echo $razon_social;?>" id="razon_social<?php echo $id_remitente;?>">
					<input type="hidden" value="<?php echo $contacto_remitente;?>" id="contacto_remitente<?php echo $id_remitente;?>">
					<input type="hidden" value="<?php echo $email_remitente;?>" id="email_remitente<?php echo $id_remitente;?>">
					<input type="hidden" value="<?php echo $direccion_remitente;?>" id="direccion_remitente<?php echo $id_remitente;?>">
					<input type="hidden" value="<?php echo $status_remitente;?>" id="status_remitente<?php echo $id_remitente;?>">
					<input type="hidden" value="<?php echo $direccion_remitente_a;?>" id="direccion_remitente_a<?php echo $id_remitente;?>">
					
					<tr>
						
						<td><?php echo $nombre_remitente; ?></td>
						<td><?php echo $ruc_remitente; ?></td>
						<td><?php echo $telefono_remitente; ?></td>
						<td><?php echo $email_remitente;?></td>
						<td><?php echo $estado;?></td>
						<td><?php echo $date_added;?></td>
						
					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar remitente' onclick="obtener_datos('<?php echo $id_remitente;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
					<a href="#" class='btn btn-default' title='Borrar remitente' onclick="eliminar('<?php echo $id_remitente; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
						
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