		$(document).ready(function(){
			load(1);
			
		});

		function load(page){
			var q= $("#q").val();
			var desde=$("#fecha_desde").val();
			var hasta=$("#fecha_hasta").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_facturas_detalladas.php?action=ajax&page='+page+'&q='+q+'&desde='+desde+'&hasta='+hasta,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					$('[data-toggle="tooltip"]').tooltip({html:true}); 
					
				}
			})
		}

	
		
			function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas eliminar la factura")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_facturas_detalladas.php",
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
		
		function imprimir_factura(id_factura){
			VentanaCentrada('./pdf/documentos/ver_factura3.php?id_factura='+id_factura,'Factura','','1024','768','true');
		}

		function imprimir_reporte(desde,hasta,q){
			VentanaCentrada('./pdf/documentos/ver_rep_facturas_det.php?desde='+desde+'&hasta='+hasta+'&q='+q,'Reporte','','1024','768','true');
		}

		function replicar(id)
		{
			var q= $("#q").val();
			if (confirm("Realmente deseas replicar la Factura")){	
			$.ajax({
	        type: "GET",
	        url: "./ajax/replicar_facturas_deta.php",
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

		function anular(id)
		{
			var q= $("#q").val();
			if (confirm("Realmente deseas anular la Factura")){	
			$.ajax({
	        type: "GET",
	        url: "./ajax/anular_facturas.php",
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