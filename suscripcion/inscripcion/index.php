<?php
  $ruta="../../";
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
  include_once($ruta."class/inscripcion.php");
  $inscripcion=new inscripcion;
  include_once($ruta."class/estudiante.php");
  $estudiante=new estudiante;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."funciones/funciones.php");
  session_start(); 

  extract($_GET);
  $fechaHoy=date('Y-m-d');
   $idhabilitadodet=dcUrl($lblcode);
   $habdet=$habilitadodet->muestra($idhabilitadodet);
   $hab=$habilitado->muestra($habdet['idhabilitado']);
   $dom=$dominio->muestra($habdet['iddominio']);

   $cur=$curso->muestra($hab['idcurso']);
   $niv=$nivel->muestra($cur['idnivel']);

 $cantidad=0;
  foreach($inscripcion->mostrarTodo("idhabilitadodet=".$idhabilitadodet." and estado=1") as $can)
  {
    $cantidad++;
  }

   $anio=date('Y');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="ESTUDIANTES INSCRITOS GESTION ".$hab['gestion'];
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
          $idmenu=1079;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row " style="background: #1C2637; text-align: center; color:white; font-size: 25px; border-radius: 5px;">
                    <?php echo $hd_titulo; ?>
              </div>
              <div class="row " style="background: white; color:#1C2637; font-size: 18px; border-radius: 5px; border:#1C2637 1px solid;">
                <div class="col s12 m12 l1">&nbsp;</div>
                  <div class="col s12 m12 l10">
                    <div class="col s12 m12 l6">
                       <div class="col s12 m12 l4">Curso:</div>
                       <div class="col s12 m12 l8" style="font-weight: bold;"><?php echo $cur['nombre'].' ' ?><b style="background: cyan"> <?php echo $dom['short'] ?></b></div>
                    </div>
                    <div class="col s12 m12 l6">
                       <div class="col s12 m12 l4">Nivel:</div>
                       <div class="col s12 m12 l8" style="font-weight: bold;"><?php echo $niv['nombre'] ?></div>
                    </div>
                    <div class="col s12 m12 l6">
                       <div class="col s12 m12 l4">Cantidad inscritos:</div>
                       <div class="col s12 m12 l8" style="font-weight: bold;"><?php echo $cantidad ?></div>
                    </div>
                    <div class="col s12 m12 l6">
                       <div class="col s12 m12 l4">Maximo permitido:</div>
                       <div class="col s12 m12 l8" style="font-weight: bold;">35</div>
                    </div>
                  </div>
                  <div class="col s12 m12 l1">&nbsp;</div>
              </div>
             
            </div>
          </div>
     
          <div class="container">
            <div class="section">
              <div class="row" >
              <div class="col s12 m12 l12" style="border-radius: 5px; border: 1px solid #E8E8E8; background: white;">
                 <a href="../" class="btn-jh waves-effect darken-4 red"><i class="fa fa-mail-reply-all"></i> Volver</a>
                 <div class="col s12 m12 l12" align="right"><a href="#modal2" class="btn waves-effect waves-light orange indigo modal-trigger "><i class="fa fa-plus-square"></i> Agregar estudiante</a>   </div>
                     
                <table id="example2" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Cod</th>
                      <th>Carnet</th>
                      <th>Estudiante</th> 
                      <th>Tutor</th>
                       <th>Celular tutor</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Cod</th>
                      <th>Carnet</th>
                      <th>Estudiante</th> 
                      <th>Tutor</th>
                       <th>Celular tutor</th>
                      <th>Acciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    $contar=0;
                    foreach($inscripcion->mostrarTodo("idhabilitadodet=".$idhabilitadodet." and estado=1") as $f)
                    {
                       $est=$estudiante->muestra($f['idestudiante']);
                      $deje=$vadmejecutivo->muestra($est['idadmejecutivo']);

                      switch ($f['estado']) {
                        case '0':
                          $estilo="background-color: #FDEDEC;";
                        break;
                        case '1':
                          $estilo="background-color: #EAFAF1;";
                        break;
                      }
                     
                      $lblcode=ecUrl($f['idinscripcion']);
                      $contar++;
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $contar ?></td>
                      <td><?php echo $deje['carnet']." ".$deje['expedido']?></td>
                      <td><?php echo $deje['nombre']." ".$deje['paterno']." ".$deje['materno'] ?></td>
                      <td><?php echo $est['tutor'] ?></td>
                      <td><?php echo $est['celulartutor'] ?></td>
                      <td>
                                               
                          <button class="btn waves-effect darken-4 red" onclick="habilitar('<?php echo $f['idcurso'] ?>');"><i class="fa fa-times"></i> Eliminar </button>
                       
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
                <div id="modal2" class="modal">
                  <div class="modal-content">
                    <form class="col s12" id="idformp" action="return false" onsubmit="return false" method="POST">
                        <input type="hidden" name="idpersonaImp" id="idpersonaImp" value="">
                        <input type="hidden" name="idestudianteImp" id="idestudianteImp" value="">
                        <input type="hidden" name="idflag" id="idflag" value="">
                        <input type="hidden" name="idhabilitadodet" id="idhabilitadodet" value="<?php echo $idhabilitadodet ?>">
                      <div id="smstext" style="font-size:18px;" align="center"></div>
                        <div class="row">                
                              <div class="col s12 m12 l12">
                              <fieldset class="informacion">
                                    <legend><div class="titulo"><strong>Datos de Estudiante</strong> </div></legend>
                                    <div class="row" style="font-size:18px; color:#566573">
                        <div id="valCarnet" class="col s12"></div>
                        <div class="input-field col s8">
                          <input id="idcarnet" name="idcarnet" onchange="cargarCI();" type="text" class="validate">
                          <label for="idcarnet">CARNET</label>
                        </div>
                        <div class="input-field col s4">
                          <label>Expedido</label>
                          <select id="idexp" name="idexp">
                            <option disabled value="">Seleccionar Departamento</option>
                            <?php
                              foreach($dominio->mostrarTodo("tipo='DEP'") as $f)
                              {
                                ?>
                                  <option value="<?php echo $f['short']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s12 m12 l4">
                          <input id="idnombre" name="idnombre" type="text" class="validate">
                          <label for="idnombre">Nombre(s)</label>
                        </div>
                        <div class="input-field col s12 m12 l4">
                          <input id="idpaterno" name="idpaterno" type="text" class="validate">
                          <label for="idpaterno">Paterno</label>
                        </div>
                        <div class="input-field col s12 m12 l4">
                          <input id="idmaterno" name="idmaterno" type="text" class="validate active">
                          <label for="idmaterno">Materno</label>
                        </div>
                        <div class="input-field col s12 m12 l4">
                          <input id="idnacimiento" name="idnacimiento" type="date" class="validate">
                          <label for="idnacimiento">Fecha Nacimiento</label>
                        </div>
                        <div class="input-field col s12 m12 l4">
                          <input id="idemail" name="idemail" type="email" class="validate">
                          <label for="idemail">Email</label>
                        </div>  
                        <div class="input-field col s12 m12 l4">
                          <input id="idcelular" name="idcelular" type="text" class="validate">
                          <label for="idcelular">Celular(es)</label>
                        </div>
                        <div class="input-field col s12 m12 l4">
                          <label>Sexo</label>
                          <select id="idsexo" name="idsexo">
                              <option value="1">MASCULINO</option>
                              <option value="2">FEMENINO</option>
                          </select>
                        </div>
                         <div class="input-field col s12 m12 l8">
                          <input id="idocupacion" name="idocupacion" type="text" value="ESTUDIANTE" class="validate">
                          <label for="idocupacion">Ocupacion</label>
                        </div> 
                                    </div>
                              </fieldset> 
                              </div>
                        </div>
                        <div class="row">                
                              <div class="col s12 m12 l12">
                              <fieldset class="informacion">
                                    <legend><div class="titulo"><strong>Datos domiciliarios</strong> </div></legend>
                                    <div class="row" style="font-size:18px; color:#566573">
                                        <div class="input-field col s12 m12 l4">
                                        <input id="idzona" name="idzona"  type="text" class="validate">
                                        <label for="idzona">Zona</label>
                                      </div>
                                      <div class="input-field col s12 m12 l4">
                                        <input id="iddireccion" name="iddireccion" type="text" class="validate">
                                        <label for="iddireccion">Direccion</label>
                                      </div>
                                      <div class="input-field col s12 m12 l4">
                                        <input id="idfono" name="idfono" type="text" class="validate">
                                        <label for="idfono">telefono</label>
                                      </div>
                                       <div class="input-field col s12 m12 l12">
                                      <label>Persona</label>
                                      <select id="tipoeje" name="tipoeje">
                                        <?php
                                          foreach($dominio->mostrarTodo("tipo='CAAS' and iddominio=166") as $f)
                                          {
                                            ?>
                                              <option value="<?php echo $f['iddominio']; ?>"><?php echo $f['nombre']; ?></option>
                                            <?php
                                          }
                                        ?>
                                      </select>
                                    </div>
                                    </div>
                                     
                              </fieldset> 
                              </div>
                        </div>
                        <div class="row">                
                              <div class="col s12 m12 l12">
                              <fieldset class="informacion">
                                    <legend><div class="titulo"><strong>Datos Del Tutor</strong> </div></legend>
                                    <div class="row" style="font-size:18px; color:#566573">
                                            <div class="row">
                                          <div class="input-field col s12 m12 l6">
                                            <input id="idtutor" name="idtutor" type="text" class="validate">
                                            <label for="idtutor">Nombre Completo:</label>
                                          </div>
                                          <div class="input-field col s12 m12 l6">
                                            <input id="idcelulartutor" name="idcelulartutor" type="text" class="validate">
                                            <label for="idcelulartutor">Celular:</label>
                                          </div>                      
                                        </div>
                                    </div>
                                     
                              </fieldset> 
                              </div>
                        </div>


                    </form>
                  </div>
                  <div class="modal-footer">
                   <!-- <a id="btnLimpiar" onclick="limpiar();" class="btn waves-effect waves-light red"><i class="fa fa-clear"></i> Limpiar</a> -->
                          <a id="btnSavep" class="btn waves-effect waves-light blue"><i class="fa fa-save"></i> Inscribir</a>
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

function cargarCI()
{ 
  var carnet = $("#idcarnet").val();
   var idhabdet = '<?php echo $idhabilitadodet ?>';
  if (carnet!='') 
  {
    $.ajax({
            async: true,
            url: "cargarpersona.php?carnet="+carnet+"&idhabilitadodet="+idhabdet,
            type: "get",
            dataType: "html",
            success: function(data){
              var json = eval("("+data+")");

               $("#idflag").val(json.tipo);
               $("#idpersonaImp").val(json.idpersonaImp);
               $("#idestudianteImp").val(json.idestudianteImp);
               $("#idexp").val(json.expedido);
               $("#idnombre").val(json.nombre);
               $("#idpaterno").val(json.paterno);
               $("#idmaterno").val(json.materno);
               $("#idnacimiento").val(json.fechanac);
               $("#idemail").val(json.email);
               $("#idcelular").val(json.celular);
               $("#idsexo").val(json.sexo);
               $("#idocupacion").val(json.ocupacion);

               $("#idzona").val(json.zona);
               $("#iddireccion").val(json.direccion);
               $("#idfono").val(json.telefono);
            }
          });
 
  }else{
    $("#idflag").val('');
  }
}

       $("#btnSavep").click(function(){
         var flag = $("#idflag").val();

         if(flag==4){
              swal("Error","El estudiante ya se encuentra inscrito","error");
          }else{
              var nombreVal1 = $("#idnombre").val();
                var carnetVal1 = $("#idcarnet").val();
                if (nombreVal1 == '' || carnetVal1 == '') 
                {
                   swal("Error","DATOS FALTANTES","error");
                }else {
                  swal({
                    title: "CONFIRMACION",
                    text: "Inscripción del estudiante ",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#2c2a6c",
                    confirmButtonText: "Inscribir",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                  }, function () {
                    var str = $( "#idformp" ).serialize();
                   // alert(str);
                    $.ajax({
                      url: "guardarp.php",
                      type: "POST",
                      data: str,
                      success: function(resp){
                        setTimeout(function(){     
                          console.log(resp);
                          $('#idresultado').html(resp);   
                        }, 1000);
                      }
                    }); 
                  });
                }
          }


         
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