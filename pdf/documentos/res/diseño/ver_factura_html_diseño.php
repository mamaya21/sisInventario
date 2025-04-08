<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
	background:#2c3e50;
	padding: 4px 4px 4px;
	color:white;
	font-weight:bold;
	font-size:12px;
}
.silver{
	background:white;
	padding: 3px 4px 3px;
}
.clouds{
	background:#ecf0f1;
	padding: 3px 4px 3px;
}
.border-top{
	border-top: solid 1px #bdc3c7;
	
}
.border-left{
	border-left: solid 1px #bdc3c7;
}
.border-right{
	border-right: solid 1px #bdc3c7;
}
.border-bottom{
	border-bottom: solid 1px #bdc3c7;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>
<style type="text/css">
    #piedepagina{
        width:720px;
        position: absolute;
        bottom: 0 !important;
        bottom: 4px;
    }    
</style>

<page backtop="13mm" backbottom="10mm" backleft="8mm" backright="12mm" style="font-size: 12pt; font-family: arial" >
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: auto; color: #444444;">
            <div style="width: 400px; height: 20px;"></div>
                <div style="width: 400px;"><img style="width: 400px; height:110px" src="../../img/logo.jpg" alt="Logo"></div>
          	</td>
            <td width="10px;">
            </td>
            <td style="width: 300px; color: #444444; border: 2px; border-radius: 7px;">
                 <div style="text-align: center; height:50px; ">
                 	<h2 style="margin: 2px 0 5px 5px;">R.U.C. 20601238544</h2>
                    <h4 style="margin: 2px 0 5px 5px;">REG. N° CNG 1567606</h4>
                 </div>
                 <div style="border: 2px; text-align: center; height:30px; margin: 5px -3px 5px -3px; background:#58ACFA">
                 <p style="text-align: center;margin: 5px 0px 5px 0px;"><b>
                 GUÍA DE REMISIÓN-TRANSPORTISTA</b>
                 </p>
                 </div>
                 <div style="text-align: center; height:40px;">
                 <h3 style="text-align: center;margin: 10px 0px 10px 0px;">001 - Nº <?php echo $numero_guia;?>
                 </h3>
                 </div>
          	</td>
        </tr>
        <tr>
          <td style="width: auto; color: #444444; font-size:9.5pt;">Fecha de Emisión: <?php echo $fec_emision;?></td>
          <td></td>
          <td style="width: 300px; color: #444444; "></td>
        </tr>
    </table>
    
    <table cellspacing="0" style="width: 100%;">
	        <tr>
            <td style="width: 50%; height:50px;color: #444444; border: 1px; border-radius: 7px;">
            <div style=" height:50px; ">
                 	<p style="margin: 0px 0 5px 5px; font-size:9.5pt;">Punto de Partida: <?php echo $dir_remitente;?> </p></div></td>
            
            <td style="width: 3px; height:50px;"></td>
            <td style="width: 50%; height:50px;color: #444444; border: 1px; border-radius: 7px;"><div style=" height:50px; ">
                 	<p style="margin: 0px 0 5px 5px; font-size:9.5pt;">Punto de Llegada: <?php echo $dir_cliente;?> </p></div></td>
        </tr>
    </table>
    
    <table cellspacing="0" style="width: 100%;">
    	<tr><td style="height:0.5px;"></td></tr>
    </table>
    
    <table cellspacing="0" style="width: 100%;">
	        <tr>
            <td style="width: 50%; height:75px;color: #444444; border: 1px; border-radius: 7px;">
            <div style=" height:50px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt;">Nombres o Razón Social del <b>REMITENTE</b>: <?php echo $remitente;?> </p></div>
                    
            <div style=" height:25px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt">RUC. N°: <?php echo $ruc_remitente;?> </p></div></td>
            
            <td style="width: 3px; height:75px;"></td>
            <td style="width: 50%; height:50px;color: #444444; border: 1px; border-radius: 7px;">
            <div style=" height:50px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt;">Nombres o Razón Social del <b>DESTINATARIO</b>: <?php echo $cliente;?> </p></div>
                    
            <div style=" height:25px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt;">RUC. N°: <?php echo $ruc_cliente;?> </p></div></td>
        </tr>
    </table>
    
    <table cellspacing="0" style="width: 100%;">
    	<tr><td style="height:0.5px;"></td></tr>
    </table>
    
    <table cellspacing="0" style="width: 100%;border: 1px; border-radius: 7px;">
	        <tr>                    
            <td style="width: 50%; height:81px;color: #444444; ">
            
            <div style="height:10px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:10pt;"><b>UNIDAD DE TRANSPORTE Y CONDUCTOR</b></p></div>
                    
           	<div style="height:1px;"></div>
            
            <div style=" height:35px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt;">Marca y Número de Placa: <?php echo $marca_placa;?> </p></div>
            <div style=" height:35px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt;">Código de Configuración Vehicular: <?php echo $conf_vehicular;?> </p></div></td>
            
            <td style="width: 3px; height:81px;"></td>
            <td style="width: 50%; height:81px;color: #444444;">
            <div style="height:10px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:10pt;"><b></b></p></div>
                    
            <div style="height:1px;"></div>
            
            <div style=" height:35px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt;">N° de Constancia de Inscripción: <?php echo $n_inscripcion;?> </p></div>
        	<div style=" height:35px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt;">N°(s) de Licencia(s) de Conducir: <?php echo $lic_conducir;?> </p></div></td>
        </tr>
    </table>
    
    <table cellspacing="0" style="width: 100%;">
    	<tr><td style="height:0.5px;"></td></tr>
    </table>
    
    <table cellspacing="0" style="width: 100%;">
	        <tr>
            <td style="width: 50%; height:30px;color: #444444; border: 1px; border-radius: 7px;">
            <div style=" height:30px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt;">Fecha de Inicio de Traslado: <?php echo $fec_traslado;?> </p></div></td>
            
            <td style="width: 3px; height:30px;"></td>
            <td style="width: 50%; height:30px;color: #444444; border: 1px; border-radius: 7px;"><div style=" height:30px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt;">Costo mínimo S/: <?php echo $cos_minimo;?> </p></div></td>
        </tr>
    </table>
    

	
    <!--<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:50%;" class='midnight-blue'>FACTURAR A</td>
        </tr>
		<tr>
           <td style="width:50%;" >
			<?php 
				$sql_cliente=mysqli_query($con,"select * from clientes where id_cliente='$id_cliente'");
				$rw_cliente=mysqli_fetch_array($sql_cliente);
				echo $rw_cliente['nombre_cliente'];
				echo "<br>";
				echo $rw_cliente['direccion_cliente'];
				echo "<br> Teléfono: ";
				echo $rw_cliente['telefono_cliente'];
				echo "<br> Email: ";
				echo $rw_cliente['email_cliente'];
			?>
			
		   </td>
        </tr>
        
   
    </table>
    
       <br>
		<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:35%;" class='midnight-blue'>VENDEDOR</td>
		  <td style="width:25%;" class='midnight-blue'>FECHA</td>
		   <td style="width:40%;" class='midnight-blue'>FORMA DE PAGO</td>
        </tr>
		<tr>
           <td style="width:35%;">
			<?php 
				$sql_user=mysqli_query($con,"select * from users where user_id='$id_vendedor'");
				$rw_user=mysqli_fetch_array($sql_user);
				echo $rw_user['firstname']." ".$rw_user['lastname'];
			?>
		   </td>
		  <td style="width:25%;"><?php echo date("d/m/Y", strtotime($fecha_factura));?></td>
		   <td style="width:40%;" >
				<?php 
				if ($condiciones==1){echo "Efectivo";}
				elseif ($condiciones==2){echo "Cheque";}
				elseif ($condiciones==3){echo "Transferencia bancaria";}
				elseif ($condiciones==4){echo "Crédito";}
				?>
		   </td>
        </tr>
		
        
   
    </table>-->
	<br>
  
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt; border:1px">
        <tr style="border:1px;">
            <th style="width: 10%;text-align:center" class='midnight-blue'>ITEM</th>
            <th style="width: 40%;text-align:center" class='midnight-blue'>DESCRIPCION</th>
            <th style="width: 15%;text-align: center" class='midnight-blue'>CANTIDAD</th>
            <th style="width: 20%;text-align: center" class='midnight-blue'>MEDIDA</th>
            <th style="width: 15%;text-align: center" class='midnight-blue'>PESO TOTAL</th>
            
        </tr>
        
        <tr  style="border:1px;">
            <td style="widtd: 10%; text-align: center; border:1px;widtd: 50%"></td>
            <td style="widtd: 40%; text-align: center;border:1px;widtd: 50%"><p>Productos Plásticos</p></td>
            <td style="widtd: 15%; text-align: center;border:1px;widtd: 50%"></td>
            <td style="widtd: 20%; text-align: center;border:1px;widtd: 50%"></td>
            <td style="widtd: 15%; text-align: center;border:1px;widtd: 50%"></td>
        </tr>
        
        <tr  style="border:1px;">
            <td style="widtd: 10%; text-align: right;border:1px;widtd: 50%"></td>
            <td style="widtd: 40%; text-align: center;border:1px;widtd: 50%"><p>Según Guía de Remisión</p></td>
            <td style="widtd: 15%; text-align: right;border:1px;widtd: 50%"></td>
            <td style="widtd: 20%; text-align: right;border:1px;widtd: 50%"></td>
            <td style="widtd: 15%; text-align: right;border:1px;widtd: 50%"></td>
        </tr>

