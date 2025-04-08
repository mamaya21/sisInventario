	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Transportes</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_transporte" name="editar_transporte">
			<div id="resultados_ajax2"></div>

			  <div class="form-group">
				<label for="mod_idtransporte" class="col-sm-3 control-label">ID transporte</label>
				<div class="col-sm-8">
				  <input type="text" readonly="readonly" class="form-control" id="mod_idtransporte" name="mod_idtransporte" required>
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_marca" class="col-sm-3 control-label">Marca</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_marca" name="mod_marca"  required>
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_placa" class="col-sm-3 control-label">Placa</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_placa" name="mod_placa"  required>
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>

			   <div class="form-group">
				<label for="mod_ninscripcion" class="col-sm-3 control-label">N° Constancia de Inscripción</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_ninscripcion" name="mod_ninscripcion">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_confvehicular" class="col-sm-3 control-label">Cód. Configuración Vehicular</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_confvehicular" name="mod_confvehicular">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_licconducir" class="col-sm-3 control-label">N° Licencia de Conducir</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_licconducir" name="mod_licconducir">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="mod_conductor" class="col-sm-3 control-label">Conductor</label>
				<div class="col-sm-8">
				 <input type="text" class="form-control" id="mod_conductor" name="mod_conductor">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="mod_estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-8">
				 <select class="form-control" id="mod_estado" name="mod_estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>
			  </div>
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>