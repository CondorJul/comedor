<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Agregar Una Novedad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-8 offset-md-2 p-3">
            <form id="formNovedades">
              <div class="input-group input-group-sm mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text"><b>Titulo: </b></span>
                </div>
                <input type="text" class="form-control" name="titulo" id="titulo" onblur="revisar(this)" onkeyup="revisar(this)" required="">
                <div class="invalid-feedback">
                      <strong>El titulo</strong> es invalido
                </div>
              </div>
              <div class="input-group input-group-sm mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text"><b>Fecha: </b></span>
                </div>
                <input type="date" class="form-control" value="<?php echo date("Y-m-d");?>" name="fecha" id="fecha" required="" onblur="revisar(this)" onkeyup="revisar(this)">
                <div class="invalid-feedback">
                      <strong>la fecha</strong> es invalida
                </div>
              </div>
              <div class="input-group input-group-sm mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text"><b>Descripción: </b></span>
                </div>
                <textarea class="form-control" name="descripcion" id="descripcion" onblur="revisar(this)" onkeyup="revisar(this)" required=""></textarea>
                <div class="invalid-feedback">
                      <strong>La descripcion</strong> es invalida
                </div>
              </div>
              <div class="col-md-3 p-1">
                  <button type="button" class="btn btn-success pull-right btn-block"  id="sendNov">Guardar</button>
              </div>
          </form>  

          </div>
        </div>

        <div class="row">
          
            <div class="col-md-12">
            <div class="card">
              <h3 class="card-header text-center card-primary">Lista de Novedades <?php //echo $_SESSION["formulario"][1]["value"];
              //var_dump($_SESSION["token"]); ?><span class="fas fa-list-ol pull-right"></span></h3>
              <div class="card-block p-3">
                <input type="text" name="table_search" id="search" class="form-control" placeholder="Buscar por titulo" >
                <div class="card-body table-responsive p-0" id="tabla_resultado">
                  <table class="table table-hover table-bordered table-condensed" style="min-width: 850px;">
                    
                    <thead>
                      <tr>
                        <th style="width:20px">COD</th>
                        <th style="width:35px">titulo</th>
                        <th style="width:60px">Fecha</th>
                        <th style="width:60px">Descripcion</th>
                        <th style="width:30px">ACCIONES</th>
                      </tr>
                    </thead>
                    <tbody id="row_flags">
                      
                      <!-- <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td style="padding-top: 10px; padding-bottom: 10px; padding-right: 0px; padding-left: 10px;">
                            <a data-toggle='tooltip' data-placement='top' title='Descactivar' style='margin-right:5px' class='btn btn-warning btn-sm' href="#">
                                <i style='color:#fff' class='fas fa-power-off'></i>
                            </a>
                          <a data-toggle='tooltip' data-placement='top' title='modificar' style='margin-right:5px' class='btn btn-primary btn-sm' href="#">
                                <i style='color:#fff' class='fas fa-edit'></i>
                            </a>

                            <a data-toggle='tooltip' data-placement='top' title='eliminar' style='margin-right:5px' class='btn btn-danger btn-sm' href="#">
                                <i style='color:#fff' class='fas fa-trash-alt'></i>
                            </a>
                            </td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td style="padding-top: 10px; padding-bottom: 10px; padding-right: 0px; padding-left: 10px;">
                            <a data-toggle='tooltip' data-placement='top' title='Descactivar' style='margin-right:5px' class='btn btn-warning btn-sm' href="#">
                                <i style='color:#fff' class='fas fa-power-off'></i>
                            </a>
                          <a data-toggle='tooltip' data-placement='top' title='modificar' style='margin-right:5px' class='btn btn-primary btn-sm' href="#">
                                <i style='color:#fff' class='fas fa-edit'></i>
                            </a>

                            <a data-toggle='tooltip' data-placement='top' title='eliminar' style='margin-right:5px' class='btn btn-danger btn-sm' href="#">
                                <i style='color:#fff' class='fas fa-trash-alt'></i>
                            </a>
                            </td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td style="height:110%; padding-top: 10px; padding-bottom: 10px; padding-right: 0px; padding-left: 10px;">
                            <a data-toggle='tooltip' data-placement='top' title='Descactivar' style='margin-right:5px' class='btn btn-warning btn-sm' href="#">
                                <i style='color:#fff' class='fas fa-power-off'></i>
                            </a>
                          <a data-toggle='tooltip' data-placement='top' title='modificar' style='margin-right:5px' class='btn btn-primary btn-sm' href="#">
                                <i style='color:#fff' class='fas fa-edit'></i>
                            </a>

                            <a data-toggle='tooltip' data-placement='top' title='eliminar' style='margin-right:5px' class='btn btn-danger btn-sm' href="#">
                                <i style='color:#fff' class='fas fa-trash-alt'></i>
                            </a>
                            </td>
                      </tr> -->
                    </tbody>
                  </table>
                        <div id="mostrar_loadingMN" style="display: block;">
                          <?php include "../templates/layouts/loading.html"; ?>
                        </div>
                </div>
                           
              </div>
            </div>

            </div>
        

        </div>
         
 



      </div>  
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){    
    getNov(false);
     $("#search").keyup(searching);
     $("body").on("click",".delete",executeDelete);
     $("body").on("click",".modify",executeModify);
     $("#sendNov").click(sendData);
     $("body").on("click",".state",changeState);
     var obj;

  });

  function executeModify(){
    obj = $(this);
     
    $.ajax({
          url: 'novedades/update/specific/',
          method:'POST',
          data:{token:obj.data("modify")},
          beforeSend: function(resp){

            capturar(obj);
          },
          success: function(resp) {
            resp = JSON.parse(resp);            
             $("#formNovedades #titulo").val(resp[0].title);
             $("#formNovedades #fecha").val(formatDate(resp[0].date_pub));
             $("#formNovedades #descripcion").val(resp[0].description); 
             removeCapturar(obj);    
          },
          error: function(jqXHR, textStatus, errorThrown) {

            if (jqXHR.status === 0) {
              alertify.error('No Conectado: Verifique su conexión a Internet.');
               removeCapturar(obj); 
            }else if (jqXHR.status == 404) {
              alertify.error('Error [404]: Página no encontrada.');
            }else if (jqXHR.status == 500) {
              alertify.error('Error [500]: Error Servidor Interno.');
            }else if (textStatus === 'timeout') {
              alertify.error('Error de tiempo de espera... :(');
            }      
          
            //alertify.error('Surgio un Error...:(');  
          }

        });
  }

  function executeDelete(){
   let obj = $(this);
            var des=confirm('¿Estás seguro de querer eliminar?');
            if (des == true) {
    $.ajax({
          url: 'novedades/delete/specific/',
          method:'POST',
          data:{token:obj.data("index")},
          beforeSend: function(resp){
            capturar(obj);
          },
          success: function(resp){
            resp = JSON.parse(resp);            
            if(resp.flag){
                obj.parent().parent().remove();                 
                alertify.success(resp.information);  
                getNov(true);                 
             }else{
                alertify.success(resp.information); 
             }  
             removeCapturar(obj);              
          },
          error: function(jqXHR, textStatus, errorThrown) {

            if (jqXHR.status === 0) {
              alertify.error('No Conectado: Verifique su conexión a Internet.');
              removeCapturar(obj);
            }else if (jqXHR.status == 404) {
              alertify.error('Error [404]: Página no encontrada.');
            }else if (jqXHR.status == 500) {
              alertify.error('Error [500]: Error Servidor Interno.');
            }else if (textStatus === 'timeout') {
              alertify.error('Error de tiempo de espera... :(');
            }      
          
            //alertify.error('Surgio un Error...:(');  
          }
        });
    }
  }

  function formatDate(date){
    return date.substring(0,date.indexOf(" "));
  }

  function sendData(e){
    $('#sendNov').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading').attr('disabled', true);

    e.preventDefault();   
        cleanFormulario();

    if(verifyForm($("#formNovedades")))
    {
      let data;
      try {
        data = {
            token : obj.data("modify"),
            form  : $("#formNovedades").serializeArray()
        };
      } catch(e) {
        data = {form: $("#formNovedades").serializeArray()};
      }      

      $.ajax({
          url: 'create/novedad/',
          method:'POST',
          data:data,
          beforeSend: function(resp){
            console.log(resp);
          },
          success: function(resp){

            
            $('#sendNov').html('Guardar').attr('disabled', false);
            resp = JSON.parse(resp); 
            obj = null;             
            if(resp.errorInfo){              
              alertify.error(resp.errorT+" "+resp.errorF+" "+resp.errorD);
            }else{
              restoreForm($("#formNovedades"));
              //$("#titulo").val("");
              //$("#descripcion").val("");

              getNov(true);
              getNov(false); 
              alertify.success("Datos ingresados correctament!!!");
            }
                  
            returndate();
          },
          error: function(jqXHR, textStatus, errorThrown) {

            if (jqXHR.status === 0) {
              alertify.error('No Conectado: Verifique su conexión a Internet.');
              $('#sendNov').html('Guardar').attr('disabled', false);
            }else if (jqXHR.status == 404) {
              alertify.error('Error [404]: Página no encontrada.');
            }else if (jqXHR.status == 500) {
              alertify.error('Error [500]: Error Servidor Interno.');
            }else if (textStatus === 'timeout') {
              alertify.error('Error de tiempo de espera... :(');
            }      
          
            //alertify.error('Surgio un Error...:(');  
          }
        });
    }else{
      $('#sendNov').html('Guardar').attr('disabled', false);
      alertify.error('Ingrese los datos correctos porfavor!!!'); 
    }
    
  }

  function changeState(){
    $.ajax({
          url: 'novedades/update/state/',
          method:'POST',
          data:{token:$(this).data("state"),state:$(this).data("status")},
          beforeSend: function(resp){
            console.log(resp);
          },
          success: function(resp) {
           //console.log(resp);
           alertify.success(resp);           
            getNov(false);   
            getNov(true);             
          },
          error: function() {
            alertify.error('Surgio un Error...:(');            
          }

        });
    }

    function searching(){
      //alertify.success($(this).val());
      $.ajax({
          url: 'novedades/search/dato/',
          method:'POST',
          data:{search:$(this).val()},
          beforeSend: function(resp){
            console.log(resp);
            document.getElementById('mostrar_loadingMN').style.display = 'block';
            document.getElementById('row_flags').style.display = 'none';
          },
          success: function(resp) {
           console.log(resp);
            document.getElementById('mostrar_loadingMN').style.display = 'none';
            document.getElementById('row_flags').style.display = '';
            let nod = "";
              var cont=0;
              $.each(JSON.parse(resp),function(index, value){           
                cont=cont+1;
              nod += '<tr class="'+state(value.state)+'"><td>'+index+'</td><td>'+value.title+'</td><td>'+formatDate(value.date_pub)+'</td><td class="text-justify">'+value.description+'</td><td style="width: 105px; padding-top: 10px; padding-bottom: 10px; padding-right: 0px; padding-left: 5px;"><a data-toggle="tooltip" data-state="'+encodeURIComponent(window.btoa(value.id))+'" data-status="'+encodeURIComponent(window.btoa(value.state))+'" data-placement="top" title="'+stateLeyend(value.state)+'" style="margin-right:5px" class="state btn '+stateBtn(value.state)+' btn-sm" href="#"><i style="color:#fff" class="fas fa-power-off"></i></a><a data-toggle="tooltip" data-placement="top" data-modify="'+encodeURIComponent(window.btoa(value.id))+'" title="modificar" style="margin-right:5px" class="modify'+i+' btn btn-primary btn-sm" href="#" ><i style="color:#fff" class="fas fa-edit"></i></a><a  data-toggle="tooltip" data-index="'+encodeURIComponent(window.btoa(value.id))+'" data-placement="top" title="eliminar" style="margin-right:5px" class="delete btn btn-danger btn-sm" href="#"><i style="color:#fff" class="fas fa-trash-alt"></i></a></td></tr>';
              });
              $("#row_flags").html(nod);                            
          },
          error: function() {
            alertify.error('Surgio un Error...:(');            
          }
        });  
    }
  
    function cleanFormulario() {
        $("#formNovedades .is-valid").each(function(){
          $(this).attr('class', 'form-control');
          
        });

        $("#formNovedades .is-invalid").each(function(){
          $(this).attr('class', 'form-control');
          
        });
        
      }

      function returndate(){
          var fecha = new Date(); //Fecha actual
        var mes = fecha.getMonth()+1; //obteniendo mes
        var dia = fecha.getDate(); //obteniendo dia
        var ano = fecha.getFullYear(); //obteniendo año
        if(dia<10)
          dia='0'+dia; //agrega cero si el menor de 10
        if(mes<10)
          mes='0'+mes //agrega cero si el menor de 10
        document.getElementById("fecha").value=ano+"-"+mes+"-"+dia;
      }

  
</script>
<!--<div class="modal fade" id="exampleModal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        
        <div class="modal-body">
          Modal body..
        </div>
        
       
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>-->