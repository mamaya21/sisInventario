
$( "#datos_factura" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);

  			var valores="";
 	    	var valores_des=[];
 	    	var valores_can=[];
            // Obtenemos todos los valores contenidos en los <td> de la fila
            // seleccionada
            //$(this).parents("tr").find("td").each(function(){
	    $("#table tr").find("td:eq(0)").each(function(){
                	//valores+=$(this).html()+",";
				valores_des.push($(this).html());
            	//});
            });

	    $("#table tr").find("td:eq(1)").each(function(){
                	//valores+=$(this).html()+",";
				valores_can.push($(this).html());
            	//});
            });
	    	var cant=valores_des.length;
	    	var res="";
	    	for (var i = 1; i < cant; i++) {
	    		res+=valores_des[i]+"/"+valores_can[i]+ "|";
	    	}

  var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nueva_fac_almacenaje.php",
			data: parametros+"&res="+res,
			 beforeSend: function(objeto){
			 	$("#resultados").html("Mensaje: Cargando...");
				//$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados").html(datos);
			$("#datos_factura")[0].reset();
			$('#guardar_datos').attr("disabled", false);
			$("#tab_guia").html('');			
		  }
	});
	 setTimeout("location.href = facturas_almacenaje.php",1000);
  event.preventDefault();
})