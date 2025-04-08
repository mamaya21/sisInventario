
		$(document).ready(function(){
			load(1);
		});

		function load(page){

			$("#loader").fadeIn('slow');
			
			var q= $("#q").val();
			var id_remitente = $("#id_remitente_bus").val();
			$.ajax({
				url:'./ajax/productos_factura.php?id_remitente='+id_remitente+'&action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	function agregar (id)
		{
			var guia=document.getElementById('guia_'+id).value;
			var nguia=document.getElementById('nguia_'+id).value;
			var cantidad=document.getElementById('cantidad_'+id).value;
			var peso=document.getElementById('peso_'+id).value;

			$.ajax({
        type: "POST",
        url: "./ajax/agregar_facturacion.php",
        data: "id="+id+"&guia="+guia+"&cantidad="+cantidad+"&peso="+peso+"&nguia="+nguia,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});
		}
		
			function eliminar (id)
		{
			
			$.ajax({
        type: "GET",
        url: "./ajax/agregar_facturacion.php",
        data: "id="+id,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});

		}
		
		$("#datos_factura").submit(function(){
		  var id_remitente = $("#id_remitente").val();
		  var id_vendedor = $("#id_vendedor").val();
		  var condiciones = $("#condiciones").val();
		  
		  if (id_remitente==""){
			  alert("Debes seleccionar un cliente");
			  $("#nombre_remitente").focus();
			  return false;
		  }
		 //VentanaCentrada('./pdf/documentos/factura_pdf.php?id_remitente='+id_remitente+'&id_vendedor='+id_vendedor+'&condiciones='+condiciones,'Factura','','1024','768','true');
	 	});



		$( "#datos_factura" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  	var id_remitente = $("#id_remitente").val();
		  	var importe= $("#importe_fac").val();
			var fecha_crea = $("#fecha_emision").val();	
			var dir_a = $("#dir_remitente").val();

		  	var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/nueva_factura.php",
					data: parametros,
					 beforeSend: function(objeto){
					 	$("#resultados").html("Mensaje: Cargando...");
						//$("#resultados_ajax").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados").html(datos);
					$("#datos_factura")[0].reset();
					$('#guardar_datos').attr("disabled", false);
				  }
			});
		  event.preventDefault();
		})


		
		$( "#guardar_cliente" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/nuevo_cliente.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados_ajax").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax").html(datos);
					$('#guardar_datos').attr("disabled", false);
					load(1);
				  }
			});
		  event.preventDefault();
		})
		
		$( "#guardar_producto" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/nuevo_producto.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados_ajax_productos").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax_productos").html(datos);
					$('#guardar_datos').attr("disabled", false);
					load(1);
				  }
			});
		  event.preventDefault();
		})
