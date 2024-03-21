"use strict";

function abrir() {
    let request = new XMLHttpRequest();
    request.open('POST', 'apipag/open_diary.php', true);
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            console.log(this.responseText);
            let response = JSON.parse(this.responseText);
            if (response["detail"] == true) {
                Swal.fire({
                    title: response["nombre"],
                    text: response["nombre"],
                    imageUrl: "img/objetos/" + response["img"],
                    text: 'Has adquirido este objeto, el cual podras encontrarlo en tu inventario',
                    customClass: {
                        icon: 'no-border'
                    },
                    confirmButtonText: 'Hecho'
                }).then((result) => {
                    location.reload();
                });
            }
        }
    }
    request.send();
}

function isButtomAllowed() {
    let information = new FormData;
    let request = new XMLHttpRequest();
    request.open('POST', 'api/get_admin_info.php', true);
    request.onload = function () {
        var answer = JSON.parse(this.responseText);
        if (request.readyState == 4 && request.status == 200) {
            if (answer["http_code"] == 200) {
                var recompensa = answer["result"]["0"]["recompensa"];
                var recompensa_seconds = (Date.parse(recompensa)) / 1000;
                /* console.log(recompensa == null);
                 console.log(Date.now()/1000 >= (recompensa_seconds + 86400));
                 console.log (((recompensa == null) == true) || ((Date.now()/1000 >= (recompensa_seconds + 86400)) == true));*/
                if (((recompensa == null) == true) || ((Date.now() / 1000 >= (recompensa_seconds + 86400)) == true)) {
                    document.getElementById("open_recompensa").removeAttribute("disabled");
                    document.getElementById("open_recompensa").classList.remove("disabled");
                } else {
                    document.getElementById("open_recompensa").removeAttribute("onclick");
                    document.getElementById("open_recompensa").classList.add("disabled");
                    document.getElementById("imgcofre").src = "img/cofreabierto.png";
                }
            }
        }
    }
    information.append("authority", "0");
    information.append("getInformation", "diary");
    request.send(information);
}

$(document).ready(() => {
    isButtomAllowed();
})