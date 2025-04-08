<?php
	 error_reporting(E_ALL ^ E_DEPRECATED);
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
		$id_cliente=intval($_GET['id']);
		$query=odbc_exec($con, "select * from t_guias where id_cliente='".$id_cliente."'");
		$count=odbc_num_rows($query);
		if ($count==0){
			if ($delete1=odbc_exec($con,"DELETE FROM t_clientes WHERE id_cliente='".$id_cliente."'")){
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
			  <strong>Error!</strong> No se pudo eliminar éste  cliente. Existen facturas vinculadas a éste producto.
			</div>
			<?php
		}



	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         #$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$r_q=$_REQUEST['q'];
		$q=str_replace( "'", "''", $r_q );
		 $aColumns = array('a.nombre_cliente');//Columnas de busqueda
		 $sTable = " t_clientes as a ";
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
		$count_query   = odbc_exec($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere group by a.nombre_cliente");
		$row= odbc_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './clientes.php';
		//main query to fetch the data
		$sql="SELECT TOP $per_page a.id_cliente, a.nombre_cliente, a.RUC, a.Direccion, a.Telefono, a.Raz_Social, a.Contacto,
		 	a.Correo, a.Estado, a.Fecha_ingreso, a.id_distrito, c.id as id_provincia, d.id as id_departamento
			FROM $sTable
			left outer join distritos as b on b.id= a.id_distrito
 		 	left outer join provincias as c on c.id= b.provincias_id
 		 	left outer join departamentos as d on d.id= c.departamentos_id
		 	$sWhere order by a.id_cliente desc ";

		//reporte
		$sql_repor="SELECT a.id_cliente, a.nombre_cliente, a.RUC, a.Direccion, a.Telefono, a.Raz_Social, a.Contacto,
		 	a.Correo, a.Estado, a.Fecha_ingreso, a.id_distrito, c.id as id_provincia, d.id as id_departamento
		 FROM $sTable
		 left outer join distritos as b on b.id= a.id_distrito
		 left outer join provincias as c on c.id= b.provincias_id
		 left outer join departamentos as d on d.id= c.departamentos_id
		 $sWhere order by a.nombre_cliente ";

		$query = odbc_exec($con, $sql);
		//loop through fetched data
		if ($numrows>0){

			?>
			<div class="table-responsive">
			<div style="margin-bottom: 10px;"><a href="ajax/reportedestina.php?sql=<?php echo $sql_repor;?> " style="padding-right: 15px;padding-left: 0px;">
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
						$id_cliente=$row['id_cliente'];
						$nombre_cliente=$row['nombre_cliente'];
						$ruc_cliente=$row['RUC'];
						$telefono_cliente=$row['Telefono'];
						$razon_social=$row['Raz_Social'];
						$contacto_cliente=$row['Contacto'];
						$email_cliente=$row['Correo'];
						$direccion_cliente=$row['Direccion'];
						$status_cliente=$row['Estado'];
						if ($status_cliente==1){$estado="Activo";}
						else {$estado="Inactivo";}
						$date_added= date('d/m/Y', strtotime($row['Fecha_ingreso']));

						$id_distrito = $row['id_distrito'];
						$id_provincia = $row['id_provincia'];
						$id_departamento = $row['id_departamento'];

					?>

					<input type="hidden" value="<?php echo $id_cliente;?>" id="id_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $nombre_cliente;?>" id="nombre_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $ruc_cliente;?>" id="ruc_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $telefono_cliente;?>" id="telefono_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $razon_social;?>" id="razon_social<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $contacto_cliente;?>" id="contacto_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $email_cliente;?>" id="email_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $direccion_cliente;?>" id="direccion_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $status_cliente;?>" id="status_cliente<?php echo $id_cliente;?>">

					<input type="hidden" value="<?php echo $id_distrito;?>" id="id_distrito<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $id_provincia;?>" id="id_provincia<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $id_departamento;?>" id="id_departamento<?php echo $id_cliente;?>">

					<tr>

						<td><?php echo $nombre_cliente; ?></td>
						<td ><?php echo $ruc_cliente; ?></td>
						<td ><?php echo $telefono_cliente; ?></td>
						<td><?php echo $email_cliente;?></td>
						<td><?php echo $estado;?></td>
						<td><?php echo $date_added;?></td>

					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar cliente' onclick="obtener_datos('<?php echo $id_cliente;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>
					<a href="#" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $id_cliente; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>

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
