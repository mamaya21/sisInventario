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

	if (isset($_GET['idconsolidado']))
	{
		$idconsolidado=intval($_GET['idconsolidado']);
		$campos=" 'CONS' + '' + RIGHT('00000' + Ltrim(Rtrim(a.nro_consolidado)),5) [Consolidado], a.nro_consolidado,
			convert(varchar(10),a.fecha,103) [fecha], sum(b.cantidad) [Cantidad], sum(b.peso) [Peso], count(b.id_guia) [Cant_guias], placa ";
		$query_consultarguia = "Select top 1 $campos
			From t_consolidados as a
			inner join (
				Select a.id_guia, sum(b.cantidad_det) cantidad, sum(peso_det) peso, c.placa
				From t_guias as a
				Inner Join detalle_guia as b on b.numero_guia = a.numero_guia
				Inner Join t_transportes as c on c.id_transporte = a.id_transporte
				Where a.id_guia in (Select id_guia From t_consolidados where estado_guia =1)
				Group by a.id_guia, c.placa
			) as b on b.id_guia = a.id_guia
			Where a.nro_consolidado = '".$idconsolidado	."'
			Group by a.nro_consolidado, convert(varchar(10),a.fecha,103), placa; ";

		$sql_factura=odbc_exec($con,$query_consultarguia);

		while ($row = odbc_fetch_array($sql_factura)) {
			$e_consolidado 				= $row['Consolidado'];
			$e_nro_consolidado 		= $row['nro_consolidado'];

			$e_fecha 					= str_replace("-","/",$row['fecha']);
			$e_cantidad				= $row['Cantidad'];
			$e_peso 					= floatval($row['Peso']);
			$e_cant_guias			= $row['Cant_guias'];

			$e_placa					= $row['placa'];
			$e_tabla ='';

			//<span class="table-add glyphicon glyphicon-plus"></span>

			$e_cabecera = ' <div id="table" class="table-editable">

						<table class="table" id="tab_guia">
								<tr>
									<th>Guía</th>
									<th style="display: none;">idGuia</th>
									<th>Fecha Guía</th>
									<th>Destinatario</th>
									<th>Cliente</th>
									<th>Cantidad</th>
									<th>Peso</th>
								</tr> ';
			$e_cuerpo = '<tr class="hide">
											<td contenteditable="true"></td>
											<td style="display: none;"></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>

										</tr>';

			$campos_deta=" a.nro_consolidado, a.id_consolidado, b.id_guia, b.buscador, b.fecha_guia, b.Destinatario, b.Cliente, b.cantidad, b.peso ";
			$query_consultardetalle = "Select $campos_deta
				From t_consolidados as a
				inner join (
					Select a.id_guia, a.buscador, convert(varchar(10),a.fecha_guia,103) [fecha_guia],
					c.Raz_Social [Destinatario], d.Raz_Social [Cliente], sum(b.cantidad_det) cantidad, sum(peso_det) peso
					From t_guias as a
					Inner Join detalle_guia as b on b.numero_guia = a.numero_guia
					Inner Join t_clientes as c on c.id_cliente = a.id_cliente
					Inner Join t_remitentes as d on d.id_remitente = a.id_remitente
					Where a.id_guia in (Select id_guia From t_consolidados where estado_guia =1)
					Group by a.id_guia, a.buscador, a.fecha_guia, c.Raz_Social, d.Raz_Social
				) as b on b.id_guia = a.id_guia
				Where a.nro_consolidado = '".$idconsolidado."'
				Order by b.id_guia asc; ";
			$sql_detalle=odbc_exec($con,$query_consultardetalle);

			while ($row2 = odbc_fetch_array($sql_detalle)) {
					$e_cuerpo = $e_cuerpo. ' '.
									'<tr>
											<td>'. $row2['buscador'] .'</td>
											<td style="display: none;">'. $row2['id_guia'] .'</td>
											<td>'. $row2['fecha_guia'] .'</td>
											<td>'. $row2['Destinatario'] .'</td>
											<td>'. $row2['Cliente'] .'</td>
											<td>'. $row2['cantidad'] .'</td>
											<td>'. $row2['peso'] .'</td>

										</tr>';
			}

			$e_cierre = '	</table> </div> ';

			$e_tabla = $e_cabecera . '' . $e_cuerpo .''. $e_cierre;

	 }
	}
	else
	{
		header("location: consolidados.php");
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
			<h4><i class='glyphicon glyphicon-edit'></i> Vista Previa Consolidado</h4>
		</div>
		<div class="panel-body">

			<form class="form-horizontal" method="post" id="datos_editar" name="datos_editar">

			<div id="resultados_ajax"></div>

				<div class="form-group row">
				  <label for="fecha_consolidado" class="col-md-1 control-label">Fecha</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="fecha_consolidado" readonly value="<?php echo $e_fecha;?>">
					  <input id="id_consolidado" name="id_consolidado" type='hidden' value="<?php echo $e_nro_consolidado;?>">
				  </div>
				  <label for="consolidado" class="col-md-1 control-label">Consolidado</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="consolidado" name="consolidado" placeholder="RUC" readonly value="<?php echo $e_consolidado;?>">
							</div>

					<label for="placa" class="col-md-1 control-label">Placa</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="placa" name="placa" placeholder="Placa" readonly value="<?php echo $e_placa;?>">
							</div>
				</div>

				<div class="form-group row">
				  <label for="cantidad" class="col-md-1 control-label">Cantidad</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="cantidad" name="cantidad" readonly required value="<?php echo $e_cantidad;?>">
				  </div>
				  <label for="peso" class="col-md-1 control-label">Peso</label>
					<div class="col-md-3">
						<input type="text" class="form-control input-sm" id="peso" name="peso" readonly value="<?php echo $e_peso;?>">
					</div>
					<label for="nroguias" class="col-md-1 control-label">Guías</label>
					<div class="col-md-2">
						<input type="text" class="form-control input-sm" id="nroguias" name="nroguias" readonly value="<?php echo $e_cant_guias;?>">
					</div>
				</div>

				 <br>

				 <!-- AQUI LA TABLA DE DETALLE -->
				 <?php echo $e_tabla; ?>

				<br>

				<div class="col-md-12">
					<div class="pull-right">

						<div class="btn-group pull-right" style="padding-left:5px;">
							<a  href="consolidados.php" class="btn btn-info"><span class="glyphicon glyphicon-hand-left" ></span> Regresar </a>
						</div>

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

	<script type="text/javascript" src="js/consolidados.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

	<script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

  </body>
</html>
