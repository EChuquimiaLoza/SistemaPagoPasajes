<?php
  $ruta="../../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/nivel.php");
  $nivel=new nivel;
  include_once($ruta."class/rol.php");
  $rol=new rol;
   include_once($ruta."class/curso.php");
  $curso=new curso;
    include_once($ruta."class/habilitado.php");
  $habilitado=new habilitado;
  include_once($ruta."class/habilitadodet.php");
  $habilitadodet=new habilitadodet;
  include_once($ruta."class/estudiante.php");
  $estudiante=new estudiante;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."class/tarjeta.php");
  $tarjeta=new tarjeta;
  include_once($ruta."funciones/funciones.php");
  session_start(); 
  extract($_GET);

 $idadmejecutivo=dcUrl($lblcode);
 $deje=$vadmejecutivo->muestra($idadmejecutivo);
 $est=$estudiante->mostrarUltimo("idadmejecutivo=".$idadmejecutivo);

 $habdet=$habilitadodet->mostrarUltimo($est['idestudiante']);
 $dom=$dominio->muestra($habdet['iddominio']);
 $hab=$habilitado->mostrarUltimo($est['idhabilitado']);
 $cur=$curso->muestra($hab['idcurso']);
 $niv=$nivel->muestra($cur['idnivel']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="ASIGNAR CREDENCIAL CLIENTE";
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
          $idmenu=1092;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
           <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
          <!--    <div class="row"> -->
                <div class="col s12 m12 l12" style="background: white; text-align: center; color:#006458; font-size: 25px; border-radius: 5px; border: #CBCBCB 1px solid; font-weight: bold;">
                <?php echo $hd_titulo; ?>
              </div>
               <div class="col s12 m12 l12" style="text-align: right;">
                  
                </div>             
           <!-- </div>--> 
         </div>
          </div>
<div class="container">
  <div class="section">
    <div class="row">
      <div class='col s12 m12 l12' align="center">
        <div class="col s12 m12 l12"  style="color:#006458; background: #D1D1D1; border-radius: 5px;">Cliente: <b><?php echo $deje['nombre'].' '.$deje['paterno'].' '.$deje['materno'] ?></b>Carnet: <b><?php echo $deje['carnet'].' '.$deje['expedido'] ?></b></div>
        </div>
      <?php
      $codigo=0;
        $tar=$tarjeta->mostrarUltimo("estado=0 and fechacreacion='".date('Y-m-d')."'");
        if (count($tar)>0) 
        {
         $codigo=$tar['codigo'];
        }

      ?>
      <div class='col s12 m12 l6'> 
        <fieldset class="informacion">
                     
                      <div class="col s12 m12 l12">
                         <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                  <fieldset class="informacion" style="border: #D1D1D1 1px solid;">
                    <legend><div class="" style="color: #006458;">
                       <a href="../../" class="btn-jh waves-effect darken-4 red"><i class="fa fa-mail-reply-all"></i></a>
                      <b>ASIGNAR CREDENCIAL RFID</b> </div></legend>
                   <input id="idadmejecutivo" name="idadmejecutivo" type="hidden" value="<?php echo $idadmejecutivo ?>" class="validate">
                   <input id="idtarjeta" name="idtarjeta" type="hidden" value="<?php echo $tar['idtarjeta'] ?>" class="validate">
                   <div class="col s12 m12 l2">&nbsp;</div> 
                    <div class="col s12 m12 l8">
                      <div class="input-field col s12 m12 l10" >
                          <input id="idcodigorfid" name="idcodigorfid" style="font-size: 40px; text-align: center; color: white; background: #006458;" readonly type="number" value="<?php echo $codigo ?>" class="validate">
                          <label for="idcodigorfid">Codigo RFID</label>
                        </div>
                        <div class="input-field col s12 m12 l2" >
                          <button class="btn waves-effect waves-light darken-4 cyan" onclick="buscar();"><i class="fa fa-search"></i></button>
                        </div>
                         
                    </div> 
                    <div class="col s12 m12 l2">&nbsp;</div>
                    <br><br><br>
                    <div class="col s12 m12 l12" align="center">
                          <a id="btnSave" class="btn waves-effect waves-light darken-4 cyan"><i class="fa fa-save"></i> Asignar RFID</a>
                        </div> 
                  </fieldset>
                </form>
                      </div> 
                    </fieldset>
      </div>  
      <div class='col s12 m12 l6'>
        <fieldset class="informacion">
          <div class="col s12 m12 l12"style="color: #006458; font-weight: bold;">Historial de tarjetas asignados al cliente</div>
      <table id="example2" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th style="width: 50%; text-align: center">Codigo tarjeta RFID</th>
                      <th style="width: 50%; text-align: right;">Opcion</th> 
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                     $contar=0;
                     foreach($tarjeta->mostrarTodo("idadmejecutivo=".$idadmejecutivo) as $f)
                    {
                      $contar++;
                        switch ($f['estado']) {
                        case '2':
                          $estilo="background-color: #FDEDEC;";
                        break;
                        case '1':
                          $estilo="background-color: #EAFAF1;";
                        break;
                      }
                    ?>
                     <tr style="<?php echo $estilo ?>">
                      <td style="text-align: center;"><?php echo $f['codigo'] ?></td>
                      <td style="text-align: right;">
                        <?php
                        if ($f['estado']==1) 
                        {
                          ?>
                          <button class="btn-jh waves-effect waves-light darken-4 red" onclick="darbaja('<?php echo $f['idtarjeta'] ?>');"><i class="fa fa-arrow-circle-down"></i> Dar de baja</button>
                          <?php
                        }
                         ?>
                        
                      </td>
                    </tr>
                    <?php
                      }
                    ?>
                  </tbody>

                </table> 
                  <?php
                   
                    if ($contar==0) 
                    {
                      ?>
                         
                          <div class="col s12 m12 l12">
                            <div class="col s12 m12 l12"style="background: #D8FAFF;  color: #BB0C0C">TARJETA RFID SIN ASIGNAR</div>
                          </div>
                        <?php
                    }
                   ?>
                 </fieldset>
      </div>
      
    </div>
  </div>
</div>

            
          <?php
           // include_once("../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
     include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
      include_once($ruta."includes/script_tablax.php");
    ?>
    <script type="text/javascript">
          $(document).ready(function() {
     
          $('#example2').DataTable( {
        dom: 'Bfrtip',
        "order": [[ 2, "asc" ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
         
    });
          $("#btnSave").click(function(){
        $('#btnSave').attr("disabled",true);
        if (validar()) 
        {          
                swal({
                  title: "¿Esta seguro?",
                  text: "Se asiganar la tarjeta",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#2c2a6c",
                  confirmButtonText: "SI",
                  closeOnConfirm: false,
                  showLoaderOnConfirm: true
                }, function () {
                  var str = $( "#idform" ).serialize();
                  $.ajax({
                    url: "guardar.php",
                    type: "POST",
                    data: str,
                    success: function(resp){
                      //alert(resp);
                      setTimeout(function(){     
                        console.log(resp);
                        $('#idresultado').html(resp);   
                      }, 1000);
                    }
                  }); 
                });
        }else{
          swal("ERROR","Pasar tarjeta RFID, realize la busqueda nuevamente","error");
        }
      });
function validar(){
        retorno=true;
        cod=$('#idcodigorfid').val();
        if(cod=="0"){
          retorno=false;
        }
        return retorno;
      }
    function limpiar()
      {
          document.getElementById("idform").reset();
      }
function buscar()
{
    location.reload();
}
function darbaja(id)
{
   swal({
                  title: "¿Esta seguro?",
                  text: "Dar baja a la tarjeta",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#2c2a6c",
                  confirmButtonText: "SI",
                  closeOnConfirm: false,
                  showLoaderOnConfirm: true
                }, function () {
                  //var str = $( "#idform" ).serialize();
                  $.ajax({
                    url: "darbaja.php",
                    type: "POST",
                    data: "idtarjeta="+id,
                    success: function(resp){
                      //alert(resp);
                      setTimeout(function(){     
                        console.log(resp);
                        $('#idresultado').html(resp);   
                      }, 1000);
                    }
                  }); 
                });
}
    </script>
</body>

</html>