		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_materiales.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');

				}
			})
		}


$( "#editar_material" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);

 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_material.php",
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
		console.log(id);
		var id_tipo = $("#id_tipo"+id).val();
		var nombre_tipo = $("#nombre_tipo"+id).val();
		var descripcion = $("#descripcion_tipo"+id).val();
		var status_tipo = $("#status_tipo"+id).val();
		var tipo_id = $("#tipo_id"+id).val();
		var tipo = $("#tipo"+id).val();
		var unidad_id = $("#unidad_id"+id).val();
		var unidad = $("#unidad"+id).val();

		$("#mod_idmaterial").val(id_tipo);
		$("#mod_nombre").val(nombre_tipo);
		$("#mod_descripcion").val(descripcion);
		$("#mod_tipomaterial").val(tipo);
		$("#mod_idtipomaterial").val(tipo_id);
		$("#mod_idtipo").val(tipo_id);
		$("#mod_unidadmedida").val(unidad);
		$("#mod_idunidadmedida").val(unidad_id);
		$("#mod_idunidad").val(unidad_id);
		$("#mod_estado").val(status_tipo);

	}

		function imprimir_reporte(q){
			VentanaCentrada('./pdf/documentos/ver_rep_remitentes.php?q='+q,'Reporte','','1024','768','true');
		}



	function eliminar_dato(id){

		var q= $("#q").val();

		Swal.fire({
			title: "Eliminar",
			text: "Realmente deseas eliminar el registro?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#d33",
			//cancelButtonColor: "#3085d6",
			confirmButtonText: "Eliminar",
			cancelButtonText: "Cancelar"
		  }).then((result) => {
			if (result.isConfirmed) {
				debugger;

				$.ajax({
					type: "GET",
					url: "./ajax/buscar_materiales.php",
					data: "id="+id,"q":q,
					 beforeSend: function(objeto){
						$("#resultados").html("Mensaje: Cargando...");
					  },
					success: function(datos){
						Swal.fire({
							title: "Eliminado!",
							text: "El registro se ha sido eliminado.",
							icon: "success"
						});

						$("#resultados").html(datos);
						load(1);
					}
				});
			  
			}
		  });
	}


		