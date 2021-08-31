function imposeMinMax(el) {
    if (el.value != "") {
        if (parseInt(el.value) < parseInt(el.min)) {
            el.value = null;
        }
        if (parseInt(el.value) > parseInt(el.max)) {
            el.value = null;
        }
    }
}

$(window).scroll(function () {
    if ($(this).scrollTop() > 130) {
        $("#navbar_top").removeClass("navbar-top");
        $("#navbar_top").addClass("fixed-top");
        $("#navbar_top").addClass("shadow");
        $("#navbar_top").addClass("nav-opacity");

        $("#navbar_top-brand").removeClass("d-none");
    } else {
        $("#navbar_top").addClass("navbar-top");
        $("#navbar_top").removeClass("fixed-top");
        $("#navbar_top").removeClass("shadow");
        $("#navbar_top").removeClass("nav-opacity");

        $("#navbar_top-brand").addClass("d-none");
    }
});

function limpiagenero() {
    $("#otrogenero").val("");
    $("#otrogenero").addClass("d-none");
}

function vergenero() {
    $("#otrogenero").removeClass("d-none");
}

$("#funciona").click(function () {
    chequear_empresa();
});

function chequear_empresa() {

    if ($("#funciona").is(":checked")) {
        $("#razon_social").prop("required", true);
        $("#cuite").prop("required", true);
        $("#id_tipo_sociedad").prop("required", true);
        $("#domiciliol").prop("required", true);
        $("#nrol").prop("required", true);
        $("#id_ciudadl").prop("required", true);
        $("#departamentol").prop("required", true);
        $("#representante").prop("required", true);
        $("#domicilior").prop("required", true);
        $("#nror").prop("required", true);
        $("#id_ciudadr").prop("required", true);
        $("#departamentor").prop("required", true);
        $("#codigoafip").prop("required", true);
        $("#actividadafip").prop("required", true);
        $("#fecha_inscripcion").prop("required", true);
        $("#fecha_inicio").prop("required", true);
        $("#otrosregistros").prop("required", true);

        $("#empresa").show();
        $("#msjopcional").hide();
        $("#msjobligatorio").show();

    } else {

        $("#razon_social").prop("required", false);
        $("#cuite").prop("required", false);
        $("#id_tipo_sociedad").prop("required", false);
        $("#domiciliol").prop("required", false);
        $("#nrol").prop("required", false);
        $("#id_ciudadl").prop("required", false);
        $("#departamentol").prop("required", false);
        $("#representante").prop("required", false);
        $("#domicilior").prop("required", false);
        $("#nror").prop("required", false);
        $("#id_ciudadr").prop("required", false);
        $("#departamentor").prop("required", false);
        $("#codigoafip").prop("required", false);
        $("#actividadafip").prop("required", false);
        $("#fecha_inscripcion").prop("required", false);
        $("#fecha_inicio").prop("required", false);
        $("#otrosregistros").prop("required", false);

        $("#empresa").hide();
        $("#msjopcional").show();
        $("#msjobligatorio").hide();
    }
}

function ver_entidad() {
    $("#div_ecosistema").removeClass("d-none");
}

function ocultar_entidad() {
    $("#div_ecosistema").addClass("d-none");
    $("#id_entidad").prop("selectedIndex", 0);
}

function refrescar() {
    d = new Date();
    $("#imagen").attr("src", "captcha.php?" + d.getTime());
}

$('#mostrar').on('click', function () {

    var x = $("#password").attr("type");

    if (x === "password") {

        $("#password").attr("type", "text");

    } else {

        $("#password").attr("type", "password");
    }
});

// BARRA NAVEGACION / SUBMENUES

$(".dropdown-menu a.dropdown-toggle").on("click", function (e) {
    var $el = $(this);
    var $parent = $(this).offsetParent(".dropdown-menu");
    if (!$(this).next().hasClass("show")) {
        $(this).parents(".dropdown-menu").first().find(".show").removeClass("show");
    }
    var $subMenu = $(this).next(".dropdown-menu");
    $subMenu.toggleClass("show");

    $(this).parent("li").toggleClass("show");

    $(this)
        .parents("li.nav-item.dropdown.show")
        .on("hidden.bs.dropdown", function (e) {
            $(".dropdown-menu .show").removeClass("show");
        });

    if (!$parent.parent().hasClass("navbar-nav")) {
        $el.next().css({ top: $el[0].offsetTop, left: $parent.outerWidth() - 4 });
    }

    return false;
});

