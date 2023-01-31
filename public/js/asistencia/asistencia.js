$(document).ready(function() {
    //var formulario = document.getElementsByName('forma_asistencia')[0];
    //elementos=formulario.elements;
    //formulario.addEventListener("submit", validarAssit);
});
var validarAssit = function(e) {
    revisarDato(e);
}
var validarFormCerrarMenu = function(e) {
    revisarFormCerrarMenu(e);
}

function revisarFormCerrarMenu(e) {
    var formCerrar = document.getElementsByName('formCerrarMenu')[0];
    elementos = formCerrar.elements;
    if (formCerrar.fechaCerrarmenu.value == null || formCerrar.fechaCerrarmenu.value.length == 0 || /^\s+$/.test(formCerrar.fechaCerrarmenu.value)) {
        formCerrar.fechaCerrarmenu.className = 'form-control is-invalid';
        e.preventDefault();
    } else {
        formCerrar.fechaCerrarmenu.className = 'form-control is-valid';
    }
    if (formCerrar.typeCerrarMenu.value == null || formCerrar.typeCerrarMenu.value.length == 0 || /^\s+$/.test(formCerrar.typeCerrarMenu.value)) {
        formCerrar.typeCerrarMenu.className = 'form-control is-invalid';
        e.preventDefault();
    } else {
        formCerrar.typeCerrarMenu.className = 'form-control is-valid';
    }
    if ($("#customRadio4").is(':checked') || $("#customRadio5").is(':checked')) {
        if ($("#customRadio4").is(':checked')) {
            formCerrar.customRadio4.className = 'custom-control-input is-valid';
            formCerrar.customRadio5.className = 'custom-control-input';
        } else {
            formCerrar.customRadio5.className = 'custom-control-input is-valid';
            formCerrar.customRadio4.className = 'custom-control-input';
        }
        e.preventDefault();
    } else {
        formCerrar.customRadio4.className = 'custom-control-input is-invalid';
        formCerrar.customRadio5.className = 'custom-control-input is-invalid';
    }
}

function revisarDato(e) {
    var formulario = document.getElementsByName('forma_asistencia')[0];
    elementos = formulario.elements;
    if (formulario.select_type_menu.value == null || formulario.select_type_menu.value.length == 0 || /^\s+$/.test(formulario.select_type_menu.value)) {
        formulario.select_type_menu.className = 'form-control is-invalid';
        e.preventDefault();
    } else {
        formulario.select_type_menu.className = 'form-control is-valid';
    }
    if (formulario.select_horario.value == null || formulario.select_horario.value.length == 0 || /^\s+$/.test(formulario.select_horario.value)) {
        formulario.select_horario.className = 'form-control is-invalid';
        e.preventDefault();
    } else {
        formulario.select_horario.className = 'form-control is-valid';
    }
    if (formulario.cod_dni_alumno.value == null || formulario.cod_dni_alumno.value.length == 0 || /^\s+$/.test(formulario.cod_dni_alumno.value)) {
        formulario.cod_dni_alumno.className = 'form-control is-invalid';
        e.preventDefault();
    } else {
        formulario.cod_dni_alumno.className = 'form-control is-valid';
    }
}
$(document).ready(function() {
    $(".cerrar").click(function() {
        $.ajax({
            url: 'close/login/user/',
            method: 'POST',
            success: function(resp) {
                setTimeout(function() {
                    location.reload();
                }, 700);
            }
        });
    });
    //eventos
    $("#form_asistencia").submit(function(e) {
        validarAssit(e);
        var valid = true;
        $("#form_asistencia .is-invalid").each(function() {
            valid = false;
        });
        if (valid) {
            $('#botonAsistencia').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading').attr('disabled', true);
            addAsistencia();
            e.preventDefault();
        }
    });
    $("#select_type_menu").change(function() {
        loadHorario($("#select_type_menu option:selected").val());
        loadMenuToday($("#select_type_menu option:selected").val());
    });
})
//funcioens y metodos
function addAsistencia() {
    $.ajax({
        url: 'updateAssist/reservation',
        type: 'POST',
        //dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        data: $("#form_asistencia").serialize(),
        beforeSend: function() {
            document.getElementById('mostrar_loading').style.display = 'block';
            document.getElementById('mostrar_info').style.display = 'none';
        },
        success: function(data) {
            //console.log(data);
            $('#botonAsistencia').html('<i class="fas fa-search"></i>').attr('disabled', false);
            document.getElementById('mostrar_loading').style.display = 'none';
            document.getElementById('mostrar_info').style.display = 'block';
            if ($.trim(data)) {
                var jsonArray = JSON.parse(data);
                //console.log(jsonArray);
                var existsAlum = (jsonArray.alumno.length == 0) ? false : true;
                var existReser = (jsonArray.reservation.length == 0) ? false : true;
                $("#label_codigo_asis").html((existsAlum) ? jsonArray.alumno[0].code : "No Encontrado");
                $("#label_dni_asis").html((existsAlum) ? jsonArray.alumno[0].pid : "No Encontrado");
                $("#label_apell_nom_asis").html((existsAlum) ? jsonArray.alumno[0].last_name0 + " " + jsonArray.alumno[0].last_name1 + ", " + jsonArray.alumno[0].first_name : "No Encontrado");
                $("#label_hora_reserva_asis").html((existReser) ? moment(jsonArray.reservation[0].reservation_time).format('h:mm a DD-MM-YYYY') : "No Encontrado");
                $("#label_turno_asis").html(jsonArray.horary);
                $("#div_mensaje_asis").html(jsonArray.message);
                $("#asistencia").html(jsonArray.totalAssist[0].assisttodaybymenu);
                $("#total").html(jsonArray.totalRegistry[0].totalregistrytodaybymenu);
                if (jsonArray.state == 0) {
                    document.getElementById("header_cuerpo_asis_infor").style.backgroundColor = "hsl(354, 70%, 87%)";
                    document.getElementById("header_cuerpo_asis_infor").style.color = "hsl(354, 61%, 28%)";
                    document.getElementById("turno").style.borderColor = "hsl(354, 61%, 28%)";
                    document.getElementById("mensaje").style.borderColor = "hsl(354, 61%, 28%)";
                    //document.getElementById("header_cuerpo_asis_infor").className='alert alert-danger headerInformacion';
                } else if (jsonArray.state == 1) {
                    document.getElementById("header_cuerpo_asis_infor").style.backgroundColor = "hsl(134, 41%, 83%)";
                    document.getElementById("header_cuerpo_asis_infor").style.color = "hsl(134, 61%, 21%)";
                    document.getElementById("turno").style.borderColor = "hsl(134, 61%, 21%)";
                    document.getElementById("mensaje").style.borderColor = "hsl(134, 61%, 21%)";
                }
                input = document.getElementById('cod_dni_alumno');
                input.focus();
                input.setSelectionRange(0, input.value.length);
                // $("#cod_dni_alumno").setSelectionRange(0, $("#cod_dni_alumno").val().length);
                //$("#cod_dni_alumno").val("");
            }
        }
    }).done(function(resp) {
        //console.log(resp);
    }).fail(function(jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 0) {
            alertify.error('No Conectado: Verifique su conexión a Internet.');
            $('#botonAsistencia').html('<i class="fas fa-search"></i>').attr('disabled', false);
        } else if (jqXHR.status == 404) {
            alertify.error('Error [404]: Página no encontrada.');
        } else if (jqXHR.status == 500) {
            alertify.error('Error [500]: Error Servidor Interno.');
        } else if (textStatus === 'timeout') {
            alertify.error('Error de tiempo de espera... :(');
        }
    }).always(function() {
        //console.log("completado");
    });
}

