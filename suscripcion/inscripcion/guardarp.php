<?php
session_start();
$ruta="../../";

include_once($ruta."class/personagrupo.php");
$personagrupo=new personagrupo;

include_once($ruta."class/persona.php");
$persona=new persona;
include_once($ruta."class/domicilio.php");
$domicilio=new domicilio;
include_once($ruta."class/estudiante.php");
$estudiante=new estudiante;
include_once($ruta."class/admejecutivo.php");
$admejecutivo=new admejecutivo;
include_once($ruta."class/usuario.php");
$usuario=new usuario;
include_once($ruta."class/inscripcion.php");
$inscripcion=new inscripcion;
include_once($ruta."funciones/funciones.php");
extract($_POST);



if ($idflag==1) 
{
	$personaB=$persona->mostrarTodo("carnet=".$idcarnet);
	$idnombre=strtoupper($idnombre);
	$idpaterno=strtoupper($idpaterno);
	$idmaterno=strtoupper($idmaterno);
	$idocupacion=strtoupper($idocupacion);
	if (count($personaB)==0){
		$valores=array(
			"carnet"=>"'$idcarnet'",
			"expedido"=>"'$idexp'",
			"nombre"=>"'$idnombre'",
			"paterno"=>"'$idpaterno'",
			"materno"=>"'$idmaterno'",
			"nacimiento"=>"'$idnacimiento'",
			"email"=>"'$idemail'",
			"celular"=>"'$idcelular'",
			"idsexo"=>"'$idsexo'",
			"ocupacion"=>"'$idocupacion'",
			"tipopersona"=>"'ESTUDIANTE'"
		 );	
	 
		if($persona->insertar($valores))
		{
			$dpersona=$persona->mostrarUltimo("carnet=".$idcarnet);
			$idp=$dpersona['idpersona'];
			$lblcode=ecUrl($dpersona['idpersona']); //aumentado
			$valoresD=array(
			    "idpersona"=>"'$idp'",
			    "idbarrio"=>"'$idzona'",
			    "nombre"=>"'$iddireccion'",
			    "telefono"=>"'$idfono'",
			  ); 
			$domicilio->insertar($valoresD);
			//registrar EJECUTIVO
				
				$idfechaingreso=date('Y-m-d');
				$valores=array(
					"idpersona"=>"'$idp'",
					"idtipo"=>"'$tipoeje'",
					"fechaingreso"=>"'$idfechaingreso'",
					"estado"=>'1',
					"idsede"=>"'1'"
					//"referenciaper"=>"'$idrefper'"
				);	
				$admejecutivo->insertar($valores);
				$dejecutivo=$admejecutivo->mostrarUltimo("idpersona=".$idp." and idtipo=".$tipoeje);
				$idadmejecutivo=$dejecutivo['idadmejecutivo'];

			//REGISTRAR ESTUDIANTE	
				$valoresES=array(
					"idadmejecutivo"=>"'$idadmejecutivo'",
					"tutor"=>"'$idtutor'",
					"celulartutor"=>"'$idcelulartutor'",
					"estado"=>"'1'"
				);	
				$estudiante->insertar($valoresES);
            $est=$estudiante->mostrarUltimo("idadmejecutivo=".$idadmejecutivo);
            $idestudiante= $est['idestudiante'];
			//REGISTRAR USUARIO
			   $idpass1=$idcarnet;
			   $idusuario=$idcarnet;
			   $idpass1=md5(e($idpass1));
			   $idrol=32; //ROL DE ESTUDIANTE
				//
				$valoresUS=array(
					"idpersona"=>"'$idp'",
					"idadmejecutivo"=>"'0'",
					"usuario"=>"'$idusuario'",
					"pass"=>"'$idpass1'",
					"idrol"=>"'$idrol'"
				);	
				$usuario->insertar($valoresUS);	

				$valorINS=array(
				    "idhabilitadodet"=>"'$idhabilitadodet'",
				    "idestudiante"=>"'$idestudiante'",
				    "descripcion"=>"'INSCRITO'",
				    "estado"=>"'1'"
				  ); 
	            $inscripcion->insertar($valorINS);

			  	?>
					<script type="text/javascript">
					swal({
						title: "Exito !!!",
						text: "Estudiante Registrado Correctamente",
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
					setTimeout(function() {
			            Materialize.toast('<span>2 No se pudo realizar la Operacion. Consulte con su proveedor</span>', 1500);
			        }, 1500);
				</script>
			<?php
		 }
	 }
	 else{
		?>
			<script type="text/javascript">
				sweetAlert("ERROR", "El estudiante ya se encuentra registrado!", "error");
			</script>
		<?php
	}
}
if ($idflag==2) 
{
	$valorGru=array(
				    "idpersona"=>"'$idpersonaImp'",
				    "idgrupo"=>"'$idgrupo1'",
				    "estado"=>"'1'"
				  ); 
	if($personagrupo->insertar($valorGru))
	{
		?>
			<script type="text/javascript">
			swal({
				title: "Exito !!!",
				text: "Asignado correctamente al grupo",
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
			sweetAlert("Error", "NO SE REGISTRO", "error");

	}
}

if ($idflag==3) 
{
	$valorINS=array(
				    "idhabilitadodet"=>"'$idhabilitadodet'",
				    "idestudiante"=>"'$idestudianteImp'",
				    "descripcion"=>"'INSCRITO'",
				    "estado"=>"'1'"
				  ); 
	if($inscripcion->insertar($valorINS))
	{
		?>
			<script type="text/javascript">
			swal({
				title: "Exito !!!",
				text: "Inscrito correctamente al curso",
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
			sweetAlert("Error", "NO SE REGISTRO", "error");
			</script>
		<?php
			

	}
}

?>