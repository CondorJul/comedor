<?php
  if(!isset($_SESSION["logged_is_user"])){
    header("Location: ".SERVER_PHP);
    exit();
  }elseif($_SESSION["role"] !== "AD" AND $_SESSION["role"] !== "SP" and $_SESSION["role"] !== "RE"  and $_SESSION["role"] !== "BU"){
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
    <h3 class="card-header text-center bg-primary" style="color: #fff; font-weight: bold; font-family: 'arial narrow';">Cantidad de Reserva Diaria<span class="fas fa-chart-bar pull-right"></span></h3>
    <div class="tab-content1" id="myTabContent">
      <div class="card">
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
              <?php include "../templates/layouts/loading.html"; ?>
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
    </div>
  </main>

	<?php include "../templates/layouts/scriptFinal.php"; ?>
  <script src="js/reporte/reporte.js"></script>
  <script src=" https://cdn.jsdelivr.net/npm/chart.js@2.8.0-rc.1/dist/Chart.min.js"></script>  
</body>

</html>	
<script>
  $(document).ready( function() {

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
        //console.log(solvet);
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