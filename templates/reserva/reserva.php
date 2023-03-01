<?php
if (!isset($_SESSION["logged_is_user"])) {
    header("Location: ".SERVER_PHP);
    exit();
} elseif ($_SESSION["role"] !== "AL" and $_SESSION["role"] !== "SP") {
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
	<?php include "../templates/layouts/head1.php"; ?>
<body class="app sidebar-mini rtl sidenav-toggled" style="min-width: 280px;">
	<?php include "../templates/layouts/header.php"; ?>
  <?php include "../templates/layouts/menu.php"; ?>

	<main class="app-content">
    <div class="container">
      <?php if ($_SESSION["role"] == "SP") {?>
      <div id="leyenda-botones" class="icon-angle-up" style="display: block;">
        <div class="container">
          <div class="row offset-md-3">
            <div class="col-4">
              <div class="fc-asistencias" id="botonLeyenda">Asistencias <span class="badge badge-light" id="asistencia" style="float: right; margin-top: 2px;">0</span></div>
            </div>
            <div class="col-4">
              <div class="fc-faltas" id="botonLeyenda">Faltas<span class="badge badge-light" id="falta" style="float: right; margin-top: 2px;">0</span></div>
            </div>
            <div class="col-4">
              <div class="fc-cancelados" id="botonLeyenda">Cancelados <span class="badge badge-light" id="cancelado" style="float: right; margin-top: 2px;">0</span></div>
            </div>
          </div>
        </div>
      </div> 
    <?php }?>
     	<div class="row">
        <div class="col-md-12" id="mostrar_loadingR" style="margin-top:22px;display: none; height: 80vh; background: white; ">
          <div style="margin-top: 100px;">
            <?php include "../templates/layouts/loading.html"; ?>
          </div>
        </div>
       	<div class="col-md-12" id="calendarioWeb">
  			</div>
  		</div>
    </div>
  </main>
  <?php if ($_SESSION["role"] === "SP") {?>
    <div class="leyendaAsistencia" style="display: none;">
      <div class="card">
        <div class="card-header text-center" aria-expanded="true" aria-controls="collapseOne" style="background-color: rgba(40,40,40,0.9);">
          <b style="color: #ffff; font-size: 16px;">Leyenda</b>
        </div>
        <div class="card-body" style="padding: 10px; text-align: center;">
          <div><span class="badge" style="margin-top: 2px; background-color: #f8d7da; color: #f8d7da;">0</span> &nbsp&nbsp0 Asistencias</div>
          <div><span class="badge" style="margin-top: 2px; background-color: #fff3cd; color: #fff3cd;">1</span> &nbsp&nbsp1 Asistencias</div>
          <div><span class="badge" style="margin-top: 2px; background-color: #CFFFB3; color: #CFFFB3;">2</span> &nbsp&nbsp2 Asistencias</div>
          <div><span class="badge" style="margin-top: 2px; background-color: #CCFFFD; color: #CCFFFD;">3</span> &nbsp&nbsp3 Asistencias</div>
        </div>
      </div>
    </div>
    <div class="icon">
      <i class="fab fa-elementor" style="font-size: 40px;"></i>
    </div>
  <?php }?>

  <?php include "../templates/layouts/scriptFinal.php"; ?>
  <?php include "../templates/reserva/modal/modalReserva.php"; ?>
  <?php 
    if ($_SESSION["role"] == "SP" OR $_SESSION["role"] == "AL") {
      include "../templates/modalRankingMenu.php";  
    }  
  ?>

</body>
  <script>
    var eventAux = null;

    $(document).ready(function(){

      countForMostrar();

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

      $(".icon").click(function(event) {
        $(".leyendaAsistencia").animate({
          width: "show"
        }, 1000, function() {
        });
        $(".leyendaAsistencia").css("display", "block");
        //$('.leyendaAsistencia').css("transform","translate(-150px,0)");
        //$(".icon").css("display", "none");
      });

      $(".icon").mouseout(function(event) {
        $(".leyendaAsistencia").css("display", "none");
        //$('.leyendaAsistencia').css("transform","translate(150px,0)");
        //$(".icon").css("display", "block");
      });

      
      $.ajax({
        url: 'menu/dato/todo/',
        beforeSend: function(resp){
          document.getElementById('mostrar_loadingR').style.display = 'block';
          document.getElementById('calendarioWeb').style.display = 'none';
        },
        success: function(resp){
          document.getElementById('mostrar_loadingR').style.display = 'none';
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
            menu["type"] = solvet[i].type;
            menu["title"] = title;
            menu["second"] = solvet[i].second;
            menu["soup"] = solvet[i].soup;
            menu["drink"] = solvet[i].drink;
            menu["fruit"] = solvet[i].fruit;
            menu["dessert"] = solvet[i].dessert;
            menu["aditional"] = solvet[i].aditional;
            menu["start"] = solvet[i].skd_date;
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

            droppable: true,
            hiddenDays: [6, 0],

            events:arrayJson,

            eventClick:  function(calEvent, jsEvent, view) {
              var momento = $('#calendarioWeb').fullCalendar('getDate');
              dateActual=dateFormat(momento.format());
              if (dateFormat(calEvent.start)<dateActual) {
                alertify.error('Lo sentimos. No puede realizar una Reserva en una Fecha Pasada.');
              }else{
                eventAux=calEvent;
                if (calEvent.type===1) {
                  $('#desayuno').html('Desayuno : ');
                }else{
                  $('#desayuno').html('Infusión : ');
                }
                $('#menuTitle').html('Reservación '+calEvent.title);
                $('#menuTitle').attr('data-idM', calEvent.id);
                $('#dateMenu').html('Menu del Día '+dateFormat(calEvent.start));
                $('#detailSecond').html(calEvent.second);
                $('#detailSoup').html(calEvent.soup);
                $("#detailDrink").html(calEvent.drink);
                $("#detailFruit").html(calEvent.fruit);
                $("#detailDessert").html(calEvent.dessert);
                $("#detailAditional").html(calEvent.aditional);
                $("#inicioReserva").html(dateFormatPersonality(calEvent.reser_date_start));
                $("#finReserva").html(dateFormatPersonality(calEvent.reser_date_end));
                $('#modalReserva').modal();
                checkMenuEnable(calEvent.type, calEvent.id);
              }
            },

            eventAfterAllRender: function(){
              asistencia();
            }

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

    });
  
    function asistencia(){
      var fecha=$('#calendarioWeb .fc-toolbar .fc-center h2').html();
      var data = 'mes='+fecha;
      $.ajax({
        url: 'reserva/asistenciasFaltas',
        type: 'POST',
        data: data,
        success: function(data){          
          var json = JSON.parse(data);
          //console.log(json);
          if (json.length!==0) {
            $('#falta').html(json[0].falta);
            $('#asistencia').html(json[0].asistencia);
            $('#cancelado').html(json[0].cancelado);
          }else{
            $('#falta').html("0");
            $('#asistencia').html("0");
            $('#cancelado').html("0");
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
    
      $.ajax({
        url: 'reserva/asistencia',
        type:'POST',
        data: data,
        success: function(resp){
          var solvet = JSON.parse(resp);
          //console.log(solvet);
          var cont_asist=0;
          var background_color="";
          for (var i = 0; i < solvet.length; i++) {
            for (var j = 0; j < solvet.length-1; j++) {
              if (solvet[i].skd_date==solvet[j].skd_date) {
                if (solvet[j].assist==true) {
                  cont_asist+=1;                  
                }
              }
              if (cont_asist==3) {break;}
            }

            if (cont_asist==0) {
              background_color="#f8d7da";
            }else if (cont_asist==1) {
              background_color="#fff3cd";
            }else if (cont_asist==2) {
              background_color="#CFFFB3";
            }else if(cont_asist==3){
              background_color="#CCFFFD";
            }

            $(".fc-day").each(function(){
              if ($(this).attr("data-date")==solvet[i].skd_date) {
                $(this).css('background-color', background_color);
              }
            });
            cont_asist=0;
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
       // console.log("complete");
      });
    }


    function checkMenuEnable(typeMenu, idMenu) {
      var data = 'idMenu='+idMenu;  
      $.ajax({
        url: 'menu/checkMenuEnable',
        type: 'POST',
        data: data,
        success: function(data){
          var json = JSON.parse(data);
          $("#listHorary").html("");
          $("#listHorary").html("");

          if(json.state==0){      
            var divHoraryAuxReservation="<div class=\"col-lg-12\">"+
                                "<div class=\"alert alert-success\" role=\"alert\">"+
                                  "<p>"+json.message+"</p>"+ 
                                "</div>"+
                              "</div>";

            var divHoraryAux="<div class=\"col-lg-12\">"+
                                "<div class=\"alert alert-danger\" role=\"alert\">"+
                                  "<p>"+json.message+"</p>"+ 
                                "</div>"+
                              "</div>";
            $("#listHorary").append( divHoraryAux)
          }else if(json.state==1){
            showHorary(typeMenu, idMenu);
          }
          //showHorary(typeMenu, idMenu);
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

    function showHorary(typeMenu, idMenu){
      var data = 'typeMenu='+typeMenu+'&idMenu='+idMenu;
      $.ajax({

        url:'horario/getHoraryCantReser',
        type: 'POST',
        data: data,
        beforeSend: function(){
          document.getElementById('mostrar_loadingHR').style.display = 'block';
        },
        success: function(data){
          document.getElementById('mostrar_loadingHR').style.display = 'none'; 
          var value=JSON.parse(data);
          var horary=value.data;
          console.log()
          $("#labelAdvert").html("");
          $("#listHorary").html("");
          if(value.state==0){ 
            var divHoraryAux="<div class=\"col-lg-6\">"+
                              "<div class=\"alert alert-danger\" role=\"alert\">"+
                                value.message+ 
                                "</div>"+
                              "</div>";
            $("#listHorary").append(divHoraryAux);
            //$("#listHorary").append(divHoraryAux);
          }         
          else if(value.state==1){
            for (var i=0; i < horary.length; i++) {

              var divHoraryAux="<div class=\"col-lg-6\"> "+
                                 "<div class=\"row caja justify-content-center align-items-center\">"+
                                   "<div class=\"col-5 horas text-center\">"+
                                     "<img src=\"img/hora.png\" width=\"40\" height=\"40\"> "+
                                      "<h4 class=\"h4-r\">Horarios</h4>"+
                                      "<h5 class=\"h5-r\">"+horary[i].food_start_char+" a "+horary[i].food_end_char+"</h5>"+
                                    "</div>"+
                                    "<div class=\"col-4 horas text-center cantidadReserva\">"+
                                     "<img src=\"img/grupo.png\" width=\"60\" height=\"40\">"+
                                      "<h4 class=\"h4-r\">Reservado</h4>"+
                                      "<h5 class=\"h5-r\"><b class=\"contador"+i+"\">"+horary[i].cantreser+"</b> de ("+horary[i].cant+")</h5>"+
                                    "</div>"+
                                    "<div class=\"col-3 horas text-center\">"+
                                      "<div class=\"checkbox\">"+
                                        "<label style=\"font-size: 2.5em; background: #2ecc71; border-radius: 50px; color: white;\">"+
                                          "<input type=\"checkbox\" class=\"only-one\" value=\""+horary[i].id+"\" id=\"checketReservation\" name=\"checketReservation\" onclick=\"reservation(this); \">"+
                                          "<span class=\"cr\" style=\"margin-right: 0px;\" ><i class=\"cr-icon fa fa-check\"></i></span>"+
                                        "</label>"+
                                      "</div>"+
                                    "</div>"+
                                  "</div>"+
                                "</div>";
                                $("#listHorary").append(divHoraryAux);


                                
            }
            captureReservationUser(idMenu);
          } 


/*
          console.log('hOLA', horary.length);
            for (var i=0; i < horary.length; i++) {

              console.log("HOla", horary)

              var divHoraryAux="<div class=\"col-lg-6\"  "+((value.state==0)?"style=\"pointer-events: none;\"" : "") +"> "+
                                 "<div class=\"row caja justify-content-center align-items-center\">"+
                                   "<div class=\"col-5 horas text-center\">"+
                                     "<img src=\"img/hora.png\" width=\"40\" height=\"40\"> "+
                                      "<h4 class=\"h4-r\">Horarios</h4>"+
                                      "<h5 class=\"h5-r\">"+horary[i].food_start_char+" a "+horary[i].food_end_char+"</h5>"+
                                    "</div>"+
                                    "<div class=\"col-4 horas text-center cantidadReserva\">"+
                                     "<img src=\"img/grupo.png\" width=\"60\" height=\"40\">"+
                                      "<h4 class=\"h4-r\">Reservado</h4>"+
                                      "<h5 class=\"h5-r\"><b class=\"contador"+i+"\">"+horary[i].cantreser+"</b> de ("+horary[i].cant+")</h5>"+
                                    "</div>"+
                                    "<div class=\"col-3 horas text-center\">"+
                                      "<div class=\"checkbox\">"+
                                        "<label style=\"font-size: 2.5em; background: #2ecc71; border-radius: 50px; color: white;\">"+
                                          "<input type=\"checkbox\" class=\"only-one\" value=\""+horary[i].id+"\" id=\"checketReservation\" name=\"checketReservation\" onclick=\"reservation(this); \">"+
                                          "<span class=\"cr\" style=\"margin-right: 0px;\" ><i class=\"cr-icon fa fa-check\"></i></span>"+
                                        "</label>"+
                                      "</div>"+
                                    "</div>"+
                                  "</div>"+
                                "</div>";
                                
                                $("#listHorary").append(divHoraryAux);

                                
            }
            captureReservationUser(idMenu);
          

            */

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

    function reservation(inputCheckbox){
      var idHorary=inputCheckbox.value;
      var checkboxes = document.getElementsByName('checketReservation');
      
      if(inputCheckbox.checked){
        if(confirmReservation("¿Desea Confirmar su Reservación?")){
          addReservation(idHorary);
          checkboxes.forEach((item) => {
            if (item !== inputCheckbox) item.checked = false;
          })
        }else{
          inputCheckbox.checked=false;
          alertify.error('Reserva no Realizada');
        }
      }else{
        if(confirmReservation("¿Desea Cancelar su Reservación?")){
          addReservation(-1);
          checkboxes.forEach((item) => {
            if (item !== inputCheckbox) item.checked = false;
          })
        }else{
          alertify.error('Reserva no Cancelada');
          inputCheckbox.checked=true;
        }
        
      }
    }
    
    function confirmReservation(message){
      var bool=confirm(message); 
      if(bool){ 
        return true; 
      }else{ 
        return false;
      }
    } 

    function addReservation(idHorary) {
      var idMenu = $("#menuTitle").attr("data-idM");
      var data = 'idMenu='+idMenu+'&idHorary='+idHorary;  
      $.ajax({
        url: 'create/reservation/',
        type: 'POST',
        data: data,
        success: function(data){
          var json = JSON.parse(data);
          if(json.state==0){
            alertify.error(json.message);
            showHorary(eventAux.type, eventAux.id);
          }else if(json.state==1){
            alertify.success(json.message);
            showHorary(eventAux.type, eventAux.id);
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
       // console.log("complete");
      });
    }

    function captureReservationUser(idMenu) {
      var data = 'idMenu='+idMenu;
      $.ajax({
        url: 'capture/reservation/',
        type: 'POST',
        data: data,
        success: function(data){
          var json = JSON.parse(data);
          if(json.length!=0){
            recorrerCheckbox(json[0].id_timetable);
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

    function modalPuntuacionMenu(){
      $("#rankingMenu").modal('show');
    }

    function countForMostrar(){
      $.ajax({
        url: 'usuario/count/listMenu/',
        success: function(data){
          var resul = JSON.parse(data);
          if (resul[0].cont!=0) {
            modalPuntuacionMenu();
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

    function dateFormatPersonality(df) {
      if(df == void 0){
        return null;
      }
      var fecha = moment(df).format('DD/MM/YYYY');
      var weekDayName =  moment(df).format('dddd');
      var weekDayNumber =  moment(df).format('DD');
      var monthName = moment(df).format('MMMM');

      var hora = moment(df).format('hh:mm A');

      var fecha = weekDayName+", "+weekDayNumber+" de "+monthName+" "+hora;
      return fecha;
    }

    function recorrerCheckbox(id_timetable) {
      $(".only-one").each(function(){
        if($(this).val()==id_timetable){
          $(this).attr("checked",'true');
        }
      });
    }
  </script>
</html>
		