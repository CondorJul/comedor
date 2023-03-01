<?php 
  if(!isset($_SESSION["logged_is_user"])){
    header("Location: ".SERVER_PHP);
    exit();
  }elseif($_SESSION["role"] !== "SP" and $_SESSION["role"] !== "AD" and $_SESSION["role"] !== "RE" and $_SESSION["role"] !== "BU"){
    if(isset($_SERVER['HTTP_REFERER'])){
      header("Location:".$_SERVER['HTTP_REFERER']);    
    }else{
      header("Location: ".SERVER_PHP);
    }
    exit();
  } 
?>
<!DOCTYPE html>
<html lang="es">
  <?php include "../templates/layouts/head1.php"; ?>
<body class="app sidebar-mini rtl sidenav-toggled" style="min-width: 280px;">
  <?php include "../templates/layouts/header.php"; ?>
  <?php include "../templates/layouts/menu.php"; ?>

  <main class="app-content" style="background: white;">
    <div class="row">

      <div class="col-lg-12">
        <div class="tab-pane" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div class="card">
            <h3 class="card-header text-center bg-primary" style="color: #fff; font-weight: bold; font-family: 'arial narrow';">Lista de Sugerencias<span class="fas fa-comment-dots pull-right"></span></h3>
            <div class="card-block p-3">
              <div class="card-body table-responsive p-0" id="tabla_resultado" >
                <table class="table table-hover table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th scope="col" class="text-center">#</th>
                      <th scope="col" class="text-center">Fecha y Hora</th>
                      <th scope="col" class="text-center">Sugerencia</th>
                     <!-- <th scope="col" class="text-center">Solución</th>
                      <th scope="col" class="text-center">Prioridad</th>-->

                    </tr>
                  </thead>

                    <tbody id="tbodyUsuarios">
                    </tbody>
                </table>
                <div class="text-center" id="mensajeErrorUser">

                </div>
                <div id="mostrar_loadingH" style="display: none;">
                  <?php include "../templates/layouts/loading.html";?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
    <!--modal restablecer contraseña-->
    <div id="passwordReset" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Restablecer Contraseña</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="input-group input-group-sm col-lg-12 col-12 pl-0 pr-0">
                <input type="text" class="form-control" id="pw" name="pw" placeholder="Nueva Contraseña">
                <div class="input-group-append">
                  <button type="button" class="btn btn-secondary" id="verPw" name="verPw"><i class="fas fa-eye"></i></button>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-success btn-sm">Restablecer</button>
          </div>
        </div>
      </div>
    </div>
  </main>



  <?php include "../templates/layouts/scriptFinal.php"; ?>
  <script src="js/starrr.js"></script>
  
</body>
</html>
<script>
  
  $(function(){
    listSugerencias();
  });



  function listSugerencias(){
    $.ajax({
      url: 'sugerencias/list/',
      method:'POST',
      beforeSend: function(){

      },
      success: function(data){
        var resul = JSON.parse(data);
        $("#tbodyUsuarios").html("");
        var cont=0;

        $.each(resul, function(index, val) {
          var tr = $("<tr />");
          cont++
          var id_sugg=-1;

          tr.append("<td>"+cont+"</td>");
          

          $.each(val, function(k, v) {

            if(k=='id'){
              //alert("fasdfasdfsadf");
              id_sugg=v;
               return true;
            }
            if(k=='date_add'){
               v=moment(v).format('YYYY/MM/DD HH:mm:ss');
              v
            }
            if (k=='solution') {
              return true;
              if(v==null){

                v='  <div><button type="button" class="btn btn-secondary"><i class="fa fa-edit"></i></button> </div> ';
              }else{
                v=k ;
              }

            }

            if (k=='priority') {
              return true;
              v="<div class='starrr' data-id_sugg='"+id_sugg+"'></div> ";
            }

            tr.append(
              $("<td />",{
                html: v
              })[0].outerHTML
            );
          });


          $("#tbodyUsuarios").append(tr);

        });


      $('.starrr').starrr({
         rating: 3,
          change: function(e, value){
            
          //console.log($(this).data("id_sugg"));
          //alert($(this).data("id_sugg"));
          changePriority($(this).data("id_sugg"), value);
          //  alert('new rating is ' + e);
          }
      });


      }
    })
    .done(function() {

      //$('.starrr').starrr();
    
      //console.log("success");
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
      if (jqXHR.status === 0) {
        alertify.error('No Conectado: Verifique su conexión a Internet.');
        $('#botonhorario').html('Guardar').attr('disabled', false);
      }else if (jqXHR.status == 404) {
        alertify.error('Error [404]: Página no encontrada.');
      }else if (jqXHR.status == 500) {
        alertify.error('Error [500]: Error Servidor Interno.');
      }else if (textStatus === 'timeout') {
        alertify.error('Error de tiempo de espera... :(');
      }
    })
    .always(function() {
      //console.log("complete");
    });
    
  }



  function changePriority(id, priority){
    $.ajax({
      url: 'sugerencias/update/priority',
      type: 'POST',
      data: {id:id, priority:priority},
      beforeSend: function(data){
       // $('#'+identificador+'').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading').attr('disabled', true);
      },
      success: function(data){
        alertify.success("Calificado con "+priority+" puntos.");
        listSugerencias();
      }
    })
    .done(function() {
      //console.log("success");
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
      if (jqXHR.status === 0) {
        alertify.error('No Conectado: Verifique su conexión a Internet.');
      }else if (jqXHR.status == 404) {
        alertify.error('Error [404]: Página no encontrada.');
      }else if (jqXHR.status == 500) {
        alertify.error('Error [500]: Error Servidor Interno.');
      }else if (textStatus === 'timeout') {
        alertify.error('Error de tiempo de espera... :(');
      }
    })
    .always(function() {
      //console.log("complete");
    });
  }
















</script>