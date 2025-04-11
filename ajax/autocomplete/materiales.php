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
	
	$fetch = mysqli_query($con,"SELECT * FROM materiales where estado = 1 and nombre like '%" .$cad. "%' LIMIT 50 "); 

	while ($row = mysqli_fetch_assoc($fetch)) {
		$row_array['label'] = $row['nombre']; // Esto se mostrará en el desplegable
		$row_array['value'] = $row['nombre']; // Esto se pondrá en el input
		$row_array['nombre']=$row['nombre'];
		$row_array['id_material']=$row['id_material'];
		array_push($return_arr,$row_array);
    }
	
}

/* Free connection resources. */
//mysqli_close($con);

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

}
?>