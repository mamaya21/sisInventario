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
	$active_usuarios="";
	$active_tarifarios="";
	$title="Nueva Guía | Facturación GPA";

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	if (isset($_GET['idguia']))
	{
		$idguia=intval($_GET['idguia']);
		$campos=" T.id_remitente, T.id_cliente, T.id_transporte, T.id_empresa, T.numero_guia,
			convert(varchar(10),T.fecha_guia,23) fecha_guia , convert(varchar(10),T.fecha_traslado,23) fecha_traslado, T.costo_minimo,
			R.nombre_remitente [Remitente], R.RUC [RUC_remite], R.Telefono [Tel_remite],
			D.nombre_cliente [Destinatario], D.RUC [RUC_destinatario], D.Telefono [Tel_destinatario],
			T2.placa [Tranporte], T2.lic_conducir [Licencia], T2.marca,
			S.nombre_empresa [Subcontrata], S.RUC [RUC_subcontra], S.Telefono [Tel_subcontrata] ";
		$query_consultarguia = "Select top 1 $campos
			From t_guias as T
				left outer join t_remitentes as R on R.id_remitente = T.id_remitente
				left outer join t_clientes as D on D.id_cliente = T.id_cliente
				left outer join t_transportes as T2 on T2.id_transporte = T.id_transporte
				left outer join t_subcontratadas as S on S.id_empresa = T.id_empresa
			Where T.id_guia = '".$idguia."'
			Order by id_guia desc; ";
		$sql_factura=odbc_exec($con,$query_consultarguia);

		while ($row = odbc_fetch_array($sql_factura)) {
			$e_numero_guia = $row['numero_guia'];

			$e_rem_id 			= $row['id_remitente'];
			$e_rem_nombre		= $row['Remitente'];
			$e_rem_ruc 			= $row['RUC_remite'];
			$e_rem_tel			= $row['Tel_remite'];

			$e_des_id 			= $row['id_cliente'];
			$e_des_nombre		= $row['Destinatario'];
			$e_des_ruc 			= $row['RUC_destinatario'];
			$e_des_tel			= $row['Tel_destinatario'];

			$e_tra_id 			= $row['id_transporte'];
			$e_tra_nombre		= $row['Tranporte'];
			$e_tra_licencia = $row['Licencia'];
			$e_tra_marca		= $row['marca'];

			$e_emp_id 			= $row['id_empresa'];
			$e_emp_nombre		= $row['Subcontrata'];
			$e_emp_ruc 			= $row['RUC_subcontra'];
			$e_emp_tel			= $row['Tel_subcontrata'];

			$e_fechaguia			= str_replace("-","/",$row['fecha_guia']);
			$e_fechatraslado	= str_replace("-","/",$row['fecha_traslado']);
			$e_costominimo		= floatval($row['costo_minimo']);

			$e_tabla ='';

			$e_cabecera = ' <div id="table" class="table-editable">
				<span class="table-add glyphicon glyphicon-plus"></span>
						<table class="table" id="tab_guia">
								<tr>
									<th>Descripción</th>
									<th>Cantidad</th>
									<th>Medida</th>
									<th>Peso Total</th>
									<th></th>
									<th></th>
								</tr> ';
			$e_cuerpo = '<tr class="hide">
											<td contenteditable="true"></td>
											<td contenteditable="true"></td>
											<td contenteditable="true">BULTOS</td>
											<td contenteditable="true"></td>
											<td>
												<span class="table-remove glyphicon glyphicon-remove"></span>
											</td>
											<td>
												<span class="table-up glyphicon glyphicon-arrow-up"></span>
												<span class="table-down glyphicon glyphicon-arrow-down"></span>
											</td>
										</tr>';

			$campos_deta=" id_detalle,numero_guia,guia_det,cantidad_det,medida_det,peso_det ";
			$query_consultardetalle = "Select $campos_deta
				From detalle_guia
				Where numero_guia = '".$e_numero_guia."'
				Order by id_detalle asc; ";
			$sql_detalle=odbc_exec($con,$query_consultardetalle);

			while ($row2 = odbc_fetch_array($sql_detalle)) {
					$e_cuerpo = $e_cuerpo. ' '.
									'<tr>
											<td contenteditable="true">'. $row2['guia_det'] .'</td>
											<td contenteditable="true">'. $row2['cantidad_det'] .'</td>
											<td contenteditable="true">'. $row2['medida_det'] .'</td>
											<td contenteditable="true">'. $row2['peso_det'] .'</td>
											<td>
												<span class="table-remove glyphicon glyphicon-remove"></span>
											</td>
											<td>
												<span class="table-up glyphicon glyphicon-arrow-up"></span>
												<span class="table-down glyphicon glyphicon-arrow-down"></span>
											</td>
										</tr>';
			}

			$e_cierre = '	</table> </div> ';

			$e_tabla = $e_cabecera . '' . $e_cuerpo .''. $e_cierre;

	 }
	}
	else
	{
		header("location: guias.php");
		exit;
	}
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
			<h4><i class='glyphicon glyphicon-edit'></i> Editar Guía</h4>
		</div>
		<div class="panel-body">

			<form class="form-horizontal" method="post" id="datos_editar" name="datos_editar">

			<div id="resultados_ajax"></div>



				<div class="form-group row">
				  <label for="nombre_remitente" class="col-md-1 control-label">Remitente</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_remitente" placeholder="Selecciona un remitente" required value="<?php echo $e_rem_nombre;?>">
					  <input id="id_remitente" name="id_remitente" type='hidden' value="<?php echo $e_rem_id;?>">
				  </div>
				  <label for="tel2" class="col-md-1 control-label">RUC</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="ruc2" name="ruc2" placeholder="RUC" readonly value="<?php echo $e_rem_ruc;?>">
							</div>
					<label for="mail2" class="col-md-1 control-label">Teléfono</label>
							<div class="col-md-2">
								<input <input type="text" class="form-control input-sm" id="tel2" name="tel2" placeholder="Teléfono" readonly value="<?php echo $e_rem_tel;?>">
							</div>
							<input id="idguia" name="idguia" type='hidden' value="<?php echo $idguia;?>">
							<input id="nroguia" name="nroguia" type='hidden' value="<?php echo $e_numero_guia;?>">
				</div>

				<div class="form-group row">
				  <label for="nombre_cliente" class="col-md-1 control-label">Destinatario</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_cliente" name="nombre_cliente" placeholder="Selecciona el destinatario final" required value="<?php echo $e_des_nombre;?>">
					  <input id="id_cliente" name="id_cliente" type='hidden' value="<?php echo $e_des_id;?>">
				  </div>
				  <label for="tel1" class="col-md-1 control-label">RUC</label>
					<div class="col-md-3">
						<input type="text" class="form-control input-sm" id="ruc1" name="ruc1" placeholder="RUC" readonly value="<?php echo $e_des_ruc;?>">
					</div>
					<label for="mail" class="col-md-1 control-label">Teléfono</label>
					<div class="col-md-2">
						<input type="text" class="form-control input-sm" id="tel1" name="tel1" placeholder="Teléfono" readonly value="<?php echo $e_des_tel;?>">
					</div>
				</div>

				 <div class="form-group row">
				  <label for="placa_transporte" class="col-md-1 control-label">Placa Transporte</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="placa_transporte" name="placa_transporte" placeholder="Selecciona un transporte" required value="<?php echo $e_tra_nombre;?>">
					  <input id="id_transporte" name="id_transporte" type='hidden' value="<?php echo $e_tra_id;?>">
				  </div>

				  <label for="licencia" class="col-md-1 control-label">Licencia</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="licencia" name="licencia" placeholder="Licencia" readonly value="<?php echo $e_tra_licencia;?>">
							</div>

				  <label for="marca1" class="col-md-1 control-label">Marca</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="marca1" name="marca1" placeholder="Marca" readonly value="<?php echo $e_tra_marca;?>">
							</div>

				 </div>

				 <div class="form-group row">
				  	<label for="fecha_emision" class="col-md-1 control-label">Fecha Emisión</label>
						<div class="col-md-3">
							<input class="form-control input-sm" id="fecha_emision" name="fecha_emision" placeholder="Elegir fecha" type="text"/ readonly value="<?php echo $e_fechaguia;?>">
						</div>

					<label for="fecha_traslado" class="col-md-1 control-label">Fecha Traslado</label>
							<div class="col-md-3">
								<input class="form-control input-sm" id="fecha_traslado" name="fecha_traslado" placeholder="Elegir fecha" type="text"/ readonly value="<?php echo $e_fechatraslado;?>">
							</div>

					<label for="costo_minimo" class="col-md-1 control-label">Costo Mínimo*</label>
						<div class="col-sm-2">
				  			<input type="text" class="form-control input-sm" id="costo_minimo" name="costo_minimo" placeholder="Campo Opcional" value="<?php echo $e_costominimo;?>">
						</div>

				 </div>

				 <div class="form-group row">
				  <label for="nombre_empresa" class="col-md-1 control-label">Sub-Contratada*</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_empresa" placeholder="Campo Opcional" value="<?php echo $e_emp_nombre;?>">
					  <input id="id_empresa" name="id_empresa" type='hidden' value="<?php echo $e_emp_id;?>">
				  </div>
				  <label for="ruc3" class="col-md-1 control-label">RUC</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="ruc3" name="ruc3" placeholder="RUC" readonly value="<?php echo $e_emp_ruc;?>">
							</div>
					<label for="tel3" class="col-md-1 control-label">Teléfono</label>
							<div class="col-md-2">
								<input <input type="text" class="form-control input-sm" id="tel3" name="tel3" placeholder="Teléfono" readonly value="<?php echo $e_emp_tel;?>">
							</div>
				 </div>

				 <br>

				 <!-- AQUI LA TABLA DE DETALLE -->
				 <?php echo $e_tabla; ?>

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
						<button type="submit" class="btn btn-primary" id="editar_datos">Editar</button>
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
							minLength: 1,
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
