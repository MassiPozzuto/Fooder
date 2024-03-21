<nav class="navbar navbar-expand-sm navbar-dark header" aria-label="Third navbar example">
    <!-- <div class="div-anim-clasificacion">
        <div class="boton-clasificacion">
            <a href="<?php echo RUTA ?>/clasificacion.php"><img src="<?php echo RUTA ?>/img/clasificacion-imagen.png" class="clasif-nav-bar"></a>
        </div>
    </div> -->

    <div class="container-fluid">
        <a class="nav-link link-nav-opcion" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?php echo RUTA ?>/img/icon-menu.png" class="img-nav-bar bi me-2">
        </a>
        <ul class="dropdown-menu list-conteiner">
            <div class="menu-conteiner">
                <li class="menu-item"><a href="<?php echo RUTA ?>/perfil.php" class="link-nav-opcion link-menu-opcion"><i class="fa-solid fa-circle-user"></i> <?php echo $language['nav-bar']['btn-perfil'] ?></a></li>
                <li class="menu-item"><a href="<?php echo RUTA ?>/ajustes-de-cuenta.php?erru=0&errm=0&errc=0" class="link-nav-opcion link-menu-opcion"><i class="fa-solid fa-gear"></i> <?php echo $language['nav-bar']['btn-ajustesCuenta'] ?></a></li>
                <li class="menu-item"><a href="<?php echo RUTA ?>/preferencias.php" class="link-nav-opcion link-menu-opcion"><i class="fa-solid fa-star"></i> <?php echo $language['nav-bar']['btn-preferencias'] ?></a></li>
                <?php
                    if($section != "feed-principal"){
                        echo ("<li class='menu-item'><a href='" . RUTA . "'/feed-principal.php' class='link-nav-opcion link-menu-opcion'><i class='fa-solid fa-circle-arrow-left'></i> ".$language['nav-bar']['btn-feedPrincipal']."</a></li>");
                    }
                ?>
                <li><hr class="dropdown-divider d-color"></li>
                <li id="cerrar-sess" class="menu-item"><a class="link-nav-opcion link-menu-opcion"><i class="fa-sharp fa-solid fa-right-from-bracket"></i> <?php echo $language['ajustesCuenta']['btn-logOut'] ?></a></li>
            </div>
        </ul>

        <button style="border: none;" class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-magnifying-glass" style="font-size: 40px; color: white;"></i>
        </button>

        <div class="navbar-collapse collapse" id="navbarsExample03">
            <form method="POST" style="width: 100%;" action="resultados-busqueda.php" role="search">
                <input type="search" class="form-control buscador" id="busqueda" name="busqueda" autocomplete="off" required placeholder=" <?php echo $language['nav-bar']['buscador'] ?>" aria-label="Search">
                <input type="submit" style="display: none;">
            </form>
            <div id="resultado_busqueda"></div>
        </div>

        <input type="checkbox" id="bts-modal-publicar">
        <label for="bts-modal-publicar" class="link-nav-opcion"><img src="<?php echo RUTA ?>/img/publicar.png" class="img-nav-bar"></label>
        <div class="modal-publicar">   
            <div id="container-subir-meme" class="container-subir-meme">
                <form method="POST" id="fomulario_memes" name="formulario_memes" action="modelos/publicar-meme.php" enctype="multipart/form-data">
                    <div class="opciones-meme">
                        <label id="label-input-file" class="p-input p-meme" style="cursor: pointer;" for="subir-meme"><i class="fa-solid fa-file-image p-icon"></i><p><?php echo $language['nav-bar']['btn-ingresarMeme'] ?></p></label>
                        <p id="msg-file-upload"></p>
                        <input type="file" id="subir-meme" name="meme" style="display: none;" accept="image/*, .gif">
                        <!-- <p class="p-input">e</p> -->
                        <input type="hidden" class="p-input" name="categorias" id="categorias">
                        <p class="p-input p-meme" style="cursor: pointer;" id="add-cat"><?php echo $language['nav-bar']['add-cags']?></p>
                        <div class="publicar-buttons">
                            <label for="bts-modal-publicar" id="cerrar" class="close-publicar-button"><?php echo $language['nav-bar']['btn-descartar'] ?></label>
                            <a id="subir_post_submit" class="subir-meme-button"><?php echo $language['nav-bar']['btn-publicar'] ?></a>
                        </div>
                    </div> 
                </form>
            </div>
            <div class="go-back">
                <p><</p>
            </div>
            <div class="container-subir-meme" id="pub-op2">
                <div class="opciones-meme">
                    <div class="buscador-creador">
                        <input type="text" id="buscador-categ" placeholder="<?php echo $language['nav-bar']['buscador']?>" class="p-input" style="width: 100%; font-size: 17px;" autocomplete="off">  
                    </div>
                    <div id="results-categs" class="p-input results-categs">
                        <i style="color: #ffffff6a; user-select: none;">*Las categorías aparecerán aquí*</i>
                    </div>
                    <div id="categs-area" class="categorias p-input results-categs" style="text-align: start; font-weight: 500;">
                        <p class="categorias-title" style="background: none;"><?php echo $language['table']['ca']?></p>
                    </div>
                    <p class="categorias" id='cagR'>Haga clic sobre las categorias ingresadas para removerlas</p>
                    <div class="buscador-creador" style="border-top: solid 2px white">
                        <input type="text" id="create-categ" class="p-input" placeholder="<?php echo $language['nav-bar']['createC']?>" style="width: 50%; font-size: 17px;" maxlength="20" autocomplete="off">
                        <a id="btn-crear-categ" class="btn-crear"><?php echo $language['nav-bar']['btn-make']?></a>
                    </div>
                </div>
                <!--<div style="height: 80px"> Para nivelar ambos divs -->
            </div>
        </div>

        <a class="navbar-brand nav-link link-nav-opcion img-campana" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
            <img src="<?php echo RUTA ?>/img/campana.png" class="img-nav-bar hvr-buzz-out ">
        </a>
        <ul class="dropdown-menu dropdown-menu-end notificaciones-container" style="position: absolute; right: 0;">
            <?php if (isset($notificaciones)) {?>
                    <?php foreach ($notificaciones as $notificacion) {?>
                    <li class="notificacion" id="?id=<?php echo $notificacion['id_N']?>">
                        <img src="<?php echo $notificacion['fotoPerfil'];?>" class="foto-usuario-not">
                        <?php if($notificacion['tipo_notificacion_id'] == 1){ ?>
                            <p class="mensaje-notificacion notifPub" id="Notif-<?php echo($notificacion['pub_id'])?>"><a href="<?php echo RUTA ?>/notif-post.php?id=<?php echo $notificacion['pub_id']?>">Alguien dio like a tu publicacion</a></p>
                        <?php } else if($notificacion['tipo_notificacion_id'] == 2){?>
                            <p class="mensaje-notificacion"><a href="comentarios.php?id=<?php echo $notificacion['publicacion_id']?>&idCom=<?php echo $notificacion['com_id']?>&section=0#<?php echo $notificacion['com_id']?>">Alguien dio like a tu comentario</a></p>   
                        <?php } else if($notificacion['tipo_notificacion_id'] == 4){?>
                            <p class="mensaje-notificacion">Tu cuenta ha sido amonestada por reportes fraudulentos</p>
                        <?php }?>
                        <p class="fecha-notificacion"><?php echo $notificacion['fecha_actual']?></p>
                        <div class="div-borrar-not" ><button onclick="delete_notif('?id=<?php echo $notificacion['id_N']?>')" class="borrar-notificacion boton-in"><img src="<?php echo RUTA ?>/img/eliminar.png"></button></a></div>
                    </li>
            <?php } }  else {?>
                    <p class="notif-empty"><?php echo $language['nav-bar']['adv-notificaciones'] ?></p>
            <?php }?>
        </ul>
    </div>

    <div class="modal-reportar">
        <div class="containerR">
            <div class="exitR">
                <p id="closeR">X</p>
            </div>
            <h3><?php echo $language['nav-bar']['rep-msg']?></h3>
            <textarea placeholder="<?php echo $language['nav-bar']['rep-desc']?>" id="descR" cols="30" rows="5" class="rep-desc" maxlength="81"></textarea>
            <p id='msg-reportes'></p>
            <div class="optionsR">
                <input type="button" value="<?php echo $language['nav-bar']['btn-publicar']?>" class="subR" id="subR1">
                <input type="hidden" value="">
            </div>
        </div>
    </div>
    <div class="modal-cerrar">
        <div class="close">
            <div id="secC">
                <p><?php echo $language['nav-bar']['mdc-q']?></p>
            </div>
            <div id="secC2">
                <a href="<?php echo RUTA ?>/modelos/cerrar-sesion.php"><?php echo $language['nav-bar']['1']?></a>
                <p id="back-close"><?php echo $language['nav-bar']['0']?></p>
            </div>
        </div>
    </div>
</nav>