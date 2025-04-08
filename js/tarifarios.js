		$(document).ready(function(){
			load(1);

			$("#departamento").change(function(){

		 		var parametros= "id="+$("#departamento").val();
				console.log("departamento: "+parametros);

				if($("#departamento").val() == "0"){
					$("#provincia").html('<option value="0">---SELECCIONAR---</option>');
					$("#distrito").html('<option value="0">---SELECCIONAR---</option>');
				}else{

					$.ajax({
						data:  parametros,
						url:   './ajax/ajax_provincias.php',
						type:  'post',
						beforeSend: function () { },
						success:  function (response) {
							$("#provincia").html(response);
						},
						error:function(){
							alert("error");
						}
		       });
				}

			});

			$("#provincia").change(function(){

		 		var parametros= "id="+$("#provincia").val();
				console.log("provincia: "+parametros);

				if($("#provincia").val() == "0"){
					$("#distrito").html('<option value="0">---SELECCIONAR---</option>');
				}else{

					$.ajax({
						data:  parametros,
						url:   './ajax/ajax_distritos.php',
						type:  'post',
						beforeSend: function () { },
						success:  function (response) {
							$("#distrito").html(response);
						},
						error:function(){
							alert("error");
						}
		       });
				}

			});


		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_tarifarios.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');

				}
			})
		}



		function eliminar (id)
		{
			var q= $("#q").val();
			if (confirm("Realmente deseas eliminar el tarifario")){
			$.ajax({
	        type: "GET",
	        url: "./ajax/buscar_tarifarios.php",
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
