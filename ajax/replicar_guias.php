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

		$queryx=odbc_exec($con, "select * from t_guias where id_guia='".$id_guia."'");

		$count=odbc_num_rows($queryx);
		$row= odbc_fetch_array($queryx);
		$estado= $row['estado_guia'];

		if ($estado=="1"){
			$n_fac=0;
			$n_fac_aumenta=0;
			$num_guia=0;

			$n_fac_sql=odbc_exec($con, " select n_guia from datos_fg; ");
			while ($row_cf=odbc_fetch_array($n_fac_sql)) {
				$n_fac=intval($row_cf['n_guia']);
			}

			$n_fac_aumenta_sql=odbc_exec($con, " select count(*) as aumenta from t_guias; ");
			while ($row_cfa=odbc_fetch_array($n_fac_aumenta_sql)) {
				$n_fac_aumenta=intval($row_cfa['aumenta']);
			}

			$num_guia=$n_fac+$n_fac_aumenta;

			$busc= strlen($num_guia);
			$guia_buscar="";
			if($busc==1){
				$guia_buscar="001-00000".$num_guia;
			}else if($busc==2){
				$guia_buscar="001-0000".$num_guia;
			}else if($busc==3){
				$guia_buscar="001-000".$num_guia;
			}else if($busc==4){
				$guia_buscar="001-00".$num_guia;
			}else if($busc==5){
				$guia_buscar="001-0".$num_guia;
			}

			$n_guia_o= $row['numero_guia'];
			$fecha_guia= date($row['fecha_guia']);
			$fecha_guia= str_replace(" 00:00:00.000", "", $fecha_guia);
			$id_cliente= $row['id_cliente'];
			$id_remitente= $row['id_remitente'];
			$id_empresa= $row['id_empresa'];
			$id_transporte= $row['id_transporte'];
			$fecha_traslado= date($row['fecha_traslado']);
			$fecha_traslado= str_replace(" 00:00:00.000", "", $fecha_traslado);
			$costo_minimo= number_format($row['costo_minimo'],2);
			$costo_minimo= str_replace(",", "", $costo_minimo);
			//para saber si fue asociado a una factura
			$add_fac= $row['add_fac'];

			//para borrar el detalle
			$num_guia_ori="";

			$sql_i1=" insert into t_guias values('$num_guia',CONVERT(datetime,'$fecha_guia',101),$id_cliente,$id_remitente,$id_empresa,$id_transporte,CONVERT(datetime,'$fecha_traslado',101),$costo_minimo,1,'$guia_buscar',$add_fac); ";
			$query_i1= odbc_exec($con, $sql_i1);

			$sql_deta=odbc_exec($con, " select * from detalle_guia where numero_guia='$n_guia_o'; ");
			while ($row_deta=odbc_fetch_array($sql_deta)) {
				$num_guia_ori= $row_deta['numero_guia'];
				$guia_det= $row_deta['guia_det'];
				$cantidad_det = $row_deta['cantidad_det'];
				$medida_det = $row_deta['medida_det'];
				$peso_det = $row_deta['peso_det'];

				$sql_i2=" insert into detalle_guia values('$num_guia','$guia_det','$cantidad_det','$medida_det','$peso_det'); ";
				$query_i2= odbc_exec($con, $sql_i2);
			}

			//borrando detalle original
			$sql_d1=" delete from detalle_guia where numero_guia='$num_guia_ori' ";

			//actualizando guia original
			$sql_u1=" update t_guias set id_cliente=0,id_remitente=0,id_empresa=0,id_transporte=0,costo_minimo=0,estado_guia=0,add_fac=0 where id_guia='$id_guia'  ";

			//si esta asociado a una factura se actualiza el id de la guia en el detalle de la factura
			if($add_fac=="1"){

				$n_id_guia=odbc_exec($con, " select * from t_guias where numero_guia='$num_guia' ");
				while ($row_nid=odbc_fetch_array($n_id_guia)) {
					$ig_guia_nuevo=intval($row_nid['id_guia']);
				}

				$sql_u2=" update detalle_factura set id_guia=$id_guia where id_guia=$id_guia; ";
				$upd2= odbc_exec($con, $sql_u2);
			}


		if ($query_d1= odbc_exec($con, $sql_d1) and $upd1= odbc_exec($con, $sql_u1)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Guía replicada exitosamente!
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo replicar la Guía
			</div>
			<?php
			
		}
	} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo replicar ésta guía. Se encuentra Inhabilitada. 
			</div>
			<?php
		}

	}
?>