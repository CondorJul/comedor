<?php
if (!isset($_SESSION["logged_is_user"])) {
    header("Location: http://comedor.undac.edu.pe/");
    exit();
} elseif ($_SESSION["role"] !== "AD" and $_SESSION["role"] !== "SP") {
    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location:" . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: http://comedor.undac.edu.pe/");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
  <?php include "../templates/layouts/head1.php";?>
<body class="app sidebar-mini rtl sidenav-toggled" style="min-width: 280px;">
  <?php include "../templates/layouts/header.php";?>
  <?php include "../templates/layouts/menu.php";?>

  <main class="app-content" style="background: white;">
    <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Asistencia Diaria</a>
      </li>
      <li class="nav-item margin">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"># Reservación Diaria</a>
      </li>
      <!--<li class="nav-item margin">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Gráfica</a>
      </li>-->
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="card">
          <br>
          <div class="card-block p-3">
            <div>
              <form class="form-horizontal needs-validation" name="form_reporte" id="form_reporte" novalidate>
                <div class="row">
                  <div class="input-group input-group-sm mb-3 col-lg-3 col-12">
                    <div class="input-group-prepend" style="height: 30px; width: 95px;">
                      <span class="input-group-text"><b>Periodo : </b></span>
                    </div>
                    <select class="form-control" value="" id="select_periodo" name="select_periodo" onblur="revisar(this)" onchange="revisar(this)" >
                      <option value="19A">19A</option>
                      <option selected="" value="19B">19B</option>
                    </select>
                    <div class="invalid-feedback">
                      Seleccione un Periodo
                    </div>
                  </div>

                  <div class="input-group input-group-sm mb-3 col-lg-3 col-12">
                    <div class="input-group-prepend" style="height: 30px; width: 95px;">
                      <span class="input-group-text"><b>Tipo de Menu : </b></span>
                    </div>
                    <select class="form-control" value="" id="select_type_menu" name="select_type_menu" onblur="revisar(this)" onchange="revisar(this)" >
                      <option selected disabled="true" value="">-- Seleccione Menú --</option>
                      <option value="1">Desayuno</option>
                      <option value="2">Almuerzo</option>
                      <option value="3">Cena</option>
                    </select>
                    <div class="invalid-feedback">
                      Selecciona Tipo de Menu
                    </div>
                  </div>

                  <div class="input-group input-group-sm mb-3 col-lg-3 col-12">
                    <div class="input-group-prepend" style="height: 30px; width: 95px;">
                      <span class="input-group-text"><b>Fecha : </b></span>
                    </div>
                    <input class="form-control" type="date" name="fecha" id="fecha" required="" onblur="revisar(this)" onkeyup="revisar(this)" required>
                    <div class="invalid-feedback">
                      Seleccionar una Fecha
                    </div>
                  </div>

                  <div class="input-group input-group-sm mb-3 col-lg-3 col-12">
                    <div class="input-group-prepend" style="height: 30px; width: 65px;">
                      <span class="input-group-text"><b>Escuela : </b></span>
                    </div>
                    <select class="form-control" value="" id="select_escuela" name="select_escuela" onblur="revisar(this)" onchange="revisar(this)" >
                      <option selected value="">Todos</option>
                      <option value="9CE">Administración</option>
                      <option value="5AG">Agronomía</option>
                      <option value="2ESBQ">Biologia y Química</option>
                      <option value="10CC">Ciencias de la Comunicación</option>
                      <option value="2ESSP">Ciencias Sociales Filosofía y Psicología Educ</option>
                      <option value="2ESCL">Comunicación y Literatura</option>
                      <option value="1CO">Contabilidad</option>
                      <option value="2DE">Derecho</option>
                      <option value="7DE">Derecho y Ciencias</option>
                      <option value="1EC">Economía</option>
                      <option value="2EI">Educación Inicial</option>
                      <option value="2EP">Educación Primaria</option>
                      <option value="2OPC">Educación Primaria Computación e Infomática</option>
                      <option value="2ES">Educación Secundaria</option>
                      <option value="3EN">Enfermería</option>
                      <option value="2ESHT">Historia, Ciencias Sociales y Turismo</option>
                      <option value="4AM">Ingeniería Ambiental</option>
                      <option value="4CI">Ingeniería Civil</option>
                      <option value="4GE">Ingenieria Geologica</option>
                      <option value="4ME">Ingenieria Metalurgica</option>
                      <option value="6MI">Ingeniería Minas</option>
                      <option value="4SI">Ingeniería Sistemas y Computación</option>
                      <option value="2ESLF">Lenguas Extranjeras: Inglés - Francés</option>
                      <option value="2ESFM">Matemática y Física</option>
                      <option value="0ME">Medicina Humana</option>
                      <option value="3OB">Obstetricia</option>
                      <option value="8OD">Odontología</option>
                      <option value="2ESTT">Tecnología Informática y Telecomunicaciones</option>
                      <option value="5ZO">Zootecnia</option>
                    </select>
                    <div class="invalid-feedback">
                      Seleccionar una escuela
                    </div>
                  </div>

                  <div class="input-group input-group-sm mb-12 col-lg-12 col-12">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Apellidos y Nombres/Cód. de Matrícula" onkeyup='listarReservasUsuarios(this.value);'>
                    <div class="input-group-append" style="height: 30px;">
                      <button type="submit" class="btn btn-info" id="botonReporte" name="botonReporte"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <br>
            <div class="card-body table-responsive p-0" id="tabla_resultado">
              <table class="table table-hover table-bordered table-condensed"  style="min-width: 630px; overflow-y: auto">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">Cód. Matrícula</th>
                    <th scope="col" class="text-center">Apellidos y Nombres</th>
                    <th scope="col" class="text-center">Fecha Reserva</th>
                    <th scope="col" class="text-center">Asistencia</th>
                  </tr>
                </thead>

                  <tbody id="tbodyReporte">
                  </tbody>
              </table>
              <div class="text-center" id="mensajeError">

              </div>
              <div id="mostrar_loadingH" style="display: none;">
                <?php include "../templates/layouts/loading.html";?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="card">
          <br>
          <div class="card-block p-3">
            <div>
              <form class="form-horizontal needs-validation" name="form_reporte2" id="form_reporte2" novalidate>
                <div class="row justify-content-md-center">
                  <div class="input-group input-group-sm mb-4 col-md-12 col-lg-6 col-12">
                    <div class="input-group-prepend" style="height: 30px;">
                      <span class="input-group-text"><b>Fecha : </b></span>
                    </div>
                    <input style="height: 30px;" class="form-control" type="date" name="fechaCantidadReserva" id="fechaCantidadReserva" required="" onblur="revisar(this)" onkeyup="revisar(this)" required>
                    <div class="input-group-append" style="height: 30px;">
                      <button class="btn btn-info" type="submit" id="botonReporte2" name="botonReporte2"><i class="fas fa-search"></i> Filtrar</button>
                    </div>
                    <div class="invalid-feedback">
                      Debes seleccionar una Fecha
                    </div>

                  </div>
                </div>
              </form>
            </div>
            <div class="card-body table-responsive p-0" id="tabla_resultado">
              <table class="table table-hover table-bordered table-condensed"  style="min-width: 630px;">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">Tipo de Menú</th>
                    <th scope="col" class="text-center">Total</th>
                    <th scope="col" class="text-center">Asistieron</th>
                    <th scope="col" class="text-center">Faltaron</th>
                    <th scope="col" class="text-center">Cancelados</th>
                  </tr>
                </thead>

                  <tbody id="tbodyReporte2">
                  </tbody>
              </table>
              <div class="text-center" id="mensajeError2">

              </div>
              <div id="mostrar_loadingH" style="display: none;">
                <?php include "../templates/layouts/loading.html";?>
              </div>
            </div>
          </div>
        </div>
        <div class="card" id="viewGrafica">
          <div class="card-block p-3">
            <div class="card-body table-responsive p-0" id="tabla_resultado">
              <canvas id="myChart" width="400" height="200"></canvas>

              <div class="text-center" id="mensajeErrorGrafica"></div>

              <div id="mostrar_loadingH" style="display: none;">
                <?php include "../templates/layouts/loading.html";?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include "../templates/layouts/scriptFinal.php";?>
  <script src="js/reporte/reporte.js"></script>
  <script src=" https://cdn.jsdelivr.net/npm/chart.js@2.8.0-rc.1/dist/Chart.min.js"></script>