<?php
$nums=1;
$sumador_total=0;
$sql=odbc_exec($con, "select guia_det as detalle, cantidad_det as cantidad,
    medida_det as medida,peso_det as peso 
    from detalle_guia 
    where numero_guia=".$numero_guia." 
    order by id_detalle;");

while ($row=odbc_fetch_array($sql))
	{
	$id_guia=" ";
	$descripcion=$row['detalle'];
	//$cantidad=$row['cantidad'];
    $cantidad=$row['cantidad'];
    $medida=$row['medida'];
	$peso=$row['peso'];
	
	/*$precio_venta=$row['precio_venta'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador*/
	if ($nums%2==0){
		$clase="clouds";
	} else {
		$clase="silver";
	}
    $sumador_total+=$cantidad;
	?>

        <tr  style="border:1px;">
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center;border:1px"><?php echo $id_guia;?></td>
            <td class='<?php echo $clase;?>' style="width: 40%; text-align: center;border:1px"><?php echo $descripcion;?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: center;border:1px"><?php echo $cantidad;?></td>
            <td class='<?php echo $clase;?>' style="width: 20%; text-align: center;border:1px"><?php echo $medida;?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: center;border:1px"><?php echo $peso;?></td>
            
        </tr>

	<?php 

	
	$nums++;
	}
	$subtotal=number_format($sumador_total,2,'.','');
	/*$total_iva=($subtotal * TAX )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva;*/
?>
	  
        <tr>
            <td colspan="2" style="widtd: 50%; text-align: right;border:1px">TOTALES &#36; </td>
            <td style="widtd: 15%; text-align: center;border:1px"> <?php echo number_format($subtotal,0);?></td>
            <td style="widtd: 20%; text-align: center;border:1px"> <?php echo $medida;?></td>
            <td style="widtd: 15%; text-align: center;border:1px"> <?php echo number_format($subtotal,2);?></td>
        </tr>
		<!--<tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">IVA (<?php echo TAX; ?>)% &#36; </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_iva,2);?></td>
        </tr><tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL &#36; </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_factura,2);?></td>
        </tr>-->
    </table>
	
	
	
	<br>
    <div id="piedepagina">
	<div style="font-size:8pt;text-align:center;font-weight:bold">LLENAR SÓLO EN CASO DE TRATARSE DE UNIDADES SUB-CONTRATADAS</div>
	
	    <table cellspacing="0" style="width: 100%;height:20px;border: 1px; border-radius: 7px;">
	        <tr>
            <td style="width: 80%; height:20px;color: #444444;">
            <div style=" height:10px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt;">Nombre o Razón Social de la empresa Sub-Contratada:............................................................</p></div></td>

            <td style="width: 20%; height:20px;color: #444444; "><div style=" height:10px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt;">RUC. N°:..................</p></div></td>
        </tr>
    </table>

<table cellspacing="0" style="width: 100%;height:60px;">
	        <tr>
            <td style="width: 5%; height:60px;color: #444444;">
            <div style=" height:60px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt;"></p></div></td>
                    <td style="width: 40%; height:60px;color: #444444;">
                    <div style=" height:58px; border-bottom:1px">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt;text-align:center"></p></div>
                    
                    <div style=" height:2px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:8pt;text-align:center">p. LOGISTICA INTEGRAL CIMEK SAC</p></div></td>
                    
                    <td style="width:10%;height:60px"></td>
            
                    <td style="width: 30%; height:60px;color: #444444;">
            <div style=" height:58px; border-bottom:1px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt;text-align:center"></p></div>
            <div style=" height:2px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:8pt;text-align:center">Recibí Conforme</p></div>
                    </td>
                    
			
            <td style="width: 15%; height:60px;color: #444444; "><div style=" height:60px; ">
                 	<p style="margin: 20px 0 5px 5px; font-size:9.5pt;text-align:right"><b>REMITENTE</b></p></div></td>
        </tr>
    </table>
    </div>
    
</page>
