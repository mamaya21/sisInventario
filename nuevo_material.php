<?php
	/*-------------------------
	Autor: Marco Amaya
	Web: https://marcoamayaquiroz.com/
	Mail: marco1021tam@gmail.com
	---------------------------*/
	session_start();
	error_reporting(0);
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	$action="";
	$active_stock= "";
	$active_movimientos="";
	$active_materiales="active";
	$active_tipos="";	
	$active_unidades="";
	$active_reportes = "";
	$active_usuarios="";

	$title="Nuevo Material";

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

    	<style type="text/css">
    		.btn-file {
			  position: relative;
			  overflow: hidden;
			  }
			.btn-file input[type=file] {
			    position: absolute;
			    top: 0;
			    right: 0;
			    min-width: 100%;
			    min-height: 100%;
			    font-size: 100px;
			    text-align: right;
			    filter: alpha(opacity=0);
			    opacity: 0;
			    outline: none;
			    background: white;
			    cursor: inherit;
			    display: block;
			}

			.btn-submit {
			  position: relative;
			  overflow: hidden;
			  }
			.btn-submit input[type=submit] {
			    position: absolute;
			    top: 0;
			    right: 0;
			    min-width: 100%;
			    min-height: 100%;
			    font-size: 100px;
			    text-align: right;
			    filter: alpha(opacity=0);
			    opacity: 0;
			    outline: none;
			    background: white;
			    cursor: inherit;
			    display: block;
			    background: #FF9900;
			}
    	</style>
  </head>
  <body>
  	<link rel="stylesheet" href="css/style.css">

	<?php
	include("navbar.php");
	?>

    <div class="container">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-edit'></i> Nuevo Material</h4>
			</div>


			<div class="panel-body">

				<form class="form-horizontal" method="post" id="datos_material" name="datos_material">
					<div id="resultados_ajax"></div>

					<div class="form-group">
						<label for="nombre" class="col-md-1 control-label">Nombre</label>
						<div class="col-md-5">
							<input type="text" class="form-control" id="nombre" name="nombre" required>
						</div>
					</div>

					<div class="form-group">
						<label for="descripcion" class="col-md-1 control-label">Descripcion</label>
						<div class="col-md-5">
							<textarea class="form-control" id="descripcion" name="descripcion" ></textarea>
						</div>
					</div>

					<div class="form-group">
						<label for="tipo_material" class="col-md-1 control-label">Tipo</label>
						<div class="col-md-5">
							<input type="text" class="form-control input-sm" id="tipo_material" placeholder="nombre tipo de material">
						</div>

						<label for="id_tipomaterial" class="col-md-1 control-label">Cod.</label>
						<div class="col-md-2">
							<input type="text" class="form-control input-sm" id="id_tipomaterial" name="id_tipomaterial" placeholder="Codigo" readonly>
							<input id="id_tipo" name="id_tipo" type='hidden'>
						</div>
				 	</div>

					<div class="form-group">
						<label for="unidad_medida" class="col-md-1 control-label">Unidad</label>
						<div class="col-md-5">
							<input type="text" class="form-control input-sm" id="unidad_medida" placeholder="Nombre unidad medida">
						</div>

						<label for="id_unidadmedida" class="col-md-1 control-label">Cod.</label>
						<div class="col-md-2">
							<input type="text" class="form-control input-sm" id="id_unidadmedida" name="id_unidadmedida" placeholder="Codigo" readonly>
							<input id="id_unidad" name="id_unidad" type='hidden'>
						</div>
				 	</div>

					<div class="form-group">
						<br>
						<div class="col-md-12">
							<div class="pull-left">
								<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
								<a  href="materiales.php" class="btn btn-info"><span class="glyphicon glyphicon-th-list" ></span> Lista de Materiales </a>
							</div>
						</div>	
				 	</div>

					 	

				</form>

			</div>
			<br>
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

	<script type="text/javascript" src="js/nuevo_material.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

	<script type="text/javascript">
		$(function() {
			$("#tipo_material").autocomplete({				
				source: "./ajax/autocomplete/tipo_materiales.php",
				minLength: 2,
				select: function(event, ui) {
					console.log("ui: "+ ui);
					event.preventDefault();
					$('#tipo_material').val(ui.item.nombre);
					$('#id_tipomaterial').val(ui.item.id_tipo);
					$('#id_tipo').val(ui.item.id_tipo);
				}
			});
		});

		$("#tipo_material" ).on( "keydown", function( event ) {
			if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
			{
				$("#id_tipomaterial" ).val("");
				$("#id_tipo" ).val("");

			}
				
			if (event.keyCode==$.ui.keyCode.DELETE){
				$("#tipo_material" ).val("");
				$("#id_tipomaterial" ).val("");
				$("#id_tipo" ).val("");
			}
		});

		$(function() {
			$("#unidad_medida").autocomplete({				
				source: "./ajax/autocomplete/unidad_medida.php",
				minLength: 2,
				select: function(event, ui) {
					console.log("ui: "+ ui);
					event.preventDefault();
					$('#unidad_medida').val(ui.item.nombre);
					$('#id_unidadmedida').val(ui.item.id_unidad);
					$('#id_unidad').val(ui.item.id_unidad);
				}
			});
		});

		$("#unidad_medida" ).on( "keydown", function( event ) {
			if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
			{
				$("#id_unidadmedida" ).val("");
				$("#id_unidad" ).val("");

			}
				
			if (event.keyCode==$.ui.keyCode.DELETE){
				$("#unidad_medida" ).val("");
				$("#id_unidadmedida" ).val("");
				$("#id_unidad" ).val("");
			}
		});
	</script>

  </body>
</html>
