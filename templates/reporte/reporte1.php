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
    <h3 class="card-header text-center bg-primary" style="color: #fff; font-weight: bold; font-family: 'arial narrow';">Asistencia Diaria<span class="fas fa-chart-bar pull-right"></span></h3>
    <div class="tab-content1" id="myTabContent">
      <div class="card">
        <div class="card-block p-3">
          <div class="card-body table-responsive p-0">
            <form class="form-horizontal needs-validation" name="form_reporte" id="form_reporte" novalidate>
              <table class="table table-bordered table-condensed" id="tableReporte1">
                <thead class="theadReporte1">
                  <tr>
                    <th scope="col" class="text-center">Fecha</th>
                    <th scope="col" class="text-center">Tipo Menú</th>                  
                    <th scope="col" class="text-center">Escuela</th>
                    <th scope="col" class="text-center">Busqueda</th>
                    <th scope="col" class="text-center">Opciones</th>
                  </tr>
                </thead>
                <tbody class="tbodyReporte1">
                  <tr>
                    <td>
                      <div class="input-group input-group-sm">
                        <input class="form-control" type="date" name="fecha" id="fecha" required="" onblur="revisar(this)" onkeyup="revisar(this)" required>
                        <div class="invalid-feedback">
                          Seleccionar una Fecha
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="input-group input-group-sm">                
                        <select class="form-control" value="" id="select_type_menu" name="select_type_menu" onblur="revisar(this)" onchange="revisar(this)">
                          <option selected disabled="true" value="">-- Seleccione Menú --</option>
                          <option value="1">Desayuno</option>
                          <option value="2">Almuerzo</option>
                          <option value="3">Cena</option>
                        </select>
                        <div class="invalid-feedback">
                          Seleccione Tipo de Menú
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="input-group input-group-sm">                  
                        <select class="form-control" id="select_escuela" name="select_escuela" onblur="revisar1(this)" onchange="revisar1(this)">
                        </select>
                      </div>
                    </td>
                    <td>
                      <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="search" name="search" placeholder="Apellidos y Nombres/Cód. de Matrícula" onkeyup="listarReservasUsuarios(this.value);" onblur="revisar(this)" onkeyup="revisar(this)">
                      </div>
                    </td>
                    <td>
                      <!--<?php #if ($_SESSION["role"] == "SP") { ?>
                      <div class="input-group">
                        <button type="submit" class="btn btn-info btn-sm" id="botonReporte" name="botonReporte"><i class="fas fa-search"></i> Buscar</button>
                        <a type="button" href="Reports/RBachiller.php" target="_blank">Descargar</a>
                      </div>
                      <?php #}?>-->
                    </td>
                  </tr>
                </tbody>
              </table>
            </form>
          </div>
          <!--<div>
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
                    <option selected value="0">Todos</option>
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
          </div>-->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover table-bordered table-condensed" id="tableReporte11" style="min-width: 700px; overflow-y: auto">
              <thead class="theadReporte11">
                <tr>
                  <th scope="col" class="text-center">Cód. Matrícula</th>
                  <th scope="col" class="text-center">Apellidos y Nombres</th>
                  <th scope="col" class="text-center">Fecha Reserva</th>
                  <th scope="col" class="text-center">Fecha Asistencia</th>
                  <th scope="col" class="text-center">Asistencia</th>
                </tr>
              </thead>

              <tbody id="tbodyReporte">
              </tbody>
            </table>
            <div id="mostrar_loadingH" style="display: none;">
              <?php include "../templates/layouts/loading.html";?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include "../templates/layouts/scriptFinal.php";?>
  <script src="js/reporte/reporte.js"></script>
