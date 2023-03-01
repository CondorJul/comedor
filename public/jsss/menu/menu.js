import { SERVER_ROUTE } from "../env";
$(document).ready(function(){

  //var formulario = document.getElementsByName('formMenu')[0];
  
  //elementos=formulario.elements;

  //formulario.addEventListener("submit", validar);

});

var validar = function(e){
      revisarvacios(e);
      existeFecha(e);
}
function revisarvacios(e){
    var formulario = document.getElementsByName('formMenu')[0];
    elementos=formulario.elements;

    
    /*
    if (formulario.segundo.value==null || formulario.segundo.value.length == 0 || /^\s+$/.test(formulario.segundo.value) ) {
         formulario.segundo.className='form-control is-invalid';
          e.preventDefault();
    }else{
          formulario.segundo.className='form-control is-valid';
    }
    if (formulario.sopa.value==null || formulario.sopa.value.length == 0 || /^\s+$/.test(formulario.sopa.value) ) {
         formulario.sopa.className='form-control is-invalid';
          e.preventDefault();
    }else{
          formulario.sopa.className='form-control is-valid';
    }
    if(formulario.infusion.value==null || formulario.infusion.value.length == 0 || /^\s+$/.test(formulario.infusion.value) ) {
         formulario.infusion.className='form-control is-invalid';
          e.preventDefault();
    }else{
          formulario.infusion.className='form-control is-valid';
    }
    if(formulario.fruta.value==null || formulario.fruta.value.length == 0 || /^\s+$/.test(formulario.fruta.value) ) {
         formulario.fruta.className='form-control is-invalid';
          e.preventDefault();
    }else{
          formulario.fruta.className='form-control is-valid';
    }
    if(formulario.postre.value==null || formulario.postre.value.length == 0 || /^\s+$/.test(formulario.postre.value) ) {
         formulario.postre.className='form-control is-invalid';
          e.preventDefault();
    }else{
          formulario.postre.className='form-control is-valid';
    }*/

    if(formulario.fechaInicio.value==null || formulario.fechaInicio.value.length == 0 || /^\s+$/.test(formulario.fechaInicio.value) ) {
         formulario.fechaInicio.className='form-control is-invalid';
          e.preventDefault();
    }else{
          formulario.fechaInicio.className='form-control is-valid';
    }

    if(formulario.fechaFin.value==null || formulario.fechaFin.value.length == 0 || /^\s+$/.test(formulario.fechaFin.value) ) {
         formulario.fechaFin.className='form-control is-invalid';
          e.preventDefault();
    }else{
          formulario.fechaFin.className='form-control is-valid';
    }

    if(formulario.horaInicio.value==null || formulario.horaInicio.value.length == 0 || /^\s+$/.test(formulario.horaInicio.value) ) {
         formulario.horaInicio.className='form-control is-invalid';
          e.preventDefault();
    }else{
          formulario.horaInicio.className='form-control is-valid';
    }

    if(formulario.horaFin.value==null || formulario.horaFin.value.length == 0 || /^\s+$/.test(formulario.horaFin.value) ) {
         formulario.horaFin.className='form-control is-invalid';
          e.preventDefault();
    }else{
          formulario.horaFin.className='form-control is-valid';
    }

    if(formulario.estado.value==null || formulario.estado.value.length == 0 || /^\s+$/.test(formulario.estado.value) ) {
         formulario.estado.className='form-control is-invalid';
          e.preventDefault();
    }else{
          formulario.estado.className='form-control is-valid';
    }
    
    var Fechainicio = formulario.fechaInicio.value;
    var Fechafin = formulario.fechaFin.value;

    var horaInicio = formulario.horaInicio.value;
    var horaFin = formulario.horaFin.value;
    //var Fecha1 = new Date(parseInt(Fecha_aux[2]),parseInt(Fecha_aux[1]),parseInt(Fecha_aux[0]));
    if (Fechainicio > Fechafin) {
      //alert("inicio es mayor");
       formulario.fechaFin.className='form-control is-invalid';
       document.getElementById("finreserva").innerHTML = "El campo Fin Reserva debe ser MAYOR al campo Inicio Reserva";
       e.preventDefault();

    }else if(Fechainicio == Fechafin ){
      if ( horaFin < horaInicio ) {
        formulario.horaFin.className='form-control is-invalid';
        document.getElementById("finreserva").innerHTML = "El campo fin Reserva debe ser MAYOR al campo inicio Reserva";
        e.preventDefault();

      }
    }
    
  } 

  function existeFecha(e){

      var formulario = document.getElementsByName('formMenu')[0];
      elementos=formulario.elements;
    var fechaf = formulario.fecha.value.split("-");
    var year = fechaf[0];
    var month = fechaf[1];
    var day = fechaf[2];

    var date = new Date(year,month,'0');
    
    if((day-0)>(date.getDate()-0) || (year>='2050') || date=='Invalid Date'){
        
         formulario.fecha.className='form-control is-invalid';
         e.preventDefault();
    }
    else{
        
         formulario.fecha.className='form-control is-valid';

    }
  }



