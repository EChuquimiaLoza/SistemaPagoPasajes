<?php
session_start();
$ruta="../../../";
include_once($ruta."class/transporte.php");
$transporte=new transporte;
extract($_POST);

$idplaca=strtoupper($idplaca);
$tran=$transporte->mostrarUltimo("idcategoria=".$idcategoria." and placa='".$idplaca."'");
if (count($tran)>0) 
{
   ?>
	<script type="text/javascript">
		swal("ERROR","Ya existe la placa registrado, intente con otro Nro. de Placa","error");
	</script>
   <?php                                                          
}else{
	//desabilitar para volver activo el nuevo
	foreach($transporte->mostrarTodo("estado=1 and idadmejecutivo=".$idadmejecutivo) as $f)
	{
		$valoresCAM=array(
		"estado"=>"'0'"
	   );	
	   $transporte->actualizar($valoresCAM,$f['idtransporte']);

	}
	$valores=array(
		"idadmejecutivo"=>"'$idadmejecutivo'",
		"idcategoria"=>"'$idcategoria'",
		"placa"=>"'$idplaca'",
		"modelo"=>"'$idmodelo'",
		"color"=>"'$idcolor'",
		"descripcion"=>"'$iddescripcion'",
		"estado"=>"'1'"
	 );	
	if($transporte->insertar($valores))
	{

		?>
		<script type="text/javascript">
		swal({
			title: "Exito !!!",
			text: "Registrado correctamente",
			type: "success",
			showCancelButton: false,
			confirmButtonColor: "#3ABD8D",
			confirmButtonText: "OK",
			closeOnConfirm: false
          }, function () {
			location.href="../";
          });
		</script>
	<?php		
	}else{
		?>
			<script type="text/javascript">
				swal("ERROR","No se registro, consulte con sistemas","error");
			</script>
		<?php
	 }
}
	

?>