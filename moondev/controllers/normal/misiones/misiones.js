
function get_normal_misiones() {
    
    let information = new FormData;
    let request = new XMLHttpRequest();
    request.open('POST', 'api/get_admin_info.php', true)
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            window.finalAnswerGETusu = "";
            let response = JSON.parse(request.responseText);
            window.responsemsg = response;
            if (response.http_code !== 200) {
                console.error('Ha ocurrido una falla al cargar la informacion:');
                console.log(response);
            } else {
                var result = response['result'];
                result.forEach(element => {
                    let answer = '<div class="divmis" style="border-style: solid;">';
                    answer += '<div class="idnone" id=' + element['id'] + '></div>';
                    answer += '<img src="img/' + element['nombre_img'] + '" class="imgmis">';
                    answer += '<div class="wrapmis">';
                    answer += '<h2 class="titmis">' + element['titulo'] + '</h2>';
                    answer += '<br />';
                    answer += '<div class="desc">' + element['descripcion'] + '</div>';
                    answer += '<div class="wraproll" id=' + element['id'] + '>';
                    answer += '<div class="duration">Duracion:' + element['tiempo'] / 60 + ' Minutos</div>';
                    answer += '<div class="goldmisv">Recompensa:' + element['oro'] + ' EclipseCoins</div>';
                    answer += '<div class="wrmisv">Winrate:' + element['winrate'] + '%</div>';
                    answer += '<div class="drmisv">Droprate:' + element['droprate'] + '%</div>';
                    answer += '</div>';
                    answer += '</div>';
                    answer += "<div class='buttonstart' id='start-cont'>";
                    answer += "<button id='mistbuton' class='butonmis' onclick='startmis(" + element['id'] + ")' disabled>Empezar</button>";
                    answer += '</div>';
                    answer += '</div>';
                    window.finalAnswerGETusu += answer;
                    
                });
                document.getElementById("get_misiones_user").innerHTML = window.finalAnswerGETusu;
                sct();
            }
            
        }
    }
    information.append("authority", "0");
    information.append("getInformation", "misiones");
    request.send(information);
}

