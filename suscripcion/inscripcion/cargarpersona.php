<?php 
$ruta="../../";
include_once($ruta."class/persona.php");
$persona=new persona; 
include_once($ruta."class/admejecutivo.php");
$admejecutivo=new admejecutivo; 
include_once($ruta."class/domicilio.php");
$domicilio=new domicilio; 
include_once($ruta."class/estudiante.php");
$estudiante=new estudiante; 
include_once($ruta."class/inscripcion.php");
$inscripcion=new inscripcion;
include_once($ruta."funciones/funciones.php");
//extract($_POST);
extract($_GET);

$existe=$persona->mostrarTodo("carnet='$carnet'");
    if(count($existe)>0)
    {
	   $per=$persona->mostrarTodo("carnet='$carnet'");
	   $per=array_shift($per);
	   $IDpersona=$per['idpersona'];
	   $dom=$domicilio->mostrarTodo("idpersona=".$IDpersona);
	   $dom=array_shift($dom);
	   $admeje=$admejecutivo->mostrarUltimo("idpersona=".$per['idpersona']);	   
	   $existe2=$estudiante->mostrarUltimo("idadmejecutivo=".$admeje['idadmejecutivo']);
	   $idestudiante=$existe2['idestudiante'];
		if (count($existe2)>0) 
		{
			
			$existe3=$inscripcion->mostrarTodo("idestudiante=".$existe2['idestudiante']." and idhabilitadodet=".$idhabilitadodet);
			if (count($existe3)>0) 
			{
				//echo '4'; //ya hace parte de este grupo (NO PUEDE VOLVER A REGISTRARSE)
				$arrayJSON['tipo']='4';
				$arrayJSON['idpersonaImp']=$IDpersona; 
				$arrayJSON['expedido']=$per['expedido'];
				$arrayJSON['nombre']=$per['nombre'];
				$arrayJSON['paterno']=$per['paterno'];
				$arrayJSON['materno']=$per['materno'];
				$arrayJSON['fechanac']=$per['nacimiento'];
				$arrayJSON['email']=$per['email'];
				$arrayJSON['celular']=$per['celular'];
				$arrayJSON['sexo']=$per['idsexo'];
				$arrayJSON['ocupacion']=$per['ocupacion'];

				//domicilio
				$arrayJSON['zona']=$dom['idbarrio'];
				$arrayJSON['direccion']=$dom['nombre'];
				$arrayJSON['telefono']=$dom['telefono'];
				echo json_encode($arrayJSON);
			}else{
				//echo '3'; //Se puede registrar en este gestion del curso, pero se encuantra en otro gestion
				$arrayJSON['tipo']='3';
				$arrayJSON['idpersonaImp']=$IDpersona;
				$arrayJSON['idestudianteImp']=$idestudiante;  
				$arrayJSON['expedido']=$per['expedido'];
				$arrayJSON['nombre']=$per['nombre'];
				$arrayJSON['paterno']=$per['paterno'];
				$arrayJSON['materno']=$per['materno'];
				$arrayJSON['fechanac']=$per['nacimiento'];
				$arrayJSON['email']=$per['email'];
				$arrayJSON['celular']=$per['celular'];
				$arrayJSON['sexo']=$per['idsexo'];
				$arrayJSON['ocupacion']=$per['ocupacion'];

				//domicilio
				$arrayJSON['zona']=$dom['idbarrio'];
				$arrayJSON['direccion']=$dom['nombre'];
				$arrayJSON['telefono']=$dom['telefono'];
				echo json_encode($arrayJSON);
			}
		}else{
			//echo '2'; //no estas en ningun grupo (LIBRE)
			$arrayJSON['tipo']='2';
			$arrayJSON['idpersonaImp']=$IDpersona; 
			$arrayJSON['expedido']=$per['expedido'];
			$arrayJSON['nombre']=$per['nombre'];
			$arrayJSON['paterno']=$per['paterno'];
			$arrayJSON['materno']=$per['materno'];
			$arrayJSON['fechanac']=$per['nacimiento'];
			$arrayJSON['email']=$per['email'];
			$arrayJSON['celular']=$per['celular'];
			$arrayJSON['sexo']=$per['idsexo'];
			$arrayJSON['ocupacion']=$per['ocupacion'];

			//domicilio
			$arrayJSON['zona']=$dom['idbarrio'];
			$arrayJSON['direccion']=$dom['nombre'];
			$arrayJSON['telefono']=$dom['telefono'];
			echo json_encode($arrayJSON);
		}
 
	}else{
		 //REGISTRAR NUEVO echo '1';
		$arrayJSON['tipo']='1';
		$arrayJSON['idpersonaImp']='0'; //flag cero para tener cntrol de que no se encuentra persona
		$arrayJSON['idestudianteImp']='0';  
		$arrayJSON['expedido']='LP';
		$arrayJSON['nombre']='';
		$arrayJSON['paterno']='';
		$arrayJSON['materno']='';
		$arrayJSON['fechanac']='';
		$arrayJSON['email']='';
		$arrayJSON['celular']='';
		$arrayJSON['sexo']=1;
		$arrayJSON['ocupacion']='';

		//domicilio
		$arrayJSON['zona']='';
		$arrayJSON['direccion']='';
		$arrayJSON['telefono']='';
		echo json_encode($arrayJSON);
	}
	
?>