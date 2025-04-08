		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_remitentes.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');

				}
			})
		}



			function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas eliminar el remitente")){
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_remitentes.php",
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



$( "#guardar_remitente" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);

 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_remitente.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$("#guardar_remitente")[0].reset();
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_remitente" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);

 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_remitente.php",
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
  event.preventDefault();
})

	function obtener_datos(id){
			var id_remitente = $("#id_remitente"+id).val();
			var nombre_remitente = $("#nombre_remitente"+id).val();
			var ruc_remitente = $("#ruc_remitente"+id).val();
			var razon_social= $("#razon_social"+id).val();
			var contacto_remitente = $("#contacto_remitente"+id).val();
			var telefono_remitente = $("#telefono_remitente"+id).val();
			var email_remitente = $("#email_remitente"+id).val();
			var direccion_remitente = $("#direccion_remitente"+id).val();
			var status_remitente = $("#status_remitente"+id).val();
			var direccion_remitente_a = $("#direccion_remitente_a"+id).val();

			$("#mod_idremitente").val(id_remitente);
			$("#mod_nombre").val(nombre_remitente);
			$("#mod_ruc").val(ruc_remitente);
			$("#mod_razsocial").val(razon_social);
			$("#mod_contacto").val(contacto_remitente);
			$("#mod_telefono").val(telefono_remitente);
			$("#mod_email").val(email_remitente);
			$("#mod_direccion").val(direccion_remitente);
			$("#mod_estado").val(status_remitente);
			$("#mod_id").val(id);
			$("#mod_direccion_a").val(direccion_remitente_a);
		}

		function imprimir_reporte(q){
			VentanaCentrada('./pdf/documentos/ver_rep_remitentes.php?q='+q,'Reporte','','1024','768','true');
		}
