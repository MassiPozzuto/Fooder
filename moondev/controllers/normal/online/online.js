import { message, display_message } from "../../message_handler.js";

/*
global Swal
global show_modal
*/

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
    $.extend(window.jsonresult_admin, window.mysqli_error_messages);
}

let searchParams = new URLSearchParams(window.location.search);
window.page_moondev = (searchParams.has('seccion')) ? searchParams.get('seccion') : null;

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
                    title: 'Error al obtener informacion del mercado online',
                    text: display_message,
                    icon: 'error',
                    confirmButtonText: 'Hecho'
                }).then((result) => {
                    location.reload();
                });
            } else {
                var operations = response["result"];
                if (operations.length == 0) {
                    document.getElementById("response_search").innerHTML = (typeof (getLikeTEXT) != "undefined") && (getLikeTEXT != "") ? "No se ha encontrado el objeto" : "No hay ningun objeto publicado";
                } else {
                    let html = '';
                    for (let i = 0; i < operations.length; i++) {
                        var datacut;
                        if (operations[i].objeto_nombre.length > 20) {
                            datacut = operations[i].objeto_nombre.slice(0, 20) + '...';
                        }
                        else {
                            datacut = operations[i].objeto_nombre;
                        }
                        html +=
                            '<div class="product-box">' +
                            '<a onclick="show_sell(' + operations[i].id + ')">' +
                            '<div class="product">' +
                            '<div id="id_obj_buy" hidden="true">' + ((window.page_moondev == "online") ? operations[i].objeto_id : operations[i].id) + '</div>' +
                            '<img src="img/objetos/' + operations[i].objeto_img + '" alt="Cargando">' +
                            '<div class="detail-data" id="dataobj">' +
                            '<div class="detail-title" id="nombrebuy">' + datacut + '</div>' +
                            '<div class="detail-price">' + operations[i].price + ' <span>EclipseCoins</span></div>' +
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
    information.append("getInformation", (window.page_moondev == "online") ? "online" : "online_seller");
    if ((typeof (getLikeTEXT) != "undefined") && (getLikeTEXT != "")) {
        information.append("getLikeTEXT", getLikeTEXT);
    } else {
        document.getElementById("response_search").innerHTML = "";
    }
    request.send(information);
}


$(document).ready(() => {
    window.get_mercado();
});

window.comprar = function comprar() {
    var id = document.getElementById("codigo").value;
    let fd = new FormData();
    fd.append('id', id);
    fd.append("selector", "online");
    let request = new XMLHttpRequest();
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

window.show_sell = function show_sell(id) {
    let information = new FormData;
    let request = new XMLHttpRequest();
    request.open('POST', 'api/get_admin_info.php', true)
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            console.log(request.responseText);
            let response = JSON.parse(request.responseText);
            window.responsemsg = response;
            if (response.http_code !== 200) {
                message(response["message"], null, window.jsonresult)
                Swal.fire({
                    title: 'Error al observar objeto de venta',
                    text: display_message,
                    icon: 'error',
                    confirmButtonText: 'Hecho'
                }).then((result) => {
                    location.reload();
                });
            } else {
                if (response["result"].length == 0) {
                    message("global.sale_not_found", null, window.jsonresult)
                    Swal.fire({
                        title: 'Error al observar objeto de venta',
                        text: display_message,
                        icon: 'error',
                        confirmButtonText: 'Hecho'
                    }).then((result) => {
                        location.reload();
                    });
                } else {
                    let processing = response["result"]["0"];
                    document.getElementById("codigo").value = processing["id"];
                    document.getElementById("seller").value = processing["username"];
                    document.getElementById("sell_created_at").value = processing["created_at"];
                    document.getElementById("sell_deleted_at").value = processing["expiration_date"];
                    document.getElementById("imgbuy").src = "img/objetos/" + processing["objeto_img"];
                    document.getElementById("nombreobj").value = processing["objeto_nombre"];
                    document.getElementById("descripcion").value = processing["objeto_descripcion"];
                    document.getElementById("precio").value = processing["price"];
                    document.getElementById("rareza").value = processing["objeto_rareza"];
                    show_modal("modal-object-buy");
                }
            }
        }
    }
    information.append("authority", "0");
    information.append("getInformation", (window.page_moondev == "online") ? "online" : "online_seller");
    information.append("getInfoID", parseInt(id));
    request.send(information);
}

window.cancel_sell = () => {
    let information = new FormData;
    let request = new XMLHttpRequest();
    request.open('POST', 'apipag/buy_and_sell/delete_sell.php', true)
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            console.log(request.responseText);
            let response = JSON.parse(request.responseText);
            window.responsemsg = response;
            if (response.http_code !== 200) {
                message(response["message"], null, window.jsonresult)
                Swal.fire({
                    title: 'Error al cancelar venta',
                    text: display_message,
                    icon: 'error',
                    confirmButtonText: 'Hecho'
                }).then((result) => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Objeto quitado del mercado exitosamente!',
                    text: 'Encontraras el objeto en tu inventario',
                    icon: 'success',
                    confirmButtonText: 'Hecho'
                }).then((result) => {
                    location.reload();
                });
            }
        }
    }
    information.append("object_id", parseInt(document.getElementById("id_obj_buy").innerHTML));
    request.send(information);
}