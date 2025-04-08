<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
	/*background:#2c3e50;*/
    background: #FFFFFF;
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
    }    
</style>

<!--<page backtop="18mm" backbottom="10mm" backleft="8mm" backright="12mm" style="font-size: 12pt; font-family: arial" >-->
<page backtop="16mm" backbottom="1mm" backleft="6mm" backright="10mm" style="font-size: 12pt; font-family: arial" >
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: auto; ">
            <div style="width: 400px; height: 20px;"></div>
                <div style="width: 400px;"></div>
          	</td>
            <td width="10px;">
            </td>
            <td style="width: 300px; color: #FFFFFF; border: 0px; border-radius: 7px;">
                 <div style="text-align: center; height:50px; ">
                 	<h2 style="margin: 2px 0 5px 5px;">R.U.C. 20601238544</h2>
                    <h4 style="margin: 2px 0 5px 5px;">REG. N° CNG 1567606</h4>
                 </div>
                 <div style="border: 0px; text-align: center; height:30px; margin: 5px -3px 5px -3px; background:#FFFFFF;">
                 
                 </div>
                 <div style="text-align: center; height:40px;">
                 <h3 style="text-align: center;margin: 10px 0px 10px 0px;">001 - Nº <?php echo $numero_guia;?>
                 </h3>
                 </div>
          	</td>
        </tr>
        <tr>
          <td style="width: auto; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $fec_emision;?></b></td>
          <td></td>
          <td style="width: 300px; "></td>
        </tr>
    </table>
    
    <table cellspacing="0" style="width: 100%;">
	        <tr>
            <td style="width: 50%; height:50px; border: 0px; border-radius: 7px;">
            <div style=" height:50px; ">
                 	<p style="margin: 17px 0 5px 2px; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $dir_remitente;?></b> </p></div></td>
																																																																	
            <td style="width: 3px; height:50px;"></td>
            <td style="width: 50%; height:50px; border: 0px; border-radius: 7px;"><div style=" height:50px; ">
                 	<p style="margin: 17px 0 5px 5px; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $dir_cliente;?></b> </p></div></td>
        </tr>
    </table>
    
    <table cellspacing="0" style="width: 100%;">
    	<tr><td style="height:0.5px;"></td></tr>
    </table>
    
    <table cellspacing="0" style="width: 100%;">
	        <tr>
            <td style="width: 50%; height:75px; border: 0px; border-radius: 7px;">
            <div style=" height:50px; ">
                 	<p style="margin: 8px 0 5px 5px; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $remitente;?> </b></p></div>
                    
            <div style=" height:25px; ">
                 	<p style="margin: 3px 0 5px 5px; font-size:9.5pt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $ruc_remitente;?> </b></p></div></td>
            
            <td style="width: 3px; height:75px;"></td>
            <td style="width: 50%; height:50px; border: 0px; border-radius: 7px;">
            <div style=" height:50px; ">
                 	<p style="margin: 8px 0 5px 5px; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $cliente;?></b> </p></div>
                    
            <div style=" height:25px; ">
                 	<p style="margin: 3px 0 5px 5px; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $ruc_cliente;?></b> </p></div></td>
        </tr>
    </table>
    
    <table cellspacing="0" style="width: 100%;">
    	<tr><td style="height:0.5px;"></td></tr>
    </table>
    
    <table cellspacing="0" style="width: 100%;border: 0px; border-radius: 7px;">
	        <tr>                    
            <td style="width: 50%; height:69px; ">
            
            <div style="height:10px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:10pt;"><b></b></p></div><div style=" height:35px; ">
                 	<p style="margin: 3px 0 5px 5px; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $marca_placa;?></b> </p></div>
            <div style=" height:23px; ">
                 	<p style="margin: 3px 0 5px 5px; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $conf_vehicular;?></b> </p></div></td>
            
            <td style="width: 3px; height:69px;"></td>
            <td style="width: 50%; height:69px;">
            <div style="height:10px; ">
                 	<p style="margin: 5px 0 5px 5px; font-size:10pt;"><b></b></p></div>
            
            <div style=" height:35px; ">
                 	<p style="margin: 3px 0 5px 5px; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $n_inscripcion;?></b> </p></div>
        	<div style=" height:23px; ">
                 	<p style="margin: 2px 0 5px 5px; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $lic_conducir;?></b> </p></div></td>
        </tr>
    </table>
    
    <table cellspacing="0" style="width: 100%;">
    	<tr><td style="height:0.5px;"></td></tr>
    </table>
    
    <table cellspacing="0" style="width: 100%;">
	        <tr>
            <td style="width: 50%; height:30px; border: 0px; border-radius: 7px;">
            <div style=" height:30px; ">
                 	<p style="margin: 6px 0 5px 5px; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $fec_traslado;?></b> </p></div></td>
            
            <td style="width: 3px; height:30px;"></td>
            <td style="width: 50%; height:30px; border: 0px; border-radius: 7px;"><div style=" height:30px; ">
                 	<p style="margin: 6px 0 5px 5px; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $cos_minimo;?></b> </p></div></td>
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

    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt; border:1px; border-color: #FFFFFF;">
       <!-- <tr style="border:1px;">
            <th style="width: 10%;text-align:center; height:19px;" >.&nbsp; </th>
            <th style="width: 40%;text-align:center" > </th>
            <th style="width: 15%;text-align: center"> </th>
            <th style="width: 20%;text-align: center"> </th>
            <th style="width: 15%;text-align: center"> </th>-->

            <tr style="border:1px;">
            <th style="width: 10%;text-align:center" class='midnight-blue'>ITEM</th>
            <th style="width: 56%;text-align:center" class='midnight-blue'>DESCRIPCION</th>
            <th style="width: 10%;text-align:center" class='midnight-blue'>CANTIDAD</th>
            <th style="width: 12%;text-align:center" class='midnight-blue'>MEDIDA</th>
            <th style="width: 13%;text-align:center" class='midnight-blue'>PESO TOTAL</th>
            
        </tr>
        
        <tr  style="border:1px;">
            <td style="widtd: 10%; text-align: center; border:1px;widtd: 50%; height: 21px; border-color: #FFFFFF;"></td>
            <td style="widtd: 56%; text-align: center;border:1px;widtd: 50%; border-color: #FFFFFF;"><b>Productos Plásticos</b></td>
            <td style="widtd: 10%; text-align: center;border:1px;widtd: 50%; border-color: #FFFFFF;"></td>
            <td style="widtd: 12%; text-align: center;border:1px;widtd: 50%; border-color: #FFFFFF;"></td>
            <td style="widtd: 13%; text-align: center;border:1px;widtd: 50%; border-color: #FFFFFF;"></td>
        </tr>
        
        <tr  style="border:1px;">
            <td style="widtd: 10%; text-align: right;border:1px;widtd: 50%; height: 21px; border-color: #FFFFFF;"></td>
            <td style="widtd: 56%; text-align: center;border:1px;widtd: 50%; border-color: #FFFFFF;"><b>Según Guía de Remisión</b></td>
            <td style="widtd: 10%; text-align: right;border:1px;widtd: 50%; border-color: #FFFFFF;"></td>
            <td style="widtd: 12%; text-align: right;border:1px;widtd: 50%; border-color: #FFFFFF;"></td>
            <td style="widtd: 13%; text-align: right;border:1px;widtd: 50%; border-color: #FFFFFF;"></td>
        </tr>

