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
	
	$fetch = odbc_exec($con,"SELECT top 50 * FROM t_remitentes where nombre_remitente like '%" .$cad. "%' "); 
	//echo "fetch: ".$fetch;
	/* Retrieve and store in array the results of the query.*/
	while ($row = odbc_fetch_array($fetch)) {
		$id_remitente=$row['id_remitente'];
		$row_array['value'] = $row['nombre_remitente'];
		$row_array['id_remitente']=$id_remitente;
		$row_array['ruc']=$row['RUC'];
		$row_array['nombre_remitente']=$row['nombre_remitente'];
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