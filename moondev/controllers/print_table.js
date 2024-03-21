"use strict";

import { message } from "../controllers/message_handler.js";

if (window.mysqli_error_messages === 'undefined') {
    $.getJSON("api/mysqli_messages.json", function (jsonresult) {
        //Esto fusiona dos objetos en uno solo.
        window.mysqli_error_messages = jsonresult;
    });
}

if (typeof window.jsonresult_admin === 'undefined') {
    $.getJSON("api/get_database_messages.json", function (jsonresult) {
        window.jsonresult_admin = jsonresult;
    });
    $.extend(window.jsonresult, window.mysqli_error_messages);
}

// ID int, indica el ID del elemento seleccionado
// authority tinyint, indica si es de administrador o no la query
// selector string, indica la query a seleccionar
// page int, indica la pagina seleccionada, 1 si no es proporcionado el dato.
// add_editor bool, agrega el boton de editor a la tabla
// counter int, le agrega a los inner HTML un _(numero de counter), esto
//      es util cuando debemos imprimir multiples tablas en una misma seccion
//      1 si no es proporcionado el dato
var stored_id = null;
const can_use_cache = ["usuariosadm"]
window.get_table = (id, authority, selector, page, add_editor_input, counter_input, getLikeTEXT) => {
    if (typeof id == "number") { stored_id = id; }
    //Si el valor es undefined significa que no podemos acceder a la cache
    //IMPORTANTE UTILIZAR EL TRIPLE IGUAL, Sino tomara undefined y null como iguales.
    else if ((id === null) && (can_use_cache.includes("usuariosadm")) && (stored_id != null)) {
        id = stored_id;
    } else if (id === undefined) {
        stored_id = null;
    }
    var counter = ((typeof (counter_input) == "undefined") || (counter_input == null)) ? "" : ("_" + counter_input);
    document.getElementById("get_table_all" + counter).innerHTML = "";
    document.getElementById("paginator_list" + counter).style.display = "none";
    let information = new FormData;
    let request = new XMLHttpRequest();
    var add_editor = add_editor_input;
    var offset = (typeof page == "undefined") ? 1 : page;
    window.offset = offset;
    request.open('POST', 'api/get_admin_info.php', true)
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            console.group("IMPRESOR DE TABLA");
            console.groupCollapsed("ENVIO Y RESPUESTA");
            console.info("id => " + id + "\nauthority =>" + authority + "\nselector =>" + selector + "\npage=>" + page);
            console.info(this.responseText);
            console.groupEnd();
            console.groupCollapsed("RESPUESTA INDIVIDUAL");
            var finalAnswerGETtable = "";
            let response = JSON.parse(request.responseText);
            if (response.http_code !== 200) {
                console.error("Ha ocurrido una falla tecnica al cargar la informacion. \n Contactar soporte.")
                message(response["message"], response["input"] + counter, window.jsonresult_admin);
            } else {
                var result = response['result'];
                console.info(result);
                finalAnswerGETtable += "<thead><tr>"
                Object.keys(result[0]).forEach(element => {
                    var element1 = element.replace("_", " ");
                    finalAnswerGETtable += "<th>" + element1 + "</th>";
                });
                if (add_editor === true) {
                    finalAnswerGETtable += "<th class='td-option'>Opciones</th></tr></thead><tbody>"
                }
                result.forEach(element => {
                    console.info(element);
                    finalAnswerGETtable += "<tr id='table_" + element["id"] + "'>";
                    Object.entries(element).forEach(element_2 => {
                        finalAnswerGETtable += "<td class='itdtd'>" + element_2[1] + "</td>";
                    });
                    if (add_editor === true) {
                        finalAnswerGETtable += '<td class="td-option">';
                        finalAnswerGETtable += '<div class="div-flexop div-td-button">';
                        finalAnswerGETtable += '<button class="btn-op" onclick="javascript:edit(' + element['id'] + ');"><i class="fa fa-pencil"></i></button>';
                        finalAnswerGETtable += '<button class="btn-op" onclick="javascript:window.delete_info(' + element['id'] + ');"><i class="fa fa-trash"></i></button>';
                        finalAnswerGETtable += "</div></td>";
                    }
                    finalAnswerGETtable += '</tr>';
                });
                //Esta parte es la del paginador
                var pages = response["pages"];
                var pages_show;
                var final_answer_paginator = "";
                //Esta funcion nos sirve para saber si el boton del paginador con la id de la pagina seleccionada existe
                //Suponiendo que exista, y que ese elemento sea el primero de la lista de paginas y no estemos en la seccion 1-10
                //Nos devolvera true la funcion, la cual sera utilzada mas tarde para restarle varios numeros a page_iterator
                //e irnos una seccion hacia atras.
                //(page_iterator esta explicado mas abajo)
                function getFirstPaginator() {
                    var first_paginator = document.getElementById("paginator_buttom_" + offset)
                    if (first_paginator == null) {
                        return false;
                    } else if (first_paginator.hasAttribute("first_paginator")) {
                        return true;
                    } else {
                        return false;
                    }
                }
                var page_iterator;
                if ((getFirstPaginator()) && (offset > 9)) {
                    page_iterator = offset - 8;
                } else {
                    page_iterator = offset;
                }
                //Page_iterator nos indica un numero de pagina, la cual puede ser en la que estamos
                // o un numero random inferior si estamos yendo hacia atras.
                //A pageshow le descuento un numero hasta que cuando ese numero divido 10 sea 0 o 1
                //Esto nos sirve para indicar el rango de paginas que debemos mostrar abajo
                // Por ejemplo, si page_show vale 16, le descuento 1 hasta llegar a 10, y ahi tendre el rango 10-20
                // pages_show = page_iterator;
                for (let i = page_iterator; (!(((i / 10) % 2 == 0) || ((i / 10) % 2 == 1))); i--) {
                    if (i < 1) { break; }
                    pages_show = i;
                }
                for (let i = pages_show; (i <= (pages_show + 10)) && (i <= response["pages"]); i++) {
                    final_answer_paginator += "<div class='paginators' id='paginator_buttom_" + i + "' onclick='javascript:window.get_table(null, \"" + String(authority) + "\", \"" + String(selector) + "\", " + i + ");'>" + i + "</div>";
                }
                document.getElementById("get_table_all" + counter).innerHTML = finalAnswerGETtable;
                var paginator_list = document.getElementById("paginator_list" + counter);
                //Agrego al HTML la lista de paginas
                paginator_list.innerHTML = final_answer_paginator;
                //Agrego a la primera pagina de la seccion el attributo first_paginator explicado anteriormente
                paginator_list.firstChild.setAttribute("first_paginator", "true");
                //Si solo hay una sola pagina de resultados, no quiero que el paginador tenga la opcion de llamar
                //ya que siempre habra solo 1 pagina, por lo que le remuevo a la unica pagina el atributo
                //onclick asi no puede llamarlo.
                if (pages == 1) { paginator_list.firstChild.removeAttribute("onclick"); }
                //Indico en el HTML en que pagina me encuentro actualmente.
                document.getElementById("paginator_section" + counter).innerHTML = "P&aacute;gina " + response["selectedPage"];
                document.getElementById("paginator_list" + counter).removeAttribute("style");
            }
            console.groupEnd();
            console.groupEnd();
        }
    }
    information.append("authority", authority);
    information.append("getInformation", selector);
    if (typeof page == 'number') {
        information.append('selectedPage', parseInt(page));
    }
    console.log(typeof id);
    if (typeof id == 'number') {
        information.append("getInfoID", parseInt(id));
    } else if (typeof getLikeTEXT == "string") {
        information.append("getLikeTEXT", getLikeTEXT);
    }
    request.send(information);
}