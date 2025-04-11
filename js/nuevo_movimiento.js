$( "#datos_movimiento" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  debugger;
  var parametros = $(this).serialize();
  $.ajax({
		 type: "POST",
		 url: "ajax/nuevo_movimiento.php",
		 data: parametros,
		  beforeSend: function(objeto){
			 $("#resultados_ajax").html("Mensaje: Cargando...");
		   },
		 success: function(datos){
			$("#resultados_ajax").html(datos);
			$("#datos_movimiento")[0].reset();
			$('#guardar_datos').attr("disabled", false);
			load(1);
		}
 });
event.preventDefault();

});