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
	
	$fetch = odbc_exec($con,"SELECT top 50 * FROM t_transportes where placa like '%" .$cad. "%' "); 
	//echo "fetch: ".$fetch;
	/* Retrieve and store in array the results of the query.*/
	while ($row = odbc_fetch_array($fetch)) {
		$id_transporte=$row['id_transporte'];
		$row_array['value'] = $row['placa'];
		$row_array['id_transporte']=$id_transporte;
		$row_array['placa_transporte']=$row['placa'];
		$row_array['marca']=$row['marca'];
		$row_array['licencia']=$row['lic_conducir'];
		array_push($return_arr,$row_array);
    }
	
}

/* Free connection resources. */
//mysqli_close($con);

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

}
?>