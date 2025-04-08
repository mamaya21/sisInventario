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


		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

		$cliente=intval($_POST["id_cliente"]);
		$remitente=intval($_POST["id_remitente"]);
		$transporte=intval($_POST["id_transporte"]);
		$subempresa=intval($_POST["id_empresa"]);
		$fec_emision=$_POST["fecha_emision"];
		$fec_traslado=$_POST["fecha_traslado"];
		$costo_minimo=floatval($_POST["costo_minimo"])+0;
		//RELACIONES DE LA GUIA
		$num_guia= intval($_POST["nroguia"]);
		$id_guia = intval($_POST["idguia"]);

		$arr_str=$_POST['res'];

		$array = explode("|", $arr_str);
		$cant= count($array);

		$des="";
		$can="";
		$med="";
		$p_tot="";
		$otro="";

		if($cant > 0){
			$sql_prev=" delete from detalle_guia where numero_guia = $num_guia; ";
			$query_prev= odbc_exec($con, $sql_prev);
		}

		for ($i=0; $i <$cant-1 ; $i++) {
			$array2= explode("/", $array[$i]);
			$des= $array2[0];
			$can= intval($array2[1]);
			$med= $array2[2];
			$p_tot= floatval($array2[3])+0;

			$sql2=" insert into detalle_guia values('$num_guia','$des',$can,'$med',$p_tot); ";
			$query_insert= odbc_exec($con, $sql2);
		}

		$sql="Update t_guias
					set numero_guia = '$num_guia', fecha_guia = convert(date,'$fec_emision'), id_cliente = $cliente, id_remitente = $remitente,
							id_empresa = $subempresa, id_transporte = $transporte, fecha_traslado = convert(date,'$fec_traslado'), costo_minimo = '$costo_minimo'
					Where id_guia = $id_guia; ";
		$query_new_insert = odbc_exec($con,$sql);
			if ($query_new_insert){
				$messages[] = "Guía actualizada satisfactoriamente.";
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
