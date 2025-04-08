	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo cliente</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_cliente" name="guardar_cliente">
			<div id="resultados_ajax"></div>
			  <div class="form-group">
					<label for="nombre" class="col-sm-3 control-label">Nombre</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="nombre" name="nombre" required>
					</div>
			  </div>
			  <div class="form-group">
					<label for="ruc" class="col-sm-3 control-label">Ruc</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="ruc" name="ruc" required>
					</div>
			  </div>
			  <div class="form-group">
					<label for="direccion" class="col-sm-3 control-label">Dirección</label>
					<div class="col-sm-8">
						<textarea class="form-control" id="direccion" name="direccion"   maxlength="255" ></textarea>
					</div>
			  </div>
			  <div class="form-group">
					<label for="telefono" class="col-sm-3 control-label">Teléfono</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="telefono" name="telefono" >
					</div>
			  </div>
			  <div class="form-group">
					<label for="razonsocial" class="col-sm-3 control-label">Razón Social</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="razonsocial" name="razonsocial" required>
					</div>
			  </div>
			  <div class="form-group">
					<label for="contacto" class="col-sm-3 control-label">Contacto</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="contacto" name="contacto" required>
					</div>
			  </div>
			  <div class="form-group">
					<label for="email" class="col-sm-3 control-label">Email</label>
					<div class="col-sm-8">
						<input type="email" class="form-control" id="email" name="email" >
					</div>
			  </div>

				<div class="form-group">
				<label for="departamento" class="col-sm-3 control-label">Departamento</label>
					<div class="col-sm-8">
						<select class="form-control input-sm" id="departamento" name="departamento">
							<option value="0">---SELECCIONAR---</option>
						<?php
						$sql_medida=odbc_exec($con," select * from departamentos; ");
						while ($rw=odbc_fetch_array($sql_medida)){
							$id=$rw["id"];
							$nombre=rtrim($rw["nombre"]);
							if ($nombre!=""){ ?>
								<option value="<?php echo $id;?>"><?php echo $nombre; ?></option>
							<?php
							}
						}
						?>
						</select>

					</div>
			  </div>
				<div class="form-group">
					<label for="provincia" class="col-sm-3 control-label">Provincia</label>
					<div class="col-sm-8">
						<select class="form-control input-sm" id="provincia" name="provincia">
							<option value="0">---SELECCIONAR---</option>
						</select>
					</div>
			  </div>
				<div class="form-group">
					<label for="distrito" class="col-sm-3 control-label">Distrito</label>
					<div class="col-sm-8">
						<select class="form-control input-sm" id="distrito" name="distrito">
							<option value="0">---SELECCIONAR---</option>
						</select>
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
