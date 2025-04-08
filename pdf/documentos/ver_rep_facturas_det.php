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
	$desde= $_GET['desde'];
	$hasta= $_GET['hasta'];
	$q= $_GET['q'];

	$where1 = "";
	$where2 = "";
		if ($desde != ""){
			$where1.= " where CONVERT(date,a.fecha_factura)>='$desde' ";		
		}else{
			$where1.= " where CONVERT(date,a.fecha_factura)>='$hoy' ";
		}

		if($hasta != ""){
			$where1.= " and CONVERT(date,a.fecha_factura)<='$hasta' ";
		}else{
			$where1.= " and CONVERT(date,a.fecha_factura)<='$hoy' ";
		}

		if (rtrim($_GET['q'] != "")){
			$where2.= " and  (b.Raz_Social like '%$q%' or a.buscador like '%$q%')  and a.tipo='D' ";	
		}else{
			$where2.= " and a.tipo= 'D' ";
		}

	$sql="select  a.id_factura as id_factura,a.numero_factura as nfactura, a.buscador as buscador, 
		convert(varchar(10),convert(date,a.fecha_factura),103) as fecha_factura,
		case when b.RUC is not null then b.RUC 
		when b.RUC is null then 'ANULADO' end as ruc,
		case when b.Raz_Social is not null then b.Raz_Social 
		when  b.Raz_Social is null then 'ANULADO' end as rsocialremitente,
		b.Telefono as tremitente,b.Correo as eremitente,
		a.importe as importe,a.igv as igv,a.total as total 
		from t_facturas as a  
		left outer join t_remitentes as b on b.id_remitente=a.id_cliente $where1 $where2 order by a.id_factura ";
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
    include(dirname('__FILE__').'/res/reporte_facturas_det.php');
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
