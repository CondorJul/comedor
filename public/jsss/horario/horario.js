$(document).ready(function(){

  //var formulario = document.getElementsByName('formHorario')[0];
  
 // elementos=formulario.elements;

  //formulario.addEventListener("submit", validar);

});

var validar = function(e){
      revisarHorario(e);
      //existeFecha(e);
}
function revisarHorario(e){
        var formulario = document.getElementsByName('formHorario')[0];
        elementos=formulario.elements;

        if (formulario.tipo.value==null || formulario.tipo.value.length == 0 || /^\s+$/.test(formulario.tipo.value) ) {
             formulario.tipo.className='form-control is-invalid';
              e.preventDefault();
        }else{
              formulario.tipo.className='form-control is-valid';
        }
        
        if (formulario.horainicio.value==null || formulario.horainicio.value.length == 0 || /^\s+$/.test(formulario.horainicio.value) ) {
             formulario.horainicio.className='form-control is-invalid';
              e.preventDefault();
        }else{
              formulario.horainicio.className='form-control is-valid';
        }

        if (formulario.horafin.value==null || formulario.horafin.value.length == 0 || /^\s+$/.test(formulario.horafin.value) ) {
             formulario.horafin.className='form-control is-invalid';
              e.preventDefault();
        }else{
              formulario.horafin.className='form-control is-valid';
        }

        if (formulario.cantidad.value==null || formulario.cantidad.value.length == 0 || /^\s+$/.test(formulario.cantidad.value) ) {
             formulario.cantidad.className='form-control is-invalid';
              e.preventDefault();
        }else{
              formulario.cantidad.className='form-control is-valid';
        }


        var horainicio = formulario.horainicio.value;
        var horafin = formulario.horafin.value;

        if (horafin < horainicio) {
            formulario.horafin.className='form-control is-invalid';
            document.getElementById("horafinHorarios").innerHTML = "El campo Fin Horario debe ser MAYOR al campo Inicio Horario";
            e.preventDefault();
        }

        if(formulario.cantidad.value!==''){
          var data = formulario.cantidad.value;
          if (data.length > 3 ) {
          formulario.cantidad.className='form-control is-invalid';
          document.getElementById("cantidadHorario").innerHTML = "El campo Cantidad solo acepta numeros menores que 999";
          e.preventDefault();
          }else{

          formulario.cantidad.className='form-control is-valid';
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
/*(function(){
    
  alert("solichi");
    var formulario = document.getElementsByName('formMenu')[0];
    
    if (formulario === void 0) {
      
      return;
    }else{
       elementos=formulario.elements;
       
    }

    boton= document.getElementById('btnGuardarMenu');
    
      function revisar(e){

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
        }

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
    function limpiarvalidacion(){
      formulario.fecha.className='form-control';
      formulario.segundo.className='form-control';
      alert("si paso");
    }
    var validar = function(e){
          
          existeFecha(e);
          revisar(e);
        
    };

    formulario.addEventListener("submit", validar);
}())*/





$(document).ready(function(){
        var obj;
          loadTable($("#search").val());
           $(".cerrar").click(function(){
            $.ajax({
                url: 'http://comedor.undac.edu.pe/close/login/user/',
                method:'POST',        
                success: function(resp) {
                  setTimeout(function(){
                    location.reload();
                  }, 700);

                }
              });
        });

           
      
      });

      /*$('#botonhorario').on('click', function() {
        var $this = $('#botonhorario');
        var loadingText = '<i class="fa fa-spinner fa-spin"></i> loading...';
        //var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...'.attr('disabled', true);
        if ($(this).html() !== loadingText) {
          $this.data('original-text', $('#botonhorario').html());
          $this.html(loadingText);
          $('#botonhorario').attr('disabled', true);
        }
        setTimeout(function() {
          $this.html($this.data('original-text'));
          $('#botonhorario').attr('disabled', false);
        }, 2000);


    });*/
          
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
              /*loader botton*/
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

          url:'http://comedor.undac.edu.pe/create/horario/',
          type: 'POST',
          data: data,
          success: function(data){
           //console.log(data);
             showHoraryTable(JSON.parse(data));

             $("#tipo").val("");
             $("#horainicio").val("");
             $("#horafin").val("");
             $("#cantidad").val("");
          }
        })
        .done(function() {
          //$('#botonhorario').attr(reset);
            cleanFormulario();
            alertify.success('Horario Agregado con Exito¡'); 

            $('#botonhorario').html('Guardar').attr('disabled', false);
             /*setTimeout(function () {
                   $('#botonhorario').button('reset');
            }, 1000);*/

             /*$('#botonhorario').button('loading').delay(1000).queue(function() {
            $('#botonhorario').button('reset');
            $('#botonhorario').dequeue();
               }); */
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
           url: 'http://comedor.undac.edu.pe/update/horario/',
           type: 'POST',
           data: data,
           success: function(data){

            //console.log(data);
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
            url: 'http://comedor.undac.edu.pe/delete/horario/',
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

            url:'http://comedor.undac.edu.pe/obtener/horario/',
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
          url: 'http://comedor.undac.edu.pe/horario/dato/todo/', 
          data: {search: search},
          type: 'POST', 
          beforeSend: function(){
              document.getElementById('mostrar_loadingH').style.display = 'block';
              document.getElementById('tbodyHorario').style.display = 'none';
          },
          success: function(resp){
            document.getElementById('mostrar_loadingH').style.display = 'none';
              document.getElementById('tbodyHorario').style.display = '';
            //solvet = JSON.parse(resp);
            //solvet = solvet[0];
            //console.log();
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
                "<td style=\"padding-top: 10px; padding-bottom: 10px; padding-right: 0px; padding-left: 10px;\"><a data-toggle='tooltip' data-placement='top' title='modificar' onclick='recuperardato("+value.id+",\"modify"+cont+"\")' style='margin-right:5px' class='modify btn btn-primary btn-sm' href=\"#\" id='modify"+cont+"'> <i style='color:#fff' class='fas fa-edit'></i> </a><a data-toggle='tooltip' data-placement='top' title='eliminar' onclick='deleteHorario("+value.id+",\"delete"+cont+"\")' style='margin-right:5px' class='btn btn-danger btn-sm' href=\"#\" id='delete"+cont+"'>             <i style='color:#fff' class='fas fa-trash-alt'></i></a></td>");

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
            url:'http://comedor.undac.edu.pe/obtener/horario/',
            type: 'POST',
            data:{id:id},
            beforeSend: function(data){
                  capturar(obj);
            },
            success: function(data){

              console.log(data);
              var array_json=JSON.parse(data);

              $("#tipo").val(array_json["type"]);
              $("#horainicio").val(array_json["food_start"]);
              $("#horafin").val(array_json["food_end"]);
              $("#cantidad").val(array_json["cant"]);
              $("#botonhorario").attr('data-pid', array_json["id"]);
              removeCapturar(obj,target,id);

              //alert(array_json["cant"]);
            }

          });
          console.log(target);
      }

      function cleanFormulario() {
        $("#formHorario .is-valid").each(function(){
          $(this).attr('class', 'form-control');
          
        });

        $("#formHorario .is-invalid").each(function(){
          $(this).attr('class', 'form-control');
          
        });
        
      }
      $(document).ready(function(){
         $('#calendarioWeb').fullCalendar({

          header:{
            left:'today, prev, next',
            center:'title',
            right:'month, basicWeek, basicDay'
          },
          dayClick:function(date, jsEvent, view){

            //alert("valor seleccionado: "+date.format());
            //alert("Vista actual "+view.name);
            //$(this).css('background-color','red');
            $('#modalReserva').modal();

          }
         });     
      });

    function capturar(elemento){
     //alert(elemento);
            elemento.html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>');
            elemento.css({
              "cursor": 'not-allowed'
            });

            elemento.removeAttr("onclick"); 


          }
      function removeCapturar(elemento,target,id){
        //alert(elemento);

        elemento.html('<i style="color:#fff" class="fas fa-edit"></i>');
        elemento.css({
          "cursor": 'pointer'
        });
        elemento.attr("onclick","recuperardato("+id+",\""+target+"\")"); 
    }

    function removeCapturarD(elemento,target,id){
        //alert(elemento);

        elemento.html('<i style="color:#fff" class="fas fa-trash-alt"></i>');
        elemento.css({
          "cursor": 'pointer'
        });
        elemento.attr("onclick","deleteHorario("+id+",\""+target+"\")"); 
    }