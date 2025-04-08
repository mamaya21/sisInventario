		$(document).ready(function(){
			load(1);

			$("#departamento").change(function(){

		 		var parametros= "id="+$("#departamento").val();
				console.log("departamento: "+parametros);

				if($("#departamento").val() == "0"){
					$("#provincia").html('<option value="0">---SELECCIONAR---</option>');
					$("#distrito").html('<option value="0">---SELECCIONAR---</option>');
				}else{

					$.ajax({
						data:  parametros,
						url:   './ajax/ajax_provincias.php',
						type:  'post',
						beforeSend: function () { },
						success:  function (response) {
							$("#provincia").html(response);
						},
						error:function(){
							alert("error");
						}
		       });
				}

			});

			$("#departamento2").change(function(){
		 		var parametros= "id="+$("#departamento2").val();
				console.log("departamento2: "+parametros);

				if($("#departamento2").val() == "0"){
					$("#provincia2").html('<option value="0">---SELECCIONAR---</option>');
					$("#distrito2").html('<option value="0">---SELECCIONAR---</option>');
				}else{

					$.ajax({
						data:  parametros,
						url:   './ajax/ajax_provincias.php',
						type:  'post',
						beforeSend: function () { },
						success:  function (response) {
							$("#provincia2").html(response);
						},
						error:function(){
							alert("error");
						}
		       });
				}

			});


			$("#provincia").change(function(){

		 		var parametros= "id="+$("#provincia").val();
				console.log("provincia: "+parametros);

				if($("#provincia").val() == "0"){
					$("#distrito").html('<option value="0">---SELECCIONAR---</option>');
				}else{

					$.ajax({
						data:  parametros,
						url:   './ajax/ajax_distritos.php',
						type:  'post',
						beforeSend: function () { },
						success:  function (response) {
							$("#distrito").html(response);
						},
						error:function(){
							alert("error");
						}
		       });
				}

			});

			$("#provincia2").change(function(){

		 		var parametros= "id="+$("#provincia2").val();
				console.log("provincia2: "+parametros);

				if($("#provincia2").val() == "0"){
					$("#distrito2").html('<option value="0">---SELECCIONAR---</option>');
				}else{

					$.ajax({
						data:  parametros,
						url:   './ajax/ajax_distritos.php',
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

			});


		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_clientes.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					//$("nuevoCliente")[0].reset();

				}
			})
		}


			function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas eliminar el cliente")){
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_clientes.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}


$( "#guardar_cliente" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);

 	var parametros = $(this).serialize();
 	console.log(parametros);
 	if($("#distrito").val()=="0"){
		alert("Debe completar la información de la ubicación (departamento, provincia y distrito)");
		$('#guardar_datos').attr("disabled", false);
	}else{
		$.ajax({
	 			type: "POST",
	 			url: "ajax/nuevo_cliente.php",
	 			data: parametros,
	 			 beforeSend: function(objeto){
	 				$("#resultados_ajax").html("Mensaje: Cargando...");
	 			  },
	 			success: function(datos){
	 			$("#resultados_ajax").html(datos);
	 			$("#guardar_cliente")[0].reset();
	 			//$('#guardar_cliente').trigger("reset");
	 			$('#guardar_datos').attr("disabled", false);
	 			load(1);
	 		  }
	 	});

	}

	event.preventDefault();

})

$( "#editar_cliente" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);

 var parametros = $(this).serialize();

 if($("#distrito2").val()=="0"){
	 alert("Debe completar la información de la ubicación (departamento, provincia y distrito)");
	 $('#actualizar_datos').attr("disabled", false);
 }else{
	 $.ajax({
				type: "POST",
				url: "ajax/editar_cliente.php",
				data: parametros,
				 beforeSend: function(objeto){
					$("#resultados_ajax2").html("Mensaje: Cargando...");
				  },
				success: function(datos){
				$("#resultados_ajax2").html(datos);
				$('#actualizar_datos').attr("disabled", false);
				load(1);
			  }
		});
 }

  event.preventDefault();
})

	function imprimir_reporte(q){
			VentanaCentrada('./pdf/documentos/ver_rep_clientes.php?q='+q,'Reporte','','1024','768','true');
		}

	function obtener_datos(id){
			var id_cliente = $("#id_cliente"+id).val();
			var nombre_cliente = $("#nombre_cliente"+id).val();
			var ruc_cliente = $("#ruc_cliente"+id).val();
			var razon_social= $("#razon_social"+id).val();
			var contacto_cliente = $("#contacto_cliente"+id).val();
			var telefono_cliente = $("#telefono_cliente"+id).val();
			var email_cliente = $("#email_cliente"+id).val();
			var direccion_cliente = $("#direccion_cliente"+id).val();
			var status_cliente = $("#status_cliente"+id).val();

			$("#mod_idcliente").val(id_cliente);
			$("#mod_nombre").val(nombre_cliente);
			$("#mod_ruc").val(ruc_cliente);
			$("#mod_razsocial").val(razon_social);
			$("#mod_contacto").val(contacto_cliente);
			$("#mod_telefono").val(telefono_cliente);
			$("#mod_email").val(email_cliente);
			$("#mod_direccion").val(direccion_cliente);
			$("#mod_estado").val(status_cliente);
			$("#mod_id").val(id);

			//DISTRITO, PROVINCIA, DEPARTAMENTO
			var depa_cliente = $("#id_departamento"+id).val();
			console.log("DEPARTAMENTO EDITAR: "+depa_cliente);
			if(depa_cliente == ""){
				depa_cliente = "0";
			}
			$("#departamento2").val(depa_cliente);

			var prov_cliente = $("#id_provincia"+id).val();
			var dist_cliente = $("#id_distrito"+id).val();

			llenarCombosDistrito(depa_cliente,prov_cliente,dist_cliente);

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
