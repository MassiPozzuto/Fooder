import { message, display_message } from "../../message_handler.js";

/* global Swal */
if (typeof window.jsonresult === 'undefined') {
    $.getJSON("controllers/normal/mercado/object_messages.json", function (jsonresult) {
        window.jsonresult = jsonresult;
    });
    $.getJSON("api/mysqli_messages.json", function (jsonresult) {
        //Esto fusiona dos objetos en uno solo.
        $.extend(window.jsonresult, jsonresult);
    });
}

window.save_object = function save_object() {
    let fd = new FormData();
    fd.append('codigo', document.getElementById('codigo').value);
    fd.append('nombre', document.getElementById('nombre').value);
    fd.append('descripcion', document.getElementById('descripcion').value);
    fd.append('precio', document.getElementById('precio').value);
    fd.append('rareza', document.getElementById('rareza').value);
    fd.append('imagen', document.getElementById('imagen').files[0]);
    fd.append('enventa', document.getElementById('enventa').value);
    fd.append('parte', document.getElementById('parte').value);
    let request = new XMLHttpRequest();
    request.open('POST', 'api/save_object.php', true);
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            let response = JSON.parse(request.responseText);
            console.log(response);
            if (response.state) {
                alert("Objeto subido");
                window.location.reload();
            } else {
                alert(response.detail);
            }
        }
    }
    request.send(fd);
}

window.delete_info = (id) => {
    var c = confirm("Estas seguro de eliminar el objeto? (Este cambio es irreversible)")
    if (c) {
        let fd = new FormData();
        fd.append('id', id);
        let request = new XMLHttpRequest();
        request.open('POST', 'api/object/delete_object.php', true);
        request.onload = function () {
            if (request.readyState == 4 && request.status == 200) {
                console.log(request.responseText);
                let response = JSON.parse(request.responseText);
                if (response["http_code"] == 200) {
                    Swal.fire({
                        title: 'Objecto eliminado exitosamente!',
                        text: 'El objeto ha sido eliminado del sistema incluyendo de los inventarios de los usuarios',
                        icon: 'success',
                        confirmButtonText: 'Hecho'
                    }).then((result) => {
                        location.reload();
                    });
                } else {
                    message(response["message"], null, window.jsonresult);
                    Swal.fire({
                        title: 'Error al borrar el objeto',
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
    } else {
        return;
    }
}

window.update_object = function update_object() {
    let fd = new FormData();
    fd.append('codigo', document.getElementById('codigo-e').value);
    fd.append('nombre', document.getElementById('nombre-e').value);
    fd.append('descripcion', document.getElementById('descripcion-e').value);
    fd.append('precio', document.getElementById('precio-e').value);
    fd.append('rareza', document.getElementById('rareza-e').value);
    fd.append('imagen', document.getElementById('imagen-e').files[0]);
    fd.append('rutimgobj', document.getElementById("rutimgobj-aux").value);
    fd.append('enventa', document.getElementById('enventa-e').value);
    fd.append('parte', document.getElementById('parte-e').value);
    let request = new XMLHttpRequest();
    request.open('POST', 'api/object_update.php', true);
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            let response = JSON.parse(request.responseText);
            console.log(response);
            if (response.state) {
                alert("Objeto actualizado");
                window.location.reload();
            } else {
                alert(response.detail);
            }
        }
    }
    request.send(fd);
}

$(document).ready(function () {
    window.get_table(null, 1, "objetos", 1);
});

