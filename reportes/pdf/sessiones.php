<?php
	session_start();
	$ruta="../../";
	include_once($ruta."class/dominio.php");
	$dominio=new dominio;
	include_once($ruta."class/vadmejecutivo.php");
	$vadmejecutivo=new vadmejecutivo;
	include_once($ruta."class/grupo.php");
	$grupo=new grupo;
	include_once($ruta."class/ciclo.php");
	$ciclo=new ciclo;
	include_once($ruta."class/grupocredito.php");
	$grupocredito=new grupocredito;
	include_once($ruta."class/vgrupocredito.php");
	$vgrupocredito=new vgrupocredito;
	include_once($ruta."class/vindividualcredito.php");
	$vindividualcredito=new vindividualcredito;
	include_once($ruta."class/credito.php");
	$credito=new credito;
	include_once($ruta."class/creditodetalle.php");
	$creditodetalle=new creditodetalle;
	include_once($ruta."class/personagrupo.php");
	$personagrupo=new personagrupo;
	include_once($ruta."class/persona.php");
	$persona=new persona;
	include_once($ruta."class/sessiones.php");
	$sessiones=new sessiones;
	include_once($ruta."class/miempresa.php");
	$miempresa=new miempresa;
	include_once($ruta."class/usuario.php");
	$usuario=new usuario;
	include_once($ruta."funciones/funciones.php");
	include($ruta."recursos/qr/qrlib.php");
	require_once '../../recursos/pdf/mpdf/vendor/autoload.php';

	/******************    SEGURIDAD *************/
	extract($_GET);
	//********* SEGURIDAD GET *************/

	$user=dcUrl($lblcode);
	//$idadmeje=dcUrl($lblcode2);
	$fechaactual=date('Y-m-d');
    $horaactual=date('H:i:s');

   // $MesInforme= $fechareporte;//date("Y-m-t",strtotime($fechareporte));
 
	$rutaImg=$ruta."imagenes/logo.png";
	$demp=$miempresa->muestra(1);

	$dus=$usuario->muestra($user);
	//$tba=$tipobanca->muestra($cred['idtipobanca']);
	//$eje=$vadmejecutivo->muestra($gr['idadmejecutivo']);
	//$ddom=$dominio->muestra($cred['frecuenciapago']);
	//$cuotacobrar=$cred['cuota']+1;
	//$canTCred=$credito->mostrarTodo("idgrupocredito=".$valor);

	$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
	$fontDirs = $defaultConfig['fontDir'];
	$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
	$fontData = $defaultFontConfig['fontdata'];

	//$consulta="SELECT sum(cuenta)  as 'maximo' FROM admcontrato where idsede=1";
	//$dcont=$credito->sql($consulta);
	//$dcont=array_shift($dcont);


	$mpdf = new \Mpdf\Mpdf([
			'fontDir' => array_merge([
		        $ruta.'recursos/font/titilium',
		    ]),
		    'fontdata' => $fontData + [
		        'frutiger' => [
		            'R' => 'TitilliumWeb-Regular.ttf',
		            'I' => 'TitilliumWeb-Italic.ttf',
		        ]
		    ],
		    'default_font' => 'frutiger',
		    'mode' => 'utf-8',
		    'margin_header' => 5, 
		    'margin_top' => 30, 
		    'orientation' => 'L'
		]
	);
