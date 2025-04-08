<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['id_cliente'])) {
           $errors[] = "Cliente vacío";
        }else if (empty($_POST['id_remitente'])) {
           $errors[] = "Remitente vacío";
        }else if (empty($_POST['id_transporte'])) {
           $errors[] = "Transporte vacío";
        }else if (empty($_POST['res'])) {
           $errors[] = "No hay detalle de la Guía";
        }else if (
			!empty($_POST['id_cliente']) &&
			!empty($_POST['id_remitente']) &&
			!empty($_POST['id_transporte']) &&
			!empty($_POST['res'])){ 

		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$cliente=intval($_POST["id_cliente"]);
		$remitente=intval($_POST["id_remitente"]);
		$transporte=intval($_POST["id_transporte"]);
		$subempresa=intval($_POST["id_empresa"]);
		$fec_emision=$_POST["fecha_emision"];
		$fec_traslado=$_POST["fecha_traslado"];
		$costo_minimo=floatval($_POST["costo_minimo"])+0;

		/*$cliente=intval("0");
		$remitente=intval("0");
		$transporte=intval("0");
		$fec_emision="2016-10-31";
		$fec_traslado="2016/10/31";
		$costo_minimo=floatval("")+0;*/

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


		$arr_str=$_POST['res'];

		//$arr_str= "coca-5-FARDOS-9|inka-8-FARDOS-45 ";

			$array = explode("|", $arr_str);
		$cant= count($array);

		$des="";
		$can="";
		$med="";
		$p_tot="";
		$otro="";

		for ($i=0; $i <$cant-1 ; $i++) { 
			$array2= explode("/", $array[$i]);
			$des= $array2[0];
			$can= intval($array2[1]);
			$med= $array2[2];
			$p_tot= floatval($array2[3])+0;
			
			$sql2=" insert into detalle_guia values('$num_guia','$des',$can,'$med',$p_tot); ";
			$query_insert= odbc_exec($con, $sql2);
		}

		$sql="insert into t_guias values ('$num_guia',convert(date,'$fec_emision'),$cliente,$remitente,$subempresa,$transporte,convert(date,'$fec_traslado'),'$costo_minimo',1,'$guia_buscar',0)";
		$query_new_insert = odbc_exec($con,$sql);
			if ($query_new_insert){
				$messages[] = "Guía creada satisfactoriamente.";
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
				<meta http-equiv="refresh" content="1;URL=guias.php" >
				<?php
			}

?>