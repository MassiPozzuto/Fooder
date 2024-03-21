"use strict";

/* global show_modal */
/* global Swal */
/* global hide_modal */

import { message, display_message } from "../../message_handler.js";

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

$(document).ready(() => {
    $.ajax({
        url: 'apipag/inv_obj.php',
        type: 'POST',
        data: {},
        success: function (data) {
            console.log(data);
            let html = '';
            let row_count = 1;
            for (var i = 0; i < data.datos.length; i++) {
                if (row_count === 1) {
                    html += '<tr class="rowinv">';
                }
                html +=
                    '<td class="columninv">' +
                    '<a onclick="mostrarobj1(' + data.datos[i].id + ')"><img src="img/objetos/' + data.datos[i].ruta_img + '" alt="Cargando" style="display:block;" width="100%" height="100%"></a>' +
                    '</td>';

                if (row_count === 3) {
                    row_count = 1;
                    html += '</tr>';
                }
                else {
                    row_count++;
                }
            }
            document.getElementById("bodyinv").innerHTML = html;

        },
        error: function (err) {
            console.log(err);
        }
    })

    function sumarinv() {
        let fd = new FormData();
        let request = new XMLHttpRequest();
        request.open('POST', 'apipag/invsum.php');
        request.onload = function () {
            if (request.readyState == 4 && request.status == 200) {
                let response = JSON.parse(request.responseText);
                let res = 0;
                for (let i = 0; i < response.datos.length; i++) {
                    res += parseInt(response.datos[i].winrate);
                    res += parseInt(response.datos[i].goldaum);
                    res += parseInt(response.datos[i].droprate);
                    res += parseInt(response.datos[i].timered);
                }
                console.log(res);
                if (res == 0) {
                    document.getElementById("humanofinal").src = "img/sprite_1.png";
                }
                if (res >= 200) {
                    document.getElementById("humanofinal").src = "img/sprite_2.png";
                }
                if (res >= 500) {
                    document.getElementById("humanofinal").src = "img/sprite_3.png";
                }
                if (res >= 1000) {
                    document.getElementById("humanofinal").src = "img/sprite_4.png";
                }
                if (res >= 1250) {
                    document.getElementById("humanofinal").src = "img/sprite_5.png";
                }
            }
        }
        request.send(fd);

    }

    sumarinv();
});



window.mostrarobj1 = function mostrarobj1(id) {
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
                document.querySelectorAll(".object_img").forEach(element => {
                    element.src = "img/objetos/" + processing["img"];
                });
                //document.getElementById("imgbuy").src = "img/objetos/" + processing["img"];
                document.querySelectorAll(".objeto_name").forEach(element => {
                    element.value = processing["nombre"];
                });
                //document.getElementById("nombreobj").value = processing["nombre"];
                document.getElementById("descripcion").value = processing["descripcion"];
                document.getElementById("precio").value = processing["precio"];
                document.getElementById("rareza").value = processing["rareza"];
                document.getElementById("parte").value = processing["part"];
                show_modal("modal-object-inv");
            }
        }
    }
    information.append("authority", "0");
    information.append("getInformation", "inventario");
    information.append("getInfoID", parseInt(id));
    request.send(information);
}

window.mostrarobjeq = function mostrarobjeq(idarma) {
    let information = new FormData;
    let request = new XMLHttpRequest();
    information.append('id', idarma);
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
                //document.getElementById("imgbuy-e").src = "img/objetos/" + processing["img"];
                document.querySelectorAll(".object_img").forEach(element => {
                    element.src = "img/objetos/" + processing["img"];
                });
                document.querySelectorAll(".objeto_name").forEach(element => {
                    element.value = processing["nombre"];
                });
                //document.getElementById("nombreobj-e").value = processing["nombre"];
                document.getElementById("descripcion-e").value = processing["descripcion"];
                document.getElementById("precio-e").value = processing["precio"];
                document.getElementById("rareza-e").value = processing["rareza"];
                document.getElementById("parte-e").value = processing["part"];
                show_modal("modal-object-eq");
            }
        }
    }
    information.append("authority", "0");
    information.append("getInformation", "inventario");
    information.append("getInfoID", parseInt(idarma));
    request.send(information);
}

window.mostrarobjeq = function mostrarobjeq(idtorso) {
    let information = new FormData;
    let request = new XMLHttpRequest();
    information.append('id', idtorso);
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
                //document.getElementById("imgbuy-e").src = "img/objetos/" + processing["img"];
                document.querySelectorAll(".object_img").forEach(element => {
                    element.src = "img/objetos/" + processing["img"];
                });
                document.querySelectorAll(".objeto_name").forEach(element => {
                    element.value = processing["nombre"];
                });
                //document.getElementById("nombreobj-e").value = processing["nombre"];
                document.getElementById("descripcion-e").value = processing["descripcion"];
                document.getElementById("precio-e").value = processing["precio"];
                document.getElementById("rareza-e").value = processing["rareza"];
                document.getElementById("parte-e").value = processing["part"];
                show_modal("modal-object-eq");
            }
        }
    }
    information.append("authority", "0");
    information.append("getInformation", "inventario");
    information.append("getInfoID", parseInt(idtorso));
    request.send(information);
}

