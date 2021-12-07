<?php
error_reporting(E_ALL);
    ini_set('display_errors', '1');
    session_start();
$ruta="../../";
include_once($ruta."class/tarjeta.php");
$tarjeta=new tarjeta;
include_once($ruta."class/cobro.php");
$cobro=new cobro;
include_once($ruta."class/tarifa.php");
$tarifa=new tarifa;
include_once($ruta."class/placarfid.php");
$placarfid=new placarfid;
$_SESSION['codusuario']=1;
$codRfid=$_REQUEST['lblcode'];

//codigo placa
$codplaca=$_REQUEST['lblcodeplaca'];
$plarfid=$placarfid->mostrarUltimo("codigoplaca='".$codplaca."' and estado=1");

$codchofer=$plarfid['idchofer'];
//$codtarifa=$_REQUEST['lblcodetarifa'];
//https://pro-ayuda.com/bolognia/webservice/cobro/?lblcode=3&lblcodechofer=1&lblcodetarifa=2
//https://pro-ayuda.com/bolognia/webservice/cobro/?lblcode=b9ed57b9&lblcodeplaca=SCRFID001
$habil=$tarjeta->mostrarUltimo("codigo='".$codRfid."' and estado=1");
$idtarjeta=$habil['idtarjeta'];
$tar=$tarjeta->muestra($idtarjeta);

//TARIFA
//$tarif=$tarifa->muestra($codtarifa);
//$montocobrar=$tarif['precio'];
//$tramo=$tarif['tramo'];
$tramo='2';
$montocobrar='2';

if (count($habil)>0) //TARJETA SI ESTA HABILITADO
{	
	if (number_format($tar['saldo'], 2, '.', '')>0) //TARJETA SI ESTA CON SALDO 0
	{
		if (number_format($tar['saldo'], 2, '.', '')>=number_format($montocobrar, 2, '.', ''))//SALDO SUFICIENTE 
		{
			$valores=array(
				"idchofer"=>"'$codchofer'",
				"idtarjeta"=>"'$idtarjeta'",
				"monto"=>"'$montocobrar'",
				"descripcion"=>"'$tramo'",
				"estado"=>'1'
			);
			if($cobro->insertar($valores))
			{
				$saldoNuevo=$tar['saldo']-$montocobrar;
				$saldoAnterior=$tar['saldo'];
				$valoresTar=array(
				"saldo"=>"'$saldoNuevo'",
				"saldoanterior"=>"'$saldoAnterior'"
				);
				if($tarjeta->actualizar($valoresTar,$idtarjeta))
				{
					echo 'COBRADO';
				}else{
					echo 'NO COBRADO...';
				}
				
			}else{
				echo 'ERROR...';
			}
		}else{
			echo 'SALDO INSUFICIENTE...';
		}
	}else{
		echo 'SALDO 0...';
	}
}else{
	echo 'TARJETA NO HABILITADO...';
}



?>
