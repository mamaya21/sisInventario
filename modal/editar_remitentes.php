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
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Remitentes</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_remitente" name="editar_remitente">
			<div id="resultados_ajax2"></div>

			  <div class="form-group">
				<label for="mod_idcliente" class="col-sm-3 control-label">ID Remitente</label>
				<div class="col-sm-8">
				  <input type="text" readonly="readonly" class="form-control" id="mod_idremitente" name="mod_idremitente" required>
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_nombre" name="mod_nombre"  required>
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_ruc" class="col-sm-3 control-label">RUC</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_ruc" name="mod_ruc"  required>
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_direccion" class="col-sm-3 control-label">Dirección</label>
				<div class="col-sm-8">
				  <textarea class="form-control" id="mod_direccion" name="mod_direccion" ></textarea>
				</div>
			  </div>

			   <div class="form-group">
				<label for="mod_telefono" class="col-sm-3 control-label">Teléfono</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_telefono" name="mod_telefono">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_razsocial" class="col-sm-3 control-label">Razón Social</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_razsocial" name="mod_razsocial">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_contacto" class="col-sm-3 control-label">Contacto</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_contacto" name="mod_contacto">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_email" class="col-sm-3 control-label">Email</label>
				<div class="col-sm-8">
				 <input type="email" class="form-control" id="mod_email" name="mod_email">
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

			  <div class="form-group">
				<label for="mod_direccion_a" class="col-sm-3 control-label">Dirección Agrupada</label>
				<div class="col-sm-8">
				  <textarea class="form-control" id="mod_direccion_a" name="mod_direccion_a" ></textarea>
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
