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
	$active_facturas="active";
	$active_guias="";
	$active_clientes="";
	$active_remitentes="";
	$active_subcontrata="";
	$active_transportes="";
	$active_usuarios="";
	$active_tarifarios="";
	$title="Nueva Factura | Facturación GPA";

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
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
			<h4><i class='glyphicon glyphicon-edit'></i> Nueva Factura Almacenaje</h4>
		</div>
		<div class="panel-body">

					<form class="form-horizontal" method="post" id="datos_factura" name="datos_factura">

			<div id="resultados_ajax"></div>

			<div class="form-group row">

				<div class="form-group row">
					<label for="fecha_emision" class="col-md-1 control-label">Emisión</label>
						<div class="col-md-3">
							<input class="form-control input-sm" id="fecha_emision" name="fecha_emision" placeholder="Elegir fecha" type="text"/ readonly>
						</div>
				</div>
				<div class="form-group row">
					<label for="importe_fac" class="col-md-1 control-label">Importe</label>
						<div class="col-md-3">
				  			<input type="text" class="form-control input-sm" id="importe_fac" name="importe_fac" placeholder="Inhabilitado por factura almacenaje" readonly>
						</div>
				</div>
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

					<label for="dir_remitente" class="col-md-1 control-label"></label>
					<div class="col-md-3">
				  		<input type="hidden" class="form-control input-sm" id="dir_remitente" name="dir_remitente">
					</div>
				</div>

			</div>

			<br>

				    <!--<div class="container">-->
			<div id="table" class="table-editable">
				<span class="table-add glyphicon glyphicon-plus"></span>
			   	<table class="table" id="tab_guia">
			   		<tr>
			        	<th>Descripción</th>
				        <th>Importe</th>
						<th></th>
						<th></th>
					</tr>

					<tr class="hide">
						<td contenteditable="true"></td>
						<td contenteditable="true"></td>
						<td>
							<span class="table-remove glyphicon glyphicon-remove"></span>
						</td>
						<td>
							<span class="table-up glyphicon glyphicon-arrow-up"></span>
						    <span class="table-down glyphicon glyphicon-arrow-down"></span>
						</td>
					</tr>
				</table>
			</div>

				<br>

			<div class="col-md-12">
				<div class="pull-right">
					<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
				</div>
			</div>
		</form>

		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->
		</div>
	</div>
		  <div class="row-fluid">
			<div class="col-md-12">

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

    <script src="js/index.js"></script>
	<script type="text/javascript" src="js/nueva_facalmacen.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

	<script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

    <script>
		$(document).ready(function(){
			var date_input=$('input[name="fecha_emision"]'); //our date input has the name "date"
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
			var date_input=$('input[name="fecha_traslado"]'); //our date input has the name "date"
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
									minLength: 2,
									select: function(event, ui) {
										event.preventDefault();
										$('#id_remitente').val(ui.item.id_remitente);
										$('#nombre_remitente').val(ui.item.Raz_Social);
										$('#tel2').val(ui.item.telefono);
										$('#ruc2').val(ui.item.ruc);
										$('#id_remitente_bus').val(ui.item.id_remitente);
										$('#dir_remitente').val(ui.item.Dir_agrupada);
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
									$('#dir_remitente').val("");
								}
								if (event.keyCode==$.ui.keyCode.DELETE){
									$("#nombre_remitente" ).val("");
									$("#id_remitente" ).val("");
									$("#tel2" ).val("");
									$("#ruc2" ).val("");
									$("#id_remitente_bus").val("");
									$('#dir_remitente').val("");
								}
					});

	</script>
  </body>
</html>
