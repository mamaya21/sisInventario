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
	$active_movimientos="";
	$active_materiales="active";
	$active_tipos="";	
	$active_unidades="";
	$active_reportes = "";
	$active_usuarios="";
	
	$title="Gestión de materiales";
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
					<a  href="tipoMateriales.php" class="btn btn-info"><span class="glyphicon glyphicon-th-list" ></span> Tipo de Materiales </a>
			</div>

			<div class="btn-group pull-right" style="padding-left:5px;">
					<a  href="nuevo_material.php" class="btn btn-info"><span class="glyphicon glyphicon-plus" ></span> Nuevo Material </a>
			</div>

			<h4><i class='glyphicon glyphicon-search'></i> Buscar Materiales</h4>
		</div>
		<div class="panel-body">

			<?php
				include("modal/editar_material.php");
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


		<!-- <form name="importa" method="post" action="<?php echo $_SERVER['PHP_SELF'] ; ?>" enctype="multipart/form-data" >

			<p4 style="padding-left: 15px;"><b>Carga Masiva : </b></p4>
			<a href="plantillas/PLANTILLA REMITENTES (CLIENTES).xlsx" download="PLANTILLA REMITENTES (CLIENTES)" style="padding-right: 15px;padding-left: 5px;">
			Descargar Plantilla
			<img src="img/excel.png"/> </a>
			<span class="btn btn-default btn-file"> Cargar Plantilla <input type="file" class="btn btn-info" name="excel" style="background: white; padding-right: 5px;"></span>
			<span class="btn btn-default btn-submit" style="background: #FF9900;"> Importar <input type="submit" class="btn btn-info" name="enviar" value="Importar" /></span>
	        <input type="hidden" class="btn btn-info" value="upload" name="action" />
    	</form> -->

	<?php
    extract($_POST);

    if ($action == "upload") {
    	$msg="";
         $archivo = $_FILES['excel']['name'];
        $tipo = $_FILES['excel']['type'];
        $destino = "bak_" . $archivo;
        if (copy($_FILES['excel']['tmp_name'], $destino)){
            $msg="Archivo Cargado Correctamente";
        }
        else{
            $msg="Error Al Cargar el Archivo";
        }
        if (file_exists("bak_" . $archivo)) {
            /** Clases necesarias */
            require_once('Classes/PHPExcel.php');
            require_once('Classes/PHPExcel/Reader/Excel2007.php');
            // Cargando la hoja de cálculo
            $objReader = new PHPExcel_Reader_Excel2007();
            $objPHPExcel = $objReader->load("bak_" . $archivo);
            $objFecha = new PHPExcel_Shared_Date();
            // Asignar hoja de excel activa
            $objPHPExcel->setActiveSheetIndex(0);
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            $arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet

            // Llenamos el arreglo con los datos  del archivo xlsx
            for ($i = 15; $i <= $arrayCount; $i++) {

            	$_DATOS_EXCEL[$i]['nombre'] = utf8_decode($objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue());
            	$_DATOS_EXCEL[$i]['ruc'] =  utf8_decode($objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue());
            	$_DATOS_EXCEL[$i]['direccion'] =  utf8_decode($objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue());
            	$_DATOS_EXCEL[$i]['telefono'] =  utf8_decode($objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue());
            	$_DATOS_EXCEL[$i]['razon social'] =  utf8_decode($objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue());
            	$_DATOS_EXCEL[$i]['contacto'] =  utf8_decode($objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue());
            	$_DATOS_EXCEL[$i]['email'] =  utf8_decode($objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue());
            	$_DATOS_EXCEL[$i]['estado'] =  utf8_decode($objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue());
            	$_DATOS_EXCEL[$i]['fecha'] = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
            }
        }
        //si por algo no cargo el archivo bak_
        else {
            //echo "Necesitas primero importar el archivo";
        }
        $errores = 0;
        $bien= 0;
        //recorremos el arreglo multidimensional
        //para ir recuperando los datos obtenidos
        //del excel e ir insertandolos en la BD
        foreach ($_DATOS_EXCEL as $campo => $valor) {
            $sql = "insert into t_remitentes values ('";
            foreach ($valor as $campo2 => $valor2) {
                $campo2 == "fecha" ? $sql.= $valor2 . "');" : $sql.= $valor2 . "','";
            }
            //echo $sql;
            $result = odbc_exec($con, $sql);
            if (!$result) {
                //echo " Error al insertar registro " . $campo;
                $errores+=1;
            }else{
                $bien+=1;
            }
        }

        if($msg=="Archivo Cargado Correctamente"){

        	?>
        	<br>
        	<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho! ARCHIVO IMPORTADO CON EXITO, <?php echo $bien;?> CORRECTOS Y <?php echo $errores;?> ERRORES</strong>
				</div>
				<?php

        }else if($msg=="Error Al Cargar el Archivo"){

        	?>
        	<br>
        	<div class="alert alert-danger" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Error! OCURRIO UN ERROR AL CARGAR EL ARCHIVO</strong>
				</div>
				<?php

        }else{

        	?>
        	<br>
        	<div class="alert alert-danger" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Error! EL ARCHIVO NO TIENE LA EXTENSION REQUERIDA</strong>
				</div>
				<?php

        }

        ?>
		<?php
        //una vez terminado el proceso borramos el archivo que esta en el servidor el bak_
        unlink($destino);
    }
    ?>
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
	<script type="text/javascript" src="js/materiales.js"></script>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

	<script type="text/javascript">
		$(function() {
			$("#mod_tipomaterial").autocomplete({				
				source: "./ajax/autocomplete/tipo_materiales.php",
				minLength: 2,
				select: function(event, ui) {
					console.log("ui: "+ ui);
					event.preventDefault();
					$('#mod_tipomaterial').val(ui.item.nombre);
					$('#mod_idtipomaterial').val(ui.item.id_tipo);
					$('#mod_idtipo').val(ui.item.id_tipo);
				}
			});
		});

		$("#mod_tipomaterial" ).on( "keydown", function( event ) {
			if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
			{
				$("#mod_idtipomaterial" ).val("");
				$("#mod_idtipo" ).val("");

			}
				
			if (event.keyCode==$.ui.keyCode.DELETE){
				$("#mod_tipomaterial" ).val("");
				$("#mod_idtipomaterial" ).val("");
				$("#mod_idtipo" ).val("");
			}
		});

		$(function() {
			$("#mod_unidadmedida").autocomplete({				
				source: "./ajax/autocomplete/unidad_medida.php",
				minLength: 2,
				select: function(event, ui) {
					console.log("ui: "+ ui);
					event.preventDefault();
					$('#mod_unidadmedida').val(ui.item.nombre);
					$('#mod_idunidadmedida').val(ui.item.id_unidad);
					$('#mod_idunidad').val(ui.item.id_unidad);
				}
			});
		});

		$("#mod_unidadmedida" ).on( "keydown", function( event ) {
			if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
			{
				$("#mod_idunidadmedida" ).val("");
				$("#mod_idunidad" ).val("");

			}
				
			if (event.keyCode==$.ui.keyCode.DELETE){
				$("#mod_unidadmedida" ).val("");
				$("#mod_idunidadmedida" ).val("");
				$("#mod_idunidad" ).val("");
			}
		});
	</script>
	

  </body>
</html>
