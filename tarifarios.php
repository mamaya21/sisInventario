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

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	$active_facturas="";
	$active_guias="";
	$active_clientes="";
	$active_remitentes="";
	$active_subcontrata="";
	$active_transportes="";
	$active_usuarios="";
	$active_tarifarios="active";
	$title="Tarifarios | Facturación CIMEK";
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
				<button type='button' class="btn btn-info" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus" ></span> Nuevo </button>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar distrito</h4>
		</div>
			<div class="panel-body">
			<?php
			include("modal/registro_tarifario.php");
			include("modal/editar_tarifario.php");
			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">

						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Nombres:</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Nombre" onkeyup='load(1);'>
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
	<script type="text/javascript" src="js/tarifarios.js"></script>


  </body>
</html>
<script>
$( "#guardar_usuario" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);

 var parametros = $(this).serialize();
 if($("#distrito").val()=="0"){
	 alert("Debe completar la información de la ubicación (departamento, provincia y distrito)");
	 $('#guardar_datos').attr("disabled", false);
 }else{
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_tarifario.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$("#guardar_usuario")[0].reset();
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});

 }

 event.preventDefault();

})

$( "#editar_tarifario" ).submit(function( event ) {
  $('#actualizar_datos2').attr("disabled", true);

 var parametros = $(this).serialize();
 if($("#distrito2").val()=="0"){
	 alert("Debe completar la información de la ubicación (departamento, provincia y distrito)");
	 $('#actualizar_datos2').attr("disabled", false);
 }else{
	 $.ajax({
			type: "POST",
			url: "ajax/editar_tarifario.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos2').attr("disabled", false);
			load(1);
		  }
	});
 }

  event.preventDefault();
})

	function get_user_id(id){
		$("#user_id_mod").val(id);
	}

	function obtener_datos(id, desde, hasta, precio){
			var id_distrito = $("#id_distrito"+id).val();
			var id_provincia = $("#id_provincia"+id).val();
			var id_departamento = $("#id_departamento"+id).val();
			//var desde = $("#desde"+id).val();
			//var hasta = $("#hasta"+id).val();

			console.log(desde);
			console.log(hasta);

			$("#mod_id").val(id);
			$("#departamento2").val(id_departamento);
			$("#desde2").val(desde);
			$("#hasta2").val(hasta);
			$("#precio2").val(precio);

			llenarCombosDistrito(id_departamento,id_provincia,id_distrito);

		}

		function llenarCombosDistrito(depa,provincia,distrito){
			/*PARA PROVINCIA*/
			var parametros_prov= "id="+depa+"&idprovincia="+provincia;
			$.ajax({
				data:  parametros_prov,
				url:   './ajax/ajax_provincia_completar.php',
				type:  'post',
				beforeSend: function () { },
				success:  function (response) {
					$("#provincia2").html(response);
				},
				error:function(){
					alert("error");
				}
			 });

			 /*PARA DISTRITO*/
 			var parametros_distrito= "id="+provincia+"&iddistrito="+distrito;
 			$.ajax({
 				data:  parametros_distrito,
 				url:   './ajax/ajax_distrito_completar.php',
 				type:  'post',
 				beforeSend: function () { },
 				success:  function (response) {
 					$("#distrito2").html(response);
 				},
 				error:function(){
 					alert("error");
 				}
 			 });

		}
</script>
