<?php
    /* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	$consulta = $_GET["sql"];

	/*
	$sql_consulta = " Select a.Consolidado, a.nro_consolidado , a.fecha, Cantidad, Peso, Cant_guias, placa, t3.buscador [Guias_asociadas] From	(
		Select 'CONS' + '' + RIGHT('00000' + Ltrim(Rtrim(a.nro_consolidado)),5) [Consolidado], a.nro_consolidado,
		convert(varchar(10),a.fecha,103) [fecha], sum(b.cantidad) [Cantidad], sum(b.peso) [Peso], count(b.id_guia) [Cant_guias], placa, a.guias_str
		From t_consolidados as a 
		inner join (
			Select a.id_guia, sum(b.cantidad_det) cantidad, sum(peso_det) peso, c.placa
			From t_guias as a
			Inner Join detalle_guia as b on b.numero_guia = a.numero_guia
			Inner Join t_transportes as c on c.id_transporte = a.id_transporte
			Where a.id_guia in (Select id_guia From t_consolidados Where estado_guia =1)
			Group by a.id_guia,  c.placa
		) as b on b.id_guia = a.id_guia
		Group by a.nro_consolidado, convert(varchar(10),a.fecha,103), placa, a.guias_str) as a 
		inner join t_consolidados as t2 on t2.nro_consolidado = a.nro_consolidado 
		inner join t_guias as t3 on t3.id_guia = t2.id_guia 
		$consulta 
		order by a.Consolidado desc ";
	*/
	
	$sql_consulta = " Select a.Consolidado, a.nro_consolidado , a.fecha, Cantidad, Peso, Cant_guias, placa, a.guias_str [Guias_asociadas] From	(
		Select 'CONS' + '' + RIGHT('00000' + Ltrim(Rtrim(a.nro_consolidado)),5) [Consolidado], a.nro_consolidado,
		convert(varchar(10),a.fecha,103) [fecha], sum(b.cantidad) [Cantidad], sum(b.peso) [Peso], count(b.id_guia) [Cant_guias], placa, b.guias_str
		From t_consolidados as a 
		inner join (
			Select a.id_guia, sum(b.cantidad_det) cantidad, sum(peso_det) peso, c.placa, a.buscador [guias_str]
			From t_guias as a
			Inner Join detalle_guia as b on b.numero_guia = a.numero_guia
			Inner Join t_transportes as c on c.id_transporte = a.id_transporte
			Where a.id_guia in (Select id_guia From t_consolidados Where estado_guia =1)
			Group by a.id_guia,  c.placa, a.buscador
		) as b on b.id_guia = a.id_guia
		Group by a.nro_consolidado, convert(varchar(10),a.fecha,103), placa, b.guias_str) as a 

		$consulta 
		order by a.Consolidado desc ";

	$resultado = odbc_exec($con, $sql_consulta);
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
							 ->setDescription("Reporte Consolidado de Guías")
							 ->setKeywords("Reporte Consolidado de Guías")
							 ->setCategory("Reporte excel");

		$tituloReporte = "Reporte Consolidado de Guías";
		//$tituloReporte = $sql_consulta;
		$titulosColumnas = array('# DE CONSOLIDADO', 'NRO_CONSOLIDADO', 'FECHA', 'CANTIDAD TOTAL','PESO TOTAL','CANT. GUÍAS','PLACA','GUÍAS ASOCIADAS');

		$objPHPExcel->setActiveSheetIndex(0)
        		    ->mergeCells('A1:H1');

		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1',$tituloReporte)
        		    ->setCellValue('A3',  $titulosColumnas[0])
		            ->setCellValue('B3',  $titulosColumnas[1])
        		    ->setCellValue('C3',  $titulosColumnas[2])
            		->setCellValue('D3',  $titulosColumnas[3])
            		->setCellValue('E3',  $titulosColumnas[4])
            		->setCellValue('F3',  $titulosColumnas[5])
            		->setCellValue('G3',  $titulosColumnas[6])
            		->setCellValue('H3',  $titulosColumnas[7]);

		//Se agregan los datos de los alumnos
		$i = 4;
		while ($fila = odbc_fetch_array($resultado)) {

			$objPHPExcel->setActiveSheetIndex(0)
        		    ->setCellValue('A'.$i,  ($fila['Consolidado']))
        		   	->setCellValue('B'.$i,  ($fila['nro_consolidado']))
        		    ->setCellValue('C'.$i,  ($fila['fecha']))
		            ->setCellValue('D'.$i,  ($fila['Cantidad']))
		            ->setCellValue('E'.$i,  ($fila['Peso']))
		            ->setCellValue('F'.$i,  ($fila['Cant_guias']))
            		->setCellValue('G'.$i,  ($fila['placa']))
            		->setCellValue('H'.$i,  ($fila['Guias_asociadas']));
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

		$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->applyFromArray($estiloTituloColumnas);
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:H".($i-1));

		for($i = 'A'; $i <= 'H'; $i++){
			$objPHPExcel->setActiveSheetIndex(0)
				->getColumnDimension($i)->setAutoSize(TRUE);
		}

		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Consolidados');

		// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
		$objPHPExcel->setActiveSheetIndex(0);
		// Inmovilizar paneles
		//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
		$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

		// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Reporte Consolidado de Guias.xlsx"');
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