function calcularEdad() {
    var fecha = document.getElementById("fecha_nac").value;

    // Si la fecha es correcta, calculamos la edad
    var values = fecha.split("/");
    var dia = values[2];
    var mes = values[1];
    var ano = values[0];

    // cogemos los valores actuales
    var fecha_hoy = new Date();
    var ahora_ano = fecha_hoy.getYear();
    var ahora_mes = fecha_hoy.getMonth() + 1;
    var ahora_dia = fecha_hoy.getDate();

    // realizamos el calculo
    var edad = ahora_ano + 1900 - ano;
    if (ahora_mes < mes) {
        edad--;
    }
    if (mes == ahora_mes && ahora_dia < dia) {
        edad--;
    }
    if (edad > 1900) {
        edad -= 1900;
    }

    // calculamos los meses
    var meses = 0;
    if (ahora_mes > mes) meses = ahora_mes - mes;
    if (ahora_mes < mes) meses = 12 - (mes - ahora_mes);
    if (ahora_mes == mes && dia > ahora_dia) meses = 11;

    // calculamos los dias
    var dias = 0;
    if (ahora_dia > dia) dias = ahora_dia - dia;

    if (ahora_dia < dia) {
        ultimoDiaMes = new Date(ahora_ano, ahora_mes, 0);
        dias = ultimoDiaMes.getDate() - (dia - ahora_dia);
    }

    if (edad >= 41) {
        $("#estado").html("Edad " + edad + " años, " + meses + " meses y " + dias + " días.<strong>Exceso Edad, presione F5 </strong>.");
        setTimeout(function () {
            document.getElementById("fecha_nac").focus();
        }, 0);
        return false;
    } else {
        return true;
    }
}
function controlar_edad() {
    var fecha = document.getElementById("fecha_nac").value;

    var values = fecha.split("/");
    var ano = values[2];
    var mes = values[1];
    var dia = values[0];

    // cogemos los valores actuales
    var fecha_hoy = new Date();
    var ahora_ano = fecha_hoy.getYear();
    var ahora_mes = fecha_hoy.getMonth() + 1;
    var ahora_dia = fecha_hoy.getDate();

    // realizamos el calculo
    var edad = ahora_ano + 1900 - ano;
    if (ahora_mes < mes) {
        edad--;
    }
    if (mes == ahora_mes && ahora_dia < dia) {
        edad--;
    }
    if (edad > 1900) {
        edad -= 1900;
    }

    // calculamos los meses
    var meses = 0;
    if (ahora_mes > mes) meses = ahora_mes - mes;
    if (ahora_mes < mes) meses = 12 - (mes - ahora_mes);
    if (ahora_mes == mes && dia > ahora_dia) meses = 11;

    // calculamos los dias
    var dias = 0;
    if (ahora_dia > dia) dias = ahora_dia - dia;

    if (ahora_dia < dia) {
        ultimoDiaMes = new Date(ahora_ano, ahora_mes, 0);
        dias = ultimoDiaMes.getDate() - (dia - ahora_dia);
    }

    if (edad >= 41) {
        var texto = "<div class='text-center'> Edad <strong>" + edad + " </strong> años</div>";
        toastr.options = { progressBar: true, showDuration: "2000", timeOut: "5000" };
        toastr.error(texto, "Atención, su edad supera los 40 años");
        setTimeout(function () {
            document.getElementById("fecha_nac").focus();
        }, 0);
        return false;
    }

    return true;
}

