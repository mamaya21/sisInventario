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
		$id_factura=intval($_GET['id']);

		$queryx=odbc_exec($con, "select * from t_fac_almacenaje where id_factura='".$id_factura."'");

		$count=odbc_num_rows($queryx);
		$row= odbc_fetch_array($queryx);
		$estado= $row['estado_factura'];

		if ($estado=="1"){
			$n_fac=0;
			$n_fac_aumenta=0;
			$n_fac_real=0;

			$n_fac_sql=odbc_exec($con, " select n_fac_almacen from datos_fg; ");
			while ($row_cf=odbc_fetch_array($n_fac_sql)) {
				$n_fac=intval($row_cf['n_fac_almacen']);
			}

			$n_fac_aumenta_sql=odbc_exec($con, " select count(*) as aumenta from t_fac_almacenaje; ");
			while ($row_cfa=odbc_fetch_array($n_fac_aumenta_sql)) {
				$n_fac_aumenta=intval($row_cfa['aumenta']);
			}

			$n_fac_real=$n_fac+$n_fac_aumenta;

			$busc= strlen($n_fac_real);
			$factura_buscar="";
			if($busc==1){
				$factura_buscar="002-00000".$n_fac_real;
			}else if($busc==2){
				$factura_buscar="002-0000".$n_fac_real;
			}else if($busc==3){
				$factura_buscar="002-000".$n_fac_real;
			}else if($busc==4){
				$factura_buscar="002-00".$n_fac_real;
			}else if($busc==5){
				$factura_buscar="002-0".$n_fac_real;
			}

			$n_factura_o= $row['numero_factura'];
			$fecha_factura= date($row['fecha_factura']);
			$fecha_factura= str_replace(" 00:00:00.000", "", $fecha_factura);
			$id_cliente= $row['id_cliente'];
			$importe= number_format($row['importe'],2);
			$importe= str_replace(",", "", $importe);
			$igv= number_format($row['igv'],2);
			$igv= str_replace(",", "", $igv);
			$total= number_format($row['total'],2);
			$total= str_replace(",", "", $total);
			$buscador= $row['buscador'];
			$tipo= $row['tipo'];

			//para borrar el detalle
			$num_factura_ori="";

			$sql_i1="insert into t_fac_almacenaje values ('$n_fac_real',CONVERT(datetime,'$fecha_factura',101),$id_cliente,$importe,$igv,$total,'$factura_buscar','A',1)";

			$query_i1= odbc_exec($con, $sql_i1);

			$sql_deta=odbc_exec($con, " select * from detalle_fac_almacenaje where numero_factura='$n_factura_o'; ");
			while ($row_deta=odbc_fetch_array($sql_deta)) {
				$num_factura_ori= $row_deta['numero_factura'];
				$factura_det = $row_deta['factura_det'];
				$monto_guia= number_format($row_deta['monto_det'],2);
				$monto_guia= str_replace(",", "", $monto_guia);

				$sql_i2=" insert into detalle_fac_almacenaje values('$n_fac_real','$factura_det',$monto_guia); ";
				$query_i2= odbc_exec($con, $sql_i2);
			}

			//borrando detalle original
			$sql_d1=" delete from detalle_fac_almacenaje where numero_factura='$num_factura_ori' ";

			//actualizando guia original
			$sql_u1=" update t_fac_almacenaje set id_cliente=0,importe=0,igv=0,total=0,estado_factura=0 where id_factura='$id_factura'  ";

		if ($query_d1= odbc_exec($con, $sql_d1) and $upd1= odbc_exec($con, $sql_u1)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Factura replicada exitosamente!
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo replicar la Factura
			</div>
			<?php
			
		}
	} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo replicar ésta Factura. Se encuentra Inhabilitada. 
			</div>
			<?php
		}

	}
?>