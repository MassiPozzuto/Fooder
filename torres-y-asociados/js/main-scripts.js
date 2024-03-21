///             INICIO FUNCIONES DE REPORTE             ///


function reportar_publicacion(datos, desc){

    $.ajax({
        url: "/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/reportar-publicacion.php"+datos,
        data: {desc: desc},
        type: 'POST',

        error: function(){
            alert('mal');
        },
    })
}

function reportar_comentario(datos, desc){

    $.ajax({
        url: '/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/reportar-comentario.php'+datos,
        data: {desc: desc},
        type: 'POST',

        error: function(){
            alert('mal');
        },
    })
}

function reportar_usuario(datos, desc){

    $.ajax({
        url: "/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/reportar-usuario.php"+datos,
        data: {desc: desc},
        type: 'POST',

        error: function(){
            alert('mal');
        },
    })
}

function delete_report(table, report_id, dest_id){

    $.ajax({
        url: "/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/eliminar-reporte.php",
        data: {from: table, id: report_id, dest: dest_id},
        type: 'POST',

        success: function(res){
            console.log(res);
            $('#'+report_id).fadeOut(); //dar animacion al eliminar
        },

        error: function(res){
            console.log(res);
        }
    })
}
function confirmar_borrar_reporte(table, report_id, dest_id){
    Swal.fire({
        
        html:'<h2 class="swal2-title" id="swal2-title" style="overflow: hidden;display: block;top:0%;">Quieres eliminar este reporte?</h2>',
        showDenyButton: true,
        confirmButtonText: 'SI',
        denyButtonText: `NO`,
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            delete_report(table, report_id, dest_id)
        }
      })
}
///         FIN FUNCIONES DE REPORTE            ///

///         Notificaciones               ///
function delete_notif(datos){

    $.ajax({
        url: '/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/eliminar-notificacion.php'+datos,

        success: function(){
            document.getElementById(datos).style.display = "none";
        },

        error: function(){
            alert('no dormir');
        }
    })
}
///         fin notificaciones          ///

///         comentarios         ///

function nick_com(datos){
    $.ajax({
        url: '/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/nickname-comentario.php'+datos,
        dataType: 'json',

        success: function(result){
            $('#dest').html('@'+result['nombre']);
            $('#idF').val(result['idF']);
        },

        error: function(result){
            alert(result);
        }
    })
    $("#comentar").focus();
}

function responder(){
    if($("#comentar").val().length !== 0){
        $.ajax({
            url: '/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/publicar-comentario.php',
            data: { comentar: $("#comentar").val(),
                    idP: $("#idP").val(),
                    idF: $("#idF").val(),
                  },
            type: 'POST',
            dataType: 'JSON',
    
            success: function(result){
                console.log(result);
                $('.com-empty').css('display', 'none');
                if(result[1] == 'com'){
                    const primer_comentario = document.getElementById("referent");
                    $(primer_comentario).prepend(result[0]);
                    location.hash = result[2];
                }
                else{
                    myf = $('#res-'+result[1]).parent();
                    console.log(myf.attr('class'));
                    
                    if(myf.attr('class') == 'div-respuestas'){
                        myf.append(result[0]);
                        location.hash = result[2];
                    }
                    
                    else{
                      
                        if($('#'+result[1]).next().attr('class') != 'div-respuestas'){
                            $('#'+result[1]).after('<div class="div-respuestas"><div class="flecha-btn-mostrar-respuesta"></div><input type="checkbox" id="btn-'+result[1]+'" class="btn-respuestas" style="display: none;" checked><label for="btn-'+result[1]+'" class="txt-mostrar-respuestas">Mostrar Respuestas</label>'+result[0]+'</div>');
                            location.hash = result[2];
                        }
    
                        else{
                            $('#'+result[1]).next().append(result[0]);
                            location.hash = result[2];
                        }
                    }
                }
            },
    
            error: function(re){
                console.log(re);
            }
        })
    $("#comentar").val("");
    $("#comentar").focus();
    }else{
        $("#comentar").focus();
    }
}
function enter(e){
    var tecla = e.keyCode;
    if(tecla == 13){
        responder();      
        $("#dest").html("");
        $('#idF').val(0); 
    }else if(tecla == 8 && document.getElementById("comentar").value.length == 0){
        $("#dest").html("");
        $('#idF').val(0);
    }
}
function like_com(datos){
    var com_id = datos.split("&");
    $.ajax({
        url: '/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/likes-comentarios.php'+datos,

        success: function(result){
            console.log(result);
            if(result == 'rojo'){
                document.getElementById(datos).setAttribute('src', 'img/corazon.png');
                likes_amount(datos, com_id[0]);
            }
            else if(result == 'blanco'){
                document.getElementById(datos).setAttribute('src', 'img/corazonvacio.png');
                likes_amount(datos, com_id[0]);
            }
        },
        error: function(resulta){
            console.log(resulta);
        }
    })
}

