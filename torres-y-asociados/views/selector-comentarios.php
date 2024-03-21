<script>
    /* -- Aqui estan todos los comentarios -- */

    // Url
    let pageNum = 1;
    let cantCommentsToShow = 15;
    let publicacion = '&id=<?php echo $_GET['id'] ?>';
    
    // HTML Constructor
    let totalPages;
    let lastComment;
    let commentsHtml = '';

    let idCom = '<?php echo (isset($_GET['idCom'])) ? $_GET['idCom'] : '' ?>';
    let ruta = '<?php echo RUTA ?>';
    let censuraComent = <?php echo $censuraComent == false ? 'false' : 'true' ?>;
    let palabras = <?php echo json_encode(file('includes/lista.txt')); ?>;
    let user = <?php echo $user['id'] ?>;
    let existWord;


    let observer = new IntersectionObserver((entries) => {
        console.log(entries);
        entries.forEach(entry => {
            if(entry.isIntersecting){
                // Elemento de carga
                const carga = document.createElement('div');
                carga.setAttribute('class', 'contenedor-gen-codigo');
                carga.id = 'contenedor-gen-codigo';
                carga.innerHTML = '<div class="carga"><div class="sombra-carga"></div></div>';
                document.getElementById('referent').appendChild(carga);

                // Espera 1s y elimina le Element de carga para luego ejecutar la funcion de cargarCommets()
                setTimeout(function(){
                    pageNum++;
                    document.getElementById("contenedor-gen-codigo").remove();
                    cargarComments();
                }, 700);
            }
        });
    }, {
        rootMargin: '0px 0px 0px 0px',
        threshold: 0.5
    });

    $.ajax({
        async: false,
        url: 'modelos/comentarios/cant-pages.php?cantComments=' + cantCommentsToShow + publicacion,
        dataType: 'json',
        success: function(infoComments){
            totalPages = infoComments;
            console.log('total pages: ' + totalPages);
        }
    })

    function cargarComments(){
        $.ajax({
            async: false,
            url: 'modelos/comentarios/comentarios.php?page=' + pageNum + '&cantComments=' + cantCommentsToShow + publicacion,
            dataType: 'json',
            success: function(user_comentarios){
                console.log(user_comentarios);
                if(user_comentarios != ''){
                    user_comentarios.forEach(function(user_comentario) {
                        if(user_comentario['padre_id'] == 0){
                            commentsHtml += `<div onmouseover="color(${user_comentario['com_id']})" class="comentario" id="${user_comentario["com_id"]}"`;
                                if(idCom != ''){
                                    if(user_comentario['com_id'] == idCom){
                                        commentsHtml += ' style="border:2px solid gold"';
                                    }
                                }
                            commentsHtml += '>';
                                commentsHtml += `<a href="${ruta}/perfil-foraneo.php?id=${user_comentario['usuario_id']}" class="link-perfil"><img src="${ruta}/${user_comentario['fotoPerfil']}" class="img-usuario-comentarios"></a>`;
                                commentsHtml += '<p class="text-comentario">';
                                    commentsHtml += `<a href="${ruta}/perfil-foraneo.php?id=${user_comentario['usuario_id']}" class="link-nombre-perfil">${user_comentario['nombreUsuario']}</a>`;
                                    if(censuraComent){
                                        palabras.forEach(function(palabra) {
                                            if(user_comentario['contenido'].toLowerCase().includes(palabra.trim())){
                                                existWord = true;
                                                commentsHtml += '<i> *Este comentario ha sido censurado*</i>';
                                            }
                                        });

                                        if(!existWord){
                                            commentsHtml += ` ${user_comentario['contenido']}`;
                                        }
                                    }else{
                                        commentsHtml += ` ${user_comentario['contenido']}`;
                                    }
                                commentsHtml += '</p>';
                                // Inicio - Fecha Constructor
                                let fechaE = new Date(user_comentario['fecha_alta']);
                                let fechaEnvio = new Date(fechaE.getFullYear() + '-' + (fechaE.getMonth() + 1) + '-' + fechaE.getDate()).getTime();
                                let fechaA = new Date();
                                let fechaActual = new Date(fechaA.getFullYear() + '-' + (fechaA.getMonth() + 1) + '-' + fechaA.getDate()).getTime();
                                let fechaPublicado = Math.round((fechaActual - fechaEnvio)/(1000*60*60*24)); // Lo convierte a dias
                                // Fin - Fecha Constructor
                                commentsHtml += fechaPublicado == 0 ? '<p class="dia-comentario">Hoy</p>' : `<p class="dia-comentario">${fechaPublicado}d</p>`;
                                commentsHtml += `<p class="cant-likes" id="?id=${user_comentario['com_id']}">${user_comentario['cantidad_likes']}&nbsp;Me gusta</p>`;
                                commentsHtml += `<a href="javascript:nick_com('?id=${user_comentario['usuario_id']}&idF=${user_comentario['com_id']}')" class="boton-responder-comentario">Responder</a>`;
                                commentsHtml += `<a href="javascript:like_com('?id=${user_comentario['com_id']}&idD=${user_comentario['usuario_id']}')" class="like-comentario"><img src="${user_comentario['color']}" id="?id=${user_comentario['com_id']}&idD=${user_comentario['usuario_id']}" class="img-like-comentario"></a>`;
                                commentsHtml += `<button class="boton-in rep-comentario"><abbr title="Reportar comentario" style="cursor: pointer;"><i ${user_comentario['reporte']} class="fas fa-flag" id="?id=${user_comentario['com_id']}&idU=${user}" onclick="reports('?id=${user_comentario['com_id']}&idU=${user}', reportar_comentario)"></i></abbr></button>`;
                            commentsHtml += '</div>';

                            if(user_comentario['espadre'] == 'si'){
                                commentsHtml += '<div class="div-respuestas" id=divR-'+user_comentario['com_id']+'>';
                                    commentsHtml += '<div class="flecha-btn-mostrar-respuesta"></div>';
                                    commentsHtml += `<input type="checkbox" id="btn-${user_comentario['com_id']}" class="btn-respuestas" style="display: none;">`;
                                    commentsHtml += `<label for="btn-${user_comentario['com_id']}" class="txt-mostrar-respuestas" onclick="pag_res('${user}', '${user_comentario['com_id']}')">Mostrar Respuestas</label>`;
                                commentsHtml += '</div>';
                            }
                        }
                    });

                    $('#referent').html(commentsHtml);

                    console.log(`Page: ${pageNum} - Cant Pages: ${totalPages}`);

                    if(pageNum < totalPages){
                        if(lastComment){
                            observer.unobserve(lastComment);
                        }

                        const commentsEnPantalla = document.querySelectorAll('#content #referent .comentario');
                        lastComment = commentsEnPantalla[commentsEnPantalla.length - 1];
                        
                        observer.observe(lastComment);
                    }
                }else if(pageNum = 1 && user_comentario == ""){
                    $('#referent').html('<p class="com-empty">Se el primero en comentar</p>'); //Agregar mejores estilos
                }
            },
            error: function(res){
                console.log(res);
            }
        })
    }

    cargarComments();

</script>