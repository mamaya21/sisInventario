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

			//actualizando guia original
			$sql_u1=" update t_facturas set id_cliente=0,importe=0,igv=0,total=0,estado_factura=0 where numero_factura='$numero_factura'  ";

		if ($upd1= odbc_exec($con, $sql_u1)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Factura anulada exitosamente!
			</div>
			<?php 
			$upd=odbc_exec($con, " select id_guia from detalle_factura where numero_factura=".$numero_factura."; ");
			while ($row_cfa=odbc_fetch_array($upd)) {
			$valor_idguia=$row_cfa['id_guia'];
			$upd2=" update t_guias set add_fac=0 where id_guia='".$valor_idguia."'; ";
			$query_update = odbc_exec($con,$upd2);
		}
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo anular la Factura
			</div>
			<?php
			
		}

	}
?>