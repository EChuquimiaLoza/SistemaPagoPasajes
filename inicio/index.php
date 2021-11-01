<?php
 
  $ruta="../";  
  session_start();
  include_once($ruta."funciones/funciones.php");
  $lblcode=ecUrl(3898);
  //echo $lblcode;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo=$_SESSION["short"];
      $hd_titulo2=$_SESSION["descripcion"];
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
    ?>
    
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1000;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div class="container">
            <div class="section">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="col s12 m12 l12" style="font-size: 18px; text-align: center; font-weight: bold;">
                    SISTEMA DE PAGO DE PASAJES
                     </div>
                  <div class="col s12 m12 l4">
                                <ul id="projects-collection" class="collection">
                                    <li class="collection-item avatar">
                                         <div class="col s5">
                                        <i class="mdi-social-group circle light-green darken-4"></i>
                                        <span class="collection-header">Usuarios</span>
                                        </div>
                                        <div class="col s7">
                                             <span class="task-cat green" style="font-size: 15px;">3</span>
                                        </div>
                                    </li>
                                </ul>
                </div>
                 <div class="col s12 m12 l4">
                                <ul id="projects-collection" class="collection">
                                    
                                    <li class="collection-item avatar">
                                         <div class="col s5">
                                        <i class="mdi-action-assignment-ind circle light-green darken-4"></i>
                                        <span class="collection-header">Choferes</span>
                                        </div>
                                        <div class="col s7">
                                             <span class="task-cat green">2</span>
                                        </div>
                                    </li>
                                </ul>
                </div>
                 <div class="col s12 m12 l4">
                                <ul id="projects-collection" class="collection">                                    
                                    <li class="collection-item avatar">
                                         <div class="col s5">
                                        <i class="mdi-maps-directions-car circle light-green darken-4"></i>
                                        <span class="collection-header">TRUFI</span>
                                        </div>
                                        <div class="col s7">
                                             <span class="task-cat green">0</span>
                                        </div>
                                    </li> 
                                </ul>
                </div>
                
                  
                </div>
                <div class="col s12 m12 l12">
                    <div class="slider">
                    <ul class="slides">
                      <li>
                        <img src="<?php echo $ruta ?>imagenes/slide/SL0.jpg"> <!-- random image -->
                        <!-- random image -->
                      
                      </li>
                      <li> 
                        <img src="<?php echo $ruta ?>imagenes/slide/SL2.jpg" alt="sample">
                         <div class="caption center-align">
                      </div>
                      </li>
                      <li>
                        <img src="<?php echo $ruta ?>imagenes/slide/SL3.jpg"> <!-- random image -->
                        <div class="caption center-align">
                        <h3></h3>
                        <h5 class="light white-text text-lighten-3"></h5>
                      </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
          <div class="container">
            <div class="section">           
                <div id="modal1" class="modal">
                  <div class="modal-content">
                   <div class="row " id="textodia" style="background: white; text-align: center; color:#1C2637; font-size: 25px; border-radius: 5px;">
                   </div>
                       <div class="col s12 m12 l12" style="background: white; text-align: center; color:#006458; font-size: 25px; border-radius: 5px; font-weight: bold;">
                        BIENVENIDO <br>
                        <?php echo $dusuario['nombre'].' '.$dusuario['paterno'] ?>
                        <br>
                        SISTEMA DE PAGO DE PASAJES
              </div>
                  </div>
                  <div class="modal-footer">
                    <button class="btn waves-effect waves-light darken-4 cyan" onclick="cerrar();">GRACIAS</button>
                  </div>
                </div>
            </div>
          </div>
          <div id="breadcrumbs-wrapper">
            <div class="container">
             
            </div>
          </div>
          
          <!--start container-->
       
          <!--end container-->
        </section>
      </div>
    </div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    
    <!-- Toast Notification -->
    <script type="text/javascript">
      $('#modal1').openModal();
      function cerrar()
      {
        $('#modal1').closeModal();
      }
    $(document).ready(function() {
      $('#example').DataTable({
        responsive: true
      });
    });
    // Toast Notification
    $(window).load(function() {
        
        setTimeout(function() {
            Materialize.toast('<span>Bienvenido</span>', 1500);
        }, 1500);
        setTimeout(function() {
            Materialize.toast('<span>En el boton izquierdo puede ver tus opciones en el sistema</span>', 3000);
        }, 5000);
        setTimeout(function() {
            Materialize.toast('<span>No dudes en consultar al departamento de sistemas</span>', 3000);
        }, 15000);
    });
    </script>
</body>

</html>