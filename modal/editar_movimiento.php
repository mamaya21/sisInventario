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
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Movimiento</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_movimiento" name="editar_movimiento">
			<div id="resultados_ajax2"></div>

			<div class="form-group">
				<label for="mod_idmovimiento" class="col-sm-3 control-label">Código</label>
				<div class="col-sm-8">
				  <input type="text" readonly="readonly" class="form-control" id="mod_idmovimiento" name="mod_idmovimiento" required>
				</div>
			</div>

			<div class="form-group">
				<label for="mod_tipomovimiento" class="col-sm-3 control-label">Tipo</label>
				<div class="col-sm-8">
				  	<select id="mod_tipomovimiento" name="mod_tipomovimiento" class="form-control" required>
						<option value="ingreso">Ingreso</option>
						<option value="salida">Salida</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="mod_material" class="col-sm-3 control-label">Material</label>
				<div class="col-md-5">
					<input type="text" class="form-control input-sm" id="mod_material" name="mod_material"  placeholder="nombre de material">
				</div>

				<label for="mod_idmaterial" class="col-md-1 control-label">Cod.</label>
				<div class="col-md-2">
					<input type="text" class="form-control input-sm" id="mod_idmaterial" name="mod_idmaterial" placeholder="Codigo" readonly>
					<input id="mod_materialid" name="mod_materialid" type='hidden'>
				</div>
			</div>

			<div class="form-group">
				<label for="mod_cantidad" class="col-sm-3 control-label">Cantidad</label>
				<div class="col-sm-8">
				<input type="number" id="mod_cantidad" name="mod_cantidad" step="0.01" min="0" class="form-control" placeholder="Ingrese un valor decimal" required>
				</div>
			</div>

			<div class="form-group">
				<label for="mod_nota" class="col-sm-3 control-label">Nota</label>
				<div class="col-sm-8">
				  <textarea class="form-control" id="mod_nota" name="mod_nota" ></textarea>
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
