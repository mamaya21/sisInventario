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
	$validation = false;

	if (isset($_GET['guias_str'])){
		//$id_guia=intval($_GET['id']);
		$str_guias 							= $_GET['guias_str'];
		$str_buscador 					= $_GET['buscador'];
		$otras_guias						= $_GET['otras_guias'];
		$otras_guias_buscador 	= $_GET['otras_guias_buscador'];

		$guias_arr = explode('|' , $str_guias);

		if($otras_guias_buscador != ''){
			for ($i = 0; $i < count($otras_guias_buscador); $i++){
				$guia_str_busca = $otras_guias_buscador[$i];
				if($str_buscador == ""){
					$str_buscador = $guia_str_busca . " | ";
				}else{
					$str_buscador = $str_buscador . " | " . $guia_str_busca;
				}
			}
		}

		$n_cons=0;

		$n_cons_sql=odbc_exec($con, " select (case when max(nro_consolidado) is null then '0' else max(nro_consolidado) end) nro_consolidado from t_consolidados; ");
		while ($row_cf=odbc_fetch_array($n_cons_sql)) {
			$n_cons=intval($row_cf['nro_consolidado']);
		}

		$n_cons = $n_cons + 1;

		if(count($guias_arr) > 0){
				for ($i = 0; $i < count($guias_arr); $i++){
					$id_guia 	= $guias_arr[$i];
					if($id_guia > 0){
						$sql_i1		= " insert into t_consolidados(id_guia,guias_str,fecha, nro_consolidado)
							values('$id_guia','$str_buscador', GETDATE(), $n_cons)  ";
						if ($insert1= odbc_exec($con, $sql_i1)){
							$validation = true;
						}else{
							$validation = false;
						}
					}

				}
		}else{
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No hay guías disponibles para generar el consolidado.
			</div>
			<?php
		}

		if($otras_guias != ''){
			if(count($otras_guias) > 0){
					for ($i = 0; $i < count($otras_guias); $i++){
						$id_guia 	= $otras_guias[$i];
						$sql_i2		= " insert into t_consolidados(id_guia,guias_str,fecha, nro_consolidado)
							values('$id_guia','$str_buscador', GETDATE(), $n_cons)  ";
						if ($insert2= odbc_exec($con, $sql_i2)){
							$validation = true;
						}else{
							$validation = false;
						}
					}
			}else{
				?>
				<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Error!</strong> No hay guías disponibles para generar el consolidado.
				</div>
				<?php
			}
		}


		if ($validation){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Consolidado generado exitosamente!
			</div>
			<?php
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo realizar el consolidado!
			</div>
			<?php

		}
	}
?>