function sct(){    
    
    $.ajax({
    async: true,
    url: 'apipag/checkmis.php',
    type: 'POST',
    data: {},
    success: function (data) {
        
        rand = Math.floor(Math.random() * 5);
        date = parseInt(Date.now());
        console.log(date);
        datephp = parseInt(new Date(data.datos.expiration).valueOf());
        console.log(data);
    
        if (typeof data.datos.result !== 'undefined' || data.datos.expiration !== null) {
            if (date > datephp) {


                updatem();
                getobjmis();
                
                imagen = document.cookie
                .split('; ')
                .find((row) => row.startsWith('image='))
                ?.split('=')[1];


                $('.butonmis').prop('disabled', false);
                if (data.datos.result == 1) {
                    switch (rand) {
                        case 1:
                            Swal.fire({
                                title: 'Mision finalizada!',
                                text: 'Sobreviviste a la mismisima muerte y cumpliste tu cometido. Conseguiste ' + orocookie + ' EclipseCoins',
                                imageUrl: "img/objetos/" + imagen,
                                confirmButtonText: 'Vamos alla',
                                customClass: {
                                    icon: 'no-border'
                                }
                            });
                            break;
                        case 2:
                            Swal.fire({
                                title: 'Mision finalizada!',
                                text: 'Sobreviviste a la mismisima muerte y cumpliste tu cometido. Conseguiste ' + orocookie + ' EclipseCoins',
                                imageUrl: "img/objetos/" + imagen,
                                confirmButtonText: 'Vamos alla',
                                customClass: {
                                    icon: 'no-border'
                                }
                            });
                            break;
                        case 3:
                            Swal.fire({
                                title: 'Mision finalizada!',
                                text: 'Sobreviviste a la mismisima muerte y cumpliste tu cometido. Conseguiste ' + orocookie + ' EclipseCoins',
                                imageUrl: "img/objetos/" + imagen,
                                confirmButtonText: 'Vamos alla',
                                customClass: {
                                    icon: 'no-border'
                                }
                            });
                            break;
                        case 4:
                            Swal.fire({
                                title: 'Mision finalizada!',
                                text: 'Sobreviviste  5 a la mismisima muerte y cumpliste tu cometido. Conseguiste ' + orocookie + ' EclipseCoins',
                                imageUrl: "img/objetos/" + imagen,
                                confirmButtonText: 'Vamos alla',
                                customClass: {
                                    icon: 'no-border'
                                }
                            });
                            break;
                        case 5:
                            Swal.fire({
                                title: 'Mision finalizada!',
                                text: 'Sobreviviste 10 a la mismisima muerte y cumpliste tu cometido. Conseguiste ' + orocookie + ' EclipseCoins',
                                imageUrl: "img/objetos/" + imagen,
                                confirmButtonText: 'Vamos alla',
                                customClass: {
                                    icon: 'no-border'
                                }
                            });
                            break;
                    }
                } else {
                    switch (rand) {
                        case 1:
                            Swal.fire({
                                title: 'Mision fallida',
                                text: 'No cumpliste con tu objetivo y actualmente estas en el valhalla, solo una determinacion oscura podria revivirte, intenta otra vez',
                                iconHtml: '<img src="https://cdn130.picsart.com/337068936024211.png?type=webp&to=min&r=240" class="swalclock">',
                                confirmButtonText: 'Continuemos',
                                customClass: {
                                    icon: 'no-border'
                                }
                            }).then((result) => {
                                location.reload();
                            });
                            break;
                        case 2:
                            Swal.fire({
                                title: 'Mision fallida',
                                text: 'Diste un mal paso y pisaste una trampa de oso antes de empezar con la mision, ahora te falta una pierna, ve con el mago del reino para ver si se puede recuperar',
                                iconHtml: '<img src="https://pa1.narvii.com/7446/580b036c4c57c678fd9dc34ad8a6c806284df324r1-210-256_00.gif" class="swalclock">',
                                confirmButtonText: 'Entendido',
                                customClass: {
                                    icon: 'no-border'
                                }
                            }).then((result) => {
                                location.reload();
                            });
                            break;
                        case 3:
                            Swal.fire({
                                title: 'Mision fallida',
                                text: 'Llegaste a un poblado a descansar y en medio de la noche una avalancha de no muertos toco tu puerta, tienes que dormir siempre con un ojo abierto...',
                                iconHtml: '<img src="https://cdn130.picsart.com/300878741221211.png?type=webp&to=min&r=240" class="swalclock">',
                                confirmButtonText: 'Vamos alla',
                                customClass: {
                                    icon: 'no-border'
                                }
                            }).then((result) => {
                                location.reload();
                            });
                            break;
                        case 4:
                            Swal.fire({
                                title: 'Mision fallida',
                                text: 'Las fuerzas del eclipse fueron mas fuertes y te consumieron, reencarna en otro cuerpo o hazte uno con la maldicion',
                                iconHtml: '<img src="https://images.fineartamerica.com/images/artworkimages/medium/2/berserk-eclipse-donny-shart-transparent.png" class="swalclock">',
                                confirmButtonText: 'Sigamos',
                                customClass: {
                                    icon: 'no-border'
                                }
                            }).then((result) => {
                                location.reload();
                            });
                            break;
                        case 5:
                            Swal.fire({
                                title: 'Mision fallida',
                                text: 'Te fallaron las piernas en el ultimo momento y fuiste derribado gracias a tu mala forma fisica',
                                iconHtml: '<img src="https://cdn130.picsart.com/300878741221211.png" class="swalclock">',
                                confirmButtonText: 'Intentemoslo otra vez',
                                customClass: {
                                    icon: 'no-border'
                                }
                            }).then((result) => {
                                location.reload();
                            });
                            break;
                    }

                }
            } else {
                lost = 0;
                win = 0;
                a = 0;
                for (i = 0; i < data.datos.resultiradas.length; i++) {
                    date = parseInt(Date.now());
                    datephp1 = parseInt(new Date(data.datos.datiradas[i]).valueOf());
                    if (date >= datephp1) {
                        if (data.datos.resultiradas[a] == 0) {
                            lost++;
                            a++;
                        } else {
                            a++;
                            win++;
                        }
                    }
                }
                current = lost + win;
                faltan = data.datos.resultiradas.length - current;
                $('.butonmis').prop("disabled", true);
                let answer = '<h1 class="curmis">Mision en curso...</h1>';
                answer += '<div class="divmis" style="border-style: solid;">';
                answer += '<div class="idnone" id=' + data.datos.id + '></div>';
                answer += '<img src="img/' + data.datos.img + '" class="imgmis">';
                answer += '<div class="wrapmis">';
                answer += '<h2 class="titmis">' + data.datos.titulo + '</h2>';
                answer += '<br/>';
                answer += '<div class="desc-c">' + data.datos.descripcion + '</div>';
                answer += '</div>';
                answer += '<div class="tiradas-c">';
                answer += '<div class="result-c">Ganadas:' + win + '<img class="imgres" src="img/good.jpg"></div>';
                answer += '<div class="result-c">Perdidas:' + lost + '<img class="imgres" src="img/bad.jpg"></div>';
                answer += '<div class="result-c">Restantes:' + faltan + '<img class="imgres" src="img/unko.jpg"></div>';
                answer += '</div>';
                answer += '</div>';
                window.finalAnswerGETusu += answer;
                document.getElementById("miscurs").innerHTML = window.finalAnswerGETusu;
                Swal.fire({
                    title: 'Mision en curso...',
                    text: 'Recuerda que aun no puedes iniciar una nueva mision ya que tienes una en progreso',
                    iconHtml: '<img src="https://cdn-icons-png.flaticon.com/512/4/4273.png" class="swalclock">',
                    confirmButtonText: 'Entendido',
                    customClass: {
                        icon: 'no-border'
                    }
                });
                return;
            }



        } else {
            $('.butonmis').prop('disabled', false);
            Swal.fire({
                title: 'Empieza tu aventura!',
                text: 'Elige una mision y embarcate en las profundidades de Midland',
                iconHtml: '<img src="https://www.pngkey.com/png/full/78-782223_image-berserk-mark-of-sacrifice.png" class="swalclock">',
                confirmButtonText: 'Vamos alla',
                background: 'white',
                customClass: {
                    icon: 'no-border'
                }
            })
        }
    }
})

}


