<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
		if (empty($_POST['id_remitente'])) {
           $errors[] = "cliente vacío";
        }else if (empty($_POST['fecha_emision'])) {
           $errors[] = "No seleccionó la fecha de emisión de la Factura";
        }else if (
			!empty($_POST['id_remitente']) &&
			!empty($_POST['fecha_emision']) 
			){ 

		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$remitente=$_POST["id_remitente"];
		$fec_emision=$_POST["fecha_emision"];
		$dir_agr=$_POST["dir_remitente"];

		/*$cliente=intval("0");
		$remitente=intval("0");
		$transporte=intval("0");
		$fec_emision="2016-10-31";
		$fec_traslado="2016/10/31";
		$costo_minimo=floatval("")+0;*/

		$id_remitente_sel=odbc_exec($con, " select id_remitente from t_remitentes where Dir_agrupada='$dir_agr' and Raz_Social='$remitente' and direccion='$dir_agr' ");
		$id_remitente_v_agr=0;
		while ($row_dv=odbc_fetch_array($id_remitente_sel)) {
			$id_remitente_v_agr=intval($row_dv['id_remitente']);
		}

		$n_fac=0;
		$n_fac_aumenta=0;
		$n_fac_real=0;
		$importe_fac=0;

		$n_fac_sql=odbc_exec($con, " select n_factura from datos_fg; ");
		while ($row_cf=odbc_fetch_array($n_fac_sql)) {
			$n_fac=intval($row_cf['n_factura']);
		}

		$n_fac_aumenta_sql=odbc_exec($con, " select count(*) as aumenta from t_facturas; ");
		while ($row_cfa=odbc_fetch_array($n_fac_aumenta_sql)) {
			$n_fac_aumenta=intval($row_cfa['aumenta']);
		}

		$n_fac_real=$n_fac+$n_fac_aumenta;

		$n_imp_sql=odbc_exec($con, " select SUM(CONVERT(decimal(8,2),monto_guia)) as suma from detalle_factura where numero_factura=$n_fac_real; ");
		while ($row_ti=odbc_fetch_array($n_imp_sql)) {
			$importe_fac=number_format(($row_ti['suma']),2);
			$importe_fac=str_replace(',', '', $importe_fac);
		}


		$busc= strlen($n_fac_real);
		$factura_buscar="";
		if($busc==1){
			$factura_buscar="001-00000".$n_fac_real;
		}else if($busc==2){
			$factura_buscar="001-0000".$n_fac_real;
		}else if($busc==3){
			$factura_buscar="001-000".$n_fac_real;
		}else if($busc==4){
			$factura_buscar="001-00".$n_fac_real;
		}else if($busc==5){
			$factura_buscar="001-0".$n_fac_real;
		}

		$IGV=18;
		$total_igv=($importe_fac * $IGV )/100;
		$total_igv=number_format($total_igv,2);
		$total_igv=str_replace(',', '', $total_igv);

		$total_fac=$total_igv + $importe_fac;
		$total_fac=number_format($total_fac,2);
		$total_fac=str_replace(',', '', $total_fac);

		//$importe_fac=str_replace(',', '', $importe_fac);


	$sql="insert into t_facturas values ('$n_fac_real',convert(date,'$fec_emision'),$id_remitente_v_agr,$importe_fac,$total_igv,$total_fac,'$factura_buscar','D',1)";
		$query_new_insert = odbc_exec($con,$sql);
			if ($query_new_insert){
				$messages[] = "Factura generada satisfactoriamente con el número $factura_buscar";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.";
			}
		} else {
			$errors []= "Error desconocido.";
		}
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<meta http-equiv="refresh" content="1;URL=facturas_detalladas.php" >
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<meta http-equiv="refresh" content="1;URL=facturas_detalladas.php" >
				<?php
			}

?>