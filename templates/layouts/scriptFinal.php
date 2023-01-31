<script src="calendar/lib/jquery.min.js"></script>
<script src="calendar/lib/jquery-ui.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="js/principal.js"></script>
<!--<script src="html/js/jscriptMenuSemanal.js"></script>-->

<!-- version 3.8.2-->
<script src='calendar/lib/moment.min.js'></script>
<script src='calendar/fullcalendar.min.js'></script>
<script src="calendar/locale/es.js"></script>

<script src="js/validacion.js"></script>

<script src="alertify/alertify.min.js"></script>

<script src="js/password/password.js"></script>


<!--<script src="DataTables/js/jquery.dataTables.min.js"></script>
<script src="DataTables/js/dataTables.bootstrap4.min.js"></script>-->

<script>

    $(document).ready(function(){
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

        $("#formPassword").submit(function(e) {
            validar(e);

            var valid = true;
            $("#formPassword .is-invalid").each(function() {
                valid = false;
            });
            e.preventDefault();

            if (valid) {
                changePassword();
            }
        });

        //$('#accordion').draggable();
    });
    
    function changePassword() {
        var data = $("#formPassword").serialize();
        $.ajax({
            url: 'login/changePassword/current/',
            type: 'POST',
            data: data,
            beforeSend : function(){
                $('#botonCambiarContrasena').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading').attr('disabled', true);
            },
            success: function(data) {
                var json = JSON.parse(data);
                if(json.state==0){
                    $('#botonCambiarContrasena').html('<i class="far fa-save"></i> Guardar').attr('disabled', false);
                    document.getElementById("passwordCurrent").className = "form-control is-invalid";
                    document.getElementById("currentPass").innerHTML = json.message;
                }else if(json.state==1){
                    $('#botonCambiarContrasena').html('<i class="far fa-save"></i> Guardar').attr('disabled', false);
                    alertify.success(json.message);
                    $("#modalpassword").modal('hide');
                    cleanModal();
                }
            }
        })
        .done(function() {
            //
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

    function cleanModal() {
        document.getElementById("formPassword").reset();
        $("#formPassword .is-valid").each(function(){
          $(this).attr('class', 'form-control');
        });

        $("#formPassword .is-invalid").each(function(){
          $(this).attr('class', 'form-control');
        });
    }


//enviar sugerencia



    <?php if ($_SESSION["role"] === "AL") {?>

         $("#formSugerencias").submit(function(e) {
          var form = $(this); // You need to use standard javascript object here
          var formData = new FormData(form[0]);


          var url = "sugerencias/create/";
          $.ajax({
                 type: "POST",
                 url: url,
                 data: formData,//$("#guardar").serialize(), 
                 contentType: false,
                 processData: false,
                 beforeSend: function() {
                    //$("guardar_datos").prop('disabled', true);
                    //$("guardar_datos").prop('text', "Guardando...");


                  },
                 success: function(data)
                 {
                     // alert(data);

                  //$("#resultados_ajax").html(data);
                    // alert(data); 
                    //load(1);
                 }
                   }).done( function() {
                       $('#modalNuevaSugerencia').modal('hide')
                       $(this).trigger("reset");
                       alertify.success("Gracias por enviarnos tu sugerencia.");
                  }).fail( function( jqXHR, textStatus, errorThrown ) {
                      if (jqXHR.status === 0) {
                        alertify.error('No Conectado: Verifique su conexión a Internet.');
                      }else if (jqXHR.status == 404) {
                        alertify.error('Error [404]: Página no encontrada.');
                      }else if (jqXHR.status == 500) {
                        alertify.error('Error [500]: Error Servidor Interno.');
                      }else if (textStatus === 'timeout') {
                        alertify.error('Error de tiempo de espera... :(');
                      }
                  });

          e.preventDefault(); 
        });



        var myVar = setInterval(blinkNuevaSugerencia, 1000);
        function blinkNuevaSugerencia() {

          var btnNuevaSugerencia=document.getElementById("btnNuevaSugerencia");
          btnNuevaSugerencia.classList.toggle('btn-success');


        }

       
    <?php }?>

  




</script>

<!-- <script src="http://localhost/comedor2/public/js/menu/menu.js"></script> -->

<!--select con busqueda
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>-->

<!--VERSION 4

 <script src='html/calendar/core/main.js'></script>
 <script src='html/calendar/daygrid/main.js'></script>
 <script src="html/calendar/core/locales/es.js"></script>-->
