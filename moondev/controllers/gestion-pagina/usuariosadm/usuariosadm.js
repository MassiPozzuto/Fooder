import { message, inputHandler, parseSettings } from "../../message_handler.js";
/* global hidder */
if (typeof window.jsonresult === 'undefined') {
    $.getJSON("controllers/auth/auth_messages.json", function (jsonresult) {
        window.jsonresult = jsonresult;
    });
    $.extend(window.jsonresult, window.mysqli_error_messages);
}

var usuariosadm_selector = document.getElementById("usuariosadm_selector");

usuariosadm_selector.addEventListener("change", () => {
    window.get_table(((usuariosadm_selector.value == "-1") ? undefined : parseInt(usuariosadm_selector.value)), 1, "usuariosadm", 1, true, null, null);
});

var settings = JSON.parse(document.getElementById("auth_settings").innerHTML);
$("#auth_settings").remove();

const regex_username_pattern = new RegExp(parseSettings(settings["server_auth_settings"]["REGEX_USERNAME"]));

window.delete_info = (id_usu) => {
    var c = confirm("Estas seguro de eliminar este usuario? (Este cambio es irreversible)")
    if (c) {
        let fd = new FormData();
        fd.append('id_usu', id_usu);
        let request = new XMLHttpRequest();
        request.open('POST', 'api/delete_usu.php', true);
        request.onload = function () {
            if (request.readyState == 4 && request.status == 200) {
                let response = JSON.parse(request.responseText);
                console.log(response);
                if (response.state) {
                    alert("Usuario eliminado");
                    window.location.reload();
                } else {
                    alert(response.detail);
                }
            }
        }
        request.send(fd);
    } else {
        return;
    }
}

window.empty_errors = function empty_errors() {
    document.getElementById("userid_error").innerHTML = "";
    document.getElementById("email1_error").innerHTML = "";
    document.getElementById("username1_error").innerHTML = "";
    document.getElementById("password1_error").innerHTML = "";
    document.getElementById("personaje_id_error").innerHTML = "";
    document.getElementById("coins_error").innerHTML = "";
    document.getElementById("roles_error").innerHTML = "";

}
window.update_usu = () => {
    let fd = new FormData();
    fd.append('userid', document.getElementById('id_usu-e').value);
    fd.append('username1', document.getElementById('usuario_usu-e').value);
    fd.append('email1', document.getElementById('mail_usu-e').value);
    fd.append('coins', document.getElementById('monedas_usu-e').value);
    fd.append('personaje_id', document.getElementById("personaje_id-e").value);
    fd.append('roles', document.getElementById("roles_id-e").value);
    let request = new XMLHttpRequest();
    request.open('POST', 'api/auth/update_user.php', true);
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            console.log(this.responseText);
            let response = JSON.parse(request.responseText);
            if (response.http_code == 200) {
                alert("Usuario actualizado");
                window.hide_modal("modal-object-edit");
                window.empty_errors();
                window.get_table(null, "1", "usuariosadm", window.offset, true, null, null);
            } else {
                //alert("Ha ocurrido un fallo, revisar consola");
                var timer = [];
                message(response.message, response.input, window.jsonresult);
            }
        }
    }
    request.send(fd);
}

window.permanent_fail = false;
window.hidder = function hidder(hide, permanent) {
    if (window.permanent_fail != true) {
        var element = document.getElementById("save_button");
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
            element.setAttribute("disabled", "true");
            element.removeAttribute("onclick");
        } else {
            element.removeAttribute("disabled");
            element.setAttribute("onclick", "javascript:window.update_usu();");
        }
    }
    if (permanent == true) {
        window.toggleInput.forEach(input => {
            input.disabled = true;
            input.style.cursor = "not-allowed";
        });
        window.permanent_fail = true;
        console.error("Se ha desactivado el modulo de edicion de usuarios debido a una falla tecnica. \nContactar soporte");
    }
}
function validatecampus(input) {
    var min, max, max_message, min_message, reference, inside;
    switch (input.id) {
        case "mail_usu-e":
            min = settings["server_auth_settings"]["EMAIL_MIN_LENGHT"];
            max = settings["server_auth_settings"]["EMAIL_MAX_LENGHT"];
            inside = input.value.length;
            max_message = 'email.max_error';
            min_message = 'email.min_error';
            reference = "email1_error";
            break;
        case "usuario_usu-e":
            min = settings["server_auth_settings"]["USERNAME_MIN_LENGHT"];
            max = settings["server_auth_settings"]["USERNAME_MAX_LENGHT"];
            inside = input.value.length;
            max_message = 'username.max_error';
            min_message = 'username.min_error';
            reference = "username1_error";
            break;
        case "personaje_id-e":
            min = settings["server_auth_settings"]["MIN_PERSONAJE_ID"];
            max = settings["server_auth_settings"]["MAX_PERSONAJE_ID"];
            inside = input.value;
            max_message = min_message = "personaje_id.invalid";
            reference = "personaje_id_error";
            break;
        case "monedas_usu-e":
            min = 0;
            max = 999999;
            inside = input.value;
            min_message = "coins.min_message";
            max_message = "coins.max_message";
            reference = "coins_error";
            break;
        case "roles_id-e":
            min = settings["server_auth_settings"]["MIN_PROFILE"];
            max = settings["server_auth_settings"]["MAX_PROFILE"];
            inside = input.value;
            min_message = max_message = "roles.wrong";
            reference = "roles_error";
            break;
        default:
            min = 0;
            max = 0;
            inside = input.value;
            max_message = 'global.local.unknow_lenght';
            min_message = 'global.local.unknow_lenght';
            reference = "global_error";
            break;
    }
    if (inside > max) {
        message(max_message, reference, window.jsonresult)
        hidder(true, false);
    } else if (inside < min) {
        message(min_message, reference, window.jsonresult);
        hidder(true, false);
    } else if ((input.id == "usuario_usu-e") && (regex_username_pattern.test(input.value) !== false)) {
        message("username.not_matched", reference, window.jsonresult);
        hidder(true, false);
    } else {
        document.getElementById(reference).innerHTML = "";
        hidder(false, false);
    }

}

$(document).ready(() => {
    inputHandler(validatecampus)
    window.get_table(null, 1, "usuariosadm", 1, true);
});