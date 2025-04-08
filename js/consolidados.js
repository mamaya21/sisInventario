		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			var desde=$("#fecha_desde").val();
			var hasta=$("#fecha_hasta").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_consolidado.php?action=ajax&page='+page+'&q='+q+'&desde='+desde+'&hasta='+hasta,
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
		if (confirm("Realmente deseas eliminar la Guía")){
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_guias.php",
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

		function imprimir_factura(id_guia){
			VentanaCentrada('./pdf/documentos/ver_factura.php?id_guia='+id_guia,'Guia','','1024','768','true');
		}

		function imprimir_reporte(desde,hasta,q){
			VentanaCentrada('./pdf/documentos/ver_rep_guias.php?desde='+desde+'&hasta='+hasta+'&q='+q,'Reporte','','1024','768','true');
		}

 	function replicar(id)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas replicar la Guía")){
		$.ajax({
        type: "GET",
        url: "./ajax/replicar_guias.php",
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
			if (confirm("¿Estás seguro de anular el Consolidado?")){
			$.ajax({
	        type: "GET",
	        url: "./ajax/anular_consolidado.php",
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


		function consolidar_guias(){

			console.log("validando...");
			var guias_str = '';
			var guias_buscador_str = '';
			try{
        var table = document.getElementById("tabla_general");

				for (var i = 0, row; row = table.rows[i]; i++) {
				  //alert(cell[i].innerText);
				  for (var j = 0, col; col = row.cells[j]; j++) {
				    //alert(col[j].innerText);
						if(j == 0){
							if(col.getElementsByClassName('tableid').length){
								var validacion =  col.getElementsByClassName('tableid')[0].checked;
								if(validacion){
									//console.log(`Txt: ${validacion} \tFila: ${i} \t Celda: ${j}`);
									//console.log(`Txt: ${row.cells[1].innerText} \tFila: ${i} \t Celda: ${j}`);
									//console.log(`Txt: ${row.cells[2].innerText} \tFila: ${i} \t Celda: ${j}`);

									var chk = col.getElementsByClassName('tableid')[0].checked;
									var guia = row.cells[1].innerText;
									var guia_str = row.cells[2].innerText;
									if(guias_str == ''){
										guias_str = guias_str + '' + guia;
									}else{
										guias_str = guias_str + '|' + guia;
									}

									if(guias_buscador_str == ''){
										guias_buscador_str = guias_buscador_str + '' + guia_str;
									}else{
										guias_buscador_str = guias_buscador_str + ' | ' + guia_str;
									}
								}
							}
						}
				  }
				}

				console.log("STR_GUIAS: "+ guias_str);
				console.log("STR_GUIAS_BUSCADOR: "+ guias_buscador_str);

				if (confirm("¿Estás seguro de realizar el consolidado de las guías seleccionadas?")){
				$.ajax({
		        type: "GET",
		        url: "./ajax/consolidar_guias.php",
		        data: {"guias_str" : guias_str,"buscador" : guias_buscador_str},
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
	    catch(error)
	    {
	        alert('Error processing document ' + console.error(error));
	    }
		}

		$( "#datos_editar" ).submit(function( event ) {
		  $('#editar_datos').attr("disabled", true);

					var idConsolidado = $('#id_consolidado').val();
					var consolidado = $('#consolidado').val();

		  			var valores="";
		 	    	var valores_id=[];
		 	    	var valores_busqueda=[];

			    $("#table tr").find("td:eq(1)").each(function(){
						valores_id.push($(this).html());
		            });

			    $("#table tr").find("td:eq(0)").each(function(){
						valores_busqueda.push($(this).html());
		            });

			    	var cant =valores_id.length;
						var cant_busqueda =valores_busqueda.length;

			    	var res="";
						var res_busqueda ="";

			    	for (var i = 1; i < cant; i++) {
							if(res == ''){
								res = res + '' + valores_id[i];
							}else{
								res = res + '|' + valores_id[i];
							}
			    	}

						for (var j = 1; j < cant_busqueda; j++) {
							if(res_busqueda == ''){
								res_busqueda = res_busqueda + '' + valores_busqueda[j];
							}else{
								res_busqueda = res_busqueda + '|' + valores_busqueda[j];
							}
			    	}

				if (confirm("¿Estás seguro de realizar la edición del consolidado " + consolidado + "?")){
						$.ajax({
		 					type: "POST",
		 					url: "ajax/editar_consolidado.php",
		 					data: {"guias_str" : res,"buscador" : res_busqueda, "id_consolidado" : idConsolidado},
		 					 beforeSend: function(objeto){
		 					 	$("#resultados").html("Mensaje: Cargando...");
		 					  },
		 					success: function(datos){
		 					$("#resultados").html(datos);
		 					$('#editar_datos').attr("disabled", true);
		 				  }
		 			});
	 			 	setTimeout("location.href = 'consolidados.php'",1000);
				}else{
					$('#editar_datos').attr("disabled", false);
				}


		  event.preventDefault();
		});