function getobjmis() {
    let fd = new FormData();
    let request = new XMLHttpRequest();
    fd.append('droprate', dropratefinal);
    fd.append('oro', orocookie);
    request.open('POST', 'apipag/getobjmis.php', true);
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            let response = JSON.parse(request.responseText);
            console.log(response);
            console.log(response.datos.img);
            if (response.detail != true) {
                document.cookie = 'image=luna.jpg;';
            } else {
                image = response.datos.img;
                document.cookie = 'image=' + image + ';';
                console.log(image);
            }
        }
    }
    request.send(fd);
}

function updatem() {
    let fd = new FormData();
    let request = new XMLHttpRequest();
    request.open('POST', 'apipag/updfile.php', true);
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            let response = JSON.parse(request.responseText);
            console.log(response);
            showedf = parseInt(response.datos.showed);
            result = parseInt(response.datos.result);
            document.cookie = 'result=' + result + ';';
        }
    }
    request.send(fd);
}


function startmis(id) {
    let fd = new FormData();
    fd.append('id', id);
    fd.append('timeredobj', timeredobj);
    fd.append('goldaumobj', goldaumobj);
    fd.append('winrateobj', winrateobj);
    fd.append('droprateobj', droprateobj);
    let request = new XMLHttpRequest();
    request.open('POST', 'apipag/startmis.php', true);
    request.onload = function () {
        if (request.readyState == 4 && request.status == 200) {
            let response = JSON.parse(request.responseText);
            orofinal = parseInt(response.datos.goldf);
            dropratefinal = parseInt(response.datos.dropratef);
            document.cookie = 'orofinal=' + orofinal + ';';
            document.cookie = 'dropratefinal=' + dropratefinal + ';';
            console.log(response);
            location.reload();
        }
    }
    request.send(fd);
}

orocookie = document.cookie
    .split('; ')
    .find((row) => row.startsWith('orofinal='))
    ?.split('=')[1];


dropratefinal = document.cookie
    .split('; ')
    .find((row) => row.startsWith('dropratefinal='))
    ?.split('=')[1];
    
$(document).ready(function () {
    
    $.ajax({
        url: 'apipag/getobjdata.php',
        type: 'POST',
        data: {},
        success: function (data) {
            console.log(data.datos[0]);
            if (data.datos[0]['winrate'] > 100) {
                winrateobj = 100;
            } else {
                winrateobj = data.datos[0]['winrate'];
            }
            if (data.datos[0]['droprate'] > 100) {
                droprateobj = 100;
            } else {
                droprateobj = data.datos[0]['droprate'];
            }
            if (data.datos[0]['goldaum'] > 100) {
                goldaumobj = 100;
            } else {
                goldaumobj = data.datos[0]['goldaum'];
            }
            if (data.datos[0]['timered'] > 100) {
                timeredobj = 100;
            } else {
                timeredobj = data.datos[0]['timered'];
            }
        },
        error: function (err) {
            console.error(err);
        }
    });
    get_normal_misiones();
    document.cookie = "image=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.cookie = "result=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
});

