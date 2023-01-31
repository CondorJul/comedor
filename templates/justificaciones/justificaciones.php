<?php 
  if(!isset($_SESSION["logged_is_user"])){
    header("Location: http://comedor.undac.edu.pe/");
    exit();
  }elseif($_SESSION["role"] !== "SP" AND $_SESSION["role"] !== "AL" AND $_SESSION["users"] = "1394403041"){
    if(isset($_SERVER['HTTP_REFERER'])){
      header("Location:".$_SERVER['HTTP_REFERER']);    
    }else{
      header("Location: http://comedor.undac.edu.pe/");
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
              <form class="form-horizontal needs-validation" name="form_justificacion" id="form_justificacion" novalidate>
                <div class="form-group input-group-sm col-lg-12 col-12 pl-0 pr-0">
                  <label for="select_period"><strong>Seleccione Periodo: </strong></label>
                  <select class="form-control" value="" id="select_period" name="select_period">    

                  </select>
                </div>
                <hr>
                <div class="form-group input-group-sm col-lg-12 col-12 pl-0 pr-0">
                  <label for="select_type_menu"><strong>Seleccione Tipo de Menú: </strong></label>
                  <select class="form-control" id="select_type_menu" name="select_type_menu">     
                    <option value="" selected>Todos</option>
                    <option value="1">Desayuno</option>
                    <option value="2">Almuerzo</option>
                    <option value="3">Cena</option>
                  </select>
                </div>
                <hr>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio1" name="justUsers" class="custom-control-input justificacion" checked="" value="">
                  <label class="custom-control-label" for="customRadio1"> Todos.</label><span class="badge badge-secondary" id="tj" style="float: right; margin-top: 2px;">0</span>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio2" name="justUsers" class="custom-control-input justificacion" value="JA">
                  <label class="custom-control-label" for="customRadio2"> Justificaciones Aceptadas.</label><span class="badge badge-success" id="ja" style="float: right; margin-top: 2px;">0</span>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio3" name="justUsers" class="custom-control-input justificacion" value="JP">
                  <label class="custom-control-label" for="customRadio3"> Justificaciones Pendientes.</label><span class="badge badge-warning" id="jp" style="float: right; margin-top: 2px;">0</span>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio4" name="justUsers" class="custom-control-input justificacion" value="JD">
                  <label class="custom-control-label" for="customRadio4"> Justificaciones Denegadas.</label><span class="badge badge-danger" id="jd" style="float: right; margin-top: 2px;">0</span>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio5" name="justUsers" class="custom-control-input justificacion" value="JO">
                  <label class="custom-control-label" for="customRadio5"> Justificaciones Observadas.</label><span class="badge badge-info" id="jo" style="float: right; margin-top: 2px;">0</span>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio6" name="justUsers" class="custom-control-input justificacion" value="NR">
                  <label class="custom-control-label" for="customRadio6"> Justificaciones No Requeridas.</label><span class="badge badge-primary" id="nr" style="float: right; margin-top: 2px;">0</span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="tab-pane" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div class="card">
            <h3 class="card-header text-center bg-primary" style="color: #fff; font-weight: bold; font-family: 'arial narrow';">Lista General de Reservaciones para Justificaciones<span class="fas fa-file-signature pull-right"></span></h3>
            <div class="card-block p-3">
              <div class="card">
                <div class="row container">
                  <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                    <div><strong>&nbspLeyenda</strong></div>
                  </div>
                  <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                    &nbspAceptada<span class="badge badge-success"><strong>A</strong></span>
                  </div>
                  <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                    &nbspPendiente<span class="badge badge-warning"><strong>P</strong></span>
                  </div>
                  <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                    &nbspDenegada<span class="badge badge-danger"><strong>D</strong></span>
                  </div>
                  <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                    &nbspObservado<span class="badge badge-info"><strong>O</strong></span>
                  </div>
                  <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                    &nbspNo Requiere<span class="badge badge-primary"><strong>NR</strong></span>
                  </div>
                </div>
              </div>
              <br>
              <div class="card-body table-responsive p-0" style="height:367px; overflow:auto;">
                <table class="table table-hover table-bordered table-condensed" id="tableJustificaciones">
                  <thead class="theadJustificaciones">
                    <tr>
                      <th scope="col" class="text-center">Fecha</th>
                      <th scope="col" class="text-center">Tipo Menú</th>
                      <th scope="col" class="text-center">Fecha Reserva</th>
                      <th scope="col" class="text-center">Asistencia</th>
                      <th scope="col" class="text-center">Justificación</th>
                      <th scope="col" class="text-center">Opciones</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyJustificaciones">
                  </tbody>
                </table>
                <div id="mostrar_loadingH" style="display: none;">
                  <?php include "../templates/layouts/loading.html";?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </main>

	<?php include "../templates/layouts/scriptFinal.php"; ?>
  <?php include "modal/modalSolicitud.php";?>  
</body>
</html>
<script>
  
  $(function(){
    
    showPeriod();
    cantidadReservacionesJustificadas();
    $(document).on("click",".requestJustify", viewModalRequest);
    /*$(document).on("click",".stateSistema", changeStateSistema);
    $(document).on("click",".passwordReset", viewModal);*/

    $(".justificacion").click(function(event){
      listJustificationsUser();
    });

    $("#select_type_menu").change(function(event) {
      listJustificationsUser();
    });

    $("#select_period").change(function(event) {
      listJustificationsUser();
    });

  });

  function listJustificationsUser(){
    var data= $("#form_justificacion").serialize();
    $.ajax({
      url: 'obtener/lista/reservaciones/',
      type: 'POST',
      data: data,
      beforeSend: function(){
        document.getElementById('mostrar_loadingH').style.display = 'block';
        document.getElementById('tbodyJustificaciones').style.display = 'none';
      },
      success: function(data){
        document.getElementById('mostrar_loadingH').style.display = 'none';
        document.getElementById('tbodyJustificaciones').style.display = '';
        var resul = JSON.parse(data);
        $("#tbodyJustificaciones").html("");
        //console.log(resul);
        var cont=0;
        $.each(resul, function(index, val) {
          var tr = $("<tr />");
          cont++;
          $.each(val, function(k, v) {
            if (k!='id_menu') {
              if (k=='assist') {
                v="<a class='stateAssist btn "+stateButtonAssist(v)+" btn-sm' href='#' data-toggle='tooltip' data-placement='top' title='"+v+"' style='margin-right:5px; color:white; text-align:center; width: 75px;'><i class='"+stateIcon(v)+"'></i> "+v+"</a>";
              }
              if (k=='just_state') {
                v="<span class='badge "+stateButtonJustify(v)+"' style='border-radius: 50%; height: 25px; width: 25px; padding-top: 6px; font-size: 12px;'><strong>"+stateJustify(v)+"</strong></span>";
              }
              tr.append(
                $("<td />",{
                  html: v
                })[0].outerHTML
              );
            }
          });
          tr.append("<td><a class='requestJustify btn btn-info btn-sm' href='#' data-id='"+val.id_menu+"' data-status='"+val.just_state+"' data-toggle='tooltip' data-placement='top' title='Solicitar Justificación'><i class='fas fa-file-signature'></i> </a></td>");
          $("#tbodyJustificaciones").append(tr);
        });
        if (resul.length==0){
          $("#tbodyJustificaciones").html("<tr><td colspan='6'><h5 class=\"alert alert-danger\" style='margin-bottom:4px;'>NO HA ENCONTRADO COINCIDENCIAS</h5></td></tr>");
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

  function showPeriod(){
    $.ajax({
      url: 'http://comedor.undac.edu.pe/reporte/period',
      type: 'POST',
      success: function(resp){
        var solvet = JSON.parse(resp);
        var select_period=$("#select_period");
        select_period.html("'<option value='' selected=''>Todos</option>");
        $.each(solvet, function(key,value){
          select_period.append('<option value="'+value.period+'" >'+value.period+'</option>');
        });
        listJustificationsUser();
      }
    })
    .done(function() {
      //console.log("done");
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

  function cantidadReservacionesJustificadas(){
      $.ajax({
        url: 'http://comedor.undac.edu.pe/cantidad/justificaciones/',
        type: 'POST',
        success: function(data){          
          var json = JSON.parse(data);
          if (json.length!==0) {
            $('#tj').html(json[0].TOTAL);
            $('#ja').html(json[0].JA);
            $('#jp').html(json[0].JP);
            $('#jd').html(json[0].JD);
            $('#jo').html(json[0].JO);
            $('#nr').html(json[0].NR);
          }else{
            $('#tj').html("0");
            $('#ja').html("0");
            $('#jp').html("0");
            $('#jd').html("0");
            $('#jo').html("0");
            $('#nr').html("0");
          }
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

  function viewModalRequest(){
    if ($(this).data("status")=="JP") {
      $("#modalSolicitud").modal('show');
    }
    let uid= decodeURIComponent($(this).data("id"));
    $("#pw").val(window.atob(uid));
    $("#restablecerPw").attr('data-id', $(this).data("id"));
  }

  function generateRequest(){
    //console.log($(this));
  }

  function stateButtonAssist(sba){
    if (sba == "Asistió") {
      return "btn-success";
    }else if(sba == "Faltó"){
      return "btn-danger";
    }else if(sba == "Canceló"){
      return "btn-secondary";
    }else{
      return "btn-info";
    }
  }

  function stateJustify(sj){
    if (sj == "JA") {
      return "A";
    }else if(sj == "JP"){
      return "P";
    }else if(sj == "JD"){
      return "D";
    }else if (sj == "JO"){
      return "O";
    }else{
      return "NR";
    }
  }

  function stateButtonJustify(sbj){
    if (sbj == "JA") {
      return "badge-success";
    }else if(sbj == "JP"){
      return "badge-warning";
    }else if(sbj == "JD"){
      return "badge-danger";
    }else if (sbj == "JO"){
      return "badge-info";
    }else{
      return "badge-primary";
    }
  }

  function stateIcon(si){
    return (si=="Asistió")?"fas fa-check-circle":"fas fa-times-circle";
  }

</script>