</body>
</html>
<script>

  $(document).ready(function(){
    listSchool();

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

    var fecha = moment().format('HH:mm:ss');
    console.log(fecha);

    if (fecha<"12:00:00") {
      document.getElementById("select_type_menu").options[1].selected = 'selected';
    }else if(fecha>="12:00:00" & fecha<"18:00:00"){
      document.getElementById("select_type_menu").options[2].selected = 'selected';
    }else if(fecha>="18:00:00"){
      document.getElementById("select_type_menu").options[3].selected = 'selected';
    }

    document.getElementById('fecha').valueAsDate = new Date();

    $("#form_reporte").submit(function(e){
      validarReporte1(e);
      e.preventDefault();

      var valid=true;
      $("#form_reporte .is-invalid").each(function(){
        alert("holaa");
        valid=false;
      });

      if (valid) {
        listarReservasUsuarios();
      }
    });

    $("#fecha").change(function(event) {
      listarReservasUsuarios();
    });

    $("#select_escuela").change(function(event) {
      listarReservasUsuarios();
    });

    $("#select_type_menu").change(function(event) {
      listarReservasUsuarios();
    });
  });

  function listarReservasUsuarios(search){
    var data= $("#form_reporte").serialize();
    $.ajax({
      url: 'reporte/reservaciones/fecha/',
      type: 'POST',
      data: data,
      beforeSend: function(){
        //$('#botonReporte').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading').attr('disabled', true);
        document.getElementById('mostrar_loadingH').style.display = 'block';
        document.getElementById('tbodyReporte').style.display = 'none';
      },      
      success: function(resp){
        document.getElementById('mostrar_loadingH').style.display = 'none';
        document.getElementById('tbodyReporte').style.display = '';
        var cont=0;
        solvet = JSON.parse(resp);
        $("#tbodyReporte").html("");
        $.each(solvet, function(key, value) {
            var tr = $("<tr />");
            cont++;
            $.each(value, function(k, v) {
              if(v=='Asistió' && k=='asistio'){
                v="<a title='Asistió' style='margin-right:5px; color:white; text-align:center; width: 100px;' class='modify btn btn-success btn-sm'><i style='color:#fff' <i class='fas fa-check-circle'></i> "+v+"</a>";
              }else if(v=='Faltó' && k=='asistio'){
                v="<a title='No Asistio' style='margin-right:5px; color:white; text-align:center; width: 100px;' class='modify btn btn-danger btn-sm'><i style='color:#fff' <i class='fas fa-times-circle'></i> "+v+"</a>";
              }else if(v=='Pendiente' && k=='asistio'){
                v="<a title='Pendiente de Atención' style='margin-right:5px; color:white; text-align:center; width: 100px;' class='modify btn btn-warning btn-sm'><i style='color:#fff' <i class='fas fa-times-circle'></i> "+v+"</a>";
              }else if(v=='Canceló' && k=='asistio'){
                v="<a title='Ha Cancelado' style='margin-right:5px; color:white; text-align:center; width: 100px;' class='modify btn btn-secondary btn-sm'><i style='color:#fff' <i class='fas fa-times-circle'></i> "+v+"</a>";
              }else if(v=='No Coberturado' && k=='asistio'){
                v="<a title='No Coberturado' style='margin-right:5px; color:white; text-align:center; width: 120px;' class='modify btn btn-danger btn-sm'><i style='color:#fff' <i class='fas fa-times-circle'></i> "+v+"</a>";
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
          $("#tbodyReporte").html("<tr><td colspan='5'><h5 class=\"alert alert-danger\" style='margin-bottom:4px;'>NO HA ENCONTRADO COINCIDENCIAS</h5></td></tr>");
        }
      }
    })
    .done(function() {
      //cleanFormulario();
      //$('#botonReporte').html('<i class="fas fa-search"></i> Buscar').attr('disabled', false);
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

  function listSchool(){
    $.ajax({
      url: 'obtener/lista/escuelas/',
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
        listarReservasUsuarios();
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

  function cleanFormulario() {
    $("#form_reporte .is-valid").each(function(){
      $(this).attr('class', 'form-control');
    });

    $("#formHorario .is-invalid").each(function(){
      $(this).attr('class', 'form-control');
    });
  } 
</script>