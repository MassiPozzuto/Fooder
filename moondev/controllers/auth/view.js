"use strict";

import { message, inputHandler, parseSettings } from "../message_handler.js";

const ALLOW_CHANGE_AUTH = false;

window.message_global = message;
if (typeof window.jsonresult === 'undefined') {
    $.getJSON("controllers/auth/auth_messages.json", function (jsonresult) {
        window.jsonresult = jsonresult;
    });
    $.getJSON("api/mysqli_messages.json", function (jsonresult) {
        //Esto fusiona dos objetos en uno solo.
        $.extend(window.jsonresult, jsonresult);
    });
}

/* global hidder */

window.message = message;

var settings = JSON.parse(document.getElementById("auth_settings").innerHTML);
$("#auth_settings").remove();

const password_regex = new RegExp(parseSettings(settings["client_auth_settings"]["PASSWORD_REGEX"]));
const username_regex = new RegExp(parseSettings(settings["client_auth_settings"]["USERNAME_REGEX"]));
const email_regex = new RegExp(parseSettings(settings["client_auth_settings"]["EMAIL_REGEX"]));
const change_username_regex = new RegExp(parseSettings(settings["client_auth_settings"]["CHANGE_USERNAME_REGEX"]));
const change_password_regex = new RegExp(parseSettings(settings["client_auth_settings"]["CHANGE_PASSWORD_REGEX"]));
const change_email_regex = new RegExp(parseSettings(settings["client_auth_settings"]["CHANGE_EMAIL_REGEX"]));
const regex_password_pattern = new RegExp(parseSettings(settings["server_auth_settings"]["REGEX_PASSWORD"]));
const regex_username_pattern = new RegExp(parseSettings(settings["server_auth_settings"]["REGEX_USERNAME"]));

window.addEvents = () => {
    var toggleEye = document.querySelectorAll('.ojo');
    if (toggleEye != null) {
        toggleEye.forEach(psw => {
            function handleClick() {
                var togglePassword = document.querySelectorAll('.contra');
                togglePassword.forEach(psw => {
                    var type = (psw.getAttribute('type') == 'password') ? 'text' : 'password';
                    psw.setAttribute('type', type);
                });
            }
            if (psw.getAttribute('listener') == null) {
                psw.addEventListener('click', handleClick);
                psw.setAttribute('listener', 'true');
            }
        });
    }
    inputHandler(validate_campus);
}

window.hidder = function hidder(hide, permanent) {
    if (window.permanent_fail != true) {
        //console.log(hide);
        function check_errors() {
            let errors = document.querySelectorAll(".display_error_class");
            var stop_foreach = false;
            errors.forEach(element => {
                if (element.innerHTML.length > 1) {
                    stop_foreach = true;
                }
            });
            return (stop_foreach == true) ? false : true;
        }
        if (hide == true || (check_errors() == false)) {
            document.getElementById("submit_button").setAttribute('disabled', 'true');
        } else {
            document.getElementById("submit_button").removeAttribute('disabled');
        }
    }
    if (permanent == true) {
        document.getElementById("global_div").removeAttribute("hidden");
        window.permanent_fail = true;
        window.toggleInput.forEach(input => {
            input.disabled = true;
            input.style.cursor = "not-allowed";
        });
        $("#password_swipe").remove();
        $("#username_swipe").remove();
    }
    if (window.permanent_fail == true) {
        console.error("Se ha deshabilitado el sistema de autenticacion debido a una falla tecnica. \n Contactar soporte.");
    }
}
function validate_campus(input) {
    var inside = input.value;
    var min;
    var max;
    var max_message;
    var min_message;
    var reference;
    if (email_regex.test(input.id)) {
        min = settings["server_auth_settings"]["EMAIL_MIN_LENGHT"];
        max = settings["server_auth_settings"]["EMAIL_MAX_LENGHT"];
        max_message = 'email.max_error';
        min_message = 'email.min_error';
        reference = input.id;
    } else if (password_regex.test(input.id)) {
        min = settings["server_auth_settings"]["PASSWORD_MIN_LENGHT"];
        max = settings["server_auth_settings"]["PASSWORD_MAX_LENGHT"];
        max_message = "password.max_error";
        min_message = "password.min_error";
        reference = input.id;
    } else if (username_regex.test(input.id)) {
        min = settings["server_auth_settings"]["USERNAME_MIN_LENGHT"];
        max = settings["server_auth_settings"]["USERNAME_MAX_LENGHT"];
        max_message = "username.max_error";
        min_message = "username.min_error";
        reference = input.id;
    } else {
        min = 0;
        max = 0;
        max_message = 'global.local.unknow_lenght';
        min_message = 'global.local.unknow_lenght';
        reference = "global";
    }
    reference += "_error";
    function doMatch(status, id, match) {
        //El id es el duplicado y el match es el original
        if (status.test(window.selectorstatus) && ((input.id == id) || (input.id == match))) {
            var id_value = document.getElementById(id).value;
            //Si el duplicado no es identico al original, y el duplicado no esta vacio, tirar mensaje de error
            if ((!(id_value == document.getElementById(match).value)) && (id_value != "")) {
                var sliced = id.slice(0, -1);
                message(sliced + ".not_the_same", id + "_error", window.jsonresult);
                //Si el input.id no es igual al duplicado
                //Significa que se corrigio desde el match (o otro lugar) y no desde el duplicado
                //Por lo que debemos retornar false para que valide al match y no se oculte
                if (input.id != id) {
                    return false;
                }
                hidder(true, false);
            } else {
                document.getElementById(id + "_error").innerHTML = "";
                if (input.id != id) {
                    return false;
                }
                hidder(false, false);
            }
            return true;
        } else { return false; }
    }
    function validateRegex() {
        if ((window.selectorstatus != "login") && (input.classList.contains("no_regex_validate") == false)) {
            if ((password_regex.test(input.id)) && (regex_password_pattern.test(inside) !== true)) {
                message("password.not_matched", reference, window.jsonresult);
                hidder(true, false);
                return true;
            } else if ((username_regex.test(input.id)) && (regex_username_pattern.test(inside) !== false)) {
                message("username.not_matched", reference, window.jsonresult);
                hidder(true, false);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    if (doMatch(/register/, "password2", "password1")) { ; }
    else if (doMatch(change_password_regex, "password3", "password2")) { ; }
    else if (doMatch(change_username_regex, "username3", "username2")) { ; }
    else if (doMatch(change_email_regex, "email3", "email2")) { ; }
    else if (inside.length > max) {
        message(max_message, reference, window.jsonresult)
        hidder(true, false);
    } else if (inside.length < min) {
        message(min_message, reference, window.jsonresult);
        hidder(true, false);
    } else if (validateRegex()) { ; }
    else {
        document.getElementById(reference).innerHTML = "";
        hidder(false, false);
    }
};

if ((ALLOW_CHANGE_AUTH !== true) && (window.page_moondev == "auth")) {
    document.getElementById("swipe_button2").style.display = "none";
    document.getElementById("swipe_button3").style.display = "none";
    document.getElementById("swipe_button4").style.display = "none";
}

window.permanent_fail = false;
$(document).ready(() => {
    /* global swipe*/
    swipe(window.selectorstatus);
    window.addEvents();
    hidder(true, false);
});