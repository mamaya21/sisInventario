function preload(){
	var tipo_reporte = $("#tiporeporte").val();
	if (tipo_reporte === "0") {
		console.log("Por favor selecciona un tipo de reporte");
		Swal.fire({
			title: "Reportes",
			text: "Por favor selecciona un tipo de reporte",
			icon: "warning"
			});
	} else {
		console.log("Reporte seleccionado: " + tipo_reporte);
		load(1, tipo_reporte);
	}
}

function load(page, tipo_reporte){
	var reporte = tipo_reporte;
	var q= $("#condiciones").val();
	var desde=$("#fecha_desde").val();
	var hasta=$("#fecha_hasta").val();
	var remitente=$("#id_remitente").val();
	var importe=$("#importe_fac").val();

	$("#loader").fadeIn('slow');
	$.ajax({
		url:'./ajax/buscar_reportes.php?action=ajax&page='+page+'&q='+q+'&desde='+desde+'&hasta='+hasta+'&reporte='+reporte+'&importe='+importe,
		beforeSend: function(objeto){
			$('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
		},
		success:function(data){
			$(".outer_div").html(data).fadeIn('slow');
			$('#loader').html('');
			$('[data-toggle="tooltip"]').tooltip({html:true}); 	
		}
	});
}

