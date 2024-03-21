<script>
    // Url
    let section = '<?php echo $section ?>';
    let pageNum = 1;
    let cantPostsToShow = 5;

    if(section == 'feed-principal'){
        var usu = '';
        var categ = '';
        var id = '';
    }else if(section == 'resultados-busqueda'){
        var categ = '&categ=<?php echo (isset($categ_buscada)) ? $categ_buscada : '' ?>';
        var usu = '';
        var id = '';
    }else if(section == 'galeria-usuario'){
        var categ = '';
        var usu = '&id=<?php echo (isset($id)) ? $id : '' ?>';
        var id = '';
    }else if(section == 'notif-post'){
        var categ = '';
        var usu = '';
        var id = '&idNP=<?php echo (isset($idPostNotif)) ? $idPostNotif : '' ?>';
    }
    
    // HTML Constructor
    let totalPages;
    let lastPost;
    let postsHtml = '';

    let censurarMeme = <?php echo $censuraMeme == false ? 'false' : 'true'?>;
    let lang = '<?php echo $lang ?>';
    let ruta = '<?php echo RUTA ?>';


    let observer = new IntersectionObserver((entries) => {
        console.log(entries);
        entries.forEach(entry => {
            if(entry.isIntersecting){
                // Elemento de carga
                const carga = document.createElement('div');
                carga.setAttribute('class', 'contenedor-gen-codigo');
                carga.id = 'contenedor-gen-codigo';
                carga.innerHTML = '<div class="carga"><div class="sombra-carga"></div></div>';
                document.getElementById('content').appendChild(carga);

                // Espera 1s y elimina le Element de carga para luego ejecutar la funcion de cargarPosts()
                setTimeout(function(){
                    pageNum++;
                    document.getElementById("contenedor-gen-codigo").remove();
                    cargarPosts();
                }, 700);
            }
        });
    }, {
        rootMargin: '0px 0px 0px 0px',
        threshold: 1.0
    });

    $.ajax({
        async: false,
        url: 'modelos/' + section + '/cant-pages.php?cantPosts=' + cantPostsToShow + categ + usu + id,
        dataType: 'json',
        success: function(infoPosts){
            totalPages = infoPosts;
        }
    })

    function cargarPosts() {
        $.ajax({
            async: false,
            url: 'modelos/' + section + '/' + section + '.php?page=' + pageNum + '&cantPosts=' + cantPostsToShow + categ + usu + id,
            dataType: 'json',
            success: function(publicaciones){

                $.ajax({
                    async: false,
                    url: 'modelos/paginador/posts-reportes.php',
                    dataType: 'json',
                    success: function(reportes){
                        if(publicaciones != ''){
                            publicaciones.forEach(function(publicacion) {
                                /*postsHtml += `<div class="conteiner-principal" id="${publicacion['publicacion_id']}" onmouseover="color('pub','${publicacion["publicacion_id"]}')">`;
                                    postsHtml += '<div class="info-persona">';
                                        postsHtml += '<div class="persona">';
                                                postsHtml += `<img src="${publicacion['fotoPerfil']}" class="foto-perfil-publicacion">`;
                                                postsHtml += `<a href="perfil-foraneo.php?id=${publicacion['usuario_id']}" class="nombre-usuario">${publicacion['nombreUsuario']}</a>`;
                                        postsHtml += '</div>';
                                        postsHtml += '<div>';
                                            postsHtml += '<button class="btn-report-perfil">';
                                                postsHtml += '<abbr title="Reportar publicacion" style="cursor: pointer;">';
                                                    postsHtml += '<i ';
                                                        reportes.forEach(function(reporte) {
                                                            if(publicacion['publicacion_id'] == reporte['publicacion_id']){
                                                                postsHtml += 'style="color: red;" ';
                                                            }
                                                        });
                                                    postsHtml += `class="<?php echo $clase == "dark" ? "whiteFlag" : "" ?> flag fa-solid fa-flag" id="?id=${publicacion['publicacion_id']}&idU=<?php echo $user['id']?>" onclick="reports('?id=${publicacion['publicacion_id']}&idU=<?php echo $user['id']?>', reportar_publicacion)"></i>`;
                                                postsHtml += '</abbr>';
                                            postsHtml += '</button>';
                                        postsHtml += '</div>';
                                    postsHtml += '</div>';
    
                                    postsHtml += '<div class="meme">';
                                        postsHtml += (censurarMeme == true && publicacion['censura'] == 'on') ? (lang == 'spanish' ? `<img src='${ruta}/img/censored-ES.png'>` : `<img src='${ruta}/img/censored-ENG.png'>`) : `<img src='${publicacion["rutaImagen"]}'>`;
                                    postsHtml += '</div>'; 
    
                                    postsHtml += '<div class="like-comentar">';
                                        postsHtml += '<div class="like">';
                                            postsHtml += `<a href="javascript:like_post('?idP=${publicacion['publicacion_id']}&id=${publicacion['usuario_id']}', '?idP=post-${publicacion['publicacion_id']}')" id="cor-postId-${publicacion['publicacion_id']}">`;
                                                postsHtml += corazon(publicacion['publicacion_id'], publicacion['usuario_id']);
                                            postsHtml += '</a>';
                                            postsHtml += `<a href="javascript:like_post('?idP=${publicacion['publicacion_id']}&id=${publicacion['usuario_id']}', '?idP=post-${publicacion['publicacion_id']}')" class="like-text" id="?idP=post-${publicacion['publicacion_id']}">`;
                                                postsHtml += contador_likes(publicacion['publicacion_id']);
                                            postsHtml += '</a>';
                                        postsHtml += '</div>';
                                        
                                        postsHtml += `<a href="${ruta}/comentarios.php?id=${publicacion['publicacion_id']}<?php if($section == 'galeria-usuario'){echo '&uId=' . $_GET['id'] ;} ?>&section=<?php if($section == 'feed-principal'){echo 0;}else if($section == 'galeria-usuario'){echo 1;}else if($section == 'resultados-busqueda'){echo 2 . '&categ=' . $categ_buscada;} ?>" class="link-boton-comentar">`;
                                            postsHtml += '<input type="button" class="boton-comentar" value="<?php echo ($language['feed-principal']['btn-comentarios']);?>">';
                                        postsHtml += '</a>';
                                    postsHtml += '</div>';
                                postsHtml += '</div>';*/



                                postsHtml += `<div class="album py-5">`;
                                    postsHtml += `<div class="row row-cols-1">`;
                                        postsHtml += `<div class="col conteiner-principal" style="margin: -20px auto;">`;
                                            postsHtml += `<div class="card shadow-sm post-layout">`;
                                                postsHtml += `<div class="info-persona">`;
                                                    postsHtml += `<div class="persona">`;
                                                        postsHtml += `<img src="${publicacion['fotoPerfil']}" class="foto-perfil-publicacion">`;
                                                        postsHtml += `<a href="perfil-foraneo.php?id=${publicacion['usuario_id']}" class="nombre-usuario">${publicacion['nombreUsuario']}</a>`;
                                                    postsHtml += `</div>`;
                                                        postsHtml += `<button class="btn-rep-feed">`;
                                                            postsHtml += `<abbr title="Reportar publicacion" style="cursor: pointer;">`;
                                                                postsHtml += `<i `;
                                                                reportes.forEach(function(reporte) {
                                                                    if(publicacion['publicacion_id'] == reporte['publicacion_id']){
                                                                        postsHtml += 'style="color: red;" ';
                                                                    }
                                                                });
                                                                postsHtml += `class="<?php echo $clase == "dark" ? "whiteFlag" : "" ?> flag fa-solid fa-flag" id="?id=${publicacion['publicacion_id']}&idU=<?php echo $user['id']?>" onclick="reports('?id=${publicacion['publicacion_id']}&idU=<?php echo $user['id']?>', reportar_publicacion)"></i>`;
                                                            postsHtml += `</abbr>`;
                                                        postsHtml += `</button>`;
                                                postsHtml += `</div>`;

                                                postsHtml += `<div class="bd-placeholder-img card-img-top" >`;
                                                    postsHtml += (censurarMeme == true && publicacion['censura'] == 'on') ? (lang == 'spanish' ? `<img src='${ruta}/img/censored-ES.png' class="meme-img">` : `<img src='${ruta}/img/censored-ENG.png' class="meme-img">`) : `<img src='${publicacion["rutaImagen"]}' class="meme-img">`;
                                                postsHtml += `</div>`;

                                                postsHtml += `<div class="card-body d-flex justify-content-between align-items-center like-comentar">`;
                                                    postsHtml += `<div class="btn-group like">`;
                                                        postsHtml += `<a href="javascript:like_post('?idP=${publicacion['publicacion_id']}&id=${publicacion['usuario_id']}', '?idP=post-${publicacion['publicacion_id']}')" id="cor-postId-${publicacion['publicacion_id']}">`;
                                                            postsHtml += corazon(publicacion['publicacion_id'], publicacion['usuario_id']);
                                                        postsHtml += `</a>`;
                                                        postsHtml += `<a href="javascript:like_post('?idP=${publicacion['publicacion_id']}&id=${publicacion['usuario_id']}', '?idP=post-${publicacion['publicacion_id']}')" class="like-text" id="?idP=post-${publicacion['publicacion_id']}">`;
                                                            postsHtml += contador_likes(publicacion['publicacion_id']);
                                                        postsHtml += `</a>`;
                                                    postsHtml += `</div>`;
                                                    
                                                    postsHtml += `<a href="${ruta}/comentarios.php?id=${publicacion['publicacion_id']}<?php if($section == 'galeria-usuario'){echo '&uId=' . $_GET['id'] ;} ?>&section=<?php if($section == 'feed-principal'){echo 0;}else if($section == 'galeria-usuario'){echo 1;}else if($section == 'resultados-busqueda'){echo 2 . '&categ=' . $categ_buscada;} ?>" class="text-muted">`;
                                                        postsHtml += `<input type="button" class="boton-comentar" value="<?php echo ($language['feed-principal']['btn-comentarios']);?>">`;
                                                    postsHtml += `</a>`;
                                                postsHtml += `</div>`;
                                            postsHtml += `</div>`;
                                        postsHtml += `</div>`;
                                    postsHtml += `</div>`;
                                postsHtml += `</div>`;

                            });
    
                            $('#content').html(postsHtml);
    
                            if(pageNum < totalPages){
                                if(lastPost){
                                    observer.unobserve(lastPost);
                                }
    
                                const postsEnPantalla = document.querySelectorAll('#content .conteiner-principal');
                                lastPost = postsEnPantalla[postsEnPantalla.length - 1];
    
                                observer.observe(lastPost);
                            }

                        }else{
                            if(section == 'galeria-usuario'){
                                $('#content').html(`<?php include_once 'includes/no-posts.php'; ?>`);
                            }else if(section != 'feed-principal'){
                                $('#content').html(`<?php include_once 'includes/category-not-found.php'; ?>`);
                            }
                        }
                    }, // complete: function() 
                })
            }
        });
    }

    cargarPosts();

