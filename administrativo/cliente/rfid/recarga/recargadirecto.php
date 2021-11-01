<?php
session_start();
$ruta="../../../../";
include_once($ruta."class/tarjeta.php");
$tarjeta=new tarjeta;
include_once($ruta."class/recarga.php");
$recarga=new recarga;
extract($_POST);

$tar=$tarjeta->muestra($idtarjetaImp);
$saldoAnt=$tar['saldo'];
	$valores=array(
		    "idtarjeta"=>"'$idtarjetaImp'",
			"monto"=>"'$idmontorecarga'",
			"saldoanterior"=>"'$saldoAnt'",
			"estado"=>"'1'"
	 );	
	if($recarga->insertar($valores))
	{
		$saldoactual=$tar['saldo']+$idmontorecarga;
		$saldoAnt=$tar['saldo'];
		$valoresTar=array(
		    "saldo"=>"'$saldoactual'",
			"saldoanterior"=>"'$saldoAnt'"
			//"estado"=>"'1'"
	    );	
		if($tarjeta->actualizar($valoresTar,$idtarjetaImp))
		{
			?>
			<script type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Recarga realizado correctamente",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#006458",
					confirmButtonText: "OK",
					closeOnConfirm: false
		          }, function () {
					location.reload();
		          });
				</script>
			<?php
		}else{
			$rec=$recarga->mostrarUltimo("idtarjeta=".$idtarjetaImp);
			$idrecarga=$rec['idrecarga'];
			$valoresRec=array(
			"estado"=>"'0'"
	      );	
	        $recarga->actualizar($valoresRec,$idrecarga);
			?>
			<script type="text/javascript">
				swal("ERROR","No se realizo la recarga, intente nuevamente","error");
			</script>
		  <?php
		}
	}else{
		
		?>
		<script type="text/javascript">
			swal("ERROR","No proceso la recarga, intente nuevamente","error");
		</script>
	  <?php
	}

?>