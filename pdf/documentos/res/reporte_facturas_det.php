<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
	background:#E0FFFF;
	padding: 4px 4px 4px;
	color:#191970;
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
                <div style="width: 400px;"><img style="width: 400px; height:150px" src="../../img/cimek.PNG" alt="Logo"></div>
          	</td>
            <td width="10px;">
            </td>
            <td style="width: 320px; heigth:30px; color: #444444;">
                <div style="width: 320px;border: 2px; border-radius: 7px;"><img style="width: 320px; height:150px;" src="../../img/logistica.jpg" alt="Logo"></div>
          	</td>
        </tr>
    </table>

<br><br>
    <table cellspacing="0" style="width: 100%;">
            <tr>
            <td style="width: 100%; height:20px;">
            <div style=" height:20px; text-align:center;">
                    <p style="margin: 7px 0 0px 0px; font-size:15pt; text-align:center;"><b>REPORTE DE FACTURAS DETALLADAS</b></p></div></td>
        </tr>
    </table>

	<br>
  
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt; border:1px">
        <tr>
            <th style="width: 12%;text-align:center; border:1px;" class='midnight-blue' ># FACTURA</th>
            <th style="width: 10%;text-align: center; border:1px;" class='midnight-blue'>EMISION</th>
            <th style="width: 36%;text-align: center; border:1px;" class='midnight-blue'>CLIENTE</th>
            <th style="width: 12%;text-align: center; border:1px;" class='midnight-blue'>RUC</th>
            <th style="width: 10%;text-align: center; border:1px;" class='midnight-blue'>IMPORTE</th>
            <th style="width: 10%;text-align: center; border:1px;" class='midnight-blue'>IGV</th>
            <th style="width: 10%;text-align: center; border:1px;" class='midnight-blue'>TOTAL</th>     
        </tr>
<?php
$nums=1;
$sql=odbc_exec($con, $sql_pasar);

$tot_importe=0;
$tot_igv=0;
$tot_total=0;

while ($row=odbc_fetch_array($sql))
	{
    $ruc=$row['ruc'];
    $n_fac=$row['buscador'];
    $n_remitente=$row['rsocialremitente'];
    $emision=$row['fecha_factura'];
    $importe=number_format($row['importe'],2);
    $importe=str_replace(',', '', $importe);
    $tot_importe= $tot_importe + $importe;
    $igv=number_format($row['igv'],2);
    $igv=str_replace(',', '', $igv);
    $tot_igv= $tot_igv + $igv;
    $total=number_format($row['total'],2);
    $total=str_replace(',', '', $total);
    $tot_total = $tot_total+$total;

	if ($nums%2==0){
		//$clase="clouds";
        $clase="silver";
	} else {
		$clase="silver";
	}
	?>

        <tr>
            <td class='<?php echo $clase;?>' style="width: 12%; text-align: center;border:1px"><?php echo $n_fac;?></td>
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center;border:1px"><?php echo $emision;?></td>
            <td class='<?php echo $clase;?>' style="width: 36%; text-align: center;border:1px"><?php echo $n_remitente;?></td>
            <td class='<?php echo $clase;?>' style="width: 12%; text-align: center;border:1px"><?php echo $ruc;?></td>
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center;border:1px"><?php echo $importe;?></td>
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center;border:1px"><?php echo $igv;?></td>
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center;border:1px"><?php echo $total;?></td>
        </tr>

    <?php 
        $nums++;
    } ?>

        <tr>
            <td class='<?php echo $clase;?>' style="width: 12%; text-align: center;border:0px"></td>
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center;border:0px"></td>
            <td class='<?php echo $clase;?>' style="width: 36%; text-align: center;border:0px"></td>
            <td class='<?php echo $clase;?>' style="width: 12%; text-align: center;border:0px"></td>
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center;border:1px"><?php echo $tot_importe;?></td>
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center;border:1px"><?php echo $tot_igv;?></td>
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center;border:1px"><?php echo $tot_total;?></td>
        </tr>
    
    </table>

</page>