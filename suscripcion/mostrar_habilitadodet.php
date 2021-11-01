<?php
session_start();
$ruta="../";
include_once($ruta."class/dominio.php");
$dominio=new dominio;
include_once($ruta."class/habilitado.php");
$habilitado=new habilitado;
include_once($ruta."class/habilitadodet.php");
$habilitadodet=new habilitadodet;
include_once($ruta."class/curso.php");
$curso=new curso;
include_once($ruta."class/inscripcion.php");
$inscripcion=new inscripcion;
//include_once($ruta."../../funciones/funciones.php");
extract($_POST);

 $curs=$curso->muestra($idcurso);
  echo "
   
  <fieldset>
     <legend class='titulo'>
      <button class='btn-jh waves-effect darken-4 green' onclick='habilitar($idcurso)'><i class='fa fa-plus-square-o'></i> Habilitar nuevo </button>".$curs['nombre']."
      </legend>
        <table id='exampleHABDET' style='font-size:14px;' class='display' cellspacing='0' width='100%'>
           <thead>
              <tr style='text-align:right;'>   
              <th>Nro.</th>
                <th>CURSO</th>
                <th>INSCRITOS</th>
                <th>MAXIMO</th>
                <th >GESTION</th>
                <th>Opciones</th>
              </tr>
           </thead>
        <tbody>
      ";      
      $contar=0;
       foreach($habilitadodet->mostrarTodo("idhabilitado=".$idhabilitado." and estado=1") as $f)
      {
         $dom=$dominio->muestra($f['iddominio']);
         $hab=$habilitado->muestra($idhabilitado);
         $cur=$curso->muestra($hab['idcurso']);
         $lblcode=ecUrl($f['idhabilitadodet']);
         $contar++; 
         $inscritos=0; 
         foreach($inscripcion->mostrarTodo("idhabilitadodet=".$f['idhabilitadodet']." and estado=1") as $ins)   
         {
            $inscritos++; 
         }   
        echo "
              <tr>
              <td>".$contar."</td>
                <td style='text-align:left;'>".$cur['nombre'].' '.$dom['short']."</td>
                <td>".$inscritos."</td>
                <td>35</td>
                <td>".$hab['gestion']."</td>
                <td><a href='inscripcion/?lblcode=$lblcode' class='btn waves-effect darken-4 cyan'><i class='fa fa-file-text'></i> INSCRIBIR</a></td>
              </tr>
            ";
      }

 echo "  </tbody>
        <tfoot>
          <tr style='align=center'>
            <th style='text-align:center'></th>
             <th style='text-align:right'></th>
             <th style='text-align:center'></th>
             <th style='text-align:center'></th>
             <th style='text-align:center'></th>
             <th style='text-align:left'></th>
           </tr>
        </tfoot>
        </table>      
       </fieldset>                         
        "; 
?> 

 <script type="text/javascript">
    $(document).ready(function() {
      
       $('#exampleHABDET').DataTable( {
        dom: 'Bfrtip',
        "order": [[ 0, "DESC" ]],
        buttons: [
           // 'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });

    });

    </script>  
     

