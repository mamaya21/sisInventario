<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoMaterial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

	  	<div class="modal-dialog" role="document">
			<div class="modal-content">
		  		<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Nuevo Material</h4>
		  		</div>

		  		<div class="modal-body">
					<form class="form-horizontal" method="post" id="guardar_tipo" name="guardar_tipo">
						<div id="resultados_ajax"></div>

						<div class="form-group">
							<label for="nombre" class="col-sm-3 control-label">Nombre</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="nombre" name="nombre" required>
							</div>
						</div>

						<div class="form-group">
							<label for="descripcion" class="col-sm-3 control-label">Descripción</label>
							<div class="col-sm-8">
								<textarea class="form-control" id="descripcion" name="descripcion" ></textarea>
							</div>
						</div>

						<div class="form-group">
							<label for="tipo_material" class="col-sm-3 control-label">Tipo</label>
							<div class="col-md-5">
								<input type="text" class="form-control input-sm" id="tipo_material" placeholder="Tipo de material">
							</div>

							<label for="ruc3" class="col-md-1 control-label">Cod.</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="ruc3" name="ruc3" placeholder="RUC" readonly>
								<input id="id_empresa" name="id_empresa" type='hidden'>
							</div>
				
				 		</div>

		  		</div>

		  	<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  	</div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>