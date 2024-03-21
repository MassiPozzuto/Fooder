import { message, display_message } from "../../message_handler.js";

/* global Swal */
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
    $.extend(window.jsonresult_admin, window.mysqli_error_messages);
}

var is_buyer = true;
window.show_compras = function show_compras() {
    document.getElementById("buy_or_seller").innerHTML = (is_buyer == true) ? "Vendedor" : "Comprador";
    document.getElementById("swipe_button").innerHTML = (is_buyer == true) ? "Historial de Ventas" : "Historial de Compras";
    document.getElementById("swipe_title").innerHTML = (is_buyer == true) ? "Historial de Compras" : "Historial de Ventas";
    document.getElementById("purchase_history_table").innerHTML = "";
    //document.querySelectorAll("#swipe_button, #swipe_title").forEach(element => { element.innerHTML = (is_buyer == true) ? "Historial de ventas" : "Historial de compras" });
    //console.log(document.querySelectorAll("#swipe_button, #swipe_title"));
    let selector = "purchase_history" + ((is_buyer == true) ? "_buyer" : "_seller");
    console.group("HISTORIAL DE COMPRA/VENTA");
    console.groupCollapsed("ENVIO Y RESPUESTA");
    console.info("is_buyer =>"  + is_buyer + "\nselector => " + selector);
    is_buyer = !is_buyer;
    let information = new FormData;
    let request = new XMLHttpRequest();
    request.open('POST', 'api/get_admin_info.php', true)
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            console.info(request.responseText);
            console.groupEnd();
            console.groupCollapsed("RESPUESTA INDIVIDUAL");
            var final_answer = "";
            let response = JSON.parse(request.responseText);
            window.responsemsg = response;
            if (response.http_code != 200) {
                console.error('Ha ocurrido una falla al cargar la informacion:');
                console.info(response);
                message(response["message"], null, window.jsonresult_admin);
                Swal.fire({
                    title: 'Error al obtener historial',
                    text: display_message,
                    icon: 'error',
                    confirmButtonText: 'Hecho'
                }).then((result) => {
                    location.reload();
                });
            } else {
                var processing = response["result"];
                console.info(processing);
                if (processing.length == 0) {
                    final_answer += "<tr><td colspan='5'>El historial esta vacio</td></tr>";
                } else {
                    processing.forEach(element => {
                        final_answer += "<tr>";
                        final_answer += "<td>" + element["created_at"] + "</td>";
                        final_answer += "<td>" + element["objeto_nombre"] + "</td>";
                        final_answer += "<td>" + element["price"] + "</td>";
                        final_answer += "<td>" + ((element["user"] == null) ? "[SISTEMA]" : element["user"]) + "</td>";
                        final_answer += "<td>" + element["deleted_at"] + "</td>";
                        final_answer += "</tr>";
                    });
                }
                document.getElementById("purchase_history_table").innerHTML = final_answer;
            }
            console.groupEnd();
            console.groupEnd();
        }
    }
    information.append("authority", "0");
    information.append("getInformation", selector);
    request.send(information);
}
$(document).ready(() => {
    window.show_compras();
    document.getElementById("swipe_button").addEventListener("click", () => { window.show_compras() });
});