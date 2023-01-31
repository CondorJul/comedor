  $(document).ready(function(){    
    getNov(false);
     $("#search").keyup(searching);
     $("body").on("click",".delete",executeDelete);
     $("body").on("click",".modifydata",executeModify);
     $("#sendNov").click(sendData);
     $("body").on("click",".state",changeState);
     var obj;

  });

  function executeModify(){
    obj = $(this);
     
    $.ajax({
          url: 'http://comedor.undac.edu.pe/novedades/update/specific/',
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

  function executeDelete()
  {
   let obj = $(this);
    $.ajax({
          url: 'http://comedor.undac.edu.pe/novedades/delete/specific/',
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
  function formatDate(date)
  {
    return date.substring(0,date.indexOf(" "));
  }

  function sendData(e)
  {
    $('#sendNov').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading').attr('disabled', true);
    e.preventDefault();   
        
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
          url: 'http://comedor.undac.edu.pe/create/novedad/',
          method:'POST',
          data:data,
          beforeSend: function(resp){
            console.log(resp);
          },
          success: function(resp) {

            
              $('#sendNov').html('Guardar').attr('disabled', false);
            resp = JSON.parse(resp); 
            obj = null;             
            if(resp.errorInfo){              
              alertify.error(resp.errorT+" "+resp.errorF+" "+resp.errorD);
            }else{
              restoreForm($("#formNovedades"));
              getNov(true);
              getNov(false); 
              alertify.success("Datos ingresados correctament!!!");
            }
                  
            
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
          url: 'http://comedor.undac.edu.pe/novedades/update/state/',
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
          url: 'http://comedor.undac.edu.pe/novedades/search/dato/',
          method:'POST',
          data:{search:$(this).val()},
          beforeSend: function(resp){
            
            document.getElementById('mostrar_loadingMN').style.display = 'block';
            document.getElementById('row_flags').style.display = 'none';
          },
          success: function(resp) {
           console.log('SS '+resp);
            document.getElementById('mostrar_loadingMN').style.display = 'none';
            document.getElementById('row_flags').style.display = '';
            let nod = "";
              var cont=0;
              $.each(JSON.parse(resp),function(index, value){           
                cont=cont+1;
              nod += '<tr class="'+state(value.state)+'"><td>'+index+'</td><td>'+value.title+'</td><td>'+formatDate(value.date_pub)+'</td><td class="text-justify">'+value.description+'</td><td style="width: 105px; padding-top: 10px; padding-bottom: 10px; padding-right: 0px; padding-left: 5px;"><a data-toggle="tooltip" data-state="'+encodeURIComponent(window.btoa(value.id))+'" data-status="'+encodeURIComponent(window.btoa(value.state))+'" data-placement="top" title="'+stateLeyend(value.state)+'" style="margin-right:5px" class="state btn '+stateBtn(value.state)+' btn-sm" href="#"><i style="color:#fff" class="fas fa-power-off"></i></a><a data-toggle="tooltip" data-placement="top" data-modify="'+encodeURIComponent(window.btoa(value.id))+'" title="modificar" style="margin-right:5px" class="modifydata modify'+i+' btn btn-primary btn-sm" href="#" ><i style="color:#fff" class="fas fa-edit"></i></a><a  data-toggle="tooltip" data-index="'+encodeURIComponent(window.btoa(value.id))+'" data-placement="top" title="eliminar" style="margin-right:5px" class="delete btn btn-danger btn-sm" href="#"><i style="color:#fff" class="fas fa-trash-alt"></i></a></td></tr>';
              });
              $("#row_flags").html(nod);                            
          },
          error: function() {
            alertify.error('Surgio un Error...:(');            
          }
        });  
    }




function getNov(flag){

        let url = (flag)?'http://comedor.undac.edu.pe/novedades/dato/state/':'http://comedor.undac.edu.pe/novedades/dato/todo/';

        $.ajax({
          url: url,
          method:'POST',
          beforeSend: function(resp){
            console.log(resp);
            document.getElementById('mostrar_loadingN').style.display = 'block';
            document.getElementById('timeline-target').style.display = 'none';

            document.getElementById('mostrar_loadingMN').style.display = 'block';
            document.getElementById('row_flags').style.display = 'none';

          },
          success: function(resp) {
            document.getElementById('mostrar_loadingN').style.display = 'none';
            document.getElementById('timeline-target').style.display = 'block';

            document.getElementById('mostrar_loadingMN').style.display = 'none';
            document.getElementById('row_flags').style.display = '';

            if(flag)
            {
              let nodes = "";
              $.each(JSON.parse(resp),function(index, value){
                 nodes+='<li class='+format(index)+'><div class="timeline-badge primary"><a><i class="fas fa-clock" data-toggle="tooltip" data-placement="top" title="11 hours ago via Twitter" id=""></i></a></div><div class="timeline-panel"><article class="list-group-item"><div class="fondocollapse" style=""><header class="filter-header p-2" ><a href="#" data-toggle="collapse" data-target="#collapse'+index+'"><i class="icon-action fa fa-chevron-down text-white"></i><h4 class="title text-white">'+value.title+'</h4></a></header><h6 class="text-white p-2" style="margin: 0px;">fecha: '+formatDate(value.date_pub)+'</h6></div><div class="filter-content collapse px-3" id="collapse'+index+'"><p class="text-justify">'+value.description+'</p></div></article><div class="timeline-footer"><a class="pull-right" data-toggle="collapse" data-target="#collapse'+index+'">Ver más...</a></div></div></li>';
              
              });  
              $("#timeline-target").html(nodes+'<li class="clearfix" style="float: none;"></li>');

            }else{
              
              let nod = "";
              cont=0;
              $.each(JSON.parse(resp),function(index, value){                
              cont=cont+1;
              nod += '<tr class="'+state(value.state)+'"><td>'+index+'</td><td>'+value.title+'</td><td>'+formatDate(value.date_pub)+'</td><td class="text-justify">'+value.description+'</td><td style="width: 105px; padding-top: 10px; padding-bottom: 10px; padding-right: 0px; padding-left: 5px;"><a data-toggle="tooltip" data-state="'+encodeURIComponent(window.btoa(value.id))+'" data-status="'+encodeURIComponent(window.btoa(value.state))+'" data-placement="top" title="'+stateLeyend(value.state)+'" style="margin-right:5px" class="state btn '+stateBtn(value.state)+' btn-sm" href="#"><i style="color:#fff" class="fas fa-power-off"></i></a><a data-toggle="tooltip" data-placement="top" data-modify="'+encodeURIComponent(window.btoa(value.id))+'" title="modificar" style="margin-right:5px" class="modifydata btn btn-primary btn-sm" href="#" id="modify'+cont+'"><i style="color:#fff" class="fas fa-edit"></i></a><a  data-toggle="tooltip" data-index="'+encodeURIComponent(window.btoa(value.id))+'" data-placement="top" title="eliminar" style="margin-right:5px" class="delete btn btn-danger btn-sm" href="#"><i style="color:#fff" class="fas fa-trash-alt"></i></a></td></tr>';
              });
              $("#row_flags").html(nod);

            }            
            
            
          },
          error: function() {
            alertify.error('Surgio un Error...:(');  
          }
        });


    }
  function format(index){return (index%2 == 0)?'':'timeline-inverted';    }
  function state(index){return (index)?'':'table-danger';    }
  function stateBtn(index){return (index)?'btn-success':'btn-warning';}
  function stateLeyend(index){return (index)?'Descactivar':'Activar';}
  
  $(document).ready(function(){
  var my_posts = $("[rel=tooltip]");
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
  getNov(true);

  var size = $(window).width();
  for(i=0;i<my_posts.length;i++){
    the_post = $(my_posts[i]);

    if(the_post.hasClass('invert') && size >=767 ){
      the_post.tooltip({ placement: 'left'});
      the_post.css("cursor","pointer");
    }else{
      the_post.tooltip({ placement: 'rigth'});
      the_post.css("cursor","pointer");
    }
  }
});

  function restoreForm(form){
    $(':input', form).each(function() {
      var type = this.type;
      var tag = this.tagName.toLowerCase();
      //limpiamos los valores de los campos…
      if (type == 'text' || type == 'password' || type == 'date' || tag == 'textarea' )
      this.value = "";
      // excepto de los checkboxes y radios, le quitamos el checked
      // pero su valor no debe ser cambiado
      else if (type == 'checkbox' || type == 'radio')
      this.checked = false;
      // los selects le ponesmos el indice a -1
      else if (tag == 'select')
      this.selectedIndex = -1;
      });
  }

  function verifyForm(form){
    let back;
    $(':input', form).each(function() {
      var type = this.type;
      var tag = this.tagName.toLowerCase();
      let ts = $(this);
      //limpiamos los valores de los campos…
      if (type == 'text' || type == 'password' || type == 'date' || tag == 'textarea' || tag == 'select' || type == 'checkbox' || type == 'radio'){
        if(ts.val()){
          ts.removeClass("is-invalid"); 
          back = true;
        }else{          
          ts.addClass("is-invalid");
          back = false;
        }  
      }
    });
    return back;
  }

function capturar(elemento){
    //alert(elemento);
    elemento.html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>');
    elemento.css({
      "cursor": 'not-allowed'
    });
    elemento.removeClass('modify'); 
}
function removeCapturar(elemento){
    //alert(elemento);
    elemento.html('<i style="color:#fff" class="fas fa-edit"></i>');
    elemento.css({
      "cursor": 'pointer'
    });
    elemento.addClass('modify'); 
}