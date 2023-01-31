var validarReporte1 = function(e) {
    revisarReporte1(e); /*revisarFormulario2(e);*/
}

function revisarReporte1(e) {
    var formulario = document.getElementsByName('form_reporte')[0];
    elementos = formulario.elements;
    if (formulario.select_type_menu.value == null || formulario.select_type_menu.value.length == 0 || /^\s+$/.test(formulario.select_type_menu.value)) {
        formulario.select_type_menu.className = 'form-control is-invalid';
        e.preventDefault();
    } else {
        formulario.select_type_menu.className = 'form-control is-valid';
    }
    if (formulario.fecha.value == null || formulario.fecha.value.length == 0 || /^\s+$/.test(formulario.fecha.value)) {
        formulario.fecha.className = 'form-control is-invalid';
        e.preventDefault();
    } else {
        formulario.fecha.className = 'form-control is-valid';
    }
}

function revisarFormulario2(e) {
    var formulario = document.getElementsByName('form_reporte2')[0];
    elementos = formulario.elements;
    if (formulario.fechaCantidadReserva.value == null || formulario.fechaCantidadReserva.value.length == 0 || /^\s+$/.test(formulario.fechaCantidadReserva.value)) {
        formulario.fechaCantidadReserva.className = 'form-control is-invalid';
        e.preventDefault();
    } else {
        formulario.fechaCantidadReserva.className = 'form-control is-valid';
    }
}