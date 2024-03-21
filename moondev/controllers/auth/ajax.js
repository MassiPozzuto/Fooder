"use strict";

/* global message */
/* global timer */

function loadAjax(isRegister) {
    $(document).ready(function () {
        if (window.page_moondev == 'auth') {
            let information = new FormData;
            function store(variable) {
                information.append(variable, document.getElementById(variable).value);
            }
            if (isRegister === true) {
                information.append("auth_method", true);
                store("username1");
                store("password2");
                //store("birthdate");
            } else {
                information.append("auth_method", false);
            }
            information.append("saveCookie", document.getElementById("remember_cookie_checkbox").checked);
            store("email1");
            store("password1");
            const xhttp = new XMLHttpRequest
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    let response = JSON.parse(this.responseText);
                    if (response.http_code !== 200) {
                        if (typeof window.jsonresult === 'undefined') {
                            console.error('No se pudo obtener el archivo de mensajes de error de Auth. \n Contactar soporte.');
                        }
                        else { var timer = []; message(response.message, response.input, window.jsonresult); }
                    }
                    else {
                        location.href = 'index.php?seccion=homepage';
                    }
                }
            }
            xhttp.open("POST", "api/auth/authentification.php", true);
            xhttp.send(information);
        } else {
            console.error("Se intento usar la funcion de autenticacion en una pagina no soportada. \nContactar soporte.");
        }
    });
}
function loadAjaxChange(selector) {
    $(document).ready(function () {
        console.group("CAMBIO DE INFORMACION");
        let information = new FormData;
        function store(variable) {
            information.append(variable, document.getElementById(variable).value);
        }
        switch (selector) {
            case "password":
                information.append("auth_method", "password");
                store("email1");
                store('password1');
                store("password2");
                store("password3");
                break;
            case "password_profile":
                information.append("auth_method", "password_profile");
                store('password1')
                store("password2");
                store("password3");
                break;
            case "username":
                information.append("auth_method", "username");
                store("email1");
                store('password1')
                store("username1");
                store("username2");
                store("username3");
                break;
            case "username_profile":
                information.append("auth_method", "username_profile");
                store("username1");
                store("username2");
                store("username3");
                break;
            case "email":
                information.append("auth_method", "email");
                store("email1");
                store("password1");
                store("email2");
                store("email3");
                break;
            case "email_profile":
                information.append("auth_method", "email_profile");
                store("email1");
                store("email2");
                store("email3");
                break;
            default:
                console.error("Se ha seleccionado un selector invalido al intentar cambiar de informacion");
                break;
        }
        console.info(selector);
        const xhttp = new XMLHttpRequest
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                let response = JSON.parse(this.responseText);
                if (response.http_code !== 200) {
                    if (typeof window.jsonresult === 'undefined') {
                        console.error('No se pudo obtener el archivo de mensajes de error de Auth. \n Contactar soporte.');
                    }
                    else { var timer = []; message(response.message, response.input, window.jsonresult); }
                }
                else {
                    alert("Cambios guardados exitosamente");
                    window.location.reload();
                }
            }
        }
        xhttp.open("POST", "api/auth/change_user_info.php", true);
        xhttp.send(information);
        console.groupEnd();
    });
}
