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
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar tarifario</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_tarifario" name="editar_tarifario">
			<div id="resultados_ajax2"></div>

				  <input type="hidden"  id="mod_id" name="mod_id">
					<div class="form-group">
					<label for="departamento2" class="col-sm-3 control-label">Departamento</label>
						<div class="col-sm-8">
							<select class="form-control input-sm" id="departamento2" name="departamento2">
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
						<label for="provincia2" class="col-sm-3 control-label">Provincia</label>
						<div class="col-sm-8">
							<select class="form-control input-sm" id="provincia2" name="provincia2">
								<option value="0">---SELECCIONAR---</option>
							</select>
						</div>
				  </div>
					<div class="form-group">
						<label for="distrito2" class="col-sm-3 control-label">Distrito</label>
						<div class="col-sm-8">
							<select class="form-control input-sm" id="distrito2" name="distrito2">
								<option value="0">---SELECCIONAR---</option>
							</select>
						</div>
				  </div>

					<hr>

				  <div class="form-group">
						<label for="desde2" class="col-sm-3 control-label">Desde (Kg)</label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" id="desde2" name="desde2" placeholder="Rango desde" title="Rango en Kg" required>
						</div>
				  </div>

					<div class="form-group">
						<label for="hasta2" class="col-sm-3 control-label">Hasta (Kg)</label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" id="hasta2" name="hasta2" placeholder="Rango hasta" title="Rango en Kg" required>
						</div>
				  </div>

					<div class="form-group">
						<label for="precio2" class="col-sm-3 control-label">Tarifa</label>
						<div class="col-sm-8">
						  <input type="decimal" class="form-control" id="precio2" name="precio2" placeholder="Precio tarifa" title="Tarifa en s/" required>
						</div>
				  </div>


		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos2">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>
