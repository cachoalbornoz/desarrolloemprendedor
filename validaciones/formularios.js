$(function () {
    var form = $("#formsolicitante");

    form.validate({
        rules: {
            dni: {
                required: true,
                minlength: 7,
                maxlength: 10,
                remote: "verifica_dni.php",
            },
            otrogenero: {
                maxlength: 20,
            },
            email: {
                required: true,
                email: true,
                remote: "verifica_email.php",
            },
            cuit: {
                required: true,
                minlength: 11,
            },
            cod_area: {
                required: true,
                minlength: 3,
            }
        },
        messages: {
            dni: {
                required: 'El dni es obligatorio',
            },
            otrogenero: {
                maxlength: 'Ingresa 1 palabra que describa tu genero',
            },
            email: {
                required: 'El email es obligatorio',
                email: 'Por favor ingrese un email válido',
            }
        }
    });
});

$(function () {
    var form = $("#formsolicitanteedit");

    form.validate({
        rules: {
            dni: {
                required: true,
                minlength: 7,
            },
            otrogenero: {
                maxlength: 20,
            },
            email: {
                required: true,
                email: true,
            },
            cod_area: {
                required: true,
                minlength: 3,
            }
        },
        messages: {
            dni: {
                required: 'El dni es obligatorio',
            },
            otrogenero: {
                maxlength: 'Ingresa 1 palabra que describa tu genero',
            },
            email: {
                required: 'El email es obligatorio',
                email: 'Por favor ingrese un email válido',
            }
        }
    })
});

$(function () {
    var form = $("#cambioclave");

    form.validate({

        rules: {
            password: {
                required: true,
            },
            password_nueva: {
                required: true,
                minlength: 8,
            },
            password_nueva1: {
                required: true,
                minlength: 8,
                equalTo: "#password_nueva"
            }
        },
        messages: {
            password: {
                required: 'La clave es obligatoria',
            },
            password_nueva1: {
                required: 'La repetición de la clave es obligatoria',
                equalTo: "Debe coincidir con la clave nueva"
            }
        },
    })
})

$(function () {
    var form = $("#desarrollo");

    form.validate({
        rules: {
        },
        messages: {
        }
    });

    $.validator.addClassRules({
        empresa: {
            required: {
                depends: function (element) {
                    return $("#funcionad").is(":checked");
                }
            }
        }
    });
})

