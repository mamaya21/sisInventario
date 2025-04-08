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
	$active_facturas="";
	$active_guias="active";
	$active_clientes="";
	$active_remitentes="";
	$active_subcontrata="";
	$active_transportes="";
	$active_tarifarios="";
	$active_usuarios="";
	$title="Nueva Guía | Facturación GPA";

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
			<h4><i class='glyphicon glyphicon-edit'></i> Nueva Guía</h4>
		</div>
		<div class="panel-body">

			<form class="form-horizontal" method="post" id="datos_factura" name="datos_factura">

			<div id="resultados_ajax"></div>

			<div class="form-group row">
				  <label for="nombre_remitente" class="col-md-1 control-label">Remitente</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_remitente" placeholder="Selecciona un remitente" required>
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
				  <label for="nombre_cliente" class="col-md-1 control-label">Destinatario</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_cliente" name="nombre_cliente" placeholder="Selecciona el destinatario final" required>
					  <input id="id_cliente" name="id_cliente" type='hidden'>
				  </div>
				  <label for="tel1" class="col-md-1 control-label">RUC</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="ruc1" name="ruc1" placeholder="RUC" readonly>
							</div>
					<label for="mail" class="col-md-1 control-label">Teléfono</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="tel1" name="tel1" placeholder="Teléfono" readonly>
							</div>
				 </div>

				 <div class="form-group row">
				  <label for="placa_transporte" class="col-md-1 control-label">Placa Transporte</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="placa_transporte" name="placa_transporte" placeholder="Selecciona un transporte" required>
					  <input id="id_transporte" name="id_transporte" type='hidden'>
				  </div>

				  <label for="licencia" class="col-md-1 control-label">Licencia</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="licencia" name="licencia" placeholder="Licencia" readonly>
							</div>

				  <label for="marca1" class="col-md-1 control-label">Marca</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="marca1" name="marca1" placeholder="Marca" readonly>
							</div>

				 </div>

				 <div class="form-group row">
				  	<label for="fecha_emision" class="col-md-1 control-label">Fecha Emisión</label>
						<div class="col-md-3">
							<input class="form-control input-sm" id="fecha_emision" name="fecha_emision" placeholder="Elegir fecha" type="text"/ readonly>
						</div>

					<label for="fecha_traslado" class="col-md-1 control-label">Fecha Traslado</label>
							<div class="col-md-3">
								<input class="form-control input-sm" id="fecha_traslado" name="fecha_traslado" placeholder="Elegir fecha" type="text"/ readonly>
							</div>

					<label for="costo_minimo" class="col-md-1 control-label">Costo Mínimo*</label>
						<div class="col-sm-2">
				  			<input type="text" class="form-control input-sm" id="costo_minimo" name="costo_minimo" placeholder="Campo Opcional">
						</div>

				 </div>

				 <div class="form-group row">
				  <label for="nombre_empresa" class="col-md-1 control-label">Sub-Contratada*</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_empresa" placeholder="Campo Opcional">
					  <input id="id_empresa" name="id_empresa" type='hidden'>
				  </div>
				  <label for="ruc3" class="col-md-1 control-label">RUC</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="ruc3" name="ruc3" placeholder="RUC" readonly>
							</div>
					<label for="tel3" class="col-md-1 control-label">Teléfono</label>
							<div class="col-md-2">
								<input <input type="text" class="form-control input-sm" id="tel3" name="tel3" placeholder="Teléfono" readonly>
							</div>
				 </div>

				 <br>

				    <!--<div class="container">-->
						<div id="table" class="table-editable">
							<span class="table-add glyphicon glyphicon-plus"></span>
						    	<table class="table" id="tab_guia">
						      		<tr>
							        	<th>Descripción</th>
								        <th>Cantidad</th>
								        <th>Medida</th>
								        <th>Peso Total</th>
								        <th></th>
								        <th></th>
						      		</tr>

						      <!-- This is our clonable table line -->
						      		<tr class="hide">
								        <td contenteditable="true"></td>
								        <td contenteditable="true"></td>
								        <td contenteditable="true">BULTOS</td>
								        <!--<select class="form-control input-sm" id="medidas" name="medidas">
								        <?php
								        $sql_medida=odbc_exec($con," select * from t_medidas ");
										while ($rw=odbc_fetch_array($sql_medida)){
										$id_medida=$rw["id_medida"];
										$medida=rtrim($rw["medida"]);
										if ($medida=="-"){
											$selected="selected";
										} else {
											$selected="";
										}
										?>
										<option value="<?php echo $medida?>" <?php echo $selected;?>><?php echo $medida?></option>
										<?php
										}
										?>
										</select>-->

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

						  <!--<button id="export-btn" class="btn btn-primary">Export Data</button>
						  <p id="export"></p>-->
				<!--</div>-->

				<br>

				<div class="col-md-12">
					<div class="pull-right">
						<!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#nuevoProducto">
						 <span class="glyphicon glyphicon-plus"></span> Nuevo producto
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#nuevoCliente">
						 <span class="glyphicon glyphicon-user"></span> Nuevo cliente
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>-->

						<!--<button type="submit" class="btn btn-default" name="add_guia">
						 <span class="glyphicon glyphicon-floppy-disk"></span> Agregar guía
						</button>-->
						<!--<button type="submit" class="btn btn-default">
						<button type="submit" class="boton">
						  <span class="glyphicon glyphicon-print"></span> Imprimir
						</button>-->
						<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
						<!--<input type="submit" value="Guardar datos" name="B1">-->
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

	<!--<script type="text/javascript" src="js/VentanaCentrada.js"></script>-->
	<script type="text/javascript" src="js/nueva_guia.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <!-- Include jQuery -->
	<!--<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>-->
	<!-- Include Date Range Picker -->
	<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>-->
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
						$("#nombre_cliente").autocomplete({
							source: "./ajax/autocomplete/clientes.php",
							minLength: 2,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_cliente').val(ui.item.id_cliente);
								$('#nombre_cliente').val(ui.item.nombre_cliente);
								$('#tel1').val(ui.item.telefono);
								$('#ruc1').val(ui.item.ruc);

							 }
						});


					});

	$("#nombre_cliente" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#ruc1" ).val("");

						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_cliente" ).val("");
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#ruc1" ).val("");
						}
			});

			$(function() {
								$("#nombre_remitente").autocomplete({
									source: "./ajax/autocomplete/remitentes_guia.php",
									minLength: 2,
									select: function(event, ui) {
										event.preventDefault();
										$('#id_remitente').val(ui.item.id_remitente);
										$('#nombre_remitente').val(ui.item.nombre_remitente);
										$('#tel2').val(ui.item.telefono);
										$('#ruc2').val(ui.item.ruc);

									 }
								});


							});

			$("#nombre_remitente" ).on( "keydown", function( event ) {
								if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
								{
									$("#id_remitente" ).val("");
									$("#tel2" ).val("");
									$("#ruc2" ).val("");

								}
								if (event.keyCode==$.ui.keyCode.DELETE){
									$("#nombre_remitente" ).val("");
									$("#id_remitente" ).val("");
									$("#tel2" ).val("");
									$("#ruc2" ).val("");
								}
					});

			$(function() {
								$("#placa_transporte").autocomplete({
									source: "./ajax/autocomplete/transportes.php",
									minLength: 2,
									select: function(event, ui) {
										event.preventDefault();
										$('#id_transporte').val(ui.item.id_transporte);
										$('#placa_transporte').val(ui.item.placa_transporte);
										$('#marca1').val(ui.item.marca);
										$('#licencia').val(ui.item.licencia);

									 }
								});


							});

			$("#placa_transporte" ).on( "keydown", function( event ) {
								if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
								{
									$("#id_transporte" ).val("");
									$("#marca1" ).val("");
									$("#licencia" ).val("");

								}
								if (event.keyCode==$.ui.keyCode.DELETE){
									$("#placa_transporte" ).val("");
									$("#id_transporte" ).val("");
									$("#marca1" ).val("");
									$("#licencia" ).val("");
								}
					});

			$(function() {
								$("#nombre_empresa").autocomplete({
									source: "./ajax/autocomplete/subcontratadas.php",
									minLength: 2,
									select: function(event, ui) {
										event.preventDefault();
										$('#id_empresa').val(ui.item.id_empresa);
										$('#nombre_empresa').val(ui.item.nombre_empresa);
										$('#ruc3').val(ui.item.ruc);
										$('#tel3').val(ui.item.telefono);

									 }
								});


							});

			$("#nombre_empresa" ).on( "keydown", function( event ) {
								if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
								{
									$("#id_empresa" ).val("");
									$("#ruc3" ).val("");
									$("#tel3" ).val("");

								}
								if (event.keyCode==$.ui.keyCode.DELETE){
									$("#nombre_empresa" ).val("");
									$("#id_empresa" ).val("");
									$("#ruc3" ).val("");
									$("#tel3" ).val("");
								}
					});

	</script>
  </body>
</html>