$header='
	<table style="width:100%; font-size:12px; text-align:center;"  align="center">
        <tr >
            <td style="width:30%;" class="letras">
              <center>
                <img style="width:180px;" src="'.$rutaImg.'" ><br>
              </center>
            </td>
            <td style="width:30%;">
	            <table class="titREP" width="100%" align="center">
	            <tr>
	            	<td>
	            		<div class="titSUB">R E P O R T E</div>
	            		<div class="titPRI"><h3>DE SESSIONES DEL SISTEMA </h3></div>
	            		<div class="titPRI"><h3>de '.$fechaini.' al '.$fechafin.'</h3></div>
	            		<div class=""><h5> '.$titulo.'</h5></div>
	            	</td>
	            </tr>
	            </table>
            </td>
            <td style="width:30%;">
	            <table border="0">
	              <tr>
	                <td>
	                  <table class="letras" cellpadding="2">
	                    <tr>
	                      <td align="right">
	                        FECHA ACTUAL:
	                      </td>
	                      <td align="left">
	                        <b>'.$fechaactual.'</b>
	                      </td>
	                    </tr>
	                    <tr>
	                      <td align="right">
	                        HORA ACTUAL:
	                      </td>
	                      <td align="left">
	                        <b>'.$horaactual.'</b>
	                      </td>
	                    </tr>
	                    <tr>
	                      <td align="right">
	                        Usuario:
	                      </td>
	                      <td align="left">
	                        <b>'.$dus['usuario'].'</b>
	                      </td>
	                    </tr>
	                  </table>
	                </td>
	              </tr>
	            </table>                     
            </td>
	  	</tr>
	</table>
	';

	$html = $html.'

	 <table class="" width="100%">
    <tr>
    	<td style="text-align:center;">
    		<h3>SESIONES INICIADOS CORRECTAMENTE </h3>
    	</td>
    </tr>
	 </table>
		<table class="tablaLIST2">
			<thead>
				<tr>
				<th width="5%"  style="text-align:left;">Nro</th>
				  <th width="40%" style="text-align:left;">Detalle</th>
				  <th width="25%" style="text-align:left;">Fecha Ingreso</th>
				  <th width="20%" style="text-align:left;">Hora Ingreso</th>
				</tr>
			</thead>
			<tbody>
				';
		
				//foreach($credito->mostrarTodo("idgrupocredito=".$valor) as $f) 
				$consulta="SELECT *
							FROM sessiones
							WHERE estado=1 and activo=1 and fecha BETWEEN '$fechaini' AND '$fechafin' ORDER BY fecha ASC";
								
				
		        foreach($sessiones->sql($consulta) as $f)
				{					
					//$cre=$usuario->muestra($f['idusuario']);
					$contar++;					
					$estilo='background-color:#E0FFEB';				
					$html = $html.'
						<tr style="background-color:#E0FFEBE0FFEB;">
						 <td>'.$contar.'</td>
						  <td>'.$f['detalle'].'</td>
						  <td>'.$f['fecha'].'</td>
						  <td>'.$f['hora'].'</td>

						</tr>
					';
				}
				$html = $html.'
			</tbody>
		  <tfoot style="text-align:center">
		    <tr>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		      
		    </tr>
		  </tfoot>
		</table><br>

   <table class="" width="100%">
    <tr>
    	<td style="text-align:center;">
    		<h3>INTENTOS DE INICIOS DE SESSION </h3>
    	</td>
    </tr>
	</table>
		<table class="tablaLIST2">
			<thead>
				<tr>
				<th width="5%" style="text-align:left;">Nro</th>
				  <th width="40%" style="text-align:left;">Detalle</th>
				  <th width="25%" style="text-align:left;">Fecha Ingreso</th>
				  <th width="20%" style="text-align:left;">Hora Ingreso</th>
				</tr>
			</thead>
			<tbody>
				';
		
				//foreach($credito->mostrarTodo("idgrupocredito=".$valor) as $f) 
				$consulta2="SELECT *
							FROM sessiones
							WHERE estado=0 and activo=1 and fecha BETWEEN '$fechaini' AND '$fechafin' ORDER BY fecha ASC";
								
				
		        foreach($sessiones->sql($consulta2) as $f)
				{					
					//$cre=$usuario->muestra($f['idusuario']);
					$contar++;					
					$estilo='background-color:#FFD6D6';				
					$html = $html.'
						<tr style="background-color:#FFD6D6;">
						 <td>'.$contar.'</td>
						  <td>'.$f['detalle'].'</td>
						  <td>'.$f['fecha'].'</td>
						  <td>'.$f['hora'].'</td>

						</tr>
					';
				}
				$html = $html.'
			</tbody>
		  <tfoot style="text-align:center">
		    <tr>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		      
		    </tr>
		  </tfoot>
		</table>


		<br>
   
	<br>				
		
	';
	//==============================================================
	//==============================================================
	//==============================================================

	//$mpdf->SetDisplayMode('fullpage');

	$stylesheet = file_get_contents($ruta.'recursos/css/elisyam-1.5.css');
	$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no
	$mpdf->SetHTMLFooter('
	<table width="100%">
	    <tr>
	        <td width="33%"></td>
	        <td width="33%" align="center"></td>
	        <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
	    </tr>
	</table>');
	$mpdf->SetHeader($header,50);
	$mpdf->WriteHTML($html);
	$mpdf->Output();

?>
