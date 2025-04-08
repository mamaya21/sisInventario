<?php
    /* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	$hoy=date("Y/m/d");

	$desde = $_GET["desde"];
	$hasta = $_GET["hasta"];
	$q = $_GET["q"];

	if($desde==""){ $desde=$hoy; }

	if($hasta==""){	$hasta=$hoy; }
	$sWhere2 = "";
	if ($desde != ""){
		$sWhere2.= " where CONVERT(date,a.fecha_guia)>='$desde' ";
	}else{
		$sWhere2.= " where CONVERT(date,a.fecha_guia)>='$hoy' ";
	}

	if($hasta != ""){
		$sWhere2.= " and CONVERT(date,a.fecha_guia)<='$hasta' ";
	}else{
		$sWhere2.= " and CONVERT(date,a.fecha_guia)<='$hoy' ";
	}

	$sWhere = "";
	 if ( $q != "" )
	 {
		 $sWhere.= " and  (b.nombre_cliente like '%$q%' or a.buscador like '%$q%') ";
	 }
	  /*
	$sWhere.=" group by a.id_guia,a.numero_guia,a.buscador,b.nombre_cliente,b.Telefono,b.Correo,c.Raz_Social,d.placa,a.fecha_guia, s.nombre_empresa,a.estado_guia,c.Direccion,b.Direccion,s.Direccion
	 	,c2.nro_consolidado, b.id_distrito, e.guia_det, e.cantidad_det, e.peso_det "; 
	
	 
	$sql_repor=" select a.id_guia as id_guia,a.numero_guia as nguia,a.buscador,
		c.Direccion as punto_partida,
		(case when s.Direccion is null then b.Direccion
		when s.Direccion is not null then s.Direccion
		end) as punto_llegada,
		convert(varchar(10),convert(date,a.fecha_guia),103) as emision,
		b.Telefono as tcliente,b.Correo as ecliente, d.placa as placa,
		--SUM(e.cantidad_det) as cantidad, SUM(e.peso_det) as peso,
		dbo.Sumar_Tipo('CANTIDAD',a.id_guia) [cantidad], dbo.Sumar_Tipo('PESO',a.id_guia)[peso],
		case when b.nombre_cliente is not null then b.nombre_cliente
		when b.nombre_cliente is null then 'ANULADO' end as ncliente,
		case when c.Raz_Social is not null then c.Raz_Social
		when c.Raz_Social is null then 'ANULADO' end as rsocialremitente,
		case when s.nombre_empresa is not null then s.nombre_empresa
		when s.nombre_empresa is null then 'ANULADO' end as sub
		,ISNULL('CONS' + '' + RIGHT('00000' + Ltrim(Rtrim(c2.nro_consolidado)),5),'-') as consolidado
		, dbo.[fnGetPrecio](b.id_distrito, SUM(e.peso_det)) as precio
		, e.guia_det [asociadas], e.cantidad_det [cant_asociada], e.peso_det [peso_asociada] 

		from t_guias a
		left outer join t_clientes b on b.id_cliente=a.id_cliente
		left outer join t_remitentes c on c.id_remitente=a.id_remitente
		left outer join t_transportes d on d.id_transporte=a.id_transporte
		left outer join t_subcontratadas s on s.id_empresa=a.id_empresa
		left outer join detalle_guia e on e.numero_guia=a.numero_guia
		left outer join t_consolidados c2 on c2.id_guia = a.id_guia
		$sWhere2 $sWhere order by id_guia ";

	*/

	$sWhere.=" group by a.id_guia,a.numero_guia,a.buscador,b.nombre_cliente,b.Telefono,b.Correo,c.Raz_Social,d.placa,a.fecha_guia, s.nombre_empresa,a.estado_guia,c.Direccion,b.Direccion,s.Direccion
	,c2.nro_consolidado, b.id_distrito, e.guia_det, e.cantidad_det, e.peso_det, tg2.cantidad, tg2.peso ";

	$sql_repor=" select a.id_guia as id_guia,a.numero_guia as nguia,a.buscador,
		c.Direccion as punto_partida,
		(case when s.Direccion is null then b.Direccion
		when s.Direccion is not null then s.Direccion
		end) as punto_llegada,
		convert(varchar(10),convert(date,a.fecha_guia),103) as emision,
		b.Telefono as tcliente,b.Correo as ecliente, d.placa as placa,
		tg2.cantidad, tg2.peso,
		case when b.nombre_cliente is not null then b.nombre_cliente
		when b.nombre_cliente is null then 'ANULADO' end as ncliente,
		case when c.Raz_Social is not null then c.Raz_Social
		when c.Raz_Social is null then 'ANULADO' end as rsocialremitente,
		case when s.nombre_empresa is not null then s.nombre_empresa
		when s.nombre_empresa is null then 'ANULADO' end as sub
		,ISNULL('CONS' + '' + RIGHT('00000' + Ltrim(Rtrim(c2.nro_consolidado)),5),'-') as consolidado
		, dbo.[fnGetPrecio](b.id_distrito, SUM(e.peso_det)) as precio
		, e.guia_det [asociadas], e.cantidad_det [cant_asociada], e.peso_det [peso_asociada] 

		from t_guias a 
		left outer join t_clientes b on b.id_cliente=a.id_cliente 
		left outer join t_remitentes c on c.id_remitente=a.id_remitente 
		left outer join t_transportes d on d.id_transporte=a.id_transporte 
		left outer join t_subcontratadas s on s.id_empresa=a.id_empresa 
		left outer join detalle_guia e on e.numero_guia=a.numero_guia 
		left outer join t_consolidados c2 on c2.id_guia = a.id_guia 
		left outer join (
			select a.id_guia, SUM(c.cantidad_det) as cantidad, SUM(c.peso_det) as peso 
			from t_guias as a  
			inner join detalle_guia as c on c.numero_guia = a.numero_guia  
			left outer join t_clientes b on b.id_cliente=a.id_cliente 
			$sWhere2 
			group by a.id_guia
		) as tg2 on tg2.id_guia = a.id_guia 
		$sWhere2 $sWhere order by id_guia ";


	$resultado = odbc_exec($con, $sql_repor);
	//if($resultado->num_rows > 0 ){
