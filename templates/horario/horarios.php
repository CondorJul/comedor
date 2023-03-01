<?php 
  if(!isset($_SESSION["logged_is_user"])){
    header("Location: ".SERVER_PHP);
    exit();
  }elseif($_SESSION["role"] !== "AD" AND $_SESSION["role"] !== "SP"){
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
    <div class="container">
      <div class="row">        
          <div class="col-md-4">
            
             <div class="card">
              <h4 class="card-header text-center card-primary">Ingrese Nuevo Horario<span class=" fas fa-clock pull-right"></span></h4>
              <div class="card-block p-3">
                <form lass="form-horizontal needs-validation" id="formHorario" name="formHorario" novalidate>
                    

                    <div class="input-group input-group-sm mb-2">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><b>Tipo : </b></span>
                      </div>
                      <select class="form-control md-form" onblur="revisar(this)" onchange="revisar(this)" name="tipo" id="tipo" required>
                        <option value="" disabled selected>-- Seleccione --</option>
                        <option value="1">Desayuno</option>
                        <option value="2">Almuerzo</option>
                        <option value="3">Cena</option>
                      </select>

                      <div class="invalid-feedback">
                        Debes seleccionar el campo Tipo
                      </div>
                    </div>
                  
                    <div class="input-group input-group-sm mb-2">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><b> Horario Inicio: </b></span>
                      </div>
                      <input class="form-control" type="time" name="horainicio" id="horainicio" required="" placeholder="Ingrese horario de Inicio" onblur="revisar(this)" onkeyup="revisar(this)" required>
                      <div class="invalid-feedback">
                        El campo Horario Inicio no debe ir vacío
                      </div>
                    </div>
                  
                    <div class="input-group input-group-sm mb-2">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><b> Horario Fin: </b></span>
                      </div>
                      <input class="form-control" type="time" name="horafin" id="horafin" required="" placeholder="Ingrese horario de Fin" onblur="revisar(this)" onkeyup="revisar(this)" required>
                      <div class="invalid-feedback" id="horafinHorarios">
                        El campo Horario Fin no debe ir vacío
                      </div>
                    </div>

                    <div class="input-group input-group-sm mb-2">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><b> Cantidad: </b></span>
                      </div>
                      <input class="form-control" type="number" name="cantidad" id="cantidad" placeholder="Ingrese cantidad de platos del horario" onblur="revisar(this); validarcantidad(this, 3)" onkeyup="revisar(this); validarcantidad(this, 3)"  required/>
                      <div class="invalid-feedback" id="cantidadHorario">
                        El campo Cantidad no debe estar Vacio
                      </div> 
                    </div>


                    <div class="col-md-4 pull-right p-1">
                      <button type="submit" class="btn btn-success btn-block" id="botonhorario" name="botonhorario"  data-pid="0" onclick="cleanFormulario();">Guardar</button>
                    </div>

                  </form>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card">
              <h3 class="card-header text-center card-primary">Lista de Horarios<span class="fas fa-list-ol pull-right"></span></h3>
              <div class="card-block p-3">
                <input type="text" name="search" id="search" class="form-control" placeholder="Buscar Horario" onkeyup='loadTable(this.value);'/>
                <div class="card-body table-responsive p-0" id="tabla_resultado">
                  <table class="table table-hover table-bordered table-condensed"  style="min-width: 630px;">
                    
                    <thead>
                      <tr>
                        <th scope="col">COD</th>
                        <th scope="col">TIPO DE HOR.</th>
                        <th scope="col">HORA INICIO</th>
                        <th scope="col">HORA FIN</th>
                        <th scope="col">CANTIDAD</th>
                        <th scope="col">ACCIONES</th>
                      </tr>
                    </thead>
                    
                      <tbody id="tbodyHorario">
                        
                        
                      </tbody>
               
                  </table>
                  <div class="text-center" id="mensajeError">
                      
                  </div>
                  <div id="mostrar_loadingH" style="display: none;">
                    <?php include "../templates/layouts/loading.html"; ?>
                  </div> 

                </div>
                           
              </div>
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

  $(document).ready(function(){
    var obj;
    loadTable($("#search").val());
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
  });
      
  $("#formHorario").submit(function(e){
    validar(e);
    e.preventDefault();

    var valid=true;
    $("#formHorario .is-invalid").each(function(){
      valid=false;
    });

    if (valid) {
      var pid = $('#botonhorario').attr('data-pid');
      if (pid == 0) {
        addHorario();
        $('#botonhorario').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading').attr('disabled', true);
        cleanFormulario();
      }else{
        updateHorario();
        $('#botonhorario').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading').attr('disabled', true);
        cleanFormulario();
      }
    }  
  });

  function addHorario(){  
    var data= $("#formHorario").serialize();
    $.ajax({

      url:'create/horario/',
      type: 'POST',
      data: data,
      success: function(data){
        showHoraryTable(JSON.parse(data));

        $("#tipo").val("");
        $("#horainicio").val("");
        $("#horafin").val("");
        $("#cantidad").val("");
      }
    })
    .done(function() {
      cleanFormulario();
      alertify.success('Horario Agregado con Exito¡'); 
      $('#botonhorario').html('Guardar').attr('disabled', false);
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

  function updateHorario(){
    var pid = $("#botonhorario").attr("data-pid");
    var data= $("#formHorario").serialize()+'&pid=' + pid;

    $.ajax({
      url: 'update/horario/',
      type: 'POST',
      data: data,
      success: function(data){
        loadTable($("#search").val());
        $("#tipo").val("");
        $("#horainicio").val("");
        $("#horafin").val("");
        $("#cantidad").val("");
      }
    })
    .done(function() {
      alertify.success('Horario Modificado con Exito¡');
      $('#botonhorario').html('Guardar').attr('disabled', false);
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

  function deleteHorario(id, target){
    obj=$("#"+target);
    var des=confirm('¿Estás seguro de querer eliminar?');
    if (des == true) {
      $.ajax({
        url: 'delete/horario/',
        type: 'POST',
        data: {id, id},
        beforeSend: function(data){
          capturar(obj);
        },
        success: function(data){  
          jsonArray=JSON.parse(data);
          if (jsonArray.state==1) {
            alertify.success(jsonArray.message);
            loadTable($("#search").val());
          }else{
            alertify.error(jsonArray.message);
          }
          removeCapturarD(obj,target,id);
        }
      })
      .done(function() {

      })
      .fail(function(jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 0) {
          alertify.error('No Conectado: Verifique su conexión a Internet.');
           removeCapturarD(obj,target,id);
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
  }

  function showHoraryTable(id){
    $.ajax({
      url:'obtener/horario/',
      type: 'POST',
      data: {id:id},
      success: function(data){
        var value=JSON.parse(data);
        var tr = $("<tr />");
        var cont=0;
        $.each(value, function(k, v) {
          cont++;
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
            })[0].outerHTML
          );
        })
        tr.append(
          "<td style=\"padding-top: 10px; padding-bottom: 10px; padding-right: 0px; padding-left: 10px;\"><a data-toggle='tooltip' data-placement='top' title='modificar' onclick='recuperardato("+value.id+")' style='margin-right:5px' class='modify btn btn-primary btn-sm' href=\"#\" id='modify"+cont+"'> <i style='color:#fff' class='fas fa-edit'></i> </a><a data-toggle='tooltip' data-placement='top' title='eliminar' onclick='deleteHorario("+value.id+")' style='margin-right:5px' class='btn btn-danger btn-sm' href=\"#\">             <i style='color:#fff' class='fas fa-trash-alt'></i></a></td>");

        $("#tbodyHorario").append(tr)
      }
    });
  }

  function loadTable(search){

    $.ajax({
      url: 'horario/dato/todo/', 
      data: {search: search},
      type: 'POST', 
      beforeSend: function(){
        document.getElementById('mostrar_loadingH').style.display = 'block';
        document.getElementById('tbodyHorario').style.display = 'none';
      },
      success: function(resp){
        //console.log(resp);
        document.getElementById('mostrar_loadingH').style.display = 'none';
        document.getElementById('tbodyHorario').style.display = '';
        var cont=0;
        solvet = JSON.parse(resp);
        $("#mensajeError").html("");
        $("#tbodyHorario").html("");
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
              })[0].outerHTML
            );
          })
          tr.append(
            "<td style=\"padding-top: 10px; padding-bottom: 10px; padding-right: 0px; padding-left: 10px;\"><a data-toggle='tooltip' data-placement='top' title='modificar' onclick='recuperardato("+value.id+",\"modify"+cont+"\")' style='margin-right:5px' class='modify btn btn-success btn-sm' href=\"#\" id='modify"+cont+"'> <i style='color:#fff' class='fas fa-power-off'></i> </a><a data-toggle='tooltip' data-placement='top' title='modificar' onclick='recuperardato("+value.id+",\"modify"+cont+"\")' style='margin-right:5px' class='modify btn btn-primary btn-sm' href=\"#\" id='modify"+cont+"'> <i style='color:#fff' class='fas fa-edit'></i> </a><a data-toggle='tooltip' data-placement='top' title='eliminar' onclick='deleteHorario("+value.id+",\"delete"+cont+"\")' style='margin-right:5px' class='btn btn-danger btn-sm' href=\"#\" id='delete"+cont+"'><i style='color:#fff' class='fas fa-trash-alt'></i></a></td>");
          $("#tbodyHorario").append(tr)
        })
        if (solvet.length==0){
          $("#mensajeError").html("<h5 class=\"alert alert-danger\">NO HA ENCONTRADO COINCIDENCIAS</h5>");
        }
      }
    });
  }
  
  function recuperardato(id, target){
    obj=$("#"+target);
    $.ajax({
      url:'obtener/horario/',
      type: 'POST',
      data:{id:id},
      beforeSend: function(data){
        capturar(obj);
      },
      success: function(data){
        //console.log(data);
        var array_json=JSON.parse(data);

        $("#tipo").val(array_json["type"]);
        $("#horainicio").val(array_json["food_start"]);
        $("#horafin").val(array_json["food_end"]);
        $("#cantidad").val(array_json["cant"]);
        $("#botonhorario").attr('data-pid', array_json["id"]);
        removeCapturar(obj,target,id);
      }
    });
    //console.log(target);
  }

  function cleanFormulario() {
    $("#formHorario .is-valid").each(function(){
      $(this).attr('class', 'form-control');
    });

    $("#formHorario .is-invalid").each(function(){
      $(this).attr('class', 'form-control');
    }); 
  }

  /*$(document).ready(function(){
    $('#calendarioWeb').fullCalendar({
      header:{
        left:'today, prev, next',
        center:'title',
        right:'month, basicWeek, basicDay'
      },
      dayClick:function(date, jsEvent, view){
        $('#modalReserva').modal();
      }
    });     
  });*/

  function capturar(elemento){
    elemento.html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>');
    elemento.css({
      "cursor": 'not-allowed'
    });
    elemento.removeAttr("onclick"); 
  }

  function removeCapturar(elemento,target,id){
    elemento.html('<i style="color:#fff" class="fas fa-edit"></i>');
    elemento.css({
      "cursor": 'pointer'
    });
    elemento.attr("onclick","recuperardato("+id+",\""+target+"\")"); 
  }

  function removeCapturarD(elemento,target,id){
    elemento.html('<i style="color:#fff" class="fas fa-trash-alt"></i>');
    elemento.css({
      "cursor": 'pointer'
    });
    elemento.attr("onclick","deleteHorario("+id+",\""+target+"\")"); 
  }
</script>