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
                 FACTURA</b>
                 </p>
                 </div>
                 <div style="text-align: center; height:40px;">
                 <h3 style="text-align: center;margin: 10px 0px 10px 0px;">001 - Nº <?php echo $numero_factura;?>
                 </h3>
                 </div>
          	</td>
        </tr>
        <tr>
          <td style="width: auto; font-size:9.5pt;">Lima,<?php echo $dia;?>  de      <?php echo $mes;?>   del 201 <?php echo $anio;?></td>
          <td></td>
          <td style="width: 300px; color: #444444; "></td>
        </tr>
    </table>

    <table cellspacing="0" style="width: 100%;">
            <tr>
            <td style="width: 70%; height:20px;">
            <div style=" height:20px; ">
                    <p style="margin: 7px 0 0px 0px; font-size:9.5pt;">Señor (es):    <?php echo $remitente;?> </p></div></td>
            
            <td style="width: 3px; height:20px;"></td>

            <td style="width: 30%; height:20px;">
            <div style=" height:20px; ">
                    <p style="margin: 7px 0 0px 0px; font-size:9.5pt;">R.U.C:    <?php echo $ruc_remitente;?> </p></div></td>
        </tr>
    </table>
    
    <table cellspacing="0" style="width: 100%;">
            <tr>
            <td style="width: 80%; height:20px;">
            <div style=" height:20px; ">
                    <p style="margin: 7px 0 0px 0px; font-size:9.5pt;">Dirección:    <?php echo $dir_remitente;?> </p></div></td>
            
            <td style="width: 3px; height:20px;"></td>
            <td style="width: 20%; height:20px;">
            <div style=" height:20px; ">
                    <p style="margin: 7px 0 0px 0px; font-size:9.5pt;"></p></div></td>
        </tr>
    </table>
   
   <table cellspacing="0" style="width: 100%;">
            <tr>
            <td style="width: 40%; height:20px;">
            <div style=" height:20px; ">
                    <p style="margin: 7px 0 0px 0px; font-size:9.5pt;">Guía de Remisión</p></div></td>
            
            <td style="width: 20%; height:20px;">
            <div style=" height:20px; ">
                    <p style="margin: 7px 0 0px 0px; font-size:9.5pt;">OC</p></div></td>

            <td style="width: 40%; height:20px;">
            <div style=" height:20px; ">
                    <p style="margin: 7px 0 0px 0px; font-size:9.5pt;">Referencia</p></div></td>
        </tr>
    </table>
    
    
    
    

	
    <!--<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:50%;" class='midnight-blue'>FACTURAR A</td>
        </tr>
		<tr>
           <td style="width:50%;" >
			<?php 
				$sql_cliente=mysqli_query($con,"select * from clientes where id_cliente='$id_remitente'");
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
            <th style="width: 8%;text-align:center" class='midnight-blue'>CANT</th>
            <th style="width: 64%;text-align:center" class='midnight-blue'>DESCRIPCION</th>
            <th style="width: 14%;text-align: center" class='midnight-blue'>PRECIO UNIT.</th>
            <th style="width: 14%;text-align: center" class='midnight-blue'>IMPORTE</th>
            
        </tr>
        
        <tr  style="border:1px;">
            <td style="widtd: 8%; text-align: center; border:1px;"></td>
            <td style="widtd: 64%; text-align: center;border:1px;">SERVICIO DE TRANSPORTE REALIZADO SEGUN GUIAS</td>
            <td style="widtd: 14%; text-align: center;border:1px;"></td>
            <td style="widtd: 14%; text-align: center;border:1px;"><?php echo $importe; ?></td>
        </tr>