window.mostrarobjeq = function mostrarobjeq(idcabeza) {
    let information = new FormData;
    let request = new XMLHttpRequest();
    information.append('id', idcabeza);
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
                //document.getElementById("imgbuy-e").src = "img/objetos/" + processing["img"];
                document.querySelectorAll(".object_img").forEach(element => {
                    element.src = "img/objetos/" + processing["img"];
                });
                //document.getElementById("nombreobj-e").value = processing["nombre"];
                document.querySelectorAll(".objeto_name").forEach(element => {
                    element.value = processing["nombre"];
                });
                document.getElementById("descripcion-e").value = processing["descripcion"];
                document.getElementById("precio-e").value = processing["precio"];
                document.getElementById("rareza-e").value = processing["rareza"];
                document.getElementById("parte-e").value = processing["part"];
                show_modal("modal-object-eq");
            }
        }
    }
    information.append("authority", "0");
    information.append("getInformation", "inventario");
    information.append("getInfoID", parseInt(idcabeza));
    request.send(information);
}

window.mostrarobjeq = function mostrarobjeq(idbotas) {
    let information = new FormData;
    let request = new XMLHttpRequest();
    information.append('id', idbotas);
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
                //document.getElementById("imgbuy-e").src = "img/objetos/" + processing["img"];
                document.querySelectorAll(".object_img").forEach(element => {
                    element.src = "img/objetos/" + processing["img"];
                });
                document.querySelectorAll(".objeto_name").forEach(element => {
                    element.value = processing["nombre"];
                });
                //document.getElementById("nombreobj-e").value = processing["nombre"];
                document.getElementById("descripcion-e").value = processing["descripcion"];
                document.getElementById("precio-e").value = processing["precio"];
                document.getElementById("rareza-e").value = processing["rareza"];
                document.getElementById("parte-e").value = processing["part"];
                show_modal("modal-object-eq");
            }
        }
    }
    information.append("authority", "0");
    information.append("getInformation", "inventario");
    information.append("getInfoID", parseInt(idbotas));
    request.send(information);
}

window.mostrarobjeq = function mostrarobjeq(idmasc) {
    let information = new FormData;
    let request = new XMLHttpRequest();
    information.append('id', idmasc);
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
                //document.getElementById("imgbuy-e").src = "img/objetos/" + processing["img"];
                document.querySelectorAll(".object_img").forEach(element => {
                    element.src = "img/objetos/" + processing["img"];
                });
                document.querySelectorAll(".objeto_name").forEach(element => {
                    element.value = processing["nombre"];
                });
                //document.getElementById("nombreobj-e").value = processing["nombre"];
                document.getElementById("descripcion-e").value = processing["descripcion"];
                document.getElementById("precio-e").value = processing["precio"];
                document.getElementById("rareza-e").value = processing["rareza"];
                document.getElementById("parte-e").value = processing["part"];
                show_modal("modal-object-eq");
            }
        }
    }
    information.append("authority", "0");
    information.append("getInformation", "inventario");
    information.append("getInfoID", parseInt(idmasc));
    request.send(information);
}

window.mostrarobjeq = function mostrarobjeq(idpiernas) {
    let information = new FormData;
    let request = new XMLHttpRequest();
    information.append('id', idpiernas);
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
                //document.getElementById("imgbuy-e").src = "img/objetos/" + processing["img"];
                document.querySelectorAll(".object_img").forEach(element => {
                    element.src = "img/objetos/" + processing["img"];
                });
                document.querySelectorAll(".objeto_name").forEach(element => {
                    element.value = processing["nombre"];
                });
                //document.getElementById("nombreobj-e").value = processing["nombre"];
                document.getElementById("descripcion-e").value = processing["descripcion"];
                document.getElementById("precio-e").value = processing["precio"];
                document.getElementById("rareza-e").value = processing["rareza"];
                document.getElementById("parte-e").value = processing["part"];
                show_modal("modal-object-eq");
            }
        }
    }
    information.append("authority", "0");
    information.append("getInformation", "inventario");
    information.append("getInfoID", parseInt(idpiernas));
    request.send(information);
}

window.vender = function vender() {
    let information = new FormData;
    let request = new XMLHttpRequest();
    let id_obj = parseInt(document.getElementById("codigo").value);
    let sell_price = document.getElementById("precio_venta").value;
    request.open('POST', 'apipag/buy_and_sell/sell.php', true)
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            console.log(request.responseText);
            let response = JSON.parse(request.responseText);
            if (response.http_code !== 200) {
                message(response["message"], null, window.jsonresult)
                Swal.fire({
                    title: 'Error al intentar publicar',
                    text: display_message,
                    icon: 'error',
                    confirmButtonText: 'Hecho'
                }).then((result) => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Objeto puesto a la venta exitosamente!',
                    text: 'El objeto ha sido publicado en el mercado online',
                    icon: 'success',
                    confirmButtonText: 'Hecho'
                }).then((result) => {
                    location.reload();
                });
            }
        }
    }
    information.append("object_id", id_obj);
    information.append("sell_price", sell_price);
    request.send(information);
}

window.open_venta = function open_venta() {
    window.hide_modal('modal-object-inv');
    document.getElementById("modal-object-venta").style.display = "block";
}

window.open_venta_eqip = function open_venta_eqip() {
    window.hide_modal('modal-object-eq');
    document.getElementById("modal-object-venta").style.display = "block";
}

$(document).ready(() => {
    $("#precio_venta").keyup(function (e) {
        if (e.key == "Enter") {
            window.vender();
        }
    });
});
