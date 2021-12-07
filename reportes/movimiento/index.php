<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/chofer.php");
  $chofer=new chofer;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."funciones/funciones.php");
  session_start();


  $idus=$_SESSION["codusuario"];
  $lblcode=ecUrl($idus);  
  //$mesAnteriorInicio= date("Y-m-01",strtotime($fecha_actual."- 1 month"));
  $mesInicio= date("Y-m-01");
  $mesFin= date("Y-m-d");
              
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="REPORTE DE MOVIMEINTO DE COBROS";
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
          $idmenu=1099;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                 <div class="col s12 m12 l12" style="background: white; text-align: center; color:#006458; font-size: 25px; border-radius: 5px; border: #CBCBCB 1px solid; font-weight: bold;">
                <?php echo $hd_titulo; ?>
              </div>
              </div>
            </div>
          </div>
     
          <div class="container">
            <div class="section">
              <div class="row">
                     <div class="col s12 m12 l4">
                      &nbsp;
                     </div>
                    <div class="col s12 m12 l4"><!--green lighten-5-->
                      <div class="card-content">
                      <div class="col s12 m12 l12" style="border-radius: 5px; border: 1px solid #E8E8E8; background: white;">
                        <div class="input-field col s12 m12 l12"> 
                         
                        <label>Chofer</label>
                          <select id="idchofer" name="idchofer">
                            <option value="0">General</option>
                            <?php
                              foreach($chofer->mostrarTodo("estado=1") as $f)
                              {
                                $deje=$vadmejecutivo->muestra($f['idadmejecutivo']);
                                $lblcode2=ecUrl($f['idchofer']);  
                                ?>
                                  <option value="<?php echo $lblcode2; ?>"><?php echo $deje['nombre']." ".$deje['paterno']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s12 m12 l6"> 
                        <input id="idfechainicio" name="idfechainicio" type="date" class="validate" value="<?php echo $mesInicio ?>">
                          <label for="idfechainicio" style="color:#00BBC7; text-decoration:none;"> Fecha Inicio</label>
                        </div>  
                         <div class="input-field col s12 m12 l6"> 
                        <input id="idfechafin" name="idfechafin" type="date" class="validate" value="<?php echo $mesFin ?>">
                          <label for="idfechafin" style="color:#00BBC7; text-decoration:none;"> Fecha Fin</label>
                        </div> 
                        &nbsp;
                        <div class="col s12 m12 l12" style="text-align: right;"> 
                         <button id="btnSave" onclick="generar2();" style="font-size: 18px; width: 100%;" class="btn-jh cyan"> Generar Reporte</button> 
                        </div>
                      </div>
                      </div>
                      </div> 
                      <div class="col s12 m12 l4">
                      &nbsp;
                      </div>
             
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
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    });

 function obtener_mensual(idpro)
 {        
    var idamdeje=$("#idadmejecutivo").val();
    var fechaini=$("#idfechaini2_1").val();
    var fechafin=$("#idfechafin2_2").val();    
        $.ajax({
        url: "../cargar/mostrar_mensual.php",
        method: "POST",
        data: "idadmejecutivo="+idamdeje+"&fechaini="+fechaini+"&fechafin="+fechafin,
        success: function(data){
            $("#result").html(data);
            //alert(data);
        }
      });
      
  }

    function cambiaestado(id,estado){
      swal({
        title: "Estas Seguro?",
        text: "Cambiaras el estado al ejecutivo",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false
      }, function () {      
        $.ajax({
          url: "cambiaestado.php",
          type: "POST",
          data: "id="+id+"&estado="+estado,
          success: function(resp){
            console.log(resp);
            $("#idresultado").html(resp);
          }   
        });
      }); 
    }

function generar2()
{
  var lbl_us="<?php echo $lblcode ?>";
  var idchof=$("#idchofer").val();
  var fechaini=$("#idfechainicio").val();
  var fechafin=$("#idfechafin").val();
    popup=window.open('../pdf/movcobros.php?lblcode='+lbl_us+'&fechaini='+fechaini+'&fechafin='+fechafin+'&lblcode2='+idchof);
}
    </script>
</body>

</html>