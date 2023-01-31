function revisar(elemento){
    if (elemento.value==null || elemento.value.length == 0 || /^\s+$/.test(elemento.value)) {
        elemento.className='form-control is-invalid';
    }else{
        elemento.className='form-control is-valid';
    }
}

function revisar1(elemento){
  if (elemento.value==null) { 
  }else{
    elemento.className='form-control is-valid';
  }
}

function revisarNoObligatorio(elemento){
    if (/^\s+$/.test(elemento.value)){
        elemento.className='form-control is-invalid';
    }else{
        elemento.className='form-control is-valid';
    }

}

function existeFecha(elemento){
      var fechaf = elemento.value.split("-");
      var year = fechaf[0];
      var month = fechaf[1];
      var day = fechaf[2];

      var date = new Date(year,month,'0');
      //console.log(date);

      if((day-0)>(date.getDate()-0) || (year>='2050') || date=='Invalid Date'){
            
           elemento.className='form-control is-invalid';
           document.getElementById("finreserva").innerHTML = "El campo Fin Reserva debe ser MAYOR al campo Inicio Reserva";
      }
      else{
          
           elemento.className='form-control is-valid';

      }
    }
function validarNumero(elemento){

  console.log(elemento.value);
  if(elemento.value==null && elemento.value.length == 0 && /^\s+$/.test(elemento.value)) {
        
         elemento.className='form-control is-invalid';
  }else{
        var data=elemento.value; 
        if(!isNaN(data)){
          
          elemento.className='form-control is-invalid';
        }else{
          
          elemento.className='form-control is-valid';
        }
  }
}

function validarcantidad(elemento, cantidad){
  if(elemento.value!==''){
    var data = elemento.value;
    if (data.length > cantidad) {
      elemento.className='form-control is-invalid';
      document.getElementById("cantidadHorario").innerHTML = "El campo Cantidad solo acepta numeros menores que 999";
    }else{

      elemento.className='form-control is-valid';
    }
  }
}
function validarFormatoFecha(elemento) {
      //var exp = /^\d{1,2}\/\d{1,2}\/\d{2,4}$/;
      var data = elemento.value;
      if (!isNaN(data)){
            elemento.className='form-control is-invalid';
      } else {
            elemento.className='form-control is-valid';
      }
}