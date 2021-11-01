<?php
  $ruta="sistema/";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Ingresar al Sistema";
      include_once($ruta."includes/head_basico.php");
    ?>
    <link href="<?php echo $ruta ?>recursos/css/layouts/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="<?php echo $ruta ?>recursos/js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="<?php echo $ruta ?>recursos/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
</head>
<body>
  <div id="loader-wrapper">
      <div id="loader"></div>
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
    <div id="login-page" class="row">
    <div class="col s12 z-depth-4 card-panel">
        <div class="row">
          <div class="input-field col s12 center"><br>
            <img style="width: 100%;" src="<?php echo $ruta ?>recursos/images/logo.png" alt="">
            <p class="center login-form-text" style="font-weight: bold;">BIENVENIDO A PRESTAMO DE CREDITOS PRO-AYUDA</p>
          
          </div>
        </div>
        
    </div>
  </div>
    <script type="text/javascript" src="<?php echo $ruta ?>recursos/js/plugins/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="<?php echo $ruta ?>recursos/js/materialize.js"></script>
    <script type="text/javascript" src="<?php echo $ruta ?>recursos/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>    
    <script type="text/javascript" src="<?php echo $ruta ?>recursos/js/plugins.js"></script>
    <script type="text/javascript" src="<?php echo $ruta ?>recursos/js/custom-script.js"></script>
    <script type="text/javascript" src="<?php echo $ruta ?>recursos/js/plugins/prism/prism.js"></script>
    <script src="<?php echo $ruta; ?>recursos/custom/session.js"></script>
    <script type="text/javascript">
    </script>
</body>

</html>