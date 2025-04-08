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
	
	$fetch = odbc_exec($con,"SELECT top 50 * FROM t_subcontratadas where nombre_empresa like '%" .$cad. "%' "); 
	//echo "fetch: ".$fetch;
	/* Retrieve and store in array the results of the query.*/
	while ($row = odbc_fetch_array($fetch)) {
		$id_empresa=$row['id_empresa'];
		$row_array['value'] = $row['nombre_empresa'];
		$row_array['id_empresa']=$id_empresa;
		$row_array['ruc']=$row['RUC'];
		$row_array['nombre_empresa']=$row['nombre_empresa'];
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