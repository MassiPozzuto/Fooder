"use strict";

import { message, display_message } from "../../message_handler.js";

/* global Swal */
/*global show_modal */
if (window.mysqli_error_messages === 'undefined') {
    $.getJSON("api/mysqli_messages.json", function (jsonresult) {
        //Esto fusiona dos objetos en uno solo.
        window.mysqli_error_messages = jsonresult;
    });
}

if (typeof window.jsonresult === 'undefined') {
    $.getJSON("controllers/normal/mercado/object_messages.json", function (jsonresult) {
        window.jsonresult = jsonresult;
    });
    $.extend(window.jsonresult, window.mysqli_error_messages);
}

if (typeof window.jsonresult_admin === 'undefined') {
    $.getJSON("api/get_database_messages.json", function (jsonresult) {
        window.jsonresult_admin = jsonresult;
    });
    $.extend(window.jsonresult, window.mysqli_error_messages);
}

window.comprar = function comprar() {
    var id = document.getElementById("codigo").value;
    let fd = new FormData();
    fd.append('id', id);
    let request = new XMLHttpRequest();
    fd.append("selector", "mercado");
    request.open('POST', 'apipag/buy_and_sell/buy.php', true);
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            console.log(request.responseText);
            let response = JSON.parse(request.responseText);
            if (response["http_code"] == 200) {
                Swal.fire({
                    title: 'Objeto adquirido!',
                    text: 'Encontraras el objeto en tu inventario',
                    icon: 'success',
                    confirmButtonText: 'Hecho'
                }).then((result) => {
                    location.reload();
                });
            } else {
                message(response["message"], null, window.jsonresult)
                Swal.fire({
                    title: 'Error al comprar',
                    text: display_message,
                    icon: 'error',
                    confirmButtonText: 'Hecho'
                }).then((result) => {
                    location.reload();
                });
            }
        }
    }
    request.send(fd);
}

$(document).ready(function () {
    $("#idbusqueda").keyup(function (e) {
        if (e.key == "Enter") {
            window.search_objeto();
        }
    });
});

$(document).ready(() => {
    window.get_mercado();
})

window.get_mercado = (getLikeTEXT) => {
    document.getElementById("container-items").innerHTML = "";
    let information = new FormData;
    let request = new XMLHttpRequest();
    request.open('POST', 'api/get_admin_info.php', true)
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            console.group("MERCADO");
            console.info(request.responseText);
            let response = JSON.parse(request.responseText);
            window.responsemsg = response;
            if (response.http_code !== 200) {
                console.error("Ha ocurrido un error al cargar la informacion de la base de datos. \nContactar soporte");
                message(response["message"], null, window.jsonresult_admin);
                Swal.fire({
                    title: 'Error al obtener informacion del mercado',
                    text: display_message,
                    icon: 'error',
                    confirmButtonText: 'Hecho'
                }).then((result) => {
                    location.reload();
                });
            } else {
                let operations = response["result"];
                if (operations.length == 0) {
                    document.getElementById("response_search").innerHTML = (typeof (getLikeTEXT) != "undefined") && (getLikeTEXT != "") ? "No se ha encontrado el objeto" : "No hay ningun objeto publicado";
                } else {
                    let html = '';
                    for (let i = 0; i < operations.length; i++) {
                        var datacut;
                        if (operations[i].nombre.length > 20) {
                            datacut = operations[i].nombre.slice(0, 20) + '...';
                        }
                        else {
                            datacut = operations[i].nombre;
                        }
                        html +=
                            '<div class="product-box">' +
                            '<a  onclick="mostrarobj(' + operations[i].id + ')">' +
                            '<div class="product">' +
                            '<div id="id_obj_buy" hidden="true">' + operations[i].id + '</div>' +
                            '<img src="img/objetos/' + operations[i].img + '" alt="Cargando">' +
                            '<div class="detail-data" id="dataobj">' +
                            '<div class="detail-title" id="nombrebuy">' + datacut + '</div>' +
                            '<div class="detail-price">' + operations[i].precio + ' <span>EclipseCoins</span></div>' +
                            '</div>' +
                            '</a>' +
                            '</div>' +
                            '</div>';
                    }
                    if ((typeof (getLikeTEXT) != "undefined") && (getLikeTEXT != "")) {
                        document.getElementById("response_search").innerHTML = "Resultados para: " + getLikeTEXT;
                    }
                    document.getElementById("container-items").innerHTML = html;
                }
            }
            console.groupEnd();
        }
    }
    information.append("authority", "0");
    information.append("getInformation", "objetos_venta");
    if ((typeof (getLikeTEXT) != "undefined") && (getLikeTEXT != "")) {
        information.append("getLikeTEXT", getLikeTEXT);
    } else {
        document.getElementById("response_search").innerHTML = "";
    }
    request.send(information);
}

window.comprar = function comprar() {
    var id = document.getElementById("codigo").value;
    let fd = new FormData();
    fd.append('id', id);
    let request = new XMLHttpRequest();
    fd.append("selector", "mercado");
    request.open('POST', 'apipag/buy_and_sell/buy.php', true);
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            console.log(request.responseText);
            let response = JSON.parse(request.responseText);
            if (response["http_code"] == 200) {
                Swal.fire({
                    title: 'Objeto adquirido!',
                    text: 'Encontraras el objeto en tu inventario',
                    icon: 'success',
                    confirmButtonText: 'Hecho'
                }).then((result) => {
                    location.reload();
                });
            } else {
                message(response["message"], null, window.jsonresult)
                Swal.fire({
                    title: 'Error al comprar',
                    text: display_message,
                    icon: 'error',
                    confirmButtonText: 'Hecho'
                }).then((result) => {
                    location.reload();
                });
            }
        }
    }
    request.send(fd);
}

$(document).ready(function () {
    $("#idbusqueda").keyup(function (e) {
        if (e.key == "Enter") {
            window.search_objeto();
        }
    });
});

window.mostrarobj = function mostrarobj(id) {
    let information = new FormData;
    let request = new XMLHttpRequest();
    request.open('POST', 'api/get_admin_info.php', true)
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            console.log(request.responseText);
            let response = JSON.parse(request.responseText);
            window.responsemsg = response;
            if (response.http_code !== 200) {
                console.error('Ha ocurrido una falla al cargar la informacion:');
                console.log(response);
            } else {
                let processing = response["result"]["0"];
                document.getElementById("codigo").value = processing["id"];
                document.getElementById("imgbuy").src = "img/objetos/" + processing["img"];
                document.getElementById("nombreobj").value = processing["nombre"];
                document.getElementById("descripcion").value = processing["descripcion"];
                document.getElementById("precio").value = processing["precio"];
                document.getElementById("rareza").value = processing["rareza"];
                show_modal("modal-object-buy");
            }
        }
    }
    information.append("authority", "0");
    information.append("getInformation", "objetos");
    information.append("getInfoID", parseInt(id));
    request.send(information);
}
