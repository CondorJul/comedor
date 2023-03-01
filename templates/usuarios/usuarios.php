<?php 
  if(!isset($_SESSION["logged_is_user"])){
    header("Location: ".SERVER_PHP);
    exit();
  }elseif($_SESSION["role"] !== "SP"){
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
      <div class="col-lg-3">
        <div class="tab-pane" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div class="card">
            <h3 class="card-header text-center bg-primary" style="color: #fff; font-weight: bold; font-family: 'arial narrow';">Busqueda<span class="fas fa-search pull-right"></span></h3>
            <div class="card-block p-2">
              <form class="form-horizontal needs-validation" name="form_reporte" id="form_reporte" novalidate>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio1" name="usersSis" class="custom-control-input sistema" checked="" value="">
                  <label class="custom-control-label" for="customRadio1"> Todos los Usuarios del Sistema</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio2" name="usersSis" class="custom-control-input sistema" value="A">
                  <label class="custom-control-label" for="customRadio2"> Usuarios Activos del Sistema.</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio3" name="usersSis" class="custom-control-input sistema" value="B">
                  <label class="custom-control-label" for="customRadio3"> Usuarios Inactivos del Sistema.</label>
                </div>
                <hr>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio4" name="usersCom" class="custom-control-input comedor" checked="" value="">
                  <label class="custom-control-label" for="customRadio4"> Todos los Usuarios del Comedor.</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio5" name="usersCom" class="custom-control-input comedor" value="A">
                  <label class="custom-control-label" for="customRadio5"> Usuarios Habilitados para el Comedor.</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio6" name="usersCom" class="custom-control-input comedor" value="B">
                  <label class="custom-control-label" for="customRadio6"> Usuarios Inhabilitados para el Comedor.</label>
                </div>
                <hr>
                <div class="input-group input-group-sm col-lg-12 col-12 pl-0 pr-0">
                  <select class="form-control" value="" id="select_escuela" name="select_escuela">     
            
                  </select>
                </div>
                <hr>
                <div class="input-group input-group-sm col-lg-12 col-12 pl-0 pr-0">
                  <input type="text" class="form-control" id="search" name="search" placeholder="Apellidos y Nombres/Cód. de Matrícula" onkeyup='listUsers(this.value);'>
                  <div class="input-group-append" style="height: 30px;">
                    <button type="button" class="btn btn-info" id="botonBuscarUsers" name="botonBuscarUsers"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="tab-pane" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div class="card">
            <h3 class="card-header text-center bg-primary" style="color: #fff; font-weight: bold; font-family: 'arial narrow';">Lista de Usuarios<span class="fas fa-users pull-right"></span></h3>
            <div class="card-block p-3">
              <div class="card-body table-responsive p-0" id="tabla_resultado" style="height:423px; overflow:auto;">
                <table class="table table-hover table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th scope="col" class="text-center">DNI</th>
                      <th scope="col" class="text-center">Código</th>
                      <th scope="col" class="text-center">Apellidos y Nombres</th>
                      <th scope="col" class="text-center">Estado(S)</th>
                      <th scope="col" class="text-center">Estado(C)</th>
                      <th scope="col" class="text-center">Opciones</th>
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
                <input type="password" class="form-control" id="pw" name="pw" placeholder="Nueva Contraseña">
                <div class="input-group-append">
                  <button type="button" class="btn btn-secondary" id="verPw" name="verPw" data-status="true"><i class="fas fa-eye"></i></button>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-success btn-sm" id="restablecerPw" name="restablecerPw">Restablecer</button>
          </div>
        </div>
      </div>
    </div>
  </main>

	<?php include "../templates/layouts/scriptFinal.php"; ?>
  <script src="js/horario/horario.js"></script>
  
</body>
</html>
<script>
  
  $(function(){
    listSchool();
    $(document).on("click",".stateComedor", changeStateComedor);
    $(document).on("click",".stateSistema", changeStateSistema);
    $(document).on("click",".passwordReset", viewModal);

    $("#restablecerPw").click(function(event) {
      resetPassword($(this).data("id"));
    });

    $("#verPw").click(function(event) {
      var tipo = document.getElementById("pw");
      if (tipo.type=="password") {
        tipo.type="text";
        $(".icon").removeClass('fa fa-eye').addClass('fa fa-eye-slash');
      }else {
        tipo.type="password";
        $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
      }
    });

    $(".sistema").click(function(event){
      listUsers();
    });

    $(".comedor").click(function(event){
      listUsers();
    });

    $("#select_escuela").change(function(event) {
      listUsers();
    });

  });

  function listUsers(){
    var data= $("#form_reporte").serialize();
    //console.log(data);
    $.ajax({
      url: 'obtener/lista/usuarios/',
      type: 'POST',
      data: data,
      beforeSend: function(){
        document.getElementById('mostrar_loadingH').style.display = 'block';
        document.getElementById('tbodyUsuarios').style.display = 'none';
      },
      success: function(data){
        document.getElementById('mostrar_loadingH').style.display = 'none';
        document.getElementById('tbodyUsuarios').style.display = '';
        var resul = JSON.parse(data);
        $("#tbodyUsuarios").html("");
        $("#mensajeErrorUser").html("");
        //console.log(resul);
        var cont=0;
        $.each(resul, function(index, val) {
          var tr = $("<tr />");
          cont++;
          $.each(val, function(k, v) {
            if (k=='state') {
              v="<a class='stateSistema btn "+stateButton(v)+" btn-sm' id='sistema"+cont+"' href='#' data-id='"+encodeURIComponent(window.btoa(val.uid))+"' data-status='"+encodeURIComponent(window.btoa(val.state))+"' data-toggle='tooltip' data-placement='top' title='"+stateTitleS(v)+"' style='margin-right:5px; color:white; text-align:center; width: 75px;'><i class='fas fa-power-off'></i> "+stateTitleS(v)+"</a>";
            }
            if (k=='state_c') {
              v="<a class='stateComedor btn "+stateButton(v)+" btn-sm' id='comedor"+cont+"' href='#' data-id='"+encodeURIComponent(window.btoa(val.uid))+"' data-status='"+encodeURIComponent(window.btoa(val.state_c))+"' data-toggle='tooltip' data-placement='top' title='"+stateTitleC(v)+"' style='margin-right:5px; color:white; text-align:center; width: 100px;'><i class='fas "+stateIcon(v)+"'></i> "+stateTitleC(v)+"</a>";
            }
            tr.append(
              $("<td />",{
                html: v
              })[0].outerHTML
            );
          });
          tr.append("<td><a class='passwordReset btn btn-info btn-sm' href='#' data-id='"+encodeURIComponent(window.btoa(val.uid))+"' data-toggle='tooltip' data-placement='top' title='Restablecer Contraseña'><i class='fas fa-key'></i> </a></td>");
          $("#tbodyUsuarios").append(tr);
        });
        if (resul.length==0){
          $("#mensajeErrorUser").html("<h5 class=\"alert alert-danger\">NO HA ENCONTRADO COINCIDENCIAS</h5>");
        }
      }
    })
    .done(function() {
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

  function changeStateComedor(){
    let identificador=$(this)[0].id;
    let data={id: $(this).data("id"), state: $(this).data("status")};
    $.ajax({
      url: 'usuario/cambiar/estadoComedor/',
      type: 'POST',
      data: data,
      beforeSend: function(data){
        $('#'+identificador+'').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading').attr('disabled', true);
      },
      success: function(data){
        alertify.success(data);
        listUsers();
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

  function changeStateSistema(){
    let identificador=$(this)[0].id;
    let data={id: $(this).data("id"), state: $(this).data("status")};
    $.ajax({
      url: 'usuario/cambiar/estadoSistema/',
      type: 'POST',
      data: data,
      beforeSend: function(data){
        $('#'+identificador+'').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading').attr('disabled', true);
      },
      success: function(data){
        alertify.success(data);
        listUsers();
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

  function viewModal(){
    $("#passwordReset").modal('show');
    let uid= decodeURIComponent($(this).data("id"));
    $("#pw").val(window.atob(uid));
    $("#restablecerPw").attr('data-id', $(this).data("id"));
  }

  function resetPassword(uid){
    $.ajax({
      url: 'usuario/restablecer/contrasena/',
      type: 'POST',
      data: {id: uid, newPassword: $("#pw").val()},
      beforeSend: function(data){
        $('#restablecerPw').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading').attr('disabled', true);
      },
      success: function(data){
        alertify.success(data);
        $("#passwordReset").modal('hide');
      }
    })
    .done(function() {
      $('#restablecerPw').html('Restablecer').attr('disabled', false);
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

  function listSchool(){
    $.ajax({
      url: 'obtener/lista/escuelas/',
      beforeSend: function(){

      },
      success: function(data){
        var resul = JSON.parse(data);
        $("#select_escuela").html("");
        //console.log(resul);
        $("#select_escuela").append("<option value='' selected=''>Todos</option>");
        $.each(resul, function(index, val) {
          var tr = $("<option value='"+val.codigo+"' />");
          tr.append(""+val.name+"");
          $("#select_escuela").append(tr);
        });
        listUsers();
      }
    })
    .done(function() {
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

  function stateButton(sb){
    return (sb=="A")?"btn-success":"btn-danger";
  }

  function stateTitleS(sts){
    return (sts=="A")?"Activo":"Inactivo";
  }

  function stateTitleC(stc){
    return (stc=="A")?"Habilitado":"Inhabilitado";
  }

  function stateIcon(si){
    return (si=="A")?"fa-sign-in-alt":"fa-sign-out-alt";
  }

</script>