function likes_amount(datos, idtag){
    $.ajax({
        url: '/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/likes-com-cant.php'+datos,
        dataType: 'json',

        success: function(result){
            document.getElementById(idtag).innerHTML = result['likes']+'&nbsp;Me gusta';
        },

        error: function(result){
            alert(result);
        }
    })
}

//          FIN COMENTARIOS         //


//          LIKES-PUBLICACION       //

function contador_likes(publicacionId){
    var num;
    var pos;
    $.ajax({
        async: false,
        url: '/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/paginador/posts-contador_likes.php?publicacionId=' + publicacionId,
        dataType: 'html',
        success: function(result){
            num = result.split('\n');
            pos = num.length - 1;
        }
    });
    return num[pos];
}

function corazon(publicacionId, post_usuario){
    var res;
    $.ajax({
        async: false,
        url: '/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/paginador/posts-corazon.php?postId=' + publicacionId + '&usuId=' + post_usuario,
        dataType: 'html',
        success: function(result){
            res = result;
        }
    });
    return res;
}

function like_post(datos, post_id){
    //var post_id = datos.split("&");
    $.ajax({
        url:'/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/likes-publicacion.php' + datos,
        success: function(result){

            console.log(result);

            if(result == 'rojo'){
                document.getElementById(datos).setAttribute('src', 'img/corazon.png');
                likes_post_amount(datos, post_id);
            }
            else if(result == 'blanco'){
                document.getElementById(datos).setAttribute('src', 'img/corazonvacio.png');
                likes_post_amount(datos, post_id);
            }
        }
    })   
}

function pag_res(user, id){
    console.log(user+" "+id);
    $.ajax({
        url: '/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/comentarios/respuestas.php?id='+id,
        dataType: 'JSON',

        success: function(res){
            let commentsHtml = '';

            for(i=0; i<res.length; i++){
                res[i] = res[i].filter(e => e!=null);
            }
            console.log(res);
            res = res.join();
            res = res.split('fin');
            
            res.map(function(val, index){
                res[index] = res[index].split(',').filter(e=> e!="");
            });
            
            res.sort();
            res.shift();
            
            res.forEach(function(v, key){
                if(!document.getElementById("res-"+res[key][0])){
                    commentsHtml += `<div class="conteiner-respuestas" id="res-${res[key][0]}">`;
                    commentsHtml += `<div class="respuestas">`;
                    commentsHtml += `<a href="/proyectos/22-4.10-proyectos/torres-y-asociados/perfil-foraneo.php?id=${res[key][1]}" class="link-perfil"><img src="/proyectos/22-4.10-proyectos/torres-y-asociados/${res[key][7]}" class="img-usuario-comentarios"></a>`;
                    commentsHtml += `<p class="text-comentario">`;
                    commentsHtml += `<a href="/proyectos/22-4.10-proyectos/torres-y-asociados/perfil-foraneo.php?id=${res[key][1]}" class="link-nombre-perfil">${res[key][6]}</a>`;
                    commentsHtml += `<a href="#" class="tag-user-res">@${res[key][6]}</a>`;
                    commentsHtml += ` ${res[key][4]}`;
                    commentsHtml += `</p>`;
                    let fechaE = new Date(res[key][5]);
                    let fechaEnvio = new Date(fechaE.getFullYear() + '-' + (fechaE.getMonth() + 1) + '-' + fechaE.getDate()).getTime();
                    let fechaA = new Date();
                    let fechaActual = new Date(fechaA.getFullYear() + '-' + (fechaA.getMonth() + 1) + '-' + fechaA.getDate()).getTime();
                    let fechaPublicado = Math.round((fechaActual - fechaEnvio)/(1000*60*60*24));
                    if(fechaPublicado == 0){
                        commentsHtml += `<p class="dia-comentario">Hoy</p>`;
                    }else{
                        commentsHtml += `<p class="dia-comentario">${fechaPublicado}d</p>`;
                    }
                    commentsHtml += `<p class="cant-likes cant-likes-res" id="?id=${res[key][0]}">`;
                    if(typeof res[key][8] ===   'undefined'){
                        commentsHtml += "0";
                    }else{
                        console.log(res[key][8]);
                        commentsHtml += res[key][8];
                    }
                    commentsHtml += `&nbsp;Me gusta</p>`;
                    commentsHtml += `<a href="javascript:nick_com('?id=${res[key][1]}&idF=${res[key][0]}')" class="btn-responder-comentario">Responder</a>`;
                    commentsHtml += `<a href="javascript:like_com('?id=${res[key][0]}&idD=${res[key][1]}')" class="like-comentario"><img src=" `;
                    if(typeof res[key][10] === 'undefined'){
                        commentsHtml += "img/corazonvacio.png";
                    }
                    else{
                        commentsHtml += res[key][10];
                    }
                  
                    commentsHtml += `"id="?id=${res[key][0]}&idD=${res[key][1]}" class="img-like-comentario"></a>`; 
                    commentsHtml += `<button class="boton-in rep-comentario"><abbr title="Reportar comentario" style="cursor: pointer;"><i `
                    if(typeof res[key][9] === 'undefined'){
                        commentsHtml += "''";
                    }
                    else{
                        commentsHtml += res[key][9];
                    } 
                    commentsHtml += ` class="fas fa-flag" id="?id=${res[key][0]}&idU=${user}" onclick="reports('?id=${res[key][0]}&idU=${user}', ${reportar_comentario})"></i></abbr></button>`;
                    commentsHtml += `</div>`;
                    commentsHtml += `</div>`;
                    commentsHtml += `</div>`;
                   // console.log(commentsHtml);
                   $('#divR-'+id).append(commentsHtml);
                }
                commentsHtml = '';
            });
            console.log(res);
        },

        error: function(res){
            console.log(res);
        },
    })
}