var eventAux=null;

  $(document).ready(function(){
    $(".cerrar").click(function(){
          $.ajax({
              url: `${SERVER_ROUTE}/close/login/user/`,
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
      url: `${SERVER_ROUTE}/menu/dato/todo/`,
        beforeSend: function(resp){
          document.getElementById('mostrar_loadingMS').style.display = 'block';
          document.getElementById('calendarioWeb').style.display = 'none';
        },
        success: function(resp){
          document.getElementById('mostrar_loadingMS').style.display = 'none';
          document.getElementById('calendarioWeb').style.display = 'block';  

           var solvet = JSON.parse(resp);
          var arrayJson=new Array();

          for (var i = 0; i <solvet.length; i++) {
            var title="";
            var backgroundColor="";
            var borderColor="";
            if (solvet[i].type==1) {
              title = 'Desayuno';
              backgroundColor = '#FF5733';
              borderColor = '#FF5733';
            }else if(solvet[i].type==2){
              title = 'Almuerzo';
              backgroundColor = '#4F248B';
              borderColor = '#4F248B';
            }else if(solvet[i].type==3){
              title = "Cena";
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

          });
        }
    })
    .done(function() {
      console.log("success");
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
      console.log("complete");
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

  function addMenu() {
    var typeMenu = $("#menuTitle").attr("data-type"); 
    var data= $("#formMenu").serialize()+'&typeMenu=' + typeMenu;
    $.ajax({
      url: `${SERVER_ROUTE}/create/menu/`,
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
      console.log("success");
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
      console.log("complete");
    });
  }

  function updMenu(){
    var pid = $("#botones").attr("data-pid");
    var data= $("#formMenu").serialize()+'&pid=' + pid;
    $.ajax({
      url: `${SERVER_ROUTE}/update/menu/`,
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
      console.log("success");
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
      console.log("complete");
    });
  }

  function delMenu(){
    var pid = $("#botones").attr("data-pid");
    $.ajax({
      url: `${SERVER_ROUTE}/delete/menu/`,
      type: 'POST',
      data: {pid, pid},
      success: function(data){
        $("#calendarioWeb").fullCalendar('removeEvents', pid);
        $('#btnEliminarMenu').html('<i class="far fa-save"></i> Guardar').attr('disabled', false);
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
      console.log("complete");
    });
  }

  function seleccionarMenu(event, pid){
    $.ajax({
      url: `${SERVER_ROUTE}/capturarEspecifico/menu/`,
      type: 'POST',
      data: {pid, pid},
      success: function(data){

        var solvet = JSON.parse(data);
        var arrayJson=new Array();

        for (var i = 0; i <solvet.length; i++) {
          event.id = solvet[i].id;
          event.second = solvet[i].second;
          event.soup = solvet[i].soup;
          event.drink = solvet[i].drink;
          event.fruit = solvet[i].fruit;
          event.dessert = solvet[i].dessert;
          event.aditional = solvet[i].aditional;
          event.start = solvet[i].skd_date;
          event.state_reser = solvet[i].state_reser;
          event.reser_date_start = solvet[i].reser_date_start;
          event.reser_date_end = solvet[i].reser_date_end;
        }
        $('#calendarioWeb').fullCalendar('updateEvent', event);       
      }
    })
    .done(function() {
      console.log("success");
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  }

  function confirmDelete(){
    var r = confirm("Esta seguro que desea Eliminar?");
    if (r == true) {
      delMenu();
    }else {

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