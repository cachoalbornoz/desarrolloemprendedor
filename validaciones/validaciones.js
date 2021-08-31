jQuery.validator.setDefaults({
    onfocusout: function(e) {
        this.element(e);
    },
    onkeyup: false,

    highlight: function(element) {
        jQuery(element).closest('.form-control').addClass('is-invalid');
    },
    unhighlight: function(element) {
        jQuery(element).closest('.form-control').removeClass('is-invalid');
        jQuery(element).closest('.form-control').addClass('is-valid');
    },

    errorElement: 'div',
    errorClass: 'invalid-feedback',
    errorPlacement: function(error, element) {
        if (element.parent('.input-group-prepend').length) {
            $(element).siblings(".invalid-feedback").append(error);
            //error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
    },
});
function EsValidoCuit(e){inputValor=e.value;inputString=inputValor.toString();if(inputString.length==11){var t=inputString.charAt(0)+inputString.charAt(1);if(t=="20"||t=="23"||t=="24"||t=="27"||t=="30"||t=="33"||t=="34"){var n=inputString.charAt(0)*5+inputString.charAt(1)*4+inputString.charAt(2)*3+inputString.charAt(3)*2+inputString.charAt(4)*7+inputString.charAt(5)*6+inputString.charAt(6)*5+inputString.charAt(7)*4+inputString.charAt(8)*3+inputString.charAt(9)*2+inputString.charAt(10)*1;Division=n/11;if(Division==Math.floor(Division)){document.getElementById("estado").innerHTML="";return true}}}document.getElementById("estado").innerHTML="Número Cuit inválido";e.focus();return false}
function getXMLHTTPRequest(){var e=false;var t=["Msxml2.XMLHTTP.5.0","Msxml2.XMLHTTP.4.0","Msxml2.XMLHTTP.3.0","Msxml2.XMLHTTP","Microsoft.XMLHTTP"];for(var n=0;!e&&n<t.length;n++){try{e=new ActiveXObject(t[n])}catch(r){e=false}}if(!e&&typeof XMLHttpRequest!="undefined"){e=new XMLHttpRequest}return e}function from(e,t,n){var r=parseInt(Math.random()*99999999);var i=n+"?id="+e+"&rand="+r;var s=t;miPeticion.open("GET",i,true);miPeticion.onreadystatechange=miPeticion.onreadystatechange=function(){if(miPeticion.readyState==4){if(miPeticion.status==200){var e=miPeticion.responseText;document.getElementById(s).style.color="#000";document.getElementById(s).style.marginTop="0px";document.getElementById(s).style.marginLeft="0px";document.getElementById(s).innerHTML=e}}else{if(miPeticion.readyState==2||miPeticion.readyState==3){document.getElementById(s).style.color="#060";document.getElementById(s).style.marginTop="5px";document.getElementById(s).style.marginLeft="5px";document.getElementById(s).innerHTML='Cargando ..." width="12" height="12">'}}};
miPeticion.send(null)}
var miPeticion=getXMLHTTPRequest();
