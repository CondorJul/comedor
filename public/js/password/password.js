$(document).ready(function() {});
    var validar = function(e) {
    revisarFormPassword(e);
}

function revisarFormPassword(e) {
    var formulario = document.getElementsByName('formPassword')[0];
    elementos = formulario.elements;
    if (formulario.passwordCurrent.value == null || formulario.passwordCurrent.value.length == 0 || /^\s+$/.test(formulario.passwordCurrent.value)) {
        formulario.passwordCurrent.className = 'form-control is-invalid';
        e.preventDefault();
    } else {
        formulario.passwordCurrent.className = 'form-control is-valid';
    }
    if (formulario.passwordNew.value == null || formulario.passwordNew.value.length == 0 || /^\s+$/.test(formulario.passwordNew.value)) {
        formulario.passwordNew.className = 'form-control is-invalid';
        e.preventDefault();
    } else {
        formulario.passwordNew.className = 'form-control is-valid';
    }
    if (formulario.passwordVerify.value == null || formulario.passwordVerify.value.length == 0 || /^\s+$/.test(formulario.passwordVerify.value)) {
        formulario.passwordVerify.className = 'form-control is-invalid';
        e.preventDefault();
    } else if (formulario.passwordNew.value != formulario.passwordVerify.value) {
        formulario.passwordVerify.className = 'form-control is-invalid';
        e.preventDefault();
        document.getElementById("verifyPass").innerHTML = "Las contraseñas no coinciden";
    } else {
        formulario.passwordVerify.className = 'form-control is-valid';
    }
    /*if (formulario.passwordNew.value !== formulario.passwordVerify.value) {
        formulario.passwordVerify.className = 'form-control is-invalid';
        formulario.verifyPass.html("hollaaaaaaaa");
        e.preventDefault();
    }else{
        formulario.passwordVerify.className = 'form-control is-valid';
    }*/
}