function loadHorario(typeMenu) {
    $.ajax({
        url: 'asistencia/horary',
        type: 'GET',
        //dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        data: {
            typeMenu: typeMenu
        },
        success: function(data) {
            if ($.trim(data)) {
                var jsonArray = JSON.parse(data);
                var select = $("#select_horario");
                //console.log(jsonArray);
                select.html("<option value=\"\" disabled=\"true\" selected=\"true\">-- Seleccione Horario --</option>");
                for (var i = 0; i < jsonArray.length; i++) {
                    select.append("<option value=\"" + jsonArray[i].id + "\">Horario: " + jsonArray[i].food_start_char + " a " + jsonArray[i].food_end_char + "</option>");
                }
            }
        }
    }).done(function(resp) {
        //console.log(resp);
    }).fail(function() {
        //console.log("error");
    }).always(function() {
        //console.log("completado");
    });
}

function loadMenuToday(typeMenu) {
    $.ajax({
        url: 'menu/today',
        type: 'GET',
        //dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        data: {
            typeMenu: typeMenu
        },
        success: function(data) {
            var disabledInput = false;
            var input_id_menu = $("#id_menu");
            if ($.trim(data)) {
                var jsonArray = JSON.parse(data);
                if (!(jsonArray.length == 0)) {
                    input_id_menu.val(jsonArray[0].id);
                } else {
                    input_id_menu.val("");
                    disabledInput = true;
                    if (typeMenu == 1) {
                        alert("No hay Desayuno programado para hoy");
                    } else if (typeMenu == 2) {
                        alert("No hay Almuerzo programado para hoy");
                    } else if (typeMenu == 3) {
                        alert("No hay Cena programada para hoy");
                    }
                }
                disabledInputs(disabledInput);
            }
        }
    }).done(function(resp) {
        //console.log(resp);
    }).fail(function() {
        //console.log("error");
    }).always(function() {
        //console.log("completado");
    });
}

function disabledInputs(disabledInput) {
    $('#select_horario').attr('disabled', disabledInput);
    $('#cod_dni_alumno').attr('disabled', disabledInput);
    $('#botonAsistencia').attr('disabled', disabledInput);
}