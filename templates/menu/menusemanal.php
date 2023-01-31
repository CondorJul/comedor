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
<body class="app sidebar-mini rtl sidenav-toggled">
  <?php include "../templates/layouts/header.php";?>
  <?php include "../templates/layouts/menu.php";?>

  <main class="app-content">
    <div class="container">
      <div id="menu-botones" class="icon-angle-up" style="display: block;">
        <div class="container">
          <div class="row col-md-7 offset-md-4">
            <div class="col-4">
              <div class="fc-desayuno" id="botonEvento" data-type="1">1. Desayuno</div>
            </div>
            <div class="col-4">
              <div class="fc-almuerzo" id="botonEvento" data-type="2">2. Almuerzo</div>
            </div>
            <div class="col-4">
              <div class="fc-cena" id="botonEvento" data-type="3">3. Cena</div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12" id="mostrar_loadingMS" style="margin-top:22px;display: none; height: 80vh; background: white; ">
          <div style="margin-top: 100px;">
            <?php include "../templates/layouts/loading.html";?>
          </div>
        </div>

        <div class="col-md-12" id="calendarioWeb" >

        </div>
      </div>
    </div>
  </main>
  <?php include "modal/modalMenu.php";?>
  <?php include "../templates/layouts/scriptFinal.php";?>
  <script src="js/menu/menu.js"></script>
</body>