</script>

<!--
    <div class="album py-5">
        <div class="row row-cols-1">
            <div class="col" style="margin: 30px auto;">
                <div class="card shadow-sm conteiner-principal">

                    <div class="info-persona">
                        <div class="persona">
                            <img src="http://localhost/proyectos/22-4.10-proyectos/torres-y-asociados/img/img-rand-perfil/1.png" class="foto-perfil-publicacion">
                            <a href="perfil-foraneo.php?id=1" class="nombre-usuario">YoSoyElMemingos</a>
                        </div>
                            <button class="btn-report-perfil">
                                <abbr title="Reportar publicacion" style="cursor: pointer;">
                                    <i class="whiteFlag flag fa-solid fa-flag" id="?id=7&idU=1"></i>
                                </abbr>
                            </button>
                    </div>

                    <div class="bd-placeholder-img card-img-top" >
                        <img src="http://localhost/proyectos/22-4.10-proyectos/torres-y-asociados/img/users/1/publicaciones/publicacion-n7.jpg" class="meme-img">
                    </div>

                    <div class="card-body d-flex justify-content-between align-items-center like-comentar">
                        <div class="btn-group like">
                            <a href="javascript:like_post('?idP=7&id=1', '?idP=post-7')" id="cor-postId-7">
                                <img src="/proyectos/22-4.10-proyectos/torres-y-asociados/img/corazon.png" align="right" style="display: block;" id="?idP=16&amp;id=1">
                            </a>
                            <a href="javascript:like_post('?idP=7&id=1', '?idP=post-7')" class="like-text" id="?idP=post-7">
                                4
                            </a>
                        </div>
                        
                        <a href="${ruta}/comentarios.php?id=7<?php if($section == 'galeria-usuario'){echo '&uId=' . $_GET['id'] ;} ?>&section=<?php if($section == 'feed-principal'){echo 0;}else if($section == 'galeria-usuario'){echo 1;}else if($section == 'resultados-busqueda'){echo 2 . '&categ=' . $categ_buscada;} ?>" class="text-muted">
                            <input type="button" class="boton-comentar" value="<?php echo ($language['feed-principal']['btn-comentarios']);?>">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->