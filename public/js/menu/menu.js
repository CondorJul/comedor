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



