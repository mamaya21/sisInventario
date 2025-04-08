	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoTransporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo Transporte</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_transporte" name="guardar_transporte">
			<div id="resultados_ajax"></div>
			  <div class="form-group">
				<label for="marca" class="col-sm-3 control-label">Marca</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="marca" name="marca" required>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="placa" class="col-sm-3 control-label">Placa</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="placa" name="placa" required>
				</div>
			  </div>

			  <div class="form-group">
				<label for="n_inscripcion" class="col-sm-3 control-label">N° Constancia de inscripción</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="n_inscripcion" name="n_inscripcion" required>
				</div>
			  </div>

			  <div class="form-group">
				<label for="conf_vehicular" class="col-sm-3 control-label">Código de configuración vehicular</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="conf_vehicular" name="conf_vehicular" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="lic_conducir" class="col-sm-3 control-label">N° Licencia de conducir</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="lic_conducir" name="lic_conducir" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="conductor" class="col-sm-3 control-label">Conductor</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="conductor" name="conductor" >
				</div>
			  </div>

			  <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-8">
				 <select class="form-control" id="estado" name="estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
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