<?php
$nums=1;
$sumador_total=0;
$peso_total=0;
$sql=odbc_exec($con, "select guia_det as detalle, cantidad_det as cantidad,
    medida_det as medida,peso_det as peso 
    from detalle_guia 
    where numero_guia=".$numero_guia." 
    order by id_detalle;");
$i=1;

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
    $peso_total+=$peso;
	?>

        <tr  style="border:1px;">
            <td style="widtd: 10%; text-align: center;border:1px;widtd: 50%; height: 21px; border-color: #FFFFFF;"><?php echo $id_guia;?></td>
            <td style="widtd: 56%; text-align: center;border:1px;widtd: 50%; border-color: #FFFFFF;"><?php echo $descripcion;?></td>
            <td style="widtd: 10%; text-align: center;border:1px;widtd: 50%; border-color: #FFFFFF;"><?php echo $cantidad;?></td>
            <td style="widtd: 12%; text-align: center;border:1px;widtd: 50%; border-color: #FFFFFF;"><?php echo $medida;?></td>
            <td style="widtd: 13%; text-align: center;border:1px;widtd: 50%; border-color: #FFFFFF;"><?php echo $peso;?></td>
        </tr>

	<?php 
	
	$nums++;
    $i++;

	}
	$subtotal=number_format($sumador_total,2,'.','');
	/*$total_iva=($subtotal * TAX )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva;*/

?>
	  
        <tr>
            <td colspan="2" style="widtd: 50%; text-align: right;border:1px; height: 21px; border-color: #FFFFFF;">TOTALES&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
            <td style="widtd: 15%; text-align: center;border:0px; border-color: #FFFFFF;"> <?php echo number_format($subtotal,0);?></td>
            <td style="widtd: 20%; text-align: center;border:0px; border-color: #FFFFFF;"> <?php echo $medida;?></td>
            <td style="widtd: 15%; text-align: center;border:0px; border-color: #FFFFFF;"> <?php echo str_replace(',','',number_format($peso_total,2));?></td>
        </tr>
		

        <?php

    for ($x=$i; $x <14; $x++) { 
        ?>
        <tr  style="border:1px;">
            <td style="widtd: 10%; text-align: center;border:1px;widtd: 50%; height: 21px;  border-color: #FFFFFF; border-color: #FFFFFF;"></td>
            <td style="widtd: 58%; text-align: center;border:1px;widtd: 50%; border-color: #FFFFFF; "></td>
            <td style="widtd: 10%; text-align: right;border:1px;widtd: 50%; border-color: #FFFFFF; "></td>
            <td style="widtd: 12%; text-align: right;border:1px;widtd: 50%; border-color: #FFFFFF; "></td>
            <td style="widtd: 13%; text-align: right;border:1px;widtd: 50%;  border-color: #FFFFFF;"></td>
        </tr>
        <?php 
    }

    ?>

    </table>	

    <table>
	<tr>
	<td style="margin-top:0px;">
    <div style="border: 9px; height: 10px; width: 580px; border-color: #FFFFFF;"><p style="font-size:9.5pt; margin-top: 4.5px;">&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $subempresa; ?></p></div></td>
    <td style="margin-top:1px;><div style="border: 10.5px; height: 10px; width: 160px;  border-color: #FFFFFF;"><p style="font-size:9.5pt;margin-top: 4.5px;">&nbsp;&nbsp;&nbsp;<?php echo $ruc_subemp; ?></p></div></td>
    </tr>
    </table>
    
</page>
