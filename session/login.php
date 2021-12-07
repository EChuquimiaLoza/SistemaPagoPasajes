<?php
$ruta="../";
extract($_POST);
include_once($ruta."class/usuario.php");$usuario=new usuario;
include_once($ruta."class/rol.php");$rol=new rol;
include_once($ruta."class/dominio.php");$dominio=new dominio;
include_once($ruta."class/sessiones.php");$sessiones=new sessiones;
include_once($ruta."funciones/funciones.php");
$errorClave=$contrasenia;
$contrasenia=md5(e($contrasenia));
$usuarios ="$usuarios";$contrasenia ="$contrasenia";
$datosUsuario=$usuario->mostrarTodo("usuario='".$usuarios."' and pass='".$contrasenia."'");
if (count($datosUsuario)>0){
$datosUsuario=array_shift($datosUsuario);session_start();

$_SESSION["estadoSesion"] = 'Jhulios2007777705';
$_SESSION["rolusuario"] = $datosUsuario['idrol'];
$_SESSION["usuario"]=$datosUsuario['usuario'];
$_SESSION["codusuario"]=$datosUsuario['idusuario'];
$_SESSION["idsede"]=$datosUsuario['idsede'];


include_once($ruta."class/configuracion.php");
$configuracion=new configuracion; 

$config = $configuracion->mostrarTodo();
$config = array_shift($config);


   $_SESSION["short"] = $config['short'];
   $_SESSION["nombreempresa"]=$config['nombreempresa'];
   $_SESSION["descripcion"]=$config['descripcion'];
   $_SESSION["descripcion"]=$config['descripcion'];
   $_SESSION["copyright"]=$config['copyright'];
   $_SESSION["titulo"]=$config['titulo'];


   
$datosRol=$rol->mostrar($datosUsuario['idrol']);
$datosRol=array_shift($datosRol);
//aumentado
$idusuarioses=$datosUsuario['idusuario'];
$fechaact=date('Y-m-d');
$horaact=date('h:i:s');
$valoresSES=array(
        "idusuario"=>"'$idusuarioses'",
        "fecha"=>"'$fechaact'",
        "hora"=>"'$horaact'",
        "detalle"=>"'$usuarios'",
        "estado"=>'1'
      );
     $sessiones->insertar($valoresSES);
 ?><script>location.href = "inicio/";</script><?php
}else{
session_start();
if (!isset($_SESSION["faltaSistema"]))
{$_SESSION['faltaSistema']="0";}
$_SESSION['faltaSistema']=$_SESSION['faltaSistema']+1;
$intentosFaltantes=3-$_SESSION['faltaSistema'];
if ($_SESSION["faltaSistema"]>=3) { ?><script>location.href = "penalizado.php";</script> <?php }
else { ?>
<div id="card-alert" class="card red lighten-5">
  <div class="card-content red-text">
    <p>FALTA AL SISTEMA : El Usuario o Contraseña no Coinciden. Intentelo Nuevamente. Intentos restantes <?php echo $intentosFaltantes;?></p>
  </div>
  <button type="button" class="close red-text" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
</div>
<?php }
$fechaact=date('Y-m-d');
$horaact=date('h:i:s');
$valoresSES=array(
        "idusuario"=>"'$idusuariosess'",
        "fecha"=>"'$fechaact'",
        "hora"=>"'$horaact'",
        "detalle"=>"'$usuarios'",
        "errorclave"=>"'$errorClave'",
        "estado"=>'0'
      );
     $sessiones->insertar($valoresSES);
}?>
