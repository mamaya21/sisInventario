<?php

	/*-------------------------
	Autor: Marco Amaya
	Web: -
	Mail: marco1021tam@gmail.com
	---------------------------*/
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id	= intval($_GET['id']);
		$query=odbc_exec($con, "select * from t_tarifarios where id=".$id.";");
		$rw_user=odbc_fetch_array($query);
		$count=$rw_user['id'];
		if ($count!=0){
			$delet="delete from t_tarifarios WHERE id=".$id.";";
			if ($delete1=odbc_exec($con,$delet)){
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

		}

	}
	if($action == 'ajax'){
		$q = $_REQUEST['q'];
		$q= str_replace("'", "''", $q);

		$aColumns = array('b.nombre', 'b.slug');//Columnas de busqueda
		$sTable = " t_tarifarios as a inner join distritos as b on b.id = a.id_distrito
				inner join provincias as c on c.id = b.provincias_id
				inner join departamentos as d on d.id = c.departamentos_id ";
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
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$query_sql_count = "select  count(*) AS numrows FROM $sTable  $sWhere";
		$count_query   = odbc_exec($con, $query_sql_count);
		$row= odbc_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './tarifarios.php';
		//main query to fetch the data
		$sql="select a.id , b.nombre as distrito, c.nombre as provincia, d.nombre as departamento, a.desde, a.hasta, a.precio, a.id_distrito, c.id as id_provincia, d.id as id_departamento
		 from  $sTable $sWhere order by a.id desc
		OFFSET $offset ROWS
	  FETCH NEXT $per_page ROWS ONLY ";
		$query = odbc_exec($con, $sql);
		//loop through fetched data
		if ($numrows>0){

			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>DEPARTAMENTO</th>
					<th>PROVINCIA</th>
					<th>DISTRITO</th>
					<th>DESDE</th>
					<th>HASTA</th>
					<th>PRECIO</th>
					<th><span class="pull-right">ACCIONES</span></th>

				</tr>
				<?php
				while ($row=odbc_fetch_array($query)){
						$id=$row['id'];
						//$fullname=$row['firstname']." ".$row["lastname"];
						$distrito=$row['distrito'];
						$provincia=$row['provincia'];
						$departamento=$row['departamento'];
						$desde=floatval($row['desde'])+0;
						$hasta=floatval($row['hasta'])+0;
						$precio=floatval($row['precio'])+0;

						$id_distrito=$row['id_distrito'];
						$id_provincia=$row['id_provincia'];
						$id_departamento=$row['id_departamento'];



					?>

					<input type="hidden" value="<?php echo $id_distrito;?>" id="id_distrito<?php echo $id;?>">
					<input type="hidden" value="<?php echo $id_provincia;?>" id="id_provincia<?php echo $id;?>">
					<input type="hidden" value="<?php echo $id_departamento;?>" id="id_departamento<?php echo $id;?>">

					<tr>
						<td><?php echo $departamento;?></td>
						<td><?php echo $provincia;?></td>
						<td><?php echo $distrito;?></td>
						<td><?php echo $desde;?></td>
						<td><?php echo $hasta;?></td>
						<td><?php echo $precio;?></td>

					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar tarifario' onclick="obtener_datos('<?php echo $id;?>','<?php echo $desde;?>','<?php echo $hasta;?>','<?php echo $precio;?>');"
							data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>
					<a href="#" class='btn btn-default' title='Borrar tarifario' onclick="eliminar('<?php echo $id;?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>

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
		}
	}
?>
