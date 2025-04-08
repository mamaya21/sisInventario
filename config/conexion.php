<?php
	/*-------------------------
	Autor: Marco Amaya
	Web: en construccion
	Mail: marco1021tam@gmail.com
	---------------------------*/
	# conectare la base de datos
    $con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    #$servidor= "Driver={SQL Server};Server=".DB_HOST.";Database=".DB_NAME.";Integrated Security=SSPI;Persist Security Info=False;";
    #$con = odbc_connect( $servidor, DB_USER, DB_PASS);
    if(!$con){
        die("imposible conectarse: ".mysqli_error($con));
        #die(" imposible conectarse ");
    }
    if (@mysqli_connect_errno()) {
        die("Conexión falló ".mysqli_connect_errno()." : ". mysqli_connect_error());
        #die(" Conexión falló ");
    }

    
?>
