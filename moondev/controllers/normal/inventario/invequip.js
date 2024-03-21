$(document).ready(function () {
    $.ajax({
        url: 'apipag/inv_equipedcabeza.php',
        type: 'POST',
        data: {},
        success: function (data) {
            console.log(data);
            if (data.datos.length > 0) {
                idcabeza = data.datos[0]['id'];
                document.getElementById("cabezaeq").src = "img/objetos/" + data.datos[0]['ruta_img'];
            }
        },
        error: function (err) {
            console.error(err);
        }
    });
});
$(document).ready(function () {
    $.ajax({
        url: 'apipag/inv_equipedtorso.php',
        type: 'POST',
        data: {},
        success: function (data) {
            console.log(data);
            if (data.datos.length > 0) {
                idtorso = data.datos[0]['id'];
                document.getElementById("torsoeq").src = "img/objetos/" + data.datos[0]['ruta_img'];
            }
        },
        error: function (err) {
            console.error(err);
        }
    });
});
$(document).ready(function () {
    $.ajax({
        url: 'apipag/inv_equipedpants.php',
        type: 'POST',
        data: {},
        success: function (data) {
            console.log(data);
            if (data.datos.length > 0) {
                idpiernas = data.datos[0]['id'];
                document.getElementById("piernaseq").src = "img/objetos/" + data.datos[0]['ruta_img'];
            }
        },
        error: function (err) {
            console.error(err);
        }
    });
});
$(document).ready(function () {
    $.ajax({
        url: 'apipag/inv_equipedbotas.php',
        type: 'POST',
        data: {},
        success: function (data) {
            console.log(data);
            if (data.datos.length > 0) {
                idbotas = data.datos[0]['id'];
                document.getElementById("botaseq").src = "img/objetos/" + data.datos[0]['ruta_img'];
            }
        },
        error: function (err) {
            console.error(err);
        }
    });
});
$(document).ready(function () {
    $.ajax({
        url: 'apipag/inv_equipedarma.php',
        type: 'POST',
        data: {},
        success: function (data) {
            console.log(data);
            if (data.datos.length > 0) {
                idarma = data.datos[0]['id'];
                document.getElementById("armaeq").src = "img/objetos/" + data.datos[0]['ruta_img'];
            }
        },
        error: function (err) {
            console.error(err);
        }
    });
});
$(document).ready(function () {
    $.ajax({
        url: 'apipag/inv_equipedmascota.php',
        type: 'POST',
        data: {},
        success: function (data) {
            console.log(data);
            if (data.datos.length > 0) {
                idmasc = data.datos[0]['id'];
                document.getElementById("mascotaeq").src = "img/objetos/" + data.datos[0]['ruta_img'];
            }
        },
        error: function (err) {
            console.error(err);
        }
    });
});


function equipar() {
    let id = document.getElementById("codigo").value;
    let part = document.getElementById("parte").value;
    let fd = new FormData();
    fd.append('id', id);
    fd.append('parte', part);
    let request = new XMLHttpRequest();
    request.open('POST', 'apipag/inv_equip.php', true);
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            let response = JSON.parse(request.responseText);
            console.log(response);
            location.reload();

        }
    }
    request.send(fd);
}

function desequipar() {
    let id = document.getElementById("codigo").value;
    let part = document.getElementById("parte-e").value;
    let fd = new FormData();
    fd.append('id', id);
    fd.append('parte', part);
    let request = new XMLHttpRequest();
    request.open('POST', 'apipag/inv_unequip.php', true);
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            let response = JSON.parse(request.responseText);
            console.log(response);
            location.reload();

        }
    }
    request.send(fd);
}
