<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['id_consolidado'])) {
           $errors[] = "No hay consolidado seleccionado.";
        }else if (empty($_POST['guias_str'])) {
           $errors[] = "Guías no seleccionadas.";
        }else if (empty($_POST['buscador'])) {
           $errors[] = "Guías no seleccionadas.";
        }else if (
					!empty($_POST['id_consolidado']) &&
					!empty($_POST['guias_str']) &&
					!empty($_POST['buscador'])
				){


		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

		$validation = false;

		$id_consolidado=intval($_POST["id_consolidado"]);
		//RELACIONES DE LA GUIA
		$guias_str= $_POST["guias_str"];
		$buscador = $_POST["buscador"];

		$array = explode("|", $guias_str);
		$cant= count($array);

		if($cant > 0){
			$sql_prev=" delete from t_consolidados where nro_consolidado = $id_consolidado; ";
			$query_prev= odbc_exec($con, $sql_prev);
		}

		if(count($array) > 0){

				if($cant > 0){
					$sql_prev=" delete from t_consolidados where nro_consolidado = $id_consolidado; ";
					$query_prev= odbc_exec($con, $sql_prev);
				}

				for ($i = 0; $i < count($array); $i++){
					$id_guia 	= $array[$i];
					$sql_i1		= " insert into t_consolidados(id_guia,guias_str,fecha, nro_consolidado)
						values('$id_guia','$buscador', GETDATE(), $id_consolidado)  ";
					if ($insert1= odbc_exec($con, $sql_i1)){
						$validation = true;
					}else{
						$validation = false;
					}
				}
		}else{
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No hay disponibles para generar el consolidado.
			</div>
			<?php
		}

		if ($validation){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Consolidado actualizado exitosamente!
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