function likes_post_amount(datos, idtag){
    $.ajax({
        url: '/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/likes-post-cant.php'+ datos,
        dataType: 'json',

        success: function(result){
            document.getElementById(idtag).innerHTML = result['likes'];
        },

        error: function(result){
            alert(result);
        }
    })
}

//          FIN LIKES PUBLICACION       //

//          INICIO EFECTOS          //

$(document).ready(function(){

    $('#eye4').click(function(){
        if($('#password2').attr('type') == 'password'){
        $('#password2').attr('type', 'text');
        $('#eye4').attr('src', 'img/ojito.png');
        }else{
        $('#password2').attr('type', 'password');
        $('#eye4').attr('src', 'img/ojo-tachado.png');
        }
    })

    // verifica si se subió un archivo correctamente //

    $('#subir-meme').change(function(){
        //console.log(this.files);
        if(this.files.length != 0){
            $('#label-input-file').css('border-color', 'green');
            $('#msg-file-upload').html('Se ha seleccionado una imagen correctamente');
            $('#msg-file-upload').css('color', 'green');
        }else{
            $('#label-input-file').css('border-color', 'red');
            $('#msg-file-upload').html('No se ha seleccionado una imagen');
            $('#msg-file-upload').css('color', 'red');
        }
    });

    // fin de verifica si se subió un archivo correctamente //

    //Busqueda en directo
    $('#busqueda').on('keyup', function() {
        var tecla = $(this).val();
        if(tecla.length != 0){
            var data = 'key='+tecla;
            $.ajax({
                type: "POST",
                url: "/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/busqueda-directa.php",
                data: data,
                success: function(data) {
                        $('#resultado_busqueda').css("display","block");
                        $('#resultado_busqueda').html(data);
                }
            });
        }else{
            $('#resultado_busqueda').css("display","none");
        }
    });

    
    window.setInterval(function(){
        if (document.getElementById('busqueda') !== document.activeElement){
            $('#resultado_busqueda').css("display","none");
        }
    }, 350);


    $('#d-more-btn-open').click(function(){
        if(document.getElementById('dropdown-more').style.display == 'none'){
            $('#dropdown-more').css('display', 'flex');
            $('#d-more-btn-open').css('border-left', 'none');
            $('#d-more-btn-open').html('<i class="fa-solid fa-arrow-left"></i>');
        }else{
            $('#dropdown-more').css('display', 'none');
            $('#d-more-btn-open').css('border-left', '');
            $('#d-more-btn-open').html('<i class="fa-solid fa-arrow-right"></i>');
        }
    });

    // Busqueda de categorias en el formulario de subir memes
    $('#buscador-categ').on('keyup', function() {
        var tecla = $(this).val();
        if(tecla.length != 0){
            var data = 'key='+tecla;
            $.ajax({
                async: false,
                type: "POST",
                url: "/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/busq-categs-post-form.php",
                data: data,
                success: function(data) {
                    $('#results-categs').html(data);

                    // Funcion para agregar las categorias
                    $('.suggested-categ').click(function(){

                        if($("#categs-area").children().length < 11){
                            idCateg = $(this).attr('id');
                            nombreCateg = $(this).html();

                            const categ = document.createElement('p');
                            categ.setAttribute('class', 'selected-categ');
                            categ.id = `c-${idCateg}`;
                            categ.innerHTML = `${nombreCateg}`;

                            const selected_categs = document.querySelectorAll('#categs-area .selected-categ');
                            categExist = false;

                            if(selected_categs.length != 0){
                                for(i = 0; i < selected_categs.length; i++){
                                    if(selected_categs[i].innerHTML == nombreCateg){
                                        categExist = true;
                                    }
                                }

                                if(categExist){
                                    $('#cagR').html('Esa categoria ya fue añadida').css('color', 'red');
                                    
                                    setTimeout(function(){
                                        $('#cagR').html('Haga clic sobre las categorias ingresadas para removerlas').css('color', "white");     
                                        // Mejorar Estilo del Mensaje y añadir idioma ingles
                                    },2000);
                                }else{
                                    document.getElementById('categs-area').appendChild(categ);
                                }

                            }else{
                                document.getElementById('categs-area').appendChild(categ);
                            }

                        }else{
                            $('#cagR').html('Ya hay 10 categorias').css('color', 'red');

                            setTimeout(function(){
                                $('#cagR').html('Haga clic sobre las categorias ingresadas para removerlas').css('color', "white");     
                                // Mejorar Estilo del Mensaje y añadir idioma ingles
                            },2000);
                        }

                        $('.selected-categ').click(function(){
                            idCateg = ($(this).attr('id')).split("-")[1];

                            document.getElementById('c-' + idCateg).remove();
                        });
                    });

                }
            });
        }else{
            $('#results-categs').html('<i style="color: #ffffff6a; user-select: none;">*Las categorias apareceran aqui*</i>');
        }
    });

    // Funcion que verifica si esa categoria existe, para luego verificar si ya estan las 10 y luego decidir si creala o no
    $('#btn-crear-categ').click(function(){
        var categToCreate = $('#create-categ').val();

        console.log(categToCreate);

        $.ajax({
            async: false,
            url: '/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/verif-categoria.php?categoria=' + categToCreate,
            success: function(result){
                if(result){
                    $('#cagR').html('La categoria que intenta crear ya existe').css('color', 'red');

                    setTimeout(function(){
                        $('#cagR').html('Haga clic sobre las categorias ingresadas para removerlas').css('color', "white");     
                        // Mejorar Estilo del Mensaje y añadir idioma ingles
                    },2000);
                }else{

                    if($("#categs-area").children().length < 11){
                        const selected_categs = document.querySelectorAll('#categs-area .selected-categ');
                        categExist = false;

                        const categ = document.createElement('p');
                        categ.setAttribute('class', 'selected-categ');
                        categ.id = `nC-${categToCreate}`;
                        categ.innerHTML = `${categToCreate}`;
                        
                        if(selected_categs.length != 0){
                            for(i = 0; i < selected_categs.length; i++){
                                if(selected_categs[i].innerHTML == categToCreate){
                                    categExist = true;
                                }
                            }

                            if(categExist){
                                $('#cagR').html('Esa categoria ya fue añadida').css('color', 'red');

                                setTimeout(function(){
                                    $('#cagR').html('Haga clic sobre las categorias ingresadas para removerlas').css('color', "white");     
                                    // Mejorar Estilo del Mensaje y añadir idioma ingles
                                },2000);
                            }else{
                                document.getElementById('categs-area').appendChild(categ);
                            }

                        }else{
                            document.getElementById('categs-area').appendChild(categ);
                        }
                    }else{
                        $('#cagR').html('Ya hay 10 categorias').css('color', 'red');

                        setTimeout(function(){
                            $('#cagR').html('Haga clic sobre las categorias ingresadas para removerlas').css('color', "white");
                        },2000);
                    }

                    $('.selected-categ').click(function(){
                        idCateg = ($(this).attr('id')).split("-")[1];

                        document.getElementById('nC-' + idCateg).remove();
                    });
                }
            }
        });
    });

    // Funcion que verifica que se hayan llenado los campos y concadena las categorias para luego hacer el submit
    $('#subir_post_submit').click(function(){
        const memeInput = document.getElementById('subir-meme');
        let memeExist = false;
        let categsExists = false;

        if(memeInput.files.length != 0){
            memeExist = true;
            $('#label-input-file').css('border-color', 'white');
        }else{
            $('#label-input-file').css('border-color', 'red');
        }

        if($("#categs-area").children().length != 1){
            categsExists = true;
            $('#add-cat').css('border-color', 'white');
        }else{
            $('#add-cat').css('border-color', 'red');
        }

        if(memeExist == true && categsExists == true){
            const categorias_ingresadas = document.querySelectorAll('#categs-area .selected-categ');
            let categorias = '';
            
            for(j = 0; j < categorias_ingresadas.length; j++){
                if(j == 0){
                    categorias += `${categorias_ingresadas[j].innerHTML}`;
                }else{
                    categorias += `-${categorias_ingresadas[j].innerHTML}`;
                }
            }
            
            $('#categorias').val(categorias);
            
            console.log(memeInput.files);
            console.log('Categorias: ' + categorias);
            
            setTimeout(function () {
                document.formulario_memes.submit();
            }, 500);
        }

    });

    // Borra la informacion del formulario de publicacion al presionar "Descartar"
    $('#cerrar').click(function(){
        const categorias_ingresadas = document.querySelectorAll('#categs-area .selected-categ');
        const memeInput = document.querySelector('#subir-meme');

        // Elimino las categorias
        for(i = 0; i < categorias_ingresadas.length; i++){
            categorias_ingresadas[i].remove();
        }

        // Elimino los archivos del input y los mensajes
        memeInput.value = '';
        $('#label-input-file').attr('style', '');
        $('#msg-file-upload').html('');
        $('#msg-file-upload').attr('style', '');
        $('#buscador-categ').val('');
        $('#results-categs').html('<i style="color: #ffffff6a; user-select: none;">*Las categorias apareceran aqui*</i>');
        $('#create-categ').val('');

    });
    
    //Subir arriba//
	$('.subir-arriva').click(function(){
		window.scrollTo({ top: 0, behavior: 'smooth' });
	});
    //directcionamiento publicacion
    $('.notifPub').click(function(){
        id = this.id
        id = id.split("-");
        $("#" + id[1]).css("animation","direc-notif-a .20s ease-out");
        setTimeout(function () { $("#" + id[1]).css("box-shadow","0 0 10px 10px gold");}, 200);
	});

    $('#add-cat').click(function(){
        $('#container-subir-meme').animate({opacity: 0}, 200);
        setTimeout(function(){$('#container-subir-meme').css('display', 'none');}, 200);
        $('#pub-op2').css('display', 'flex');
        $('#pub-op2').animate({opacity: 1},200);
        $('.go-back').css('display', 'flex');
    });

    $('.go-back').click(function(){
        $('#container-subir-meme').css('display', 'flex');
        $('#container-subir-meme').animate({opacity: 1}, 200);
        $('#pub-op2').animate({opacity: 0},200);
        setTimeout(function(){$('#pub-op2').css('display', 'none');}, 200);
        $('.go-back').css('display', 'none');
    })

    //reportes
    
    /*
    $('.fa-flag').click(function(){
        console.log($(this).attr('style'));
        where = $(this).parent().attr('title').split(' ');
        if(document.getElementById($(this).attr('id')).style.color == 'red'){
            func = 'reportar_'+where[1];
            switch (func){
                case "reportar_publicacion":
                    reportar_publicacion($(this).attr('id'));
                    break;
                case "reportar_comentario":
                    reportar_comentario($(this).attr('id'));
                    break;
                case "reportar_usuario":
                    reportar_usuario($(this).attr('id'));
                    break;
            }
            document.getElementById($(this).attr('id')).style.animation= "desreportar 0.25s ease-in";
            document.getElementById($(this).attr('id')).style.color = "black";
        }
        else{
            $('.modal-reportar').css('visibility', 'visible');
            $('.modal-reportar').animate({opacity: 1}, 500);
            $('#subR1').next().val('reportar_'+where[1]);
            $('#subR1').next().attr('class', $(this).attr('id'));
        }
    })
    
    $('#subR1').click(function(){
        if($('#descR').val() == ''){
            $('#msg-reportes').html('Complete el campo de texto');
            $('#msg-reportes').css('color', 'red');
        }else{
            $('#msg-reportes').html('Se envio el reporte exitosamente');
            $('#msg-reportes').css('color', 'green');
            setTimeout(function () {
                $('#msg-reportes').html('');
                document.getElementById($('#subR1').next().attr('class')).style.animation= "desreportar 0.25s ease-in";
                document.getElementById($('#subR1').next().attr('class')).style.color = "red";
                $('.modal-reportar').animate({opacity: 0}, 500);
                $('.modal-reportar').css('visibility', 'hidden');
                
                switch ($('#subR1').next().val()){
                    case "reportar_publicacion":
                        reportar_publicacion($('#subR1').next().attr('class'));
                        break;
                    case "reportar_comentario":
                        reportar_comentario($('#subR1').next().attr('class'));
                        break;
                    case "reportar_usuario":
                        reportar_usuario($('#subR1').next().attr('class'));
                        break;
                }
            }, 750);
        }
    })*/
    $('#subR1').click(function(){
        if($('#descR').val() == ''){
            $('#msg-reportes').html('Complete el campo de texto');
            $('#msg-reportes').css('color', 'red');
        }else{
            $('#msg-reportes').html('Se envio el reporte exitosamente');
            $('#msg-reportes').css('color', 'green');
            $('.modal-reportar').animate({opacity: 0}, 500);
            $('.modal-reportar').css('visibility', 'hidden');    
            from = $('#subR1').next().val();
            id = $('#subR1').next().attr('class');
            desc = $('#descR').val();
            console.log(from+''+id+''+desc);
            switch(from){
                case 'reportar_publicacion':
                    reportar_publicacion(id, desc);
                    break;
                case 'reportar_comentario':
                    reportar_comentario(id, desc);
                    break;
                case 'reportar_usuario':
                    reportar_usuario(id, desc);
                    break;
            }
            document.getElementById($('#subR1').next().attr('class')).style.animation= "desreportar 0.25s ease-in";
            document.getElementById($('#subR1').next().attr('class')).style.color = "red";
            $('#descR').val('');
            $('#msg-reportes').html('');
        }
    })

    $('#closeR').click(function(){
        $('#msg-reportes').html('');
        $('#subR1').next().attr('class', '');
        $('.modal-reportar').animate({opacity: 0}, 500); //fadeOut()
        $('.modal-reportar').css('visibility', 'hidden'); 
        $('#descR').val('');
    })

    //  Cerrar Session
    $('#cerrar-sess').click(function(){
        $('.modal-cerrar').css('visibility', 'visible');
        $('.modal-cerrar').fadeIn(200);
        $('.modal-cerrar').animate({opacity: 1}, 200);
    })
    $('#back-close').click(function(){
        $('.modal-cerrar').css('visibility', 'visible');
        $('.modal-cerrar').fadeOut(200);
    })
});

function reports(id, from){
    console.log(id+' '+from+''+document.getElementById(id).style.color);
    if(document.getElementById(id).style.color == 'red'){
        from(id, '');
        document.getElementById(id).style.animation= "desreportar 0.25s ease-in";
        document.getElementById(id).style.color = "black";
    }
    else{
        str = ''+from+'';
        $('.modal-reportar').css('visibility', 'visible');
        $('.modal-reportar').animate({opacity: 1}, 500)
        $('#subR1').next().val(str.split('(')[0].split('function')[1].split(' ')[1]);
        $('#subR1').next().attr('class', id);
    }
}

///             direccionamiento de notificaciones             ///
function color(x,id){
    if(x == "pub"){
        if(document.getElementById(id).style.boxShadow == "gold 0px 0px 10px 10px"){
            idPub = "#" + id;
            $(idPub).css("animation","direc-notif-b .20s ease-in");
            setTimeout(function () {$(idPub).css("box-shadow","var(--shadow-light)");},200)
        }
    }else{
        document.getElementById(x).style.border ="none";
    }
}