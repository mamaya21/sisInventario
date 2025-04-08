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

	$active_guias="active";
	$active_facturas="";
	$active_clientes="";
	$active_remitentes="";
	$active_subcontrata="";
	$active_transportes="";
	$active_usuarios="";
	$active_tarifarios="";
	$title="Guías | Facturación CIMEK";
?>
<!DOCTYPE html>
<html lang="en">
  <head>

	<?php include("head.php");?>

  </head>
  <body>
	<?php
	include("navbar.php");
	?>
    <div class="container">
		<div class="panel panel-info">
		<div class="panel-heading">

			<div class="btn-group pull-right">
				<a  href="guias.php" class="btn btn-info"><span class="glyphicon glyphicon-th-list" ></span> Ir a Guias </a>
			</div>

			<h4><i class='glyphicon glyphicon-search'></i> Buscar Consolidados</h4>
		</div>
			<div class="panel-body">

				<?php
					include("modal/editar_guias.php");
				?>

				<form class="form-horizontal" role="form" id="datos_cotizacion">

							<div class="form-group row">
								<label for="q" class="col-md-2 control-label"> Búsqueda</label>
								<div class="col-md-5">
									<input type="text" class="form-control" id="q" placeholder="Nro. de consolidado" onkeyup='load(1);'>
								</div>

								<div class="col-md-3">
									<button type="button" class="btn btn-default" onclick='load(1);'>
										<span class="glyphicon glyphicon-search" ></span> Buscar </button>
										<span id="loader"></span>
								</div>

							</div>

							<div class="form-group row">
						  	<label for="fecha_desde" class="col-md-2 control-label">Desde: </label>
								<div class="col-md-3">
									<input class="form-control input-sm" id="fecha_desde" name="fecha_desde" placeholder="Elegir fecha" type="text"/ readonly>
								</div>

								<label for="fecha_hasta" class="col-md-2 control-label">Hasta: </label>
								<div class="col-md-3">
									<input class="form-control input-sm" id="fecha_hasta" name="fecha_hasta" placeholder="Elegir fecha" type="text"/ readonly>
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
	<script src="js/index.js"></script>

	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/consolidados.js"></script>

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
			});

			var date_hasta=$('input[name="fecha_hasta"]'); //our date input has the name "date"
			var contenido=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
			date_hasta.datepicker({
				format: 'yyyy/mm/dd',
				container: contenido,
				todayHighlight: true,
				autoclose: true,
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
	})
	</script>
  </body>
</html>
