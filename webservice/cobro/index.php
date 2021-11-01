<?php
error_reporting(E_ALL);
    ini_set('display_errors', '1');
    session_start();
$ruta="../";
include_once($ruta."class/tarjeta.php");
$tarjeta=new tarjeta;
include_once($ruta."class/cobro.php");
$cobro=new cobro;
$_SESSION['codusuario']=1;
$codRfid=$_REQUEST['lblcode'];//Request para android
$codchofer=$_REQUEST['lblcodechof'];
$codmonto=$_REQUEST['lblcodemonto'];

$tar=$tarjeta->muestra($codRfid);

if ($tar['saldo']<=0) 
{
	
}else{
	echo 'SIN SALDO...';
}

$valores=array(
	"idchofer"=>"'$idchofer'",
	"idtarjeta"=>"'$codRfid'",
	"monto"=>"'$codmonto'",
	"estado"=>'1'
);
if($cobro->insertar($valores))
{
	
	$saldoNuevo=$tar['saldo']-$codmonto;
	$saldoAnterior=$tar['saldo'];
	$valoresTar=array(
	"saldo"=>"'$saldoNuevo'",
	"saldoanterior"=>"'$saldoAnterior'"
	);
	if($tarjeta->actualizar($valoresTar,$codRfid))
	{

		echo 'COBRADO';
	}else{
		echo 'NO COBRADO...';
	}
	
}else{
	echo 'ERROR...';
}


?>
