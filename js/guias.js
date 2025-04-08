		var global_guiaselect = [];
		var buscador_guiaselect = [];
		var placa_global = '';

		$(document).ready(function(){
			load(1);
		});

		function changeChkTbl(valor, buscador, placa){

				if (placa_global == ''){
					placa_global = placa;

					elemento = document.getElementById(valor).checked;

					if (elemento) {
							let pos = global_guiaselect.indexOf(valor);
							if(pos == -1){
								global_guiaselect.push(valor);
								buscador_guiaselect.push(buscador);
							}
					}else{
							let pos = global_guiaselect.indexOf(valor);
							if ( pos !== -1 ) {
									global_guiaselect.splice( pos, 1 );
									buscador_guiaselect.splice( pos, 1 );
									if(global_guiaselect.length == 0){
										placa_global = '';
									}
							}
					}
					
				}else{
					if(placa_global != placa){
						alert('No puede seleccionar una GUÍA que cuentan con distinta unidad de transporte!');
						elemento = document.getElementById(valor);
						elemento.checked = false;
					}else{
						elemento = document.getElementById(valor).checked;

						if (elemento) {
								let pos = global_guiaselect.indexOf(valor);
								if(pos == -1){
									global_guiaselect.push(valor);
									buscador_guiaselect.push(buscador);
								}
		        }else{
								let pos = global_guiaselect.indexOf(valor);
								if ( pos !== -1 ) {
						        global_guiaselect.splice( pos, 1 );
										buscador_guiaselect.splice( pos, 1 );
										if(global_guiaselect.length == 0){
											placa_global = '';
										}
						    }
						}
						console.log("actualizando...");
						console.log(global_guiaselect);
						console.log(buscador_guiaselect);
					}
				}

		}

		function load(page){
			var q= $("#q").val();
			var desde=$("#fecha_desde").val();
			var hasta=$("#fecha_hasta").val();
			$("#loader").fadeIn('slow');
			$.ajax({
					url:'./ajax/buscar_guias.php?action=ajax&page='+page+'&q='+q+'&desde='+desde+'&hasta='+hasta+'&data2='+global_guiaselect,
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
			if (confirm("Realmente deseas anular la Guía")){
			$.ajax({
	        type: "GET",
	        url: "./ajax/anular_guias.php",
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
					console.log("i: "+i);
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

									let pos = global_guiaselect.indexOf(guia);
									if ( pos !== -1 ) {
							        global_guiaselect.splice( pos, 1 );
											buscador_guiaselect.splice( pos, 1 );
											if(global_guiaselect.length == 0){
												placa_global = '';
											}
							    }

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
				console.log(guias_str.length);

				if(global_guiaselect.length == 0){
					global_guiaselect = '';
					buscador_guiaselect = '';
				}

				if(global_guiaselect.length == 0 && guias_str == ''){
					alert('No es posible generar un CONSOLIDADO sin GUÍAS seleccionadas!');
				}else{
					if (confirm("¿Estás seguro de realizar el consolidado de las guías seleccionadas?")){
						//debugger;
					$.ajax({
			        type: "GET",
			        url: "./ajax/consolidar_guias.php",
			        data: {"guias_str" : guias_str,"buscador" : guias_buscador_str, "otras_guias" : global_guiaselect, "otras_guias_buscador" : buscador_guiaselect},
						 beforeSend: function(objeto){
							$("#resultados").html("Mensaje: Cargando...");
						  },
			        success: function(datos){
							$("#resultados").html(datos);
								global_guiaselect = [];
								buscador_guiaselect = [];
								placa_global = '';
								load(1);

							}
						});
					}
				}


	    }
	    catch(error)
	    {
	        alert('Error processing document ' + console.error(error));
	    }
		}
