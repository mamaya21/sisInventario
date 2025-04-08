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
                    <p style="margin: 7px 0 0px 0px; font-size:15pt; text-align:center;"><b>REPORTE DE TRANSPORTES</b></p></div></td>
        </tr>
    </table>

	<br>
  
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt; border:1px">
        <tr>
            <th style="width: 20%;text-align:center; border:1px;" class='midnight-blue'>MARCA</th>
            <th style="width: 15%;text-align:center; border:1px;" class='midnight-blue'>PLACA</th>
            <th style="width: 30%;text-align: center; border:1px;" class='midnight-blue'>CONDUCTOR</th>
            <th style="width: 20%;text-align: center; border:1px;" class='midnight-blue'>LICENCIA</th>
            <th style="width: 15%;text-align: center; border:1px;" class='midnight-blue'>INGRESO</th>    
        </tr>
<?php
$nums=1;
$sql=odbc_exec($con, $sql_pasar);
while ($row=odbc_fetch_array($sql))
	{
    $marca=$row['marca'];
    $placa=$row['placa'];
    $licencia=$row['lic_conducir'];
    $conductor=$row['conductor'];
    $fecha=$row['fecha'];
    
	if ($nums%2==0){
		//$clase="clouds";
        $clase="silver";
	} else {
		$clase="silver";
	}
	?>

        <tr>
            <td class='<?php echo $clase;?>' style="width: 20%; text-align: center;border:1px"><?php echo $marca;?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: center;border:1px"><?php echo $placa;?></td>
            <td class='<?php echo $clase;?>' style="width: 30%; text-align: center;border:1px"><?php echo $licencia;?></td>
            <td class='<?php echo $clase;?>' style="width: 20%; text-align: center;border:1px"><?php echo $conductor;?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: center;border:1px"><?php echo $fecha;?></td>
        </tr>

    <?php 
        $nums++;
    } ?>
    
    </table>

</page>