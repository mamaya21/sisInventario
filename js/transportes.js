		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_transportes.php?action=ajax&page='+page+'&q='+q,
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
		if (confirm("Realmente deseas eliminar el transporte")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_transportes.php",
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
		
		
	
$( "#guardar_transporte" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_transporte.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$("#guardar_transporte")[0].reset();
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_transporte" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_transporte.php",
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
			var id_transporte = $("#id_transporte"+id).val();
			var marca = $("#marca"+id).val();
			var placa = $("#placa"+id).val();
			var n_inscripcion= $("#n_inscripcion"+id).val();
			var conf_vehicular = $("#conf_vehicular"+id).val();
			var lic_conducir = $("#lic_conducir"+id).val();
			var conductor = $("#conductor"+id).val();
			var status_transporte = $("#status_transporte"+id).val();

			$("#mod_idtransporte").val(id_transporte);
			$("#mod_marca").val(marca);
			$("#mod_placa").val(placa);
			$("#mod_ninscripcion").val(n_inscripcion);
			$("#mod_confvehicular").val(conf_vehicular);
			$("#mod_licconducir").val(lic_conducir);
			$("#mod_conductor").val(conductor);
			$("#mod_estado").val(status_transporte);
			$("#mod_id").val(id);
		
		}
	
		function imprimir_reporte(q){
			VentanaCentrada('./pdf/documentos/ver_rep_transportes.php?q='+q,'Reporte','','1024','768','true');
		}