</body>
</html>
<script>

  $(document).ready(function(){

    var form=null;

    $(".cerrar").click(function(){
      $.ajax({
        url: 'close/login/user/',
        method:'POST',
        success: function(resp) {
          setTimeout(function(){
            location.reload();
          }, 700);

        }
      });
    });

    $("#form_reporte").submit(function(e){
      form=1;
      validar(e, form);
      e.preventDefault();

      var valid=true;
      $("#form_reporte .is-invalid").each(function(){
        valid=false;
      });

      if (valid) {
        listarReservasUsuarios();
        /*loader botton*/
        $('#botonReporte').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading').attr('disabled', true);
        cleanFormulario();
      }
    });

    document.getElementById('fechaCantidadReserva').valueAsDate = new Date();
    listarCantidadReservaciones();
    showGraphic();

    $("#form_reporte2").submit(function(e){
      form=2;
      validar(e, form);
      e.preventDefault();

      var valid=true;
      $("#form_reporte2 .is-invalid").each(function(){
        valid=false;
      });

      if (valid) {
        listarCantidadReservaciones();
        showGraphic();
        $('#botonReporte2').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading').attr('disabled', true);
        cleanFormulario();
      }
    });
  });

  function listarReservasUsuarios(search){
    var data= $("#form_reporte").serialize();
    $.ajax({
      url: 'reporte/reservaciones/fecha/',
      data: data,
      type: 'POST',
      beforeSend: function(){
        document.getElementById('mostrar_loadingH').style.display = 'block';
        document.getElementById('tbodyReporte').style.display = 'none';
      },
      success: function(resp){
        document.getElementById('mostrar_loadingH').style.display = 'none';
        document.getElementById('tbodyReporte').style.display = '';
        var cont=0;
        solvet = JSON.parse(resp);
        $("#mensajeError").html("");
        $("#tbodyReporte").html("");
        $.each(solvet, function(key, value) {
            var tr = $("<tr />");
            cont++;
            $.each(value, function(k, v) {
              if(v=='Asistió' && k=='asistio'){
                v="<a title='Asistió' style='margin-right:5px; color:white; text-align:center; width: 100px;' class='modify btn btn-success btn-sm'><i style='color:#fff' <i class='fas fa-check-circle'></i> "+v+"</a>";
              }else if(v=='No Asistió' && k=='asistio'){
                v="<a title='No Asistio' style='margin-right:5px; color:white; text-align:center; width: 100px;' class='modify btn btn-danger btn-sm'><i style='color:#fff' <i class='fas fa-times-circle'></i> "+v+"</a>";
              }else if(v=='Canceló' && k=='asistio'){
                v="<a title='Ha cancelado' style='margin-right:5px; color:white; text-align:center; width: 100px;' class='modify btn btn-warning btn-sm'><i style='color:#fff' <i class='fas fa-times-circle'></i> "+v+"</a>";
              }
              tr.append(
                $("<td />",{
                  html: v
                })[0].outerHTML
              );
            })
            $("#tbodyReporte").append(tr)
         })

        if (solvet.length==0){
          $("#mensajeError").html("<h5 class=\"alert alert-danger\">NO HA ENCONTRADO COINCIDENCIAS</h5>");
        }
      }
    })
    .done(function() {
      //cleanFormulario();
      $('#botonReporte').html('<i class="fas fa-search"></i>').attr('disabled', false);
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

  function cleanFormulario() {
    $("#form_reporte .is-valid").each(function(){
      $(this).attr('class', 'form-control');
    });

    $("#formHorario .is-invalid").each(function(){
      $(this).attr('class', 'form-control');
    });
  }

  /*reporte 2*/
  function listarCantidadReservaciones(){
    var data= $("#form_reporte2").serialize();
    //console.log(data);
    $.ajax({
      url: 'reporte/cantidad/reservaciones/fecha/',
      data: data,
      type: 'POST',
      beforeSend: function(){
        document.getElementById('mostrar_loadingH').style.display = 'block';
        document.getElementById('tbodyReporte2').style.display = 'none';
      },
      success: function(resp){
        document.getElementById('mostrar_loadingH').style.display = 'none';
        document.getElementById('tbodyReporte2').style.display = '';
        var cont=0;
        solvet = JSON.parse(resp);
        //console.log(solvet);
        $("#mensajeError2").html("");
        $("#tbodyReporte2").html("");
        $.each(solvet, function(key, value) {
            var tr = $("<tr />");
            cont++;
            $.each(value, function(k, v) {
              if(v==1 && k=='type'){
                v='Desayuno';
              }
              if(v==2 && k=='type'){
                v='Almuerzo';
              }
              if(v==3 && k=='type'){
                v='Cena';
              }
              tr.append(
                $("<td />",{
                  html: v
                }).css('text-align', 'center')[0].outerHTML
              );
            })
            $("#tbodyReporte2").append(tr)
         })

        if (solvet.length==0){
          $("#mensajeError2").html("<h5 class=\"alert alert-danger\">NO HA ENCONTRADO COINCIDENCIAS</h5>");
        }
      }
    })
    .done(function() {
      //cleanFormulario();
      $('#botonReporte2').html('<i class="fas fa-search"></i> Filtrar').attr('disabled', false);
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

  function cleanFormulario() {
    $("#form_reporte2 .is-valid").each(function(){
      $(this).attr('class', 'form-control');
    });

    $("#formHorario .is-invalid").each(function(){
      $(this).attr('class', 'form-control');
    });
  }

  /*Grafica*/
  function showGraphic(){
    var data= $("#form_reporte2").serialize();
    $.ajax({
      url: 'reporte/cantidad/reservaciones/fecha/',
      data: data,
      type: 'POST',
      beforeSend: function(){
        document.getElementById('mostrar_loadingH').style.display = 'block';
        document.getElementById('tbodyReporte2').style.display = 'none';
      },
      success: function(resp){
        document.getElementById('mostrar_loadingH').style.display = 'none';
        document.getElementById('tbodyReporte2').style.display = '';

        solvet = JSON.parse(resp);
        console.log(solvet);
        var data_json_asistencia=new Array();
        var data_json_faltas=new Array();
        var data_json_cancelados=new Array();
        var labels_json=new Array();
        for(var i=0;i<solvet.length;i++){
            data_json_asistencia.push(solvet[i].asistieron);
            data_json_faltas.push(solvet[i].faltaron);
            data_json_cancelados.push(solvet[i].cancelaron);
            if(solvet[i].type===1){
              labels_json.push("Desayuno ("+solvet[i].total+")");
            }else if(solvet[i].type===2){
              labels_json.push("Almuerzo ("+solvet[i].total+")");
            }else if(solvet[i].type===3){
              labels_json.push("Cena ("+solvet[i].total+")");
            } else{
              labels_json.push("Cancelados");
            }
        }
        //var ctx = document.getElementById('myChart').html("");
        var ctx = document.getElementById('myChart').getContext('2d');
        //ctx.html("");
        
        var dataAsistencias = {
          label: "# de Asistencias",
          data: data_json_asistencia,
          backgroundColor: [
                  'rgba(54, 214, 91, 0.8)',
                  'rgba(54, 214, 91, 0.8)',
                  'rgba(54, 214, 91, 0.8)'
          ],
          borderColor: [
                  'rgba(54, 214, 91, 1)',
                  'rgba(54, 214, 91, 1)',
                  'rgba(54, 214, 91, 1)'
          ],
          borderWidth: 1
        };
           
        var dataFaltas = {
          label: "# de faltas",
          data: data_json_faltas,
          backgroundColor: [              
                  'rgba(245, 61, 79, 0.8)',
                  'rgba(245, 61, 79, 0.8)',
                  'rgba(245, 61, 79 , 0.8)'
          ],
          borderColor: [
                  'rgba(245, 61, 79, 1)',
                  'rgba(245, 61, 79, 1)',
                  'rgba(245, 61, 79, 1)'
           ],
          borderWidth: 1
        };

        var dataCancelados = {
          label: "# de Cancelados",
          data: data_json_cancelados,
          backgroundColor: [
                  'rgba(255, 193, 7, 0.8)',
                  'rgba(255, 193, 7, 0.8)',
                  'rgba(255, 193, 7, 0.8)'
          ],
          borderColor: [
                  'rgba(255, 193, 7, 1)',
                  'rgba(255, 193, 7, 1)',
                  'rgba(255, 193, 7, 1)'
           ],
          borderWidth: 1
        };
           
        var dataMenu = {
          labels: labels_json,
          datasets: [dataAsistencias, dataFaltas, dataCancelados]
        };
        
        var myChart = new Chart(ctx, {
          type: 'bar',
          data: dataMenu
        });
      }
    })
    .done(function() {
      //cleanFormulario();
      $('#botonReporte2').html('<i class="fas fa-search"></i> Filtrar').attr('disabled', false);
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

</script>