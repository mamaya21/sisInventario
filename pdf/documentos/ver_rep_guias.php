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
			$where1.= " where CONVERT(date,a.fecha_guia)>='$desde' ";		
		}else{
			$where1.= " where CONVERT(date,a.fecha_guia)>='$hoy' ";
		}

		if($hasta != ""){
			$where1.= " and CONVERT(date,a.fecha_guia)<='$hasta' ";
		}else{
			$where1.= " and CONVERT(date,a.fecha_guia)<='$hoy' ";
		}

		if (rtrim($_GET['q'] != "")){
		$where2.= " and  (b.nombre_cliente like '%$q%' or a.buscador like '%$q%') ";	
		}
		
	$where1.=" group by a.id_guia,a.numero_guia,a.buscador,b.nombre_cliente,b.Telefono,b.Correo,c.Raz_Social,d.placa,a.fecha_guia, s.nombre_empresa ";

	$sql=" select a.id_guia as id_guia,a.numero_guia as nguia,a.buscador,
		convert(varchar(10),convert(date,a.fecha_guia),103) as emision,
		b.Telefono as tcliente,b.Correo as ecliente,d.placa as placa,
		SUM(e.cantidad_det) as cantidad, SUM(e.peso_det) as peso,
		case when b.nombre_cliente is not null then b.nombre_cliente when b.nombre_cliente is null then 'ANULADO' end as ncliente,
 		case when c.Raz_Social is not null then c.Raz_Social when c.Raz_Social is null then 'ANULADO' end as rsocialremitente,
 		case when s.nombre_empresa is not null then s.nombre_empresa when s.nombre_empresa is null then 'ANULADO' end as sub 
		from t_guias a 
		left outer join t_clientes b on b.id_cliente=a.id_cliente 
		left outer join t_remitentes c on c.id_remitente=a.id_remitente 
		left outer join t_transportes d on d.id_transporte=a.id_transporte 
		left outer join t_subcontratadas s on s.id_empresa=a.id_empresa 
		left outer join detalle_guia e on e.numero_guia=a.numero_guia $where1 $where2 order by id_guia ";
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
    include(dirname('__FILE__').'/res/reporte_guias.php');
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
