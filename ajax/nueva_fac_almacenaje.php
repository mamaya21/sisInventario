<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['id_remitente'])) {
           $errors[] = "Remitente vacío";
        }else if (empty($_POST['res'])) {
           $errors[] = "No hay detalle de la Guía";
        }else if (
			!empty($_POST['id_remitente']) &&
			!empty($_POST['res'])){ 

		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

		//$cliente=intval($_POST["id_cliente"]);
		$remitente=$_POST["id_remitente"];
		//$transporte=intval($_POST["id_transporte"]);
		//$subempresa=intval($_POST["id_empresa"]);
		$fec_emision=$_POST["fecha_emision"];
		//$fec_traslado=$_POST["fecha_traslado"];
		//$costo_minimo=floatval($_POST["costo_minimo"])+0;
		$dir_agr=$_POST["dir_remitente"];


		$n_fac=0;
		$n_fac_aumenta=0;
		$num_guia=0;

		$n_fac_sql=odbc_exec($con, " select n_fac_almacen from datos_fg; ");
		while ($row_cf=odbc_fetch_array($n_fac_sql)) {
			$n_fac=intval($row_cf['n_fac_almacen']);
		}

		$n_fac_aumenta_sql=odbc_exec($con, " select count(*) as aumenta from t_fac_almacenaje; ");
		while ($row_cfa=odbc_fetch_array($n_fac_aumenta_sql)) {
			$n_fac_aumenta=intval($row_cfa['aumenta']);
		}

		$num_guia=$n_fac+$n_fac_aumenta;

		$busc= strlen($num_guia);
		$guia_buscar="";
		if($busc==1){
			$guia_buscar="002-00000".$num_guia;
		}else if($busc==2){
			$guia_buscar="002-0000".$num_guia;
		}else if($busc==3){
			$guia_buscar="002-000".$num_guia;
		}else if($busc==4){
			$guia_buscar="002-00".$num_guia;
		}else if($busc==5){
			$guia_buscar="002-0".$num_guia;
		}


		$arr_str=$_POST['res'];

		//$arr_str= "coca-5-FARDOS-9|inka-8-FARDOS-45 ";

			$array = explode("|", $arr_str);
		$cant= count($array);

		$des="";
		$can="";
		$suma_can=0;
		
		$otro="";

		for ($i=0; $i <$cant-1 ; $i++) { 
			$array2= explode("/", $array[$i]);
			$des= $array2[0];
			$can= floatval($array2[1]+0);
			$suma_can=floatval($suma_can)+$can;
			$sql2=" insert into detalle_fac_almacenaje values('$num_guia','$des',$can); ";
			$query_insert= odbc_exec($con, $sql2);
		}

		$id_remitente_sel=odbc_exec($con, " select id_remitente from t_remitentes where Dir_agrupada='$dir_agr' and Raz_Social='$remitente' and direccion='$dir_agr' ");
		$id_remitente_v_agr=0;
		while ($row_dv=odbc_fetch_array($id_remitente_sel)) {
			$id_remitente_v_agr=intval($row_dv['id_remitente']);
		}

		$IGV=18;
		$total_igv=($suma_can * $IGV )/100;
		$total_igv=number_format($total_igv,2);
		$total_igv=str_replace(',', '', $total_igv);

		$total_fac=$total_igv + $suma_can;
		$total_fac=number_format($total_fac,2);
		$total_fac=str_replace(',', '', $total_fac);

		$sql="insert into t_fac_almacenaje values ('$num_guia',convert(date,'$fec_emision'),$id_remitente_v_agr,$suma_can,$total_igv,$total_fac,'$guia_buscar','A',1)";

		$query_new_insert = odbc_exec($con,$sql);
			if ($query_new_insert){
				$messages[] = "Factura creada satisfactoriamente.";
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
			<meta http-equiv="refresh" content="1;URL=guias.php" >
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
				<meta http-equiv="refresh" content="1;URL=facturas_almacenaje.php" >
				<?php
			}

?>