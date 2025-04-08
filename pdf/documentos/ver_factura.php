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
	$id_guia= intval($_GET['id_guia']);
	$sql_count=odbc_exec($con,"select * from t_guias where id_guia='".$id_guia."'");
	$count=odbc_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('Guia no encontrada')</script>";
	echo "<script>window.close();</script>";
	exit;
	}
	$sql_guia=odbc_exec($con,"select a.numero_guia as n_guia,CONVERT(VARCHAR(10),a.fecha_guia,103) as f_emision,
		CONVERT(VARCHAR(10),a.fecha_traslado,103) as f_traslado,a.costo_minimo as c_minimo,
		b.Direccion as dir_remitente,b.Raz_Social as remitente,b.RUC as ruc_remit,
		c.Direccion as dir_cliente,c.Raz_Social as cliente,c.RUC as ruc_clien,
		d.marca+' / '+d.placa as marca_placa,d.conf_vehicular as conf_vehicular,
		d.n_inscripcion as n_inscripcion,d.lic_conducir as lic_conducir, e.Raz_Social as subempresa, 
		e.RUC as  ruc_subemp, e.Direccion as dir_subempresa
		from t_guias as a 
		inner join t_remitentes as b on b.id_remitente=a.id_remitente 
		inner join t_clientes as c on c.id_cliente=a.id_cliente 
		inner join t_transportes as d on d.id_transporte=a.id_transporte 
		left outer join t_subcontratadas as e on e.id_empresa=a.id_empresa
		where a.id_guia='".$id_guia."'");

	$rw_guia=odbc_fetch_array($sql_guia);
	$numero_guia=$rw_guia['n_guia'];
	$fec_emision=$rw_guia['f_emision'];
	$fec_traslado=$rw_guia['f_traslado'];
	$cos_minimo=number_format($rw_guia['c_minimo'],2);
	$dir_remitente=$rw_guia['dir_remitente'];
	$remitente=$rw_guia['remitente'];
	$ruc_remitente=$rw_guia['ruc_remit'];
	//$dir_cliente=$rw_guia['dir_cliente'];
	$cliente=$rw_guia['cliente'];
	$ruc_cliente=$rw_guia['ruc_clien'];
	$marca_placa=$rw_guia['marca_placa'];
	$conf_vehicular=$rw_guia['conf_vehicular'];
	$n_inscripcion=$rw_guia['n_inscripcion'];
	$lic_conducir=$rw_guia['lic_conducir'];
	$subempresa= $rw_guia['subempresa'];
	$ruc_subemp= $rw_guia['ruc_subemp'];
	$dir_subcontratada= $rw_guia['dir_subempresa'];
	$dir_cliente='';
	if($dir_subcontratada!=''){
		$dir_cliente=$dir_subcontratada;
	}else{
		$dir_cliente=$rw_guia['dir_cliente'];
	}
	//$condiciones=$rw_guia['condiciones'];
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/ver_factura_html.php');
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
