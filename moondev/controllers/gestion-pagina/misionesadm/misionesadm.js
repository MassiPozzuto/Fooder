function save_mis() {
    let fd = new FormData();
    fd.append('id_mis', document.getElementById('id_mis').value);
    fd.append('titulo_mis', document.getElementById('titulo_mis').value);
    fd.append('descripcion_mis', document.getElementById('descripcion_mis').value);
    fd.append('oro_mis', document.getElementById('oro_mis').value);
    fd.append('winrate_mis', document.getElementById('winrate_mis').value);
    fd.append('mis_rutaimg', document.getElementById('mis_rutaimg').files[0]);
    fd.append('droprate_mis', document.getElementById('droprate_mis').value);
    fd.append('tiempo_mis', document.getElementById('tiempo_mis').value);
    let request = new XMLHttpRequest();
    request.open('POST', 'api/save_mis.php', true);
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            let response = JSON.parse(request.responseText);
            console.log(response);
            if (response.state) {
                alert("Mision creada");
                window.location.reload();
            } else {
                alert(response.detail);
            }
        }
    }
    request.send(fd);
}

window.delete_info = (id_mis) => {
    var c = confirm("Estas seguro de eliminar esta mision? (Este cambio es irreversible)")
    if (c) {
        let fd = new FormData();
        fd.append('id_mis', id_mis);
        let request = new XMLHttpRequest();
        request.open('POST', 'api/delete_mis.php', true);
        request.onload = function () {
            if (request.readyState == 4 && request.status == 200) {
                let response = JSON.parse(request.responseText);
                console.log(response);
                if (response.state) {
                    alert("Mision eliminada");
                    window.location.reload();
                } else {
                    alert(response.detail);
                }
            }
        }
        request.send(fd);
    } else {
        return;
    }
}

function update_mis() {
    let fd = new FormData();
    fd.append('id_mis', document.getElementById('id_mis-e').value);
    fd.append('titulo_mis', document.getElementById('titulo_mis-e').value);
    fd.append('descripcion_mis', document.getElementById('descripcion_mis-e').value);
    fd.append('oro_mis', document.getElementById('oro_mis-e').value);
    fd.append('winrate_mis', document.getElementById('winrate_mis-e').value);
    fd.append('mis_rutaimg', document.getElementById('mis_rutaimg-e').value);
    fd.append('droprate_mis', document.getElementById('droprate_mis-e').value);
    fd.append('tiempo_mis', document.getElementById('tiempo_mis-e').value);
    let request = new XMLHttpRequest();
    request.open('POST', 'api/update_mis.php', true);
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            console.log(request.responseText);
            let response = JSON.parse(request.responseText);
            console.log(response);
            if (response.state) {
                alert("Mision actualizada");
                window.location.reload();
            } else {
                alert(response.detail);
            }
        }
    }
    request.send(fd);
}

$(document).ready(() => {
    window.get_table(null, 1, "misionesadm", 1);
});