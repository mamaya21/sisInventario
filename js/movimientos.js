		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_movimientos.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');

				}
			})
		}


$( "#editar_movimiento" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);

 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_movimiento.php",
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
		var id_movimiento = $("#id_movimiento"+id).val();
		var fecha_crea = $("#fecha_crea"+id).val();
		var movimiento = $("#movimiento"+id).val();
		var id_material = $("#id_material"+id).val();
		var material = $("#material"+id).val();
		var cantidad = $("#cantidad"+id).val();
		var tipo = $("#tipo"+id).val();
		var unidad = $("#unidad"+id).val();
		var nota = $("#nota"+id).val();

		$("#mod_idmovimiento").val(id_movimiento);
		$("#mod_tipomovimiento").val(movimiento);
		$("#mod_material").val(material);
		$("#mod_idmaterial").val(id_material);
		$("#mod_materialid").val(id_material);
		$("#mod_cantidad").val(cantidad);
		$("#mod_nota").val(nota);

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
					url: "./ajax/buscar_movimientos.php",
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


		