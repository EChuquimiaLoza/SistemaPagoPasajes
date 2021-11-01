<?php
  $ruta="../../../../";
  session_start();
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/vtitular.php");
  $vtitular=new vtitular;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/cobcartera.php");
  $cobcartera=new cobcartera;
  include_once($ruta."class/admcontratodelle.php");
  $admcontratodelle=new admcontratodelle;
  include_once($ruta."class/vcontratoplan.php");
  $vcontratoplan=new vcontratoplan;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."funciones/funciones.php");
  extract($_GET);
  if (!isset($_SESSION["idsede"])) {
    $query=" and idsede=0";
    $tituloSede="Debe pertenecer a una sede para realizar esta operacion";
    $numeracion=0;
  }
  else{
    $query=" and idsede=".$_SESSION["idsede"];
    $dsede=$sede->muestra($_SESSION["idsede"]);
    $codigo="110-1-";
    $numeracion=$dsede['ult_record'];
    $tituloSede="Contratos en Sede ".$dsede['nombre'];
  }
  if (!isset($fechaGen)) {
    $fechaGen=date("Y-m-d");
  }
/************************************************/
// condicionamos la fecha inicio

/*************************************/
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Parte diario de Verificacion";
    include_once($ruta."includes/head_basico.php");
    include_once($ruta."includes/head_tabla.php");
  ?>
  <style type="text/css">
    .estIn input{
      border:solid 1px #4286f4;
      width: 110px;
    }
  </style>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=55;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l5">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <div class="formcontent">
                <div class="col s12 m4 l3">
                  <h4 class="titulo">Reporte Diario de Produccion</h4>
                  <p style="text-align: justify;">
                    Deberas verificar que no haya registros pendientes por consolidar.
                  </p>
                </div>
                <div class="col s12 m8 l9">
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input type="hidden" name="idcontrato" id="idcontrato" value="<?php echo $idcontrato; ?>">
                    <div class="row">
                      <div class="input-field col s12 m6 l3">
                        <input id="idfecha" style="text-align: center;" name="idfecha" type="date" value="<?php echo date('Y-m-d'); ?>" class="validate">
                        <label for="idfecha">Fecha</label>
                      </div>
                      <div class="input-field col s3">
                        <label>SEDE</label>
                        <select id="codsede" name="codsede">
                          <?php
                            foreach($sede->mostrarTodo("") as $f)
                            {
                              ?>
                                <option value="<?php echo $f['idsede']; ?>"><?php echo $f['nombre']; ?></option>
                              <?php
                            }
                          ?>
                        </select>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <a style="width: 100%" id="btnSsave" class="btn waves-effect waves-light darken-3 purple"><i class="fa fa-save"></i> GENERAR REPORTE</a><br><br><br>
                      </div>
                    </div>
                  </form>
                </div>&nbsp;
                <div class="col s12 m12 l12">
                  <div class="divider"></div>
                </div>
              </div>
            </div>
          </div>
          <?php
            include_once("../../../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    <script type="text/javascript">
      $("#idfechaCon").change(function() {
        //alert($("#idfechaCon").val() );
        location.href="?fechaGen="+$("#idfechaCon").val();
      });
      $("#btnSsave").click(function(){
        //alert($("#idfechaCon").val() );
        window.open("imprimir/?fechaGen="+$("#idfecha").val()+'&codsede='+$("#codsede").val(),"_blank");
      });
      $("#btnSave").click(function(){
        swal({
          title: "Consolidar?",
          text: "Deseas consolidar el Parte diario?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#28e29e",
          confirmButtonText: "Estoy Seguro",
          closeOnConfirm: false
        }, function () {
          $('#btnSave').attr("disabled",true);
          var str ="fechaGen="+$("#idfechaCon").val();
          $.ajax({
            url: "guardarParte.php",
            type: "POST",
            data: str,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
        }); 
      });
      function guardaH(id){
        var hora=$('#c'+id).val();
        var obs=$('#o'+id).val();
        var str="hora="+hora+"&id="+id+"&obs="+obs;
        $.ajax({
          url: "guardar.php",
          type: "POST",
          data: str,
          success: function(resp){
            console.log(resp);
            $('#idresultado').html(resp);
          }
        });
      }
      $('.cuentaCaja').formatter({
        'pattern': '110-1-{{99999}}',
        'persistent': true
      });
      $('#example').DataTable();
       $('#example5').DataTable();
      $('#example1').DataTable();
    </script>
</body>
</html>