<?php
$nums=1;
$sumador_total=0;
$sql=odbc_exec($con, "select factura_det as detalle 
    from detalle_factura 
    where numero_factura=".$numero_factura." 
    order by id_detalle;");
$i=1;
while ($row=odbc_fetch_array($sql))
	{
	$id_guia=" ";
	$descripcion=$row['detalle'];
	//$cantidad=$row['cantidad'];
	
	/*$precio_venta=$row['precio_venta'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador*/
	if ($nums%2==0){
		//$clase="clouds";
        $clase="silver";
	} else {
		$clase="silver";
	}
    $sumador_total=$sumador_total+1;
	?>

        <tr  style="border:1px;">
            <td class='<?php echo $clase;?>' style="width: 8%; text-align: center;border:1px"><?php echo $sumador_total;?></td>
            <td class='<?php echo $clase;?>' style="width: 64%; text-align: center;border:1px"><?php echo $descripcion;?></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: center;border:1px"></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: center;border:1px"></td>
            
        </tr>

	<?php 

	
	$nums++;
    $i++;
	}
	$subtotal=number_format($sumador_total,2,'.','');
	/*$total_iva=($subtotal * TAX )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva;*/
    for ($x=$i; $x <8; $x++) { 
        ?>
        <tr  style="border:1px;">
            <td class='<?php echo $clase;?>' style="width: 8%; text-align: center;border:1px"><?php echo $x; ?></td>
            <td class='<?php echo $clase;?>' style="width: 64%; text-align: center;border:1px"></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: center;border:1px"></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: center;border:1px"></td>
            
        </tr>
        <?php 
    }

?>

    <tr  style="border:1px;">
            <td class='<?php echo $clase;?>' style="width: 8%; text-align: center;border-left:1px;border-bottom: 1px;border-top: 1px;"><b>  SON:</b></td>
            <td class='<?php echo $clase;?>' style="width: 64%; text-align: center;border-bottom: 1px;border-top: 1px;"></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: center;border-bottom: 1px;border-top: 1px;border-right: 1px"></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: center;border:1px"></td>
            
        </tr>
    </table>

	  <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt; ">
		<tr>
            <td class='<?php echo $clase;?>' style="width: 8%; text-align: center;"></td>
            <td class='<?php echo $clase;?>' style="width: 64%; text-align: center;"></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: left;border-right: 1px;border-left: 1px;border-bottom: 1px;"><b> SUBTOTAL</b></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: center;border-right: 1px;border-left: 1px;border-bottom: 1px;"><?php echo $importe; ?></td>
        </tr>
        <tr>
            <td class='<?php echo $clase;?>' style="width: 8%; text-align: center;"></td>
            <td class='<?php echo $clase;?>' style="width: 64%; text-align: center;"></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: left;border:1px"><b> IGV   %</b></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: center;border:1px"><?php echo $igv; ?></td>
        </tr>
        <tr>
            <td class='<?php echo $clase;?>' style="width: 8%; text-align: center;"></td>
            <td class='<?php echo $clase;?>' style="width: 64%; text-align: center;"></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: left;border:1px"><b> TOTAL  S/</b></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: center;border:1px"><?php echo $total; ?></td>
        </tr>
    </table>
<table cellspacing="0" style="width: 100%;height:60px;">
	        <tr>
            <td style="width: 30%; height:60px;color: #444444;">
            <div style=" height:60px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt;"></p></div></td>
                    <td style="width: 20%; height:60px;color: #444444;">
                    <div style=" height:58px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt;text-align:center"></p></div>
                    
                    <div style=" height:2px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:8pt;text-align:center"></p></div></td>
                    
                    <td style="width:10%;height:60px"></td>
            
                    <td style="width: 10%; height:60px;color: #444444;">
            <div style=" height:58px;  ">
                 	<p style="margin: 5px 0 5px 5px; font-size:9.5pt;text-align:center"></p></div>
            <div style=" height:2px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:8pt;text-align:center"></p></div>
                    </td>
                    
			
            <td style="width: 30%; height:60px;color: #444444; "><div style=" height:60px; ">
                 	<p style="margin: 20px 0 5px 5px; font-size:9.5pt;text-align:center"><b>ADQUIRIENTE O USUARIO</b></p></div></td>
        </tr>
    </table>
</page>
