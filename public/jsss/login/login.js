import { SERVER_ROUTE } from "../env";
$(document).ready(function(){
  var local = window.sessionStorage;
  var obj = $("#login");
  obj.find('input[name=user]').val(local.email);
  obj.find('select[name=role]').val(local.role); 
$("#login").submit(function(e) {
  e.preventDefault()
    let btn = obj.find("button[type=submit]");
    let tag = $(".messaje");    
    let user =  obj.find('input[name=user]');   
    let role =  obj.find('select[name=role]');  
    let password =  obj.find('input[name=password]');    
    local.email = user.val();
    local.role = role.val();    
  if(verifyForm(obj))
  {
      $.ajax({
            url: `${SERVER_ROUTE}/validate/login/user/`,
            method:'POST',
            data:obj.serialize(),
            beforeSend: function(resp){       
              
              btn.attr('disabled',true);
              btn.css({
                'cursor':'not-allowed'
              });
            },
            success: function(resp) {
             
              resp = $.parseJSON(resp);
              tag.removeClass("alert alert-warning");
              tag.removeClass(resp.remove);            

               tag.addClass(resp.alert);
               tag.html(resp.information);
              let validates=(resp.validate)?local.clear():'';
              setTimeout(function(){
                location.reload();
              }, 1000);     

              
            },
            error: function() {
               tag.removeClass("alert alert-warning");  
               tag.removeClass("alert alert-success");  
               tag.addClass("alert alert-danger");
               tag.html("No se ha podido obtener la información"); 
               btn.removeAttr('disabled');
               btn.css({
                'cursor':'default'
              });
              
            }
          });
   }else{
     tag.removeClass("alert alert-danger");  
     tag.removeClass("alert alert-success");  
     tag.addClass("alert alert-warning");
     tag.html('Ingrese los datos correctos porfavor!!!'); 

    }

});

});



function verifyForm(form){
    let back;
    $(':input', form).each(function() {
      var type = this.type;
      var tag = this.tagName.toLowerCase();
      let ts = $(this);
      
      if (type == 'text' || type == 'password' || type == 'date' || tag == 'textarea' || tag == 'select' || type == 'checkbox' || type == 'radio' || type == 'number'){
        if(ts.val()){
          ts.removeClass("is-invalid"); 
          back = true;
        }else{          
          ts.addClass("is-invalid");
          back = false;
        }  

      }

      if(!back){
        return back;
      }


    });

    return back;
  }

