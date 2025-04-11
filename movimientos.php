<?php
	/*-------------------------
	Autor: Marco Amaya
	Web: -
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
	$active_movimientos="active";
	$active_materiales="";
	$active_tipos="";	
	$active_unidades="";
	$active_reportes = "";
	$active_usuarios="";

	$title="Ingresos / Salidas";
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

			.ui-autocomplete {
				z-index: 1051 !important; /* Bootstrap modal está en 1050 */
			}
    	</style>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>

    <div class="container">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="btn-group pull-right" style="padding-left:5px;">
					<a  href="stock.php" class="btn btn-info"><span class="glyphicon glyphicon-th-list" ></span> Ver STOCK </a>
			</div>

			<div class="btn-group pull-right" style="padding-left:5px;">
					<a  href="nuevo_movimiento.php" class="btn btn-info"><span class="glyphicon glyphicon-plus" ></span> Registrar Movimiento </a>
			</div>

			<h4><i class='glyphicon glyphicon-search'></i> Buscar Movimientos por Material</h4>
		</div>
		<div class="panel-body">

			<?php
				include("modal/editar_movimiento.php");
			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">

						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Material</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Nombre o código del material" onkeyup='load(1);'>
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

	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/movimientos.js"></script>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

	<script type="text/javascript">
		$(function() {
			$("#mod_material").autocomplete({				
				source: "./ajax/autocomplete/materiales.php",
				minLength: 2,
				select: function(event, ui) {
					console.log("ui: "+ ui);
					event.preventDefault();
					$('#mod_material').val(ui.item.nombre);
					$('#mod_idmaterial').val(ui.item.id_material);
					$('#mod_materialid').val(ui.item.id_material);
				}
			});
		});

		$("#mod_material" ).on( "keydown", function( event ) {
			if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
			{
				$("#mod_idmaterial" ).val("");
				$("#mod_materialid" ).val("");

			}
				
			if (event.keyCode==$.ui.keyCode.DELETE){
				$("#mod_material" ).val("");
				$("#mod_idmaterial" ).val("");
				$("#mod_materialid" ).val("");
			}
		});
	</script>
	

  </body>
</html>
