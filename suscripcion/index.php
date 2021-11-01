<?php
  $ruta="../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/nivel.php");
  $nivel=new nivel;
  include_once($ruta."class/curso.php");
  $curso=new curso;
  include_once($ruta."class/habilitado.php");
  $habilitado=new habilitado;
  include_once($ruta."class/habilitadodet.php");
  $habilitadodet=new habilitadodet;
  include_once($ruta."funciones/funciones.php");
  session_start(); 
   $fechaHoy=date('Y-m-d');
   $anio=date('Y');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="HABILITAR CURSOS GESTION ".$anio=date('Y');;
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
      include_once($ruta."includes/head_tablax.php");
    ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1078;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row " style="background: #1C2637; text-align: center; color:white; font-size: 25px; border-radius: 5px;">
                    <?php echo $hd_titulo; ?>
              </div>
             
            </div>
          </div>
     
          <div class="container">
            <div class="section">
              <div class="row" >
              <div class="col s12 m12 l12" style="border-radius: 5px; border: 1px solid #E8E8E8; background: white;">
                        
                <table id="example2" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Cod</th>
                      <th>Nivel</th>
                      <th>Nombre del curso</th> 
                      <th>descripción</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Cod</th>
                      <th>Nivel</th>
                      <th>Nombre del curso</th> 
                      <th>descripción</th>
                      <th>Acciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    foreach($curso->mostrarTodo("estado=1") as $f)
                    {
                       $niv=$nivel->muestra($f['idnivel']);

                      switch ($f['estado']) {
                        case '0':
                          $estilo="background-color: #FDEDEC;";
                        break;
                        case '1':
                          $estilo="background-color: #EAFAF1;";
                        break;
                      }
                     
                      $lblcode=ecUrl($f['idcurso']);
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $f['idcurso'] ?></td>
                      <td><?php echo $niv['nombre'] ?></td>
                      <td><?php echo $f['nombre'] ?></td>
                      <td><?php echo $f['descripcion'] ?></td>
                      <td>
                        <?php
                           $hab=$habilitado->mostrarUltimo("idcurso=".$f['idcurso']." and gestion=".$anio);
                           $idhabilitado=$hab['idhabilitado'];
                           if (count($hab)>0) 
                           {
                            ?>
                                                       
                             <a href="#modal1" class="btn waves-effect waves-light   indigo modal-trigger " onclick="cargar_habilitadodet('<?php echo $idhabilitado ?>','<?php echo $f['idcurso'] ?>');"> <i class="fa fa-check-square-o"></i> VER</a>
                             <?php
                           }else{
                              ?>
                              <button class="btn waves-effect darken-4 cyan" onclick="habilitar('<?php echo $f['idcurso'] ?>');"><i class="fa fa-clock-o"></i> HABILITAR GESTION </button>
                             <?php
                           }
                         ?>
                        
                        <a href="editar/?lblcode=<?php echo $lblcode ?>" class="btn waves-effect darken-4 orange"><i class="fa fa-edit (alias)"></i> editar</a>
                       
                      </td>
                    </tr>
                    <?php
                      }
                    ?>
                  </tbody>
                </table>
              </div>
              </div>
            </div>     
            </div>
       
        <div class="container">
            <div class="section">           
                <div id="modal1" class="modal">
                  <div class="modal-content">
                   <div class="row " style="background: #1C2637; text-align: center; color:white; font-size: 25px; border-radius: 5px;">
                    HABILITADOS
                   </div>
                        <div class="col s12 m12 l12"  style="background-color: white;">
                          <div class="table-responsive">  
                                                                       
                                <div id="result2"></div>
                           </div>
                           <!-- <div class="titulo">Lista de item ingresado a la fecha</div> -->
                            
                        </div> 
                  </div>
                  <div class="modal-footer">
                    <a id="btnLimpiar" onclick="limpiar();" class="btn waves-effect waves-light red"><i class="fa fa-clear"></i> CERRAR</a>
                  </div>
                </div>
            </div>
          </div>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
      include_once($ruta."includes/script_tablax.php");
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
        $('#example1').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
          $('#example2').DataTable( {
        dom: 'Bfrtip',
        "order": [[ 0, "asc" ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
         
    });
    //0=fecha actual dia
    //1=fecha cambiado
    function habilitar(id)
    {
      $ges='<?php echo $anio ?>';
      swal({
            title: "¿Esta seguro?",
            text: "Habilitar el curso para la gestion "+$ges,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "Habilitar",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
          }, function () {
            //var str = $( "#idform" ).serialize();
            $.ajax({
              url: "habilitarcurso.php",
              type: "POST",
              data: "idcurso="+id+"&gestion="+$ges,
              success: function(resp){
                setTimeout(function(){     
                  console.log(resp);
                  $('#idresultado').html(resp);   
                }, 1000);
              }
            }); 
          });
    }

   function cargar_habilitadodet(idhab,idcur)
    {     
      //alert(idhab);
        
          $.ajax({
              url: "mostrar_habilitadodet.php",
              method: "POST",
              data: "idhabilitado="+idhab+"&idcurso="+idcur,
              success: function(data){
                  $("#result2").html(data);
                  //alert(data);
              }
            });
        
    } 


    </script>
</body>

</html>