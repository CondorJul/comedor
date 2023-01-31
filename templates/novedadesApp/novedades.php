<!DOCTYPE html>
<html lang="es">
	<?php include "../templates/layouts/head1.php"; ?>
<body class="app sidebar-mini rtl" style="min-width: 280px;">

  <!-- <div>
	<?php //include "../templates/layouts/loading.html"; ?>
</div> -->
  <main class="" style="padding: 10px 25px;">

  
    <div class="">

      <div class="row">
        <div class="col-12" style="padding: 0px;">
          <div class="card novedades">
            <h3 class="card-header text-center card-primary">NOVEDADES
              <button type="button" class="btn btn-primary pull-right d-none d-sm-none d-md-block d-lg-block d-xl-block" data-toggle="modal" data-target="#modalreglamento" style="margin-left: 5px;">REGLAMENTOS</button>
            
            
            <button type="button" class="btn btn-primary pull-right d-block d-sm-block d-md-none d-lg-none d-xl-none" data-toggle="modal" data-target="#modalreglamento" data-placement='top' title='REGLAMENTO' style="margin-left: 5px;"><i class="far fa-address-book"></i></button><span class="fas fa-credit-card pull-left"></span></h3>

              <div class="card-block p-3">
                  <div class="list-group filter-wrap">
                  
                    <!--<article class="list-group-item">
                      <header class="filter-header">
                        <a href="#" data-toggle="collapse" data-target="#collapse3">
                          <i class="icon-action fa fa-chevron-down"></i>
                          <h4 class="title">Titulo de novedad </h4>
                          <h6>fecha: 12-12-2019</h6>
                        </a>
                      </header>
                      <div class="filter-content collapse" id="collapse3">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
                      </div>
                    </article>-->


                    <div class="page-header text-center">
                        <h1 id="timeline"></h1>
                    </div>

                       <div id="mostrar_loadingN" style="display: none;">
                          <?php include "../templates/layouts/loading.html"; ?>
                        </div>
                      <ul class="timeline" id="timeline-target">

                       

                         <!-- <li>
                            <div class="timeline-badge primary"><a><i class="fas fa-clock" data-toggle='tooltip' data-placement='top' title="11 hours ago via Twitter" id=""></i></a></div>
                            <div class="timeline-panel">
                               
                                <article class="list-group-item">
                                  <div class="fondocollapse" style="">
                                  <header class="filter-header p-2" >
                                    <a href="#" data-toggle="collapse" data-target="#collapse3">
                                      <i class="icon-action fa fa-chevron-down"></i>
                                      <h4 class="title text-white">Reparticion de panetones por fin de año</h4>
                                  
                                    </a>
                                  </header>
                                  
                                  <h6 class="text-white p-2" style="margin: 0px;">fecha: 12-12-2019</h6>
                                  </div>

                                  <div class="filter-content collapse show px-3" id="collapse3">
                                    <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
                                  </div>
                                </article>
                           
                              <div class="timeline-footer">
                                  
                                  <a class="pull-right" data-toggle="collapse" data-target="#collapse3">Continuar Lendo</a>
                              </div>
                            </div>
                          </li>
                          
                          <li class="timeline-inverted">
                            <div class="timeline-badge primary"><a><i class="fas fa-clock" data-toggle='tooltip' data-placement='top' title="11 hours ago via Twitter" id=""></i></a></div>
                            <div class="timeline-panel">
                               
                                <article class="list-group-item">
                                  <div class="fondocollapse" style="">
                                  <header class="filter-header p-2" >
                                    <a href="#" data-toggle="collapse" data-target="#collapse4">
                                      <i class="icon-action fa fa-chevron-down"></i>
                                      <h4 class="title text-white">Reparticion de panetones por fin de año</h4>
                                  
                                    </a>
                                  </header>
                                  
                                  <h6 class="text-white p-2" style="margin: 0px;">fecha: 12-12-2019</h6>
                                  </div>

                                  <div class="filter-content collapse show px-3" id="collapse4">
                                    <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
                                  </div>
                                </article>
                           
                              <div class="timeline-footer">
                                  
                                  <a class="pull-right" data-toggle="collapse" data-target="#collapse4">Continuar Lendo</a>
                              </div>
                            </div>
                          </li>  -->                        
                         
                          
                      </ul>




              </div>  

          </div>

        </div>

      </div>
     	
		</div>
  </main>

	<?php include "../templates/layouts/scriptFinal.php"; ?>
  
  <?php include "../templates/novedades/modal/modalReglamento.php"; ?>
