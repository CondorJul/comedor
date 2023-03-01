<?php
if (!isset($_SESSION["logged_is_user"])) {
    header("Location: ".SERVER_PHP);
    exit();
} elseif ($_SESSION["role"] !== "AD" and $_SESSION["role"] !== "SP" and $_SESSION["role"] !== "RE"  and $_SESSION["role"] !== "BU") {
    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location:" . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: ".SERVER_PHP);
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
    <div class="container">
      <div class="col-md-12">
        <div class="card">
          <h3 class="card-header text-center bg-primary" style="color: #fff; font-weight: bold; font-family: 'arial narrow';">LISTA DE ASISTENCIAS POR INTERVALO DE FECHAS<span class="fas fa-chart-bar pull-right"></span></h3>
          <div class="card-block p-3">
            <div>
              <form class="form-horizontal needs-validation" name="form_reporte3" id="form_reporte3" novalidate>
                <div class="row">
                 

                   <div class="input-group input-group-sm mb-3 col-lg-3 col-12">
                    <div class="input-group-prepend" style="height: 30px; width: 95px;">
                      <span class="input-group-text"><b>F. Inicio : </b></span>
                    </div>
                    <input class="form-control" type="date" name="date_start" id="date_start" required=""  required>
                

                  </div>

                   <div class="input-group input-group-sm mb-3 col-lg-3 col-12">
                    <div class="input-group-prepend" style="height: 30px; width: 95px;">
                      <span class="input-group-text"><b>F. Fin : </b></span>
                    </div>
                    <input class="form-control" type="date" name="date_end" id="date_end" required=""  required>
                

                  </div>


                  <div class="input-group input-group-sm mb-4 col-lg-3 col-12">
                    <div class="input-group-prepend" style="height: 30px;">
                      <span class="input-group-text"><b>Tipo de Menu : </b></span>
                    </div>
                    <select class="form-control" value="" id="select_type_menu" name="select_type_menu"  >
                      <!--<option selected disabled="true" value="">-- Seleccione Menú --</option> -->
                      <option value="" selected>Todos</option>
                      <option value="1">Desayuno</option>
                      <option value="2">Almuerzo</option>
                      <option value="3">Cena</option>
                    </select>
                  </div>


                  <div class="input-group input-group-sm mb-4 col-lg-3 col-12">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Cód. de Matrícula" >
                    <div class="input-group-append" style="height: 30px;">
                      <button type="submit" class="btn btn-info" id="botonReporte" name="botonReporte"><i class="fas fa-search"></i>Buscar</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="card-body table-responsive p-0" id="tabla_resultado">
              <table class="table table-hover table-bordered table-condensed"  style="min-width: 630px;">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Cód. Matrícula</th>
                    <th scope="col">Apellidos y Nombres</th>
                    <th scope="col">Asistencias</th>
                    <th scope="col">Faltas</th>
                    <th scope="col">Canceladas</th>
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
              <p><strong>(*)</strong>No incluye los menús programados pendientes de atención.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include "../templates/layouts/scriptFinal.php";?>
  

</body>
</html>
<script>

  $(document).ready(function(){
           listarReservasUsuariosF();

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


    $("#form_reporte3").submit(function(e){
      e.preventDefault();

       listarReservasUsuariosF();

    });

    /*call function*/
     



  })

//eventos 


 


  //metodos y funciones
  


  function listarReservasUsuariosF(search){
    var data= $("#form_reporte3").serialize();
    $.ajax({
      url: 'reporte/get_more_asssist_by_interval_date',
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

              tr.append(
                $("<td />",{
                  html: cont
                })[0].outerHTML
              );
            $.each(value, function(k, v) {
         
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


</script>