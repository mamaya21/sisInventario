<?php
	/*-------------------------
	Autor: Marco Amaya
	Web: -
	Mail: marco1021tam@gmail.com
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

	$action="";
	$active_stock= "";
	$active_movimientos="";
	$active_materiales="";
	$active_tipos="";	
	$active_unidades="";
	$active_reportes = "active";
	$active_usuarios="";

	$title="Reportes";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <link rel='stylesheet' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
    <link rel='stylesheet' href='http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css'>

  	<script type="text/javascript" src="https://formden.com/static/cdn/formden.js"></script>
	<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
	<link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css"/>
	<?php include("head.php");?>

  </head>
  <body>
  <link rel="stylesheet" href="css/style.css">
	<?php
	include("navbar.php");
	?>
    <div class="container">
		<div class="panel panel-info">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-tasks'></i> Reportes Almacén</h4>
		</div>
			<div class="panel-body">
				<form class="form-horizontal" role="form" id="datos_cotizacion">

					<div class="form-group row">
				 		<label for="tiporeporte" class="col-md-1 control-label">Reporte</label>
						<div class="col-md-3">
							<select class='form-control input-sm' id="tiporeporte" name="tiporeporte" onchange="cambiarReporte(this)">
								<option selected value="0">--Seleccionar tipo de reporte--</option>
								<option value="1">Stock actual</option>
								<option value="2">Ingresos por fecha</option>
								<option value="3">Salidas por fecha</option>
								<option value="4">Movimientos por material</option>
								<option value="5">Movimientos por usuario</option>
								<option value="6">Kardex de entrada / salida</option>
								<option value="7">Top materiales más usados</option>
								<option value="8">Top materiales más ingresados</option>
								<option value="9">Materiles con bajo stock</option>
							</select>
						</div>
					</div>

					<div class="form-group row" id="control_fechas">
				  		<label for="fecha_desde" class="col-md-1 control-label">Desde: </label>
						<div class="col-md-3">
							<input class="form-control input-sm" id="fecha_desde" name="fecha_desde" placeholder="Elegir fecha" type="text" readonly>
						</div>

						<label for="fecha_hasta" class="col-md-1 control-label">Hasta: </label>
						<div class="col-md-3">
							<input class="form-control input-sm" id="fecha_hasta" name="fecha_hasta" placeholder="Elegir fecha" type="text" readonly>
						</div>
					</div>

					<div class="form-group row" id="control_material">
					  	<label for="material" class="col-md-1 control-label">Material</label>
					 	 <div class="col-md-3">
						  	<input type="text" class="form-control input-sm" id="material" placeholder="Seleccionar material" required>
					  	</div>
					  	<label for="id_material" class="col-md-1 control-label">Cod.</label>
						<div class="col-md-2">
							<input type="text" class="form-control input-sm" id="id_material" name="id_material" placeholder="Codigo" readonly>
							<input id="material_id" name="material_id" type='hidden'>
						</div>
				 	</div>

					<div class="form-group row" id="control_usuario">
					  	<label for="usuario" class="col-md-1 control-label">Usuario</label>
					 	 <div class="col-md-3">
						  	<input type="text" class="form-control input-sm" id="usuario" placeholder="Seleccionar usuario" required>
					  	</div>
					  	<label for="id_usuario" class="col-md-1 control-label">Cod.</label>
						<div class="col-md-2">
							<input type="text" class="form-control input-sm" id="id_usuario" name="id_usuario" placeholder="Codigo" readonly>
							<input id="material_id" name="material_id" type='hidden'>
						</div>
				 	</div>

					 <div class="form-group row">
					  	<label for="usuario" class="col-md-1 control-label"></label>
						<div class="col-md-3">
							<button type="button" class="btn btn-default" onclick='preload();'>
							<span class="glyphicon glyphicon-search" ></span> Buscar</button>
							<span id="loader"></span>
						</div>
				 	</div>
			</form>

				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
			</div>
		</div>

	</div>
	<hr>
	<?php
	include("footer.php");
	?>

	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
	<script src='http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js'></script>
	<script src='http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.6.0/underscore.js'></script>

	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/reportes.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

	<script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

    <script>
		$(document).ready(function(){

			//Validaciones control de reportes
			//primero nacen ocultos
			ocultarFiltros();

			var date_input=$('input[name="fecha_desde"]'); //our date input has the name "date"
			var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
			date_input.datepicker({
				format: 'yyyy/mm/dd',
				container: container,
				todayHighlight: true,
				autoclose: true,
			});

			var date_ouput=$('input[name="fecha_hasta"]'); //our date ouput has the name "date"
			var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
			date_ouput.datepicker({
				format: 'yyyy/mm/dd',
				container: container,
				todayHighlight: true,
				autoclose: true,
			})
		});
	</script>


	<script type="text/javascript">
		$(function() {
			$("#material").autocomplete({				
				source: "./ajax/autocomplete/materiales.php",
				minLength: 2,
				select: function(event, ui) {
					console.log("ui: "+ ui);
					event.preventDefault();
					$('#material').val(ui.item.nombre);
					$('#id_material').val(ui.item.id_material);
					$('#material_id').val(ui.item.id_material);
				}
			});
		});

		$("#material" ).on( "keydown", function( event ) {
			if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
			{
				$("#id_material" ).val("");
				$("#material_id" ).val("");

			}
				
			if (event.keyCode==$.ui.keyCode.DELETE){
				$("#material" ).val("");
				$("#id_material" ).val("");
				$("#material_id" ).val("");
			}
		});

		function ocultarFiltros(){
			document.getElementById('control_fechas').style.display = 'none';
			document.getElementById('control_material').style.display = 'none';
			document.getElementById('control_usuario').style.display = 'none';
		}

		function cambiarReporte(select){

			const valor = select.value;

			switch (valor) {
				case "2":
					ocultarFiltros();
					document.getElementById('control_fechas').style.display = 'flex';
					break;
				case "3":
					ocultarFiltros();
					document.getElementById('control_fechas').style.display = 'flex';
					break;
				case "4":
					ocultarFiltros();
					document.getElementById('control_material').style.display = 'flex';
					break;
				case "5":
					ocultarFiltros();
					document.getElementById('control_usuario').style.display = 'flex';
					break;
				default:
					console.log("Ningún reporte válido seleccionado");
					ocultarFiltros();
					break;
			}

			if (tipo_reporte === "0") {
				
			} else if(tipo_reporte === "1" || tipo_reporte === "2") {
				debugger;
				
			}
		}

	</script>
	


  </body>
</html>
