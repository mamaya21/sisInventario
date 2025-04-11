$(document).ready(function(){
	load(1);
});

function load(page){
	var q= $("#q").val();
	$("#loader").fadeIn('slow');
	$.ajax({
		url:'./ajax/buscar_usuarios.php?action=ajax&page='+page+'&q='+q,
		beforeSend: function(objeto){
			$('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
		},
		success:function(data){
			$(".outer_div").html(data).fadeIn('slow');
			$('#loader').html('');
		}
	})
}

	
		
function eliminar (id) {

	Swal.fire({
		title: "Eliminar",
		text: "Realmente deseas eliminar el registro?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#d33",
		//cancelButtonColor: "#3085d6",
		confirmButtonText: "Eliminar",
		cancelButtonText: "Cancelar"
	  }).then((result) => {
		if (result.isConfirmed) {

			$.ajax({
				type: "GET",
				url: "./ajax/buscar_usuarios.php",
				data: "id="+id,"q":q,
				 beforeSend: function(objeto){
					$("#resultados").html("Mensaje: Cargando...");
				  },
				success: function(datos){
					Swal.fire({
						title: "Eliminado!",
						text: "El registro se ha sido eliminado.",
						icon: "success"
					});

					$("#resultados").html(datos);
					load(1);
				}
			});
		  
		}
	  });

}
		
		
		
		

