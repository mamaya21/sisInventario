
		/*$(document).ready(function(){
			load(1);
		});


		$("#datos_factura").submit(function(){
		  var id_cliente = $("#id_cliente").val();
		  var id_remitente = $("#id_remitente").val();
		  var id_transporte = $("#id_transporte").val();

		  if (id_cliente==""){
			  alert("Debes seleccionar un cliente");
			  $("#nombre_cliente").focus();
			  return false;
		  }
		 VentanaCentrada('./pdf/documentos/factura_pdf.php?id_cliente='+id_cliente+'&id_remitente='+id_remitente+'&id_transporte='+id_transporte,'Guia','','1024','768','true');
	 	});*/

		/*function load(page){
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_clientes.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');

				}
			})
		}*/



$( "#datos_factura" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);

  			var valores="";
 	    	var valores_des=[];
 	    	var valores_can=[];
 	    	var valores_med=[];
 	    	var valores_pes=[];
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

	    $("#table tr").find("td:eq(2)").each(function(){
                	//valores+=$(this).html()+",";
				valores_med.push($(this).html());
            	//});
            });

	    $("#table tr").find("td:eq(3)").each(function(){
                	//valores+=$(this).html()+",";
				valores_pes.push($(this).html());
            	//});
            });
	    	var cant=valores_des.length;
	    	var res="";
	    	for (var i = 1; i < cant; i++) {
	    		res+=valores_des[i]+"/"+valores_can[i]+"/"+valores_med[i]+"/"+valores_pes[i]+ "|";
	    	}

  var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nueva_guia.php",
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
	 setTimeout("location.href = guias.php",1000);
  event.preventDefault();
});



$( "#datos_editar" ).submit(function( event ) {
  $('#editar_datos').attr("disabled", true);

  			var valores="";
 	    	var valores_des=[];
 	    	var valores_can=[];
 	    	var valores_med=[];
 	    	var valores_pes=[];
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

	    $("#table tr").find("td:eq(2)").each(function(){
                	//valores+=$(this).html()+",";
				valores_med.push($(this).html());
            	//});
            });

	    $("#table tr").find("td:eq(3)").each(function(){
                	//valores+=$(this).html()+",";
				valores_pes.push($(this).html());
            	//});
            });
	    	var cant=valores_des.length;
	    	var res="";
	    	for (var i = 1; i < cant; i++) {
	    		res+=valores_des[i]+"/"+valores_can[i]+"/"+valores_med[i]+"/"+valores_pes[i]+ "|";
	    	}

  var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_guia.php",
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
	 setTimeout("location.href = 'guias.php'",1000);
  event.preventDefault();
});
