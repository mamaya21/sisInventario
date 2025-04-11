$(document).ready(function(){
	load(1);
});

function load(page){
	var q= $("#q").val();
	$("#loader").fadeIn('slow');
	$.ajax({
		url:'./ajax/buscar_unidadesMedida.php?action=ajax&page='+page+'&q='+q,
		beforeSend: function(objeto){
			$('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
		},
		success:function(data){
			$(".outer_div").html(data).fadeIn('slow');
			$('#loader').html('');

		}
	})
}


$( "#guardar_unidad" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);

 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nueva_unidad.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$("#guardar_unidad")[0].reset();
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_unidad" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);

 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_unidad.php",
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
	var id_tipo = $("#id_unidad"+id).val();
	var nombre_tipo = $("#nombre_unidad"+id).val();
	var descripcion = $("#descripcion_unidad"+id).val();
	var status_tipo = $("#status_unidad"+id).val();

	$("#mod_idunidad").val(id_tipo);
	$("#mod_nombre").val(nombre_tipo);
	$("#mod_descripcion").val(descripcion);
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

				$.ajax({
					type: "GET",
					url: "./ajax/buscar_unidadesMedida.php",
					data: "id="+id,"q":q,
					 beforeSend: function(objeto){
						$("#resultados").html("Mensaje: Cargando...");
					  },
					success: function(datos){
						Swal.fire({
							title: "Eliminado!",
							text: "El registro ha sido eliminado.",
							icon: "success"
						});

						$("#resultados").html(datos);
						load(1);
					}
				});
			  
			}
		  });
	}


		