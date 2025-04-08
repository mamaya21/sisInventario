<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
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
</style>
<?php

function numtoletras($xcifra)
{
    $xarray = array(0 => "Cero",
        1 => "UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
//
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                            
                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {
                            
                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                            
                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";

        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "CERO CON $xdecimales/100 SOLES";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UNO CON $xdecimales/100 SOLES ";
                    }
                    if ($xcifra >= 2) {
                        $xcadena.= " CON $xdecimales/100 SOLES "; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

function subfijo($xx)
{ // esta función regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
}
 
?>
<!--<page backtop="15mm" backbottom="10mm" backleft="8mm" backright="12mm" style="font-size: 12pt; font-family: arial" >-->
<page backtop="18mm" backbottom="0mm" backleft="0mm" backright="12mm" style="font-size: 12pt; font-family: arial" >
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: auto; color: #444444;">
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
          <td style="width: auto; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $dia;?></b>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $mes;?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $anio;?></b></td>
          <td></td>
          <td style="width: 300px; color: #444444; "></td>
        </tr>
    </table>

    <table cellspacing="5" style="width: 100%;">
            <tr>
            <td style="width: 70%; height:20px;">
            <div style=" height:20px; ">
                    <p style="margin: 7px 0 0px 0px; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   <b> <?php echo $remitente;?> </b></p></div></td>
            
            <td style="width: 3px; height:20px;"></td>

            <td style="width: 30%; height:20px;">
            <div style=" height:20px; ">
                    <p style="margin: 7px 0 0px 0px; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $ruc_remitente;?></b> </p></div></td>
        </tr>
    </table>
    
    <table cellspacing="5" style="width: 100%;">
            <tr>
            <td style="width: 99%; height:20px;">
            <div style=" height:20px; ">
                    <p style="margin: 7px 0 0px 0px; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $dir_remitente;?></b> </p></div></td>
            
            <td style="width: 3px; height:20px;"></td>
            <td style="width: 1%; height:20px;">
            <div style=" height:20px; ">
                    <p style="margin: 7px 0 0px 0px; font-size:9.5pt;"></p></div></td>
        </tr>
    </table>
   
   <table cellspacing="11" style="width: 100%;">
            <tr>
            <td style="width: 40%; height:20px;">
            <div style=" height:20px; ">
                    <p style="margin: 7px 0 0px 0px; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></div></td>
            
            <td style="width: 20%; height:20px;">
            <div style=" height:20px; ">
                    <p style="margin: 7px 0 0px 0px; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;</p></div></td>

            <td style="width: 40%; height:20px;">
            <div style=" height:20px; ">
                    <p style="margin: 7px 0 0px 0px; font-size:9.5pt;">&nbsp;&nbsp;&nbsp;</p></div></td>
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

    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt; border:1px;border-color: #FFFFFF;">
        <tr style="border:1px; ">
            <th style="width: 8%;text-align:center; height: 11px;" class='midnight-blue'>CANT</th>
            <th style="width: 64%;text-align:center; height: 11px;" class='midnight-blue'>DESCRIPCION</th>
            <th style="width: 14%;text-align: center; height: 11px;" class='midnight-blue'>PRECIO UNIT.</th>
            <th style="width: 14%;text-align: center; height: 11px;" class='midnight-blue'>IMPORTE</th>
            
        </tr>
        
        <tr  style="border:1px; border-color: #FFFFFF;">
            <td style="widtd: 8%; text-align: center; border:1px;border-color: #FFFFFF;"></td>
            <td style="widtd: 64%; text-align: center;border:1px;border-color: #FFFFFF;">SERVICIO DE TRANSPORTE REALIZADO SEGUN GUIAS</td>
            <td style="widtd: 14%; text-align: center;border:1px;border-color: #FFFFFF;"></td>
            <td style="widtd: 14%; text-align: left;border:1px;border-color: #FFFFFF;"><b><?php echo $importe; ?></b></td>
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

        <tr  style="border:1px;border-color: #FFFFFF;">
            <td class='<?php echo $clase;?>' style="width: 8%; text-align: center;border:1px;border-color: #FFFFFF;"><b><?php echo $sumador_total;?></b></td>
            <td class='<?php echo $clase;?>' style="width: 64%; text-align: center;border:1px;border-color: #FFFFFF;"><b><?php echo $descripcion;?></b></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: center;border:1px;border-color: #FFFFFF;"></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: center;border:1px;border-color: #FFFFFF;"></td>
            
        </tr>

	<?php 

	
	$nums++;
    $i++;
	}
	$subtotal=number_format($sumador_total,2,'.','');
	/*$total_iva=($subtotal * TAX )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva;*/
    for ($x=$i; $x <26; $x++) { 
        ?>
        <tr  style="border:1px;border-color: #FFFFFF;">
            <td class='<?php echo $clase;?>' style="width: 8%; text-align: center;border:1px;border-color: #FFFFFF;"><?php echo $x; ?></td>
            <td class='<?php echo $clase;?>' style="width: 64%; text-align: center;border:1px;border-color: #FFFFFF;"></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: center;border:1px;border-color: #FFFFFF;"></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: center;border:1px;border-color: #FFFFFF;"></td>
            
        </tr>
        <?php 
    }

?> 

    <tr  style="border:1px;border-color: #FFFFFF;">
            <td class='<?php echo $clase;?>' style="width: 8%; text-align: center;border-left:1px;border-bottom: 1px;border-top: 1px;border-color: #FFFFFF;"><b>  &nbsp;&nbsp;&nbsp;</b></td>
            <td class='<?php echo $clase;?>' style="width: 64%; text-align: center;border-bottom: 1px;border-top: 1px;border-color: #FFFFFF;"><b><?php echo numtoletras($total);?></b></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: center;border-bottom: 1px;border-top: 1px;border-right: 1px;border-color: #FFFFFF;"></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: center;border:1px;border-color: #FFFFFF;"></td>
            
        </tr>
    </table>

	  <table cellspacing="5" style="width: 100%; text-align: left; font-size: 10pt; ">
		<tr>
            <td class='<?php echo $clase;?>' style="width: 8%; text-align: center;"></td>
            <td class='<?php echo $clase;?>' style="width: 64%; text-align: center;"></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: left;border-right: 1px;border-left: 1px;border-bottom: 1px;border-color: #FFFFFF;"><b> &nbsp;&nbsp;&nbsp;</b></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: left;border-right: 1px;border-left: 1px;border-bottom: 1px;border-color: #FFFFFF;"><?php echo $importe; ?></td>
        </tr>
        <tr>
            <td class='<?php echo $clase;?>' style="width: 8%; text-align: center;"></td>
            <td class='<?php echo $clase;?>' style="width: 64%; text-align: center;"></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: left;border:1px;border-color: #FFFFFF;"><b> &nbsp;&nbsp;&nbsp;</b></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: left;border:1px;border-color: #FFFFFF;"><?php echo $igv; ?></td>
        </tr>
        <tr>
            <td class='<?php echo $clase;?>' style="width: 8%; text-align: center;"></td>
            <td class='<?php echo $clase;?>' style="width: 64%; text-align: center;"></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: left;border:1px;border-color: #FFFFFF;"><b> &nbsp;&nbsp;&nbsp;</b></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: left;border:1px;border-color: #FFFFFF;"><?php echo $total; ?></td>
        </tr>
    </table>
    
<!--<table cellspacing="0" style="width: 100%;height:60px; color: #444444;">
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
                 	<p style="margin: 20px 0 5px 5px; font-size:9.5pt;text-align:center"><b>&nbsp;&nbsp;&nbsp;</b></p></div></td>
        </tr>
    </table> -->
    
</page>
