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
	$id_factura= intval($_GET['id_factura']);
	$sql_count=odbc_exec($con,"select * from t_facturas where id_factura='".$id_factura."'");
	$count=odbc_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('Factura no encontrada')</script>";
	echo "<script>window.close();</script>";
	exit;
	}
	$sql_factura=odbc_exec($con,"select a.numero_factura as n_factura,a.importe as importe,a.igv as igv, a.total as total,
		b.Raz_Social as remitente,b.RUC as  ruc_remit,b.Direccion as dir_remitente,
		DATEPART(dd,a.fecha_factura) as dia, 
		rtrim(CONVERT(varchar(25),datename(MM,a.fecha_factura))) as mes,
		substring(CONVERT(varchar(4),DATEPART(YEAR,a.fecha_factura)),4,1) as anio 
		from t_facturas as a 
		inner join t_remitentes as b on b.id_remitente=a.id_cliente 
		where a.id_factura='".$id_factura."'");

	$rw_factura=odbc_fetch_array($sql_factura);
	$numero_factura=$rw_factura['n_factura'];
	$importe=number_format($rw_factura['importe'],2);
	$importe=str_replace(',', '', $importe);
	$igv=number_format($rw_factura['igv'],2);
	$igv=str_replace(',', '', $igv);
	$total=number_format($rw_factura['total'],2);
	$total=str_replace(',', '', $total);
	$remitente=$rw_factura['remitente'];
	$dir_remitente=$rw_factura['dir_remitente'];
	$ruc_remitente=$rw_factura['ruc_remit'];
	
	$dia=$rw_factura['dia'];
	$mes=$rw_factura['mes'];
	$anio=$rw_factura['anio'];
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/ver_factura_html3.php');
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
        $html2pdf->Output('Factura.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
