		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_subcontratadas.php?action=ajax&page='+page+'&q='+q,
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
		if (confirm("Realmente deseas eliminar la empresa")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_subcontratadas.php",
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
		
		
	
$( "#guardar_empresa" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nueva_empresa.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$("#guardar_empresa")[0].reset();
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_empresa" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_empresa.php",
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
			var id_empresa = $("#id_empresa"+id).val();
			var nombre_empresa = $("#nombre_empresa"+id).val();
			var ruc_empresa = $("#ruc_empresa"+id).val();
			var razon_social= $("#razon_social"+id).val();
			var contacto_empresa = $("#contacto_empresa"+id).val();
			var telefono_empresa = $("#telefono_empresa"+id).val();
			var email_empresa = $("#email_empresa"+id).val();
			var direccion_empresa = $("#direccion_empresa"+id).val();
			var status_empresa = $("#status_empresa"+id).val();

			$("#mod_idempresa").val(id_empresa);
			$("#mod_nombre").val(nombre_empresa);
			$("#mod_ruc").val(ruc_empresa);
			$("#mod_razsocial").val(razon_social);
			$("#mod_contacto").val(contacto_empresa);
			$("#mod_telefono").val(telefono_empresa);
			$("#mod_email").val(email_empresa);
			$("#mod_direccion").val(direccion_empresa);
			$("#mod_estado").val(status_empresa);
			$("#mod_id").val(id);
		
		}
	
		function imprimir_reporte(q){
			VentanaCentrada('./pdf/documentos/ver_rep_empresas.php?q='+q,'Reporte','','1024','768','true');
		}