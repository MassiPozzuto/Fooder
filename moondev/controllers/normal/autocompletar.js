"use strict";

$(document).ready(function () {
    const url = new URLSearchParams(document.location.search);
    const seccion = (url.has('seccion') && (url.get('seccion') == "mercado")) ? "objetos_venta" : "online";
    console.log("selector de autocompletado: " + seccion);
    $('#idbusqueda').on('keyup', function () {
        var tecla = $(this).val();
        if (tecla.length != 0) {
            $.ajax({
                type: "POST",
                url: "api/get_admin_info.php",
                data: {
                    "authority": "0",
                    "getInformation": seccion,
                    "getLikeTEXT": this.value
                },
                success: function (response) {
                    $('#resultado_busqueda').css("display", "block");
                    let html = "";
                    if (response.http_code == 200) {
                        if (response.result.length == 0) {
                            html += "No se encontro ningun objeto.";
                        } else {
                            response.result.forEach(element => {
                                let display_name = element[(seccion == "objetos_venta") ? "nombre" : "objeto_nombre"];
                                html += '<div><a class="resultado_elemento" href="javascript:window.search_objeto(\'' + display_name + '\');">' + display_name + '</p></div>';
                            });
                        }
                    } else {
                        html += "Ha ocurrido una falla tecnica al autocompletar. Contactar soporte";
                    }
                    $('#resultado_busqueda').html(html);
                }
            });
        } else {
            $('#resultado_busqueda').css("display", "none");
        }
    });
    document.addEventListener(
        "click",
        function (event) {
            let resultado_busqueda = document.getElementById("resultado_busqueda");
            if ((!event.target.matches("#resultado_busqueda")) && (resultado_busqueda.getAttribute("style") == "display: block;")) {
                document.getElementById("resultado_busqueda").setAttribute("style", "display: none;");
            }
        },
        false
    )

});

window.search_objeto = function search_objeto(search_query) {
    if (typeof (search_query) != "undefined") {
        document.getElementById("idbusqueda").value = search_query;
    }
    let search = document.getElementById("idbusqueda").value;
    window.get_mercado(search);
    document.getElementById("resultado_busqueda").setAttribute("style", "display: none;");
}