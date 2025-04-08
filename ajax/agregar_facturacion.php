<?php
	/*-------------------------
	Autor: Marco Amaya
	Web: -
	Mail: marco1021tam@gmail.com
	---------------------------*/
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();
if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['guia'])){$guia=$_POST['guia'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['peso'])){$peso=$_POST['peso'];}
if (isset($_POST['nguia'])){$nguia=$_POST['nguia'];}

	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	$n_fac=0;
	$n_fac_aumenta=0;
	$n_fac_real=0;

	$n_fac_sql=odbc_exec($con, " select n_factura from datos_fg; ");
	while ($row_cf=odbc_fetch_array($n_fac_sql)) {
		$n_fac=intval($row_cf['n_factura']);
	}

	$n_fac_aumenta_sql=odbc_exec($con, " select count(*) as aumenta from t_facturas; ");
	while ($row_cfa=odbc_fetch_array($n_fac_aumenta_sql)) {
		$n_fac_aumenta=intval($row_cfa['aumenta']);
	}

	$n_fac_real=$n_fac+$n_fac_aumenta;

if (!empty($id) and !empty($guia) and !empty($cantidad) and !empty($peso) and !empty($nguia))
{
	$ssql_upd="update t_guias set add_fac=1 where id_guia= '$id' ";
	$upd_tmp=odbc_exec($con, $ssql_upd);
	$peso= str_replace(',', '', $peso);
	$ssql="insert into detalle_factura values('$n_fac_real',$id,'$guia',$cantidad,$peso,0) ";
	$insert_tmp=odbc_exec($con, $ssql);
	

}
if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_tmp=intval($_GET['id']);	
	$delete=odbc_exec($con, "delete from detalle_factura WHERE id_guia='".$id_tmp."';");
	$update_it=odbc_exec($con, "update t_guias set add_fac=0 WHERE id_guia='".$id_tmp."';");
}

?>
<table class="table">
<tr>
	<th class='text-center'>#</th>
	<th class='text-center'>GUIA</th>
	<th class='text-center'>DEST. FINAL</th>
	<th class='text-center'>CANTIDAD</th>
	<th class='text-center'>PESO</th>
	<th></th>
</tr>
<?php
	$cuenta=0;
	$sumador_total=0;
	$sql=odbc_exec($con, "select * from detalle_factura where numero_factura='$n_fac_real' ");
	while ($row=odbc_fetch_array($sql))
	{
	$cuenta=intval($cuenta+1);
	$id_guia=$row['id_guia'];
	$id_detalle=$row["id_detalle"];
	$factura_det=$row['factura_det'];
	$cantidad=$row['cantidad'];
	$peso=$row['peso'];	
	$dest_final="";
	$count_query_rw = odbc_exec($con, " select b.nombre_cliente as cliente from t_guias as a 
		inner join t_clientes as b on b.id_cliente=a.id_cliente 
		where a.id_guia='$id_guia';");
	$row_r=odbc_fetch_array($count_query_rw);
	$dest_final = $row_r['cliente'];
	
		?>
		<tr>
			<td class='text-center'><?php echo $cuenta;?></td>
			<td class='text-center'><?php echo $factura_det;?></td>
			<td class='text-center'><?php echo $dest_final;?></td>
			<td class='text-center'><?php echo $cantidad;?></td>
			<td class='text-center'><?php echo $peso;?></td>
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_guia ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php
	}

?>

</table>
