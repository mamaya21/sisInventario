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

	$active_guias="";
	$active_facturas="active";
	$active_clientes="";
	$active_remitentes="";
	$active_subcontrata="";
	$active_transportes="";
	$active_usuarios="";
	$active_tarifarios="";
	$title="Facturas | Facturación CIMEK";
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
			<h4><i class='glyphicon glyphicon-tasks'></i> Reporte Facturas</h4>
		</div>
			<div class="panel-body">
				<form class="form-horizontal" role="form" id="datos_cotizacion">

					<div class="form-group row">
					  <label for="nombre_remitente" class="col-md-1 control-label">Cliente</label>
					  <div class="col-md-3">
						  <input type="text" class="form-control input-sm" id="nombre_remitente" placeholder="Selecciona un cliente" required>
						  <input id="id_remitente" name="id_remitente" type='hidden'>
					  </div>
					  <label for="tel2" class="col-md-1 control-label">RUC</label>
								<div class="col-md-3">
									<input type="text" class="form-control input-sm" id="ruc2" name="ruc2" placeholder="RUC" readonly>
								</div>
						<label for="mail2" class="col-md-1 control-label">Teléfono</label>
								<div class="col-md-2">
									<input <input type="text" class="form-control input-sm" id="tel2" name="tel2" placeholder="Teléfono" readonly>
								</div>
				 	</div>

				 	<div class="form-group row">
				 	<label for="email" class="col-md-1 control-label">Importe</label>
							<div class="col-md-3">
								<select class='form-control input-sm' id="condiciones">
									<option value="1">Menor a </option>
									<option value="2">Menor o igual a </option>
									<option value="3">Igual a </option>
									<option value="4">Mayor a</option>
									<option selected value="5">Mayor o igual a</option>
								</select>
							</div>
						<div class="col-md-2">
				  			<input type="text" class="form-control input-sm" id="importe_fac" name="importe_fac" placeholder="Ingresar Importe" value="0" style="text-align: center;">
						</div>

					</div>

						<div class="form-group row">
				  	<label for="fecha_desde" class="col-md-1 control-label">Desde: </label>
						<div class="col-md-3">
							<input class="form-control input-sm" id="fecha_desde" name="fecha_desde" placeholder="Elegir fecha" type="text"/ readonly>
						</div>

					<label for="fecha_hasta" class="col-md-1 control-label">Hasta: </label>
							<div class="col-md-3">
								<input class="form-control input-sm" id="fecha_hasta" name="fecha_hasta" placeholder="Elegir fecha" type="text"/ readonly>
							</div>

							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1);'>
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
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/reporte.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

	<script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

    <script>
		$(document).ready(function(){
			var date_input=$('input[name="fecha_desde"]'); //our date input has the name "date"
			var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
			date_input.datepicker({
				format: 'yyyy/mm/dd',
				container: container,
				todayHighlight: true,
				autoclose: true,
			})
		})
	</script>

	<script>
		$(document).ready(function(){
			var date_input=$('input[name="fecha_hasta"]'); //our date input has the name "date"
			var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
			date_input.datepicker({
				format: 'yyyy/mm/dd',
				container: container,
				todayHighlight: true,
				autoclose: true,
			})
		})
	</script>

	<script>

		$(function() {
								$("#nombre_remitente").autocomplete({
									source: "./ajax/autocomplete/remitentes.php",
									minLength: 1,
									select: function(event, ui) {
										event.preventDefault();
										$('#id_remitente').val(ui.item.id_remitente);
										$('#nombre_remitente').val(ui.item.Raz_Social);
										$('#tel2').val(ui.item.telefono);
										$('#ruc2').val(ui.item.ruc);
										$('#id_remitente_bus').val(ui.item.id_remitente);
									 }
								});


							});

			$("#nombre_remitente" ).on( "keydown", function( event ) {
								if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
								{
									$("#id_remitente" ).val("");
									$("#tel2" ).val("");
									$("#ruc2" ).val("");
									$("#id_remitente_bus").val("");
								}
								if (event.keyCode==$.ui.keyCode.DELETE){
									$("#nombre_remitente" ).val("");
									$("#id_remitente" ).val("");
									$("#tel2" ).val("");
									$("#ruc2" ).val("");
									$("#id_remitente_bus").val("");
								}
					});

	</script>
  </body>
</html>
