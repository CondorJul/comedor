<div id="rankingMenu" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Calificacion de Menú</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="height: 430px;  width: 100%;  overflow-y: auto;">
          <div class="card-body table-responsive p-0">
            <table class="table table-hover table-bordered table-condensed" id="tablePuntuacion" name="tableUni" style="overflow-y: auto">
              <thead class="theadPuntuacion">
                <tr>
                  <th scope="col" class="text-center">Fecha</th>
                  <th scope="col" class="text-center">Tipo Menú</th>
                  <th scope="col" class="text-center">Puntuación</th>
                </tr>
              </thead>
              <tbody id="tbodyPuntuacion">
              </tbody>
            </table>
            <div id="mostrar_loadingH" style="display: none;">
              <?php include "../templates/layouts/loading.html";?>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
    listMenuPunctuacion();

    $(document).on("click", ".radioEstrellas", sendPunctuation);
    $(document).on("click", "#botonComentario", sendComments);
    
  });

  function listMenuPunctuacion(){
    $.ajax({
      url: 'obtener/lista/puntuaciones',
      beforeSend: function(){
        document.getElementById('mostrar_loadingH').style.display = 'block';
        document.getElementById('tbodyPuntuacion').style.display = 'none';
      },
      success: function(data){
        document.getElementById('mostrar_loadingH').style.display = 'none';
        document.getElementById('tbodyPuntuacion').style.display = '';
        var resul = JSON.parse(data);
        $("#tbodyPuntuacion").html("");
        //console.log(resul);
        var cont=0;
        var r=0;
        $.each(resul, function(index, val) {
          var tr = $("<tr />");
          cont++;
          $.each(val, function(k, v) {
            if (k!='id_menu') {
              tr.append(
                $("<td />",{
                  html: v
                })[0].outerHTML
              );
            }
          });
          tr.append("<td>"+
            "<p class=\"clasificacion\">"+
              "<input class=\"radioEstrellas\" id=\"radio"+(r)+"\" type=\"radio\" name=\"estrellas"+cont+"\" value=\"5\" data-id_menu=\""+encodeURIComponent(window.btoa(val.id_menu))+"\" data-num=\""+cont+"\">"
              +"<label for=\"radio"+(r++)+"\" style='margin: 0px;'>★</label>"
              +"<input class=\"radioEstrellas\" id=\"radio"+(r)+"\" type=\"radio\" name=\"estrellas"+cont+"\" value=\"4\" data-id_menu=\""+encodeURIComponent(window.btoa(val.id_menu))+"\" data-num=\""+cont+"\">"
              +"<label for=\"radio"+(r++)+"\" style='margin: 0px;'>★</label>"
              +"<input class=\"radioEstrellas\" id=\"radio"+(r)+"\" type=\"radio\" name=\"estrellas"+cont+"\" value=\"3\" data-id_menu=\""+encodeURIComponent(window.btoa(val.id_menu))+"\" data-num=\""+cont+"\"> "
              +"<label for=\"radio"+(r++)+"\" style='margin: 0px;'>★</label>"
              +"<input class=\"radioEstrellas\" id=\"radio"+(r)+"\" type=\"radio\" name=\"estrellas"+cont+"\" value=\"2\" data-id_menu=\""+encodeURIComponent(window.btoa(val.id_menu))+"\" data-num=\""+cont+"\">"
              +"<label for=\"radio"+(r++)+"\" style='margin: 0px;'>★</label>"
              +"<input class=\"radioEstrellas\" id=\"radio"+(r)+"\" type=\"radio\" name=\"estrellas"+cont+"\" value=\"1\" data-id_menu=\""+encodeURIComponent(window.btoa(val.id_menu))+"\" data-num=\""+cont+"\">"
              +"<label for=\"radio"+(r++)+"\" style='margin: 0px;'>★</label>"
            +"</p>"
            +"</td>");
          $("#tbodyPuntuacion").append(tr, "<tr><td colspan='4' style='padding: 0px'><div class='input-group' style='padding-left: 5px; padding-right: 5px;'><textarea class='comentario"+cont+" form-control' rows='1' style='display: none;' id='textArea"+cont+"' name='textArea"+cont+"'></textarea><div class='input-group-prepend'><button class='btn btn-success btnComent"+cont+"' type='button' id='botonComentario' name='botonComentario' style='display:none;' data-bid_menu='"+encodeURIComponent(window.btoa(val.id_menu))+"' data-bnum='"+cont+"'>Enviar</button></div></div></td></tr>");
        });
        if (resul.length==0){
          $("#tbodyPuntuacion").html("<tr><td colspan='4'><h5 class=\"alert alert-danger\" style='margin-bottom:4px;'>NO HA ENCONTRADO COINCIDENCIAS</h5></td></tr>");
        }
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

  function sendPunctuation(){
    $(".comentario"+$(this).data("num")).css({"display": "block", "margin": "5px 0px 5px 0px"});
    $(".btnComent"+$(this).data("num")).css({"display": "block", "margin": "5px 0px 5px 0px"});
    clean($(this).data("num"));

    let data={score: $(this).val(), id_menu: $(this).data("id_menu")};
    $.ajax({
      url: 'usuario/send/punctuationMenu/',
      type: 'POST',
      data: data,
      success: function(data){
        alertify.success(data);
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

  function sendComments(){
    var comment = document.getElementById("textArea"+$(this).data("bnum")).value;

    let data={comment: comment, id_menu: $(this).data("bid_menu")};
    $.ajax({
      url: 'usuario/send/commentsMenu/',
      type: 'POST',
      data: data,
      success: function(data){
        alertify.success(data);
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

  function count(){
    $.ajax({
      url: 'usuario/count/listMenu/',
      success: function(data){
        var resul = JSON.parse(data);
        console.log(resul);
        if (resul[0].cont!=0) {
          listMenuPunctuacion();
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

  function clean(num) {
    c=0;
    $(".form-control").each(function(){
      if (c!=num) {
        $(".comentario"+c).css({"display": "none"});
        $(".btnComent"+c).css({"display": "none"});
      }
      c++;
    });
  }

</script>