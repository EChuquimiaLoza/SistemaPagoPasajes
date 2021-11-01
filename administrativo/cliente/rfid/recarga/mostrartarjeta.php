<?php 
$ruta="../../../../";
include_once($ruta."class/tarjeta.php");
$tarjeta=new tarjeta;
include_once($ruta."class/vadmejecutivo.php");
$vadmejecutivo=new vadmejecutivo;
extract($_GET);
$tar=$tarjeta->muestra($idtarjeta);
$vadmeje=$vadmejecutivo->muestra($tar['idadmejecutivo']);

$arrayJSON['nombres']=$vadmeje['nombre'].' '.$vadmeje['paterno'].' '.$vadmeje['materno'];
$arrayJSON['saldo']=number_format($tar['saldo'], 2, '.', '');
$arrayJSON['codigo']=$tar['codigo'];

echo json_encode($arrayJSON); 
?>
