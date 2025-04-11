	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Material</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_material" name="editar_material">
			<div id="resultados_ajax2"></div>

			<div class="form-group">
				<label for="mod_idmaterial" class="col-sm-3 control-label">Código</label>
				<div class="col-sm-8">
				  <input type="text" readonly="readonly" class="form-control" id="mod_idmaterial" name="mod_idmaterial" required>
				</div>
			</div>

			<div class="form-group">
				<label for="mod_nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_nombre" name="mod_nombre"  required>
				</div>
			</div>

			<div class="form-group">
				<label for="mod_descripcion" class="col-sm-3 control-label">Descripción</label>
				<div class="col-sm-8">
				  <textarea class="form-control" id="mod_descripcion" name="mod_descripcion" ></textarea>
				</div>
			</div>

			<div class="form-group">
				<label for="mod_tipomaterial" class="col-sm-3 control-label">Tipo</label>
				<div class="col-md-5">
					<input type="text" class="form-control" id="mod_tipomaterial" name="mod_tipomaterial" placeholder="nombre tipo de material">
				</div>

				<label for="mod_idtipomaterial" class="col-md-1 control-label">Cod.</label>
				<div class="col-md-2">
					<input type="text" class="form-control" id="mod_idtipomaterial" name="mod_idtipomaterial" placeholder="Codigo" readonly>
					<input id="mod_idtipo" name="mod_idtipo" type='hidden'>
				</div>
			</div>

			<div class="form-group">
				<label for="mod_unidadmedida" class="col-sm-3 control-label">Unidad</label>
				<div class="col-md-5">
					<input type="text" class="form-control" id="mod_unidadmedida" name="mod_unidadmedida" placeholder="Nombre unidad medida">
				</div>

				<label for="mod_idunidadmedida" class="col-md-1 control-label">Cod.</label>
				<div class="col-md-2">
					<input type="text" class="form-control" id="mod_idunidadmedida" name="mod_idunidadmedida" placeholder="Codigo" readonly>
					<input id="mod_idunidad" name="mod_idunidad" type='hidden'>
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
