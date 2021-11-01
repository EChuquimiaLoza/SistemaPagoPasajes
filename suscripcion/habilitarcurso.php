<?php
session_start();
$ruta="../";
include_once($ruta."class/dominio.php");
$dominio=new dominio;
include_once($ruta."class/habilitado.php");
$habilitado=new habilitado;
include_once($ruta."class/habilitadodet.php");
$habilitadodet=new habilitadodet;
extract($_POST);
	$valores=array(
		"idcurso"=>"'$idcurso'",
		"gestion"=>"'$gestion'",
		"descripcion"=>"'HABILITADO'",
		"estado"=>"'1'"
	 );	
	if($habilitado->insertar($valores))
	{
		$dom=$dominio->mostrarUltimo("codigo=1 and tipo='CRSS'");
		$iddom=$dom['iddominio'];
		$hab=$habilitado->mostrarUltimo("idcurso=".$idcurso." and gestion=".$gestion);
		$idhabilitado=$hab['idhabilitado'];
				$valoresDET=array(
				"idhabilitado"=>"'$idhabilitado'",
				"iddominio"=>"'$iddom'",
				"descripcion"=>"'CURSO A'",
				"estado"=>"'1'"
			 );	
			if($habilitadodet->insertar($valoresDET))
			{
				?>
				<script type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Curso habilitado correctamente",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#28e29e",
					confirmButtonText: "OK",
					closeOnConfirm: false
		          }, function () {
		          	location.reload();
		          });
				</script>
			<?php
				
			}else{
				?>
					<script type="text/javascript">
						swal("ERROR","No se registro detalle, consulte con sistemas","error");
					</script>
				<?php
			 }
		
	}else{
		?>
			<script type="text/javascript">
				swal("ERROR","No se registro, consulte con sistemas","error");
			</script>
		<?php
	 }

?>