<script>
  var eventAux=null;

  $(document).ready(function(){

    listSecond();
    listSoup();
    listDrink();
    listFruit();
    listDessert();
    listAditional();    
    
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

    $('#menu-botones #botonEvento').each(function() {

      $(this).data('event', {
        title: $.trim($(this).text()),
        typeMenu: $(this).attr('data-type'),
        backgroundColor: $(this).css('background-color'),
        borderColor: $(this).css('border-color'),
        textColor: $(this).css('color'),
        id: 0,
        stick: true
      });

      $(this).draggable({
        zIndex: 999,
        revert: true,
        revertDuration: 0
      });
    });

    $.ajax({
      url: 'menu/dato/todo/',
        beforeSend: function(resp){
          document.getElementById('mostrar_loadingMS').style.display = 'block';
          document.getElementById('calendarioWeb').style.display = 'none';
        },
        success: function(resp){
          document.getElementById('mostrar_loadingMS').style.display = 'none';
          document.getElementById('calendarioWeb').style.display = 'block';

          var solvet = JSON.parse(resp);
          //console.log(solvet);
          var arrayJson=new Array();

          for (var i = 0; i <solvet.length; i++) {
            var title="";
            var backgroundColor="";
            var borderColor="";
            if (solvet[i].type==1) {
              title = '1. Desayuno';
              backgroundColor = '#FF5733';
              borderColor = '#FF5733';
            }else if(solvet[i].type==2){
              title = '2. Almuerzo';
              backgroundColor = '#4F248B';
              borderColor = '#4F248B';
            }else if(solvet[i].type==3){
              title = "3. Cena";
              backgroundColor = '#8B5024';
              borderColor = '#8B5024';
            }
            var menu={};
            menu["id"] = solvet[i].id;
            menu["title"] = title;
            menu["second"] = solvet[i].second;
            menu["soup"] = solvet[i].soup;
            menu["drink"] = solvet[i].drink;
            menu["fruit"] = solvet[i].fruit;
            menu["dessert"] = solvet[i].dessert;
            menu["aditional"] = solvet[i].aditional;
            menu["start"] = solvet[i].skd_date;
            menu["state_reser"] = solvet[i].state_reser;
            menu["reser_date_start"] = solvet[i].reser_date_start;
            menu["reser_date_end"] = solvet[i].reser_date_end;
            menu["backgroundColor"] = backgroundColor;
            menu["borderColor"] = borderColor;
            menu["textColor"] = '#FFF';
            arrayJson.push(menu);
          }

          $('#calendarioWeb').fullCalendar({

            header:{
              left:'today, prev, next',
              center:'title',
              right:'month, basicWeek, basicDay'
            },

            editable: true,
            droppable: true,
            hiddenDays: [6, 0],

            events:arrayJson,

            eventClick:  function(calEvent, jsEvent, view) {
              var momento = $('#calendarioWeb').fullCalendar('getDate');
              dateActual=dateFormat(momento.format());
              if (dateFormat(calEvent.start)<dateActual && calEvent.id===0) {
                alertify.error('No puede Agregar un Menú en una Fecha Pasada');
                $("#calendarioWeb").fullCalendar('removeEvents', 0);
              }else{
                if (dateFormat(calEvent.start)<dateActual && calEvent.id!=0) {
                  $("#btnEliminarMenu").attr("disabled", true);
                  $("#btnGuardarMenu").attr("disabled", true);
                }
                if (dateFormat(calEvent.start)>dateActual && calEvent.id!=0) {
                  $("#btnEliminarMenu").attr("disabled", false);
                  $("#btnGuardarMenu").attr("disabled", false);
                }
                eventAux=calEvent;
                $('#menuTitle').attr('data-type', calEvent.typeMenu);
                $('#menuTitle').html(calEvent.title);
                $("#fecha").val(dateFormat(calEvent.start));
                $("#segundo").val(calEvent.second);
                $("#sopa").val(calEvent.soup);
                $("#infusion").val(calEvent.drink);
                $("#fruta").val(calEvent.fruit);
                $("#postre").val(calEvent.dessert);
                $("#adicional").val(calEvent.aditional);
                $("#fechaInicio").val(dateFormat(calEvent.reser_date_start));
                $("#horaInicio").val(timeFormat(calEvent.reser_date_start));
                $("#fechaFin").val(dateFormat(calEvent.reser_date_end));
                $("#horaFin").val(timeFormat(calEvent.reser_date_end));
                $('#estado option[value="'+calEvent.state_reser+'"]').prop('selected', true);
                $("#botones").attr('data-pid', calEvent.id);
                $('#menu').modal('show');
              }
            }

            /*eventAfterAllRender: function(){ 
              /*$('.fc-button').click(function(e){ 
                console.log($(this).text()) 
              }) 

              $(".fc-basicWeek-button").click(function(){
                alert("hola pinche solis");
              });
            }*/

          });
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

    $("#formMenu").submit(function(e){
      validar(e);
      e.preventDefault();

      var valid=true;
      $("#formMenu .is-invalid").each(function(){
        valid=false;
      });

      if (valid) {
        var pid = $('#botones').attr('data-pid');
        $('#btnGuardarMenu').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading').attr('disabled', true);
        if (pid != 0){
          updMenu();
          cleanModal();
        }else{
          addMenu();
          cleanModal();
        }
      }
    });

    $("#btnEliminarMenu").click(function(e){
      confirmDelete();
      $('#btnEliminarMenu').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading').attr('disabled', true);
      e.preventDefault();
    });

  });

  function verificar(start) {
      var check = moment(start).format('YYYY-MM-DD');
      var today = moment(new Date()).format('YYYY-MM-DD');
      //alert("holaa"+today+' '+check);
      if (check >= today) {
        return true;
      }else {
        return false;
      }
  }

  function addMenu() {
    var typeMenu = $("#menuTitle").attr("data-type");
    var data= $("#formMenu").serialize()+'&typeMenu=' + typeMenu;
    $.ajax({
      url: 'create/menu/',
      type: 'POST',
      data: data,
      success: function(data){
        var json = JSON.parse(data);
        if(json.state==0){
          alertify.error(json.message);
        }else if(json.state==1){
          seleccionarMenu(eventAux, json.data);
          alertify.success(eventAux.title+json.message);
          $('#btnGuardarMenu').html('<i class="far fa-save"></i> Guardar').attr('disabled', false);
          $("#menu").modal('hide');
        }
      }
    })
    .done(function() {
      //console.log("success");
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
      if (jqXHR.status === 0) {
        alertify.error('No Conectado: Verifique su conexión a Internet.');
         $('#btnGuardarMenu').html('<i class="far fa-save"></i> Guardar').attr('disabled', false);
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

  function updMenu(){
    var pid = $("#botones").attr("data-pid");
    var data= $("#formMenu").serialize()+'&pid=' + pid;
    $.ajax({
      url: 'update/menu/',
      type: 'POST',
      data: data,
      success: function(data){
        var json = JSON.parse(data);
        if(json.state==0){
          alertify.error(json.message);
        }else if(json.state==1){
          seleccionarMenu(eventAux, pid);
          alertify.success(eventAux.title+json.message);
          $('#btnGuardarMenu').html('<i class="far fa-save"></i> Guardar').attr('disabled', false);
          $("#menu").modal('hide');
        }
      }
    })
    .done(function() {
      //console.log("success");
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
      if (jqXHR.status === 0) {
        alertify.error('No Conectado: Verifique su conexión a Internet.');
        $('#btnGuardarMenu').html('<i class="far fa-save"></i> Guardar').attr('disabled', false);
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

  function delMenu(){
    var pid = $("#botones").attr("data-pid");
    $.ajax({
      url: 'delete/menu/',
      type: 'POST',
      data: {pid, pid},
      success: function(data){
        $("#calendarioWeb").fullCalendar('removeEvents', pid);
        $('#btnEliminarMenu').html('<i class="far fa-save"></i> Eliminar').attr('disabled', false);
        $("#menu").modal('hide');
      }
    })
    .done(function() {
      alertify.success(eventAux.title+' Eliminado con Exito...!');
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
      if (jqXHR.status === 0) {
        alertify.error('No Conectado: Verifique su conexión a Internet.');
        $('#btnEliminarMenu').html('<i class="far fa-save"></i> Guardar').attr('disabled', false);
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

  function seleccionarMenu(event, pid){
    $.ajax({
      url: 'capturarEspecifico/menu/',
      type: 'POST',
      data: {pid, pid},
      success: function(data){

        var solvet = JSON.parse(data);        
        if (solvet.length==1) {
          event.id = solvet[0].id;
          event.second = solvet[0].second;
          event.soup = solvet[0].soup;
          event.drink = solvet[0].drink;
          event.fruit = solvet[0].fruit;
          event.dessert = solvet[0].dessert;
          event.aditional = solvet[0].aditional;
          event.start = solvet[0].skd_date;
          event.state_reser = solvet[0].state_reser;
          event.reser_date_start = solvet[0].reser_date_start;
          event.reser_date_end = solvet[0].reser_date_end;
        }
        $('#calendarioWeb').fullCalendar('updateEvent', event);        
      }
    })
    .done(function() {
      //console.log("success");
    })
    .fail(function() {
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

  function listSecond(){
    $.ajax({
      url: 'listar/menu/second/',
      success: function(data){
        var json = JSON.parse(data);
        //console.log(json);
        $("#listSegundo").html("");
          for (var i = 0; i < json.length; i++) {
            var divSecondAux="<option value=\""+json[i].second+"\">"+
                            "</option>";
            $("#listSegundo").append(divSecondAux)
          }       
          
      }
    })
    .done(function() {
      //console.log("success");
    })
    .fail(function() {
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

  function listSoup(){
    $.ajax({
      url: 'listar/menu/soup/',
      success: function(data){
        var json = JSON.parse(data);
        //console.log(json);
        $("#listSopa").html("");
          for (var i = 0; i < json.length; i++) {
            var divSoupAux="<option value=\""+json[i].soup+"\">"+
                            "</option>";
            $("#listSopa").append(divSoupAux)
          }       
      }
    })
    .done(function() {
      //console.log("success");
    })
    .fail(function() {
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

  function listDrink(){
    $.ajax({
      url: 'listar/menu/drink/',
      success: function(data){
        var json = JSON.parse(data);
        //console.log(json);
        $("#listAgua").html("");
          for (var i = 0; i < json.length; i++) {
            var divDrinkAux="<option value=\""+json[i].drink+"\">"+
                            "</option>";
            $("#listAgua").append(divDrinkAux)
          }       
      }
    })
    .done(function() {
      //console.log("success");
    })
    .fail(function() {
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

  function listFruit(){
    $.ajax({
      url: 'listar/menu/fruit/',
      success: function(data){
        var json = JSON.parse(data);
        //console.log(json);
        $("#listFruta").html("");
          for (var i = 0; i < json.length; i++) {
            var divFruitAux="<option value=\""+json[i].fruit+"\">"+
                            "</option>";
            $("#listFruta").append(divFruitAux)
          }       
      }
    })
    .done(function() {
      //console.log("success");
    })
    .fail(function() {
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

  function listDessert(){
    $.ajax({
      url: 'listar/menu/dessert/',
      success: function(data){
        var json = JSON.parse(data);
        //console.log(json);
        $("#listPostre").html("");
          for (var i = 0; i < json.length; i++) {
            var divDessertAux="<option value=\""+json[i].dessert+"\">"+
                            "</option>";
            $("#listPostre").append(divDessertAux)
          }       
      }
    })
    .done(function() {
      //console.log("success");
    })
    .fail(function() {
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

  function listAditional(){
    $.ajax({
      url: 'listar/menu/aditional/',
      success: function(data){
        var json = JSON.parse(data);
        //console.log(json);
        $("#listAdicional").html("");
          for (var i = 0; i < json.length; i++) {
            var divAditionalAux="<option value=\""+json[i].aditional+"\">"+
                            "</option>";
            $("#listAdicional").append(divAditionalAux)
          }       
      }
    })
    .done(function() {
      //console.log("success");
    })
    .fail(function() {
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

  function confirmDelete(){
    var r = confirm("Esta seguro que desea Eliminar?");
    if (r == true) {
      delMenu();
    }
  }

  function cleanModal() {
    $("#formMenu .is-valid").each(function(){
      $(this).attr('class', 'form-control');
    });

    $("#formMenu .is-invalid").each(function(){
      $(this).attr('class', 'form-control');
    });
  }

  function dateFormat(df) {
    if(df == void 0){
      return null;
    }
    var fecha = moment(df).format('DD/MM/YYYY');
    return fecha.split('/').reverse().join('-');
  }

  function timeFormat(tf) {
    if (tf == void 0) {
      return null;
    }
    var hora = moment(tf).format('HH:mm:ss');
    return hora;
  }

</script>

</html>

