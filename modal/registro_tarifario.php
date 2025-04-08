	<?php
	error_reporting(0);
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo tarifario</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_usuario" name="guardar_usuario">
			<div id="resultados_ajax"></div>

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

				<hr>

			  <div class="form-group">
					<label for="desde" class="col-sm-3 control-label">Desde (Kg)</label>
					<div class="col-sm-8">
					  <input type="decimal" class="form-control" id="desde" name="desde" placeholder="Rango desde" title="Rango en Kg" required>
					</div>
			  </div>

				<div class="form-group">
					<label for="hasta" class="col-sm-3 control-label">Hasta (Kg)</label>
					<div class="col-sm-8">
					  <input type="decimal" class="form-control" id="hasta" name="hasta" placeholder="Rango hasta" title="Rango en Kg" required>
					</div>
			  </div>

				<div class="form-group">
					<label for="precio" class="col-sm-3 control-label">Tarifa</label>
					<div class="col-sm-8">
					  <input type="decimal" class="form-control" id="precio" name="precio" placeholder="Precio tarifa" title="Tarifa en s/" required>
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