if(1 > 0 ){
		if (PHP_SAPI == 'cli')
			die('Este archivo solo se puede ver desde un navegador web');

		/** Se agrega la libreria PHPExcel */
		require_once '../libraries/PHPExcel/PHPExcel.php';

		// Se crea el objeto PHPExcel
		$objPHPExcel = new PHPExcel();

		// Se asignan las propiedades del libro
		$objPHPExcel->getProperties()->setCreator("CIMEK") //Autor
							 ->setLastModifiedBy("CIMEK") //Ultimo usuario que lo modificó
							 ->setTitle("Reporte Excel")
							 ->setSubject("Reporte Excel")
							 ->setDescription("Reporte de guias")
							 ->setKeywords("reporte guias")
							 ->setCategory("Reporte excel");

		$tituloReporte = "Reporte de Guias Generadas";
		//$tituloReporte = $sql_repor;
		$titulosColumnas = array('# DE GUIA', 'FECHA', 'CLIENTE', 'DESTINATARIO','PUNTO DE PARTIDA','PUNTO DE LLEGADA','SUB-CONTRATADA','MOVILIDAD','CANTIDAD','PESO','PRECIO','CONSOLIDADO','GUIA ASOCIADA','CANT. GUIA ASOC.','PESO GUIA ASOC.');

		$objPHPExcel->setActiveSheetIndex(0)
        		    ->mergeCells('A1:O1');

		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1',	$tituloReporte)
        		    ->setCellValue('A3',  	$titulosColumnas[0])
		            ->setCellValue('B3',  	$titulosColumnas[1])
        		    ->setCellValue('C3',  	$titulosColumnas[2])
            		->setCellValue('D3',  	$titulosColumnas[3])
            		->setCellValue('E3',  	$titulosColumnas[4])
            		->setCellValue('F3',  	$titulosColumnas[5])
            		->setCellValue('G3',  	$titulosColumnas[6])
            		->setCellValue('H3',  	$titulosColumnas[7])
            		->setCellValue('I3',  	$titulosColumnas[8])
            		->setCellValue('J3',  	$titulosColumnas[9])
					->setCellValue('K3',  	$titulosColumnas[10])
					->setCellValue('L3',  	$titulosColumnas[11])
					->setCellValue('M3',  	$titulosColumnas[12])
					->setCellValue('N3',  	$titulosColumnas[13])
					->setCellValue('O3',  	$titulosColumnas[14]);

		//Se agregan los datos de los alumnos
		$i = 4;
		while ($fila = odbc_fetch_array($resultado)) {
			$sub="";
			if($fila['sub']!="NULL"){
				$sub=$fila['sub'];
			}
			$objPHPExcel->setActiveSheetIndex(0)
        		    ->setCellValue('A'.$i,  $fila['buscador'])
        		   	->setCellValue('B'.$i,  $fila['emision'])
        		    ->setCellValue('C'.$i,  utf8_encode($fila['rsocialremitente']))
		            ->setCellValue('D'.$i,  utf8_encode($fila['ncliente']))
		            ->setCellValue('E'.$i,  utf8_encode($fila['punto_partida']))
		            ->setCellValue('F'.$i,  utf8_encode($fila['punto_llegada']))
            		->setCellValue('G'.$i,  utf8_encode($sub))
            		->setCellValue('H'.$i,  utf8_encode($fila['placa']))
            		->setCellValue('I'.$i, $fila['cantidad'])
            		->setCellValue('J'.$i, $fila['peso'])
					->setCellValue('K'.$i, $fila['precio'])
					->setCellValue('L'.$i, $fila['consolidado'])
					->setCellValue('M'.$i, $fila['asociadas'])
					->setCellValue('N'.$i, $fila['cant_asociada'])
					->setCellValue('O'.$i, $fila['peso_asociada']);
					$i++;
		}

		$estiloTituloReporte = array(
        	'font' => array(
	        	'name'      => 'Verdana',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>16,
	            	'color'     => array(
    	            	'rgb' => 'FFFFFF'
        	       	)
            ),
	        'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('argb' => 'FF220835')
			),
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_NONE
               	)
            ),
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );

		$estiloTituloColumnas = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,
                'color'     => array(
                    'rgb' => 'FFFFFF'
                )
            ),
            'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				'rotation'   => 80,
        		'startcolor' => array(
            		'rgb' => '3a2a47'
        		),
        		'endcolor'   => array(
            		'argb' => '3a2a47'
        		)
			),
            'borders' => array(
            	'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '143860'
                    )
                ),
                /*'bottom'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '143860'
                    )
                )*/
            ),
			'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'wrap'          => TRUE
    		));

		$estiloInformacion = new PHPExcel_Style();
		$estiloInformacion->applyFromArray(
			array(
           		'font' => array(
               	'name'      => 'Arial',
               	'color'     => array(
                   	'rgb' => '000000'
               	)
           	),
           	'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'		=> array('argb' => 'FFFFFF')
			),
           	'borders' => array(
               	'left'     => array(
                   	'style' => PHPExcel_Style_Border::BORDER_THIN ,
	                'color' => array(
    	            	'rgb' => '3a2a47'
                   	)
               	)
           	)
        ));

		$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A3:O3')->applyFromArray($estiloTituloColumnas);
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:O".($i-1));

		for($i = 'A'; $i <= 'L'; $i++){
			$objPHPExcel->setActiveSheetIndex(0)
				->getColumnDimension($i)->setAutoSize(TRUE);
		}

		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Guias');

		// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
		$objPHPExcel->setActiveSheetIndex(0);
		// Inmovilizar paneles
		//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
		$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

		// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Reporte de Guias.xlsx"');
		//header('Cache-Control: max-age=0');
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		ob_end_clean();
		$objWriter->save('php://output');
		exit;
	}
	else{
		print_r('No hay resultados para mostrar');
	}
?>
