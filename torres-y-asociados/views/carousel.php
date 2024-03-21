<?php require_once "modelos/mayor-comentario.php"; ?>
<?php require_once "modelos/mayor-publicacion.php"; ?>
<section class="carrusel">
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="5" aria-label="Slide 6"></button>
        </div>
        <div class="carousel-inner">
            <?php
            /*carrusel publicaciones */
            $active = " active";
            foreach ($mayorPub as $carrusel) { ?>
                <div class="carousel-item<?php echo ($active); ?>">
                    <img src="<?php echo RUTA . "/" . $carrusel['rutaImagen'] ?>" class="d-block w-100 img-carrusel" alt="...">
                    <div class="carousel-caption d-none d-md-block label-carrusel">
                        <i>
                            <h2>MEJORES MEMES DE LA PAGINA</h2>
                            <h4>Meme hecho por: <?php echo ($carrusel['nombreUsuario']); ?> con <?php echo ($carrusel['cantLikes']); ?> likes</h4>
                        </i>
                    </div>
                </div><?php $active = "";
                    } ?>
            <?php
            /*carrusel comentarios */
            foreach ($mayorCom as $carruselCom) { ?>
                <div class="carousel-item">
                    <div class="com-carrusel" style="margin-top: 0;">
                        <a class="a-img-com-car" href="<?php echo RUTA . "/perfil-foraneo.php?id=" . $carruselCom['usuario_id']; ?>"><img class="img-com-car" src="<?php echo RUTA . "/" . $carruselCom['fotoPerfil'] ?>" alt="..."></a>
                        <p class="d-block w-100 text-com-carr">
                            <a href="<?php echo RUTA . "/perfil-foraneo.php?id=" . $carruselCom['usuario_id']; ?>" class="link-nombre-perfil-carrusel"><?php echo $carruselCom['nombreUsuario'] ?></a><br><a href="<?php echo RUTA ?>/comentarios.php?id=<?php echo $carruselCom['publicacion_id']?>&idCom=0&idR=0" class="link-com-car"><?php echo $carruselCom['contenido']?></a>
                        </p>
                    </div>
                    <div class="carousel-caption d-none d-md-block">
                        <i class="label-carrusel-com">
                            <h2>MEJORES COMENTARIOS DE LA PAGINA</h2>
                            <h4>Este comentario tiene: <?php echo ($carruselCom['cantLikesC']); ?> likes</h4>
                        </i>
                    </div>
                </div>
            <?php } ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" style="z-index:4;" data-bs-slide="prev">
            <span class="carousel-control-prev-icon boton-carrusel" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon boton-carrusel" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>