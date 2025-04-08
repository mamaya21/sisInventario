

		function load(page){
			var q= $("#condiciones").val();
			var desde=$("#fecha_desde").val();
			var hasta=$("#fecha_hasta").val();
			var remitente=$("#id_remitente").val();
			var importe=$("#importe_fac").val();

			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_facturas_repor.php?action=ajax&page='+page+'&q='+q+'&desde='+desde+'&hasta='+hasta+'&remitente='+remitente+'&importe='+importe,
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