function ver_dni(dni) {

    var apellido = $("#apellido").val();
    var nombres = $("#nombres").val();
    var fecha_nac = $("#fecha_nac").val();
    var direccion = $("#direccion").val();
    var nro = $("#nro").val();
    var email = $("#email").val();

    if (dni.value == 0) {
        console.log("No ingreso un Nro dni");
        return false;
    }

    if (apellido.value == 0 && nombres.value == 0 && fecha_nac.value == 0 && direccion.value == 0 && nro.value == 0 && email.value == 0) {
        var url = "verifica_dni.php";

        $.ajax({
            type: "GET",
            url: url,
            data: { dni: dni },
            dataType: "json",
            success: function (resp) {
                switch (resp[0]) {
                    case 1:
                        $("#errorDni").removeClass("hidden");
                        $("#errorDni").html("DNI registrado en un proyecto.");
                        setTimeout(function () {
                            document.getElementById("dni").focus();
                        }, 0);
                        return false;

                    case 2:
                        $("#errorDni").removeClass("hidden");
                        $("#errorDni").html("DNI registrado en un expediente no cerrado.");
                        setTimeout(function () {
                            document.getElementById("dni").focus();
                        }, 0);
                        return false;
                    default:
                        $("#errorDni").addClass("hidden");

                        $("#apellido").val(resp[0]);
                        $("#nombres").val(resp[1]);
                        $("#fecha_nac").val(resp[2]);
                        $("#direccion").val(resp[3]);
                        $("#nro").val(resp[4]);
                        $("#email").val(resp[5]);
                        $("#cuit").val(resp[6]);
                        $("#celular").val(resp[7]);
                        $("#telefono").val(resp[8]);
                        $("#laboral").val(resp[9]);
                        $("#id_departamento").val(resp[10]).change();
                        $("#id_ciudad").val(resp[11]);
                        $("#id_ciudad").trigger("change");
                        $("#cod_area").val(resp[13]);
                }
            },
        });
        return true;
    }
}

function chequea_dni() {
    var dni = document.getElementById("dni").value;

    var url = "verifica_solicitante.php";

    $.ajax({
        type: "GET",
        url: url,
        data: { id: dni },
        success: function (resp) {
            if (resp == 1) {
                var texto = "<br> \n \n\
                Ingrese Usuario <b>Email</b>\n\
                Clave <b>Dni</b>\n\
                <br> \n\
                <br>Comuníquese Tel 0343-4840964";

                ymz.jq_alert({ title: "Usuario Registrado", text: texto, ok_btn: "Ok", close_fn: null });
                setTimeout(function () {
                    document.getElementById("dni").focus();
                }, 0);
                return false;
            }
        },
    });
    return true;
}

function calcularEdad(fecha) {
    // Si la fecha es correcta, calculamos la edad
    var values = fecha.split("/");
    var ano = values[2];
    var mes = values[1];
    var dia = values[0];

    // cogemos los valores actuales
    var fecha_hoy = new Date();
    var ahora_ano = fecha_hoy.getYear();
    var ahora_mes = fecha_hoy.getMonth() + 1;
    var ahora_dia = fecha_hoy.getDate();

    // realizamos el calculo
    var edad = ahora_ano + 1900 - ano;
    if (ahora_mes < mes) {
        edad--;
    }
    if (mes == ahora_mes && ahora_dia < dia) {
        edad--;
    }
    if (edad > 1900) {
        edad -= 1900;
    }

    // calculamos los meses
    var meses = 0;
    if (ahora_mes > mes) meses = ahora_mes - mes;
    if (ahora_mes < mes) meses = 12 - (mes - ahora_mes);
    if (ahora_mes == mes && dia > ahora_dia) meses = 11;

    // calculamos los dias
    var dias = 0;
    if (ahora_dia > dia) dias = ahora_dia - dia;

    if (ahora_dia < dia) {
        ultimoDiaMes = new Date(ahora_ano, ahora_mes, 0);
        dias = ultimoDiaMes.getDate() - (dia - ahora_dia);
    }

    return edad;
}


// check if the element is empty or not
function checkEmpty(elem) {
    if (elem.val() === '') {
        elem.addClass('empty border-danger');
    } else {
        elem.removeClass('empty border-danger');
    }
}

// listen for when the input/select change
$('input, textarea, select').on('change keyup', function () {
    checkEmpty($(this));
});

// loop through the elements when the page loads
$('input, textarea, select').each(function () {
    checkEmpty($(this));
});

function salida() {
    window.location = "../accesorios/salir.php";
}