</body>
</html>

<script type="text/javascript">

    function getNov(flag){

        let url = (flag)?'novedades/dato/state/':'novedades/dato/todo/';

        $.ajax({
          url: url,
          method:'POST',
          beforeSend: function(resp){
            console.log(resp);
            document.getElementById('mostrar_loadingN').style.display = 'block';
            document.getElementById('timeline-target').style.display = 'none';

            //document.getElementById('mostrar_loadingMN').style.display = 'block';
            //document.getElementById('row_flags').style.display = 'none';

          },
          success: function(resp) {
            document.getElementById('mostrar_loadingN').style.display = 'none';
            document.getElementById('timeline-target').style.display = 'block';

            //document.getElementById('mostrar_loadingMN').style.display = 'none';
            //document.getElementById('row_flags').style.display = '';

            if(flag)
            {
              let nodes = "";
              $.each(JSON.parse(resp),function(index, value){
                 nodes+='<li class='+format(index)+'><div class="timeline-badge primary"><a><i class="fas fa-clock" data-toggle="tooltip" data-placement="top" title="'+ moment(value.date_pub).format('YYYY/MM/DD HH:mm:ss')+'" id=""></i></a></div><div class="timeline-panel"><article class="list-group-item"><div class="fondocollapse" style=""><header class="filter-header p-2"><a href="#"  data-toggle="collapse" data-target="#collapse'+index+'" style="text-decoration:none;"><i class="icon-action fa fa-chevron-down text-white"></i><h4 class="title text-white">'+value.title+'</h4></a></header><h6 class="text-white p-2" style="margin: 0px;">fecha: '+ moment(value.date_pub).format('YYYY/MM/DD HH:mm:ss')+'</h6></div><div class="filter-content collapse show px-3" id="collapse'+index+'"><p class="text-justify">'+value.description+'</p></div></article><div class="timeline-footer"><a class="pull-right" data-toggle="collapse" data-target="#collapse'+index+'">Ver más...</a></div></div></li>';
              
              });  
              $("#timeline-target").html(nodes+'<li class="clearfix" style="float: none;"></li>');
            }else{
              
              /*let nod = "";
              cont=0;
              $.each(JSON.parse(resp),function(index, value){                
              cont=cont+1;
              nod += '<tr class="'+state(value.state)+'"><td>'+index+'</td><td>'+value.title+'</td><td>'+formatDate(value.date_pub)+'</td><td class="text-justify">'+value.description+'</td><td style="width: 105px; padding-top: 10px; padding-bottom: 10px; padding-right: 0px; padding-left: 5px;"><a data-toggle="tooltip" data-state="'+encodeURIComponent(window.btoa(value.id))+'" data-status="'+encodeURIComponent(window.btoa(value.state))+'" data-placement="top" title="'+stateLeyend(value.state)+'" style="margin-right:5px" class="state btn '+stateBtn(value.state)+' btn-sm" href="#"><i style="color:#fff" class="fas fa-power-off"></i></a><a data-toggle="tooltip" data-placement="top" data-modify="'+encodeURIComponent(window.btoa(value.id))+'" title="modificar" style="margin-right:5px" class="modify btn btn-primary btn-sm" href="#" id="modify'+cont+'"><i style="color:#fff" class="fas fa-edit"></i></a><a  data-toggle="tooltip" data-index="'+encodeURIComponent(window.btoa(value.id))+'" data-placement="top" title="eliminar" style="margin-right:5px" class="delete btn btn-danger btn-sm" href="#"><i style="color:#fff" class="fas fa-trash-alt"></i></a></td></tr>';
              });
              $("#row_flags").html(nod);*/

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
  $("#close").click(function(){
      
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

  /*function restoreForm(form){
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
  }*/

  /*function verifyForm(form){
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
  }*/
function formatDate(date)
  {
    return date.substring(0,date.indexOf(" "));
  }
/*function capturar(elemento){
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
}*/

</script>
