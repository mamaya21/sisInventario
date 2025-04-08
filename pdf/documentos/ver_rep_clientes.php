<?php
	/*-------------------------
	Autor: Marco Amaya
	Web: -
	Mail: marco1021tam@gmail.com
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
    }
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");

	$q= $_GET['q'];

	$where = "";

		if (rtrim($q) != ""){
			$where.= " where nombre_cliente like '%$q%'  ";	
		}

	$sql="select Raz_Social,RUC,Telefono,Contacto,CONVERT(varchar(10),CONVERT(DATE,Fecha_ingreso),103) as Fecha_ingreso from  t_clientes $where order by nombre_cliente";
	$sql_exc=odbc_exec($con,$sql);
	$count=odbc_num_rows($sql_exc);
	if ($count==0)
	{
	echo "<script>alert('No Existe Reporte')</script>";
	echo "<script>window.close();</script>";
	exit;
	}
	

	$sql_pasar= $sql;
	
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
    // get the HTML
     ob_start();
    include(dirname('__FILE__').'/res/reporte_clientes.php');
    $content = ob_get_clean();
    ob_clean();
    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
        $html2pdf->Output('Reporte.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
