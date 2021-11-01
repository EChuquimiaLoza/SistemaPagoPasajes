<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."class/tarjeta.php");
  $tarjeta=new tarjeta;
  include_once($ruta."funciones/funciones.php");
  session_start(); 
   $fechaHoy=date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="LISTA GENERAL DE TARJETAS RFID ASIGNADOS";
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
          $idmenu=1089;
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
              <div class="row" >
              <div class="col s12 m12 l12" style="border-radius: 5px; border: 1px solid #E8E8E8; background: white;">
                        
                <table id="example2" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Cod</th>
                        <th>Cliente</th> 
                        <th>Codigo</th>
                        <th>Saldo</th>
                        <th>Fecha asignado</th>
                        <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <tr>
                        <th></th>
                        <th></th> 
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    $contar=0;
                    foreach($tarjeta->mostrarTodo("estado=1") as $f)
                    {
                                        
                      $lblcode=ecUrl($f['idtarjeta']);
                      $vadmeje=$vadmejecutivo->muestra($f['idadmejecutivo']);
                      $contar++;
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $f['idtarjeta'] ?></td>
                      <td><?php echo $vadmeje['nombre'].' '.$vadmeje['paterno'].' '.$vadmeje['materno'] ?></td>
                      <td><?php echo $f['codigo'] ?></td>
                      <td><?php echo number_format($f['saldo'], 2, '.', '') ?></td>
                      <td><?php echo $f['fecha'] ?></td>
                      <td>
                        <button class="btn-jh waves-effect darken-4 cyan" onclick="mostrartarjeta('<?php echo $f['idtarjeta'] ?>')"><i class="fa fa-credit-card"></i> RECARGAR TARJETA</button>
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
        </section>
        <div class="container">
            <div class="section">
              <div id="modal1" class="modal">
                <div class="modal-content">
                <h1 style="color:#006458; font-weight: bold;">Recarga de Tarjeta RFID</h1>
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input id="idtarjetaImp" name="idtarjetaImp" hidden value="0">
                      <div class="row">
                      <div class='col s12 m12 l12' align="center">
                    <div class="col s12 m12 l12" style="color:#006458; background: #D1D1D1; border-radius: 5px; font-size: 17px;">Cliente: <b id="idnombresImp"></b> <br>
                      Codigo: <b id="idcodigoImp"></b><br>
                      Saldo: <b id="idsaldoImp"></b></div>
                        </div>
                        <div class="col s12 m3 l3">&nbsp;</div>
                        <div class="input-field col s12 m6 l6">
                          <input id="idmontorecarga" name="idmontorecarga" type="number"  class="validate">
                          <label for="idmontorecarga">Ingrese monto a recargar</label>
                        </div>
                        <div class="col s12 m3 l3">&nbsp;</div>
                      </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <a href="#" class="btn waves-effect waves-light light-red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</a>
                  <button id="btnSave" class="btn waves-effect darken-4 cyan"><i class="fa fa-save"></i> RECARGAR</button>
                </div>
              </div>
          
            </div>
          </div>
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
          //  'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
         
    });
    //0=fecha actual dia
    //1=fecha cambiado

  function mostrartarjeta(id)
  {
    $("#idtarjetaImp").val(id);
    //alert(id);
     $.ajax({
        async: true,
        url: "recarga/mostrartarjeta.php?idtarjeta="+id,
        type: "get",
        dataType: "html",
        success: function(data){
          console.log(data);
          var json = eval("("+data+")");
          $("#idnombresImp").text(json.nombres);
          $("#idsaldoImp").text(json.saldo);
          $("#idcodigoImp").text(json.codigo);

          $('#modal1').openModal();
        }
      });
  }
     $("#btnSave").click(function(){
        if (validar()) 
        {          
                swal({
                  title: "¿Esta seguro?",
                  text: "Recargar",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#006458",
                  confirmButtonText: "SI",
                  closeOnConfirm: false,
                  showLoaderOnConfirm: true
                }, function () {
                  var str = $( "#idform" ).serialize();
                  $.ajax({
                    url: "recarga/recargadirecto.php",
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
          swal("ERROR","Ingrese un monto valido, intente nuevamente","error");
        }
      });
function validar(){
        retorno=true;
        monrec=$('#idmontorecarga').val();
        tarImp=$('#idtarjetaImp').val();
        if(monrec<="0" || tarImp=="0"){
          retorno=false;
        }
        return retorno;
      }
    </script> 
</body>

</html>