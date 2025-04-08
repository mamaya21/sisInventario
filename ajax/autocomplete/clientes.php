<?php
//$dd="pits";
if (isset($_GET['term'])){
include("../../config/db.php");
include("../../config/conexion.php");
$return_arr = array();
/* If connection to database, run sql statement. */
if ($con)
{

	$cad=$_GET['term'];
	$cad= str_replace( "'", "''", $cad);

	$query_consulta = "SELECT top 50 * FROM t_clientes where nombre_cliente like '%" .$cad. "%' ";
	$fetch = odbc_exec($con, $query_consulta);
	//echo "fetch: ".$fetch;
	/* Retrieve and store in array the results of the query.*/
	while ($row = odbc_fetch_array($fetch)) {
		$id_cliente=$row['id_cliente'];
		$row_array['value'] = $row['nombre_cliente'];
		$row_array['id_cliente']=$id_cliente;
		$row_array['ruc']=$row['RUC'];
		$row_array['nombre_cliente']=$row['nombre_cliente'];
		$row_array['telefono']=$row['Telefono'];
		$row_array['email']=$row['Correo'];
		array_push($return_arr,$row_array);
  }

}

/* Free connection resources. */
//mysqli_close($con);

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

}
?>
