"use strict";

// https://www.javascripttutorial.net/dom/manipulating/replace-a-dom-element/

//https://stackoverflow.com/questions/19491336/how-to-get-url-parameter-using-jquery-or-plain-javascript
//Esta indica el estado de swipe
let searchParams = new URLSearchParams(window.location.search);
window.page_moondev = (searchParams.has('seccion')) ? searchParams.get('seccion') : null;
window.selectorstatus = (window.page_moondev == 'auth') ? 'login' : 'change_username_profile';

function swipe(change) {
    window.selectorstatus = change;
    function display(reference, item) {
        var referenceNode = document.getElementById(reference);
        /* global newItem */
        referenceNode.parentNode.insertBefore(item, referenceNode.nextSibling);
    }
    function password(counter, displayer, placeholder, no_validate) {
        var newItem = document.createElement('div');
        newItem.setAttribute("id", "password_" + counter + "_div");
        newItem.setAttribute("class", "pswcontainer swipe_inputs");
        newItem.innerHTML = '<p>'
        newItem.innerHTML += '<input required minlength="8" maxlength="32" type="password" name="password' + counter + '" id="password' + counter + '"placeholder="' + placeholder + '" class="contra ingresadores ' + ((no_validate == true) ? 'no_regex_validate' : '') + '">';
        newItem.innerHTML += '<i class="bi bi-eye-slash ojo"></i>';
        newItem.innerHTML += '</p>';
        newItem.innerHTML += '<p class="display_error_class" id="password' + counter + '_error"></p>';
        display(displayer, newItem);
    }
    function username(counter, displayer, placeholder, no_validate) {
        var newItem = document.createElement('div');
        newItem.setAttribute("id", "register2_username" + counter);
        newItem.setAttribute("class", "swipe_inputs");
        newItem.innerHTML = '<input required type="text" minlength="3" maxlength="15" name="username' + counter + '" id="username' + counter + '" placeholder="' + placeholder + '" class="user ingresadores ' + ((no_validate == true) ? 'no_regex_validate' : '') + '">';
        newItem.innerHTML += '<p class="display_error_class" id="username' + counter + '_error"></p>';
        display(displayer, newItem);
    }
    function email(counter, displayer, placeholder, no_validate) {
        var newItem = document.createElement('div');
        newItem.setAttribute("id", "email_" + counter + "_div");
        newItem.setAttribute("class", "swipe_inputs");
        newItem.innerHTML = '<input required type="email" id="email' + counter + '" name="mail" placeholder="' + placeholder + '" class="email ingresadores">';
        newItem.innerHTML += '<p class="display_error_class" id="email' + counter + '_error"></p>';
        display(displayer, newItem);
    }
    function showRemember(reference) {
        var newItem = document.createElement("div");
        newItem.setAttribute("class", "swipe_inputs");
        newItem.innerHTML = "<input id='remember_cookie_checkbox' class='wantcook' type='checkbox'>¿Desea recordar su contrase&ntilde;a? </input>";
        display(reference, newItem);
    }
    function login(no_validate) {
        password("1", "br_1", "Ingrese su contrase&ntilde;a", no_validate);
    }
    $(".swipe_inputs").remove();
    function down_buttons(id, selector, code) {
        var element = document.getElementById(id);
        if (element == undefined) {
            console.error("ERROR al elegir el input del boton de abajo, el id no ha sido encontrado.");
            console.info("id => " + id + "\nselector => " + selector);
        } else {
            switch (selector) {
                case "register":
                    //element.setAttribute("onclick", "javascript:swipe('register');");
                    element.innerHTML = "¿No tienes usuario? <a class='link' href='" + code + "'style='cursor: pointer;'>registrate.</a>";
                    break;
                case "login":
                    // element.setAttribute("onclick", "javascript:swipe('login');");
                    element.innerHTML = "Si ya posees un usuario, puedes <a href='" + code + "'>iniciar sesi&oacute;n</a>";
                    break;
                case "change_username":
                    //element.setAttribute("onclick", "javascript:swipe('change_username');");
                    element.innerHTML = "Si queres cambiar tu nombre de usuario, <a href='" + code + "'> has click aqui.</a>";
                    break;
                case "change_password":
                    // element.setAttribute("onclick", "javascript:swipe('change_password');");
                    element.innerHTML = "Si queres cambiar tu contrase&ntilde;a hace <a href='" + code + "'>click aqui.</a>";
                    break;
                case "change_email":
                    element.innerHTML = "Si queres cambiar de E-Mail, <a href='" + code + "'>has click aqui.</a>";
                    break;
                default:
                    console.error("ERROR al elegir el selector para el boton de abajo, selector desconocido.");
                    console.info("id => " + id + "\nselector => " + selector);
                    break;
            }
        }
    }
    switch (change) {
        case "register":
            email("1", "global_div", "Ingrese su E-mail", false);
            login(false);
            username("1", "email1_error", "Ingrese su nombre de usuario");
            password("2", "password_1_div", "Repita su contrase&ntilde;a");
            showRemember("password_2_div");
            document.getElementById("auth_form").action = "javascript:loadAjax(true);";
            document.getElementById("submit_button").innerHTML = 'Crear usuario';
            down_buttons("swipe_button1", "login", "javascript:swipe(\"login\");");
            down_buttons("swipe_button2", "change_password", "javascript:swipe(\"change_password\");");
            down_buttons("swipe_button3", "change_username", "javascript:swipe(\"change_username\");");
            down_buttons("swipe_button4", "change_email", "javascript:swipe(\"change_email\");");
            break;
        case "change_password":
            email("1", "global_div", "Ingrese su E-mail", true);
            document.getElementById("auth_form").action = "javascript:loadAjaxChange(\"password\");";
            document.getElementById("submit_button").innerHTML = 'Cambiar contrase&ntilde;a';
            down_buttons("swipe_button1", "login", "javascript:swipe(\"login\");");
            down_buttons("swipe_button2", "register", "javascript:swipe(\"register\");");
            down_buttons("swipe_button3", "change_username", "javascript:swipe(\"change_username\");");
            down_buttons("swipe_button4", "change_email", "javascript:swipe(\"change_email\");");
            login(true);
            password("2", "password_1_div", "Ingrese su nueva contrase&ntilde;a");
            password("3", "password_2_div", "Repita su nueva contrase&ntilde;a");
            break;
        case "change_password_profile":
            document.getElementById("auth_form").action = "javascript:loadAjaxChange(\"password_profile\");";
            document.getElementById("submit_button").innerHTML = 'Cambiar contrase&ntilde;a';
            down_buttons("swipe_button1", "change_email", 'javascript:swipe(\"change_email_profile\");');
            down_buttons("swipe_button2", "change_password", 'javascript:swipe(\"change_username_profile\");');
            login(true);
            password("2", "password_1_div", "Ingrese su nueva contrase&ntilde;a");
            password("3", "password_2_div", "Repita su nueva contrase&ntilde;a");
            break;
        case "change_username":
            email("1", "global_div", "Ingrese su E-mail", false);
            document.getElementById("auth_form").action = "javascript:loadAjaxChange(\"username\");";
            document.getElementById("submit_button").innerHTML = 'Cambiar nombre de usuario';
            down_buttons("swipe_button1", "login", "javascript:swipe(\"login\");");
            down_buttons("swipe_button2", "register", "javascript:swipe(\"register\");");
            down_buttons("swipe_button3", "change_password", "javascript:swipe(\"change_password\");");
            down_buttons("swipe_button4", "change_email", "javascript:swipe(\"change_email\");");
            login(true);
            username("1", "password_1_div", "Ingrese su nombre de usuario actual", true);
            username("2", "register2_username1", "Ingrese su nuevo nombre de usuario", false);
            username("3", "register2_username2", "Repita su nuevo nombre de usuario", false);
            break;
        case "login":
            email("1", "global_div", "Ingrese su E-mail", false);
            document.getElementById("auth_form").action = "javascript:loadAjax(false);";
            document.getElementById("submit_button").innerHTML = 'Iniciar sesion';
            login(true);
            showRemember("password_1_div");
            down_buttons("swipe_button1", "register", "javascript:swipe(\"register\");");
            down_buttons("swipe_button2", "change_password", "javascript:swipe(\"change_password\");");
            down_buttons("swipe_button3", "change_username", "javascript:swipe(\"change_username\");");
            down_buttons("swipe_button4", "change_email", "javascript:swipe(\"change_email\");");
            break;
        case "change_username_profile":
            document.getElementById("auth_form").action = "javascript:loadAjaxChange('username_profile');";
            document.getElementById("submit_button").innerHTML = 'Cambiar nombre de usuario';
            username("1", "br_1", "Ingrese su nombre de usuario actual", true);
            username("2", "register2_username1", "Ingrese su nuevo nombre de usuario", false);
            username("3", "register2_username2", "Repita su nuevo nombre de usuario", false);
            down_buttons("swipe_button1", "change_email", 'javascript:swipe(\"change_email_profile\");');
            down_buttons("swipe_button2", "change_password", 'javascript:swipe(\"change_password_profile\");');
            break;
        case "change_email":
            email("1", "global_div", "Ingrese su E-mail", false);
            document.getElementById("auth_form").action = "javascript:loadAjaxChange('email');";
            document.getElementById("submit_button").innerHTML = "Cambiar E-Mail";
            down_buttons("swipe_button1", "login", "javascript:swipe(\"login\");");
            down_buttons("swipe_button2", "register", "javascript:swipe(\"register\");");
            down_buttons("swipe_button3", "change_password", "javascript:swipe(\"change_password\");");
            down_buttons("swipe_button4", "change_username", "javascript:swipe(\"change_username\");");
            password("1", "br_1", "Ingrese su contrase&ntilde;a", true);
            email("2", "password_1_div", "Ingrese su nuevo email", false);
            email("3", "email_2_div", "Repita su nuevo email", false);
            break;
        case "change_email_profile":
            document.getElementById("auth_form").action = "javascript:loadAjaxChange('email_profile')";
            document.getElementById("submit_button").innerHTML = "Cambiar E-mail";
            email("1", "br_1", "Ingrese su email actual", true);
            email("2", "email_1_div", "Ingrese su nuevo email", false);
            email("3", "email_2_div", "Repita su nuevo email", false);
            down_buttons("swipe_button2", "change_password", 'javascript:swipe(\"change_username_profile\");');
            down_buttons("swipe_button2", "change_password", 'javascript:swipe(\"change_password_profile\");');
            break;
        default:
            window.message_global("global.local.unknow_swipe", "global_error", window.jsonresult);
            break;
    }
    $(document).ready(() => {
        window.addEvents();
    })
}