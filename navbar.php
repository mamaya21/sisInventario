	<?php
		if (isset($title))
		{
	?>
<nav class="navbar navbar-default ">
  <div class="container-fluid">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Almacén Express </a>
    </div>


    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="<?php echo $active_materiales;?>"><a href="materiales.php"><i class='glyphicon glyphicon-barcode'></i> Materiales<span class="sr-only">(current)</span></a></li>
        <li class="<?php echo $active_tipos;?>"><a href="tipoMateriales.php"><i class='glyphicon glyphicon-list-alt'></i> Tipos de Materiales</a></li>
		<li class="<?php echo $active_clientes;?>"><a href="clientes.php"><i class='glyphicon glyphicon-user'></i> Destinatario Final</a></li>
    <li class="<?php echo $active_remitentes;?>"><a href="remitentes.php"><i class='glyphicon glyphicon-th-large'></i> Remitentes (Clientes)</a></li>
    <li class="<?php echo $active_subcontrata;?>"><a href="sub_contratadas.php"><i class='glyphicon glyphicon-paperclip'></i> Sub-Contratadas</a></li>
    <li class="<?php echo $active_transportes;?>"><a href="transportes.php"><i class='glyphicon glyphicon-scale'></i> Transportes</a></li>
		<li class="<?php echo $active_tarifarios;?>"><a href="tarifarios.php"><i class='glyphicon glyphicon-euro'></i> Tarifarios</a></li>
    <?php
      if($_SESSION['facilidad']=="Administrador"){
    ?>
		<li class="<?php echo $active_usuarios;?>"><a href="usuarios.php"><i  class='glyphicon glyphicon-lock'></i> Usuarios</a></li>
    <?php
      }
    ?>
    </ul>
      <ul class="nav navbar-nav navbar-right">
        <!--<li><a href="#" target='_blank'><i class='glyphicon glyphicon-envelope'></i> Soporte </a></li>-->
		<li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir </a></li>
      </ul>
    </div>
  </div>
</nav>
	<?php
		}
	?>
