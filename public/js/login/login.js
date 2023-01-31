function verifyForm(e) {
    let a;
    return $(":input", e).each(function() {
        var e = this.type,
            r = this.tagName.toLowerCase();
        let t = $(this);
        if ("text" != e && "password" != e && "date" != e && "textarea" != r && "select" != r && "checkbox" != e && "radio" != e && "number" != e || (t.val() ? (t.removeClass("is-invalid"), a = !0) : (t.addClass("is-invalid"), a = !1)), !a) return a
    }), a
}
$(document).ready(function() {

    showModalInstalarApp();

    var e = window.sessionStorage,
        a = $("#login");
    a.find("input[name=user]").val(e.email), a.find("select[name=role]").val(e.role), $("#login").submit(function(r) {
        r.preventDefault();
        let t = a.find("button[type=submit]"),
            s = $(".messaje"),
            l = a.find("input[name=user]"),
            o = a.find("select[name=role]");
        a.find("input[name=password]");
        e.email = l.val(), e.role = o.val(), verifyForm(a) ? $.ajax({
            url: "validate/login/user/",
            method: "POST",
            data: a.serialize(),
            beforeSend: function(e) {
                t.attr("disabled", !0), t.css({
                    cursor: "not-allowed"
                })
            },
            success: function(a) {
                a = $.parseJSON(a), s.removeClass("alert alert-warning"), s.removeClass(a.remove), s.addClass(a.alert), s.html(a.information);
                a.validate && e.clear();
                setTimeout(function() {
                    location.reload()
                }, 1e3)
            },
            error: function() {
                s.removeClass("alert alert-warning"), s.removeClass("alert alert-success"), s.addClass("alert alert-danger"), s.html("No se ha podido obtener la información"), t.removeAttr("disabled"), t.css({
                    cursor: "default"
                })
            }
        }) : (s.removeClass("alert alert-danger"), s.removeClass("alert alert-success"), s.addClass("alert alert-warning"), s.html("Ingrese los datos correctos porfavor!!!"))
    })
});

function showModalInstalarApp(){
    var isAndroid = /(android)/i.test(navigator.userAgent);
    if(isAndroid){
        $('#modalPush').modal('show'); 

    }

}