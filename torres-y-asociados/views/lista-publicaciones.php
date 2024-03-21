<section class="lista-mod-conteiner">
    <div class="miguitas"><?php foreach ($rowRoles as $rowRol) {
                                if ($rowRol['perfil_id'] == 1) {
                                    echo ('<a href="' . RUTA . '/lista-admin.php"> '. $language['pan']['Admin'] .'</a> > ');
                                    break;
                                }
                            }
                            echo (isset($_GET["origen"]) ? '<a href="' . RUTA . "/lista-" . $_GET["origen"] . '.php">' . $language['pan'][$_GET["origen"]]. '</a>' : "?"); ?> > <?php echo $language['pan']['Publicaciones']?> </div>
    <div class="columns-posts-mod-list">
        <div class="column">
            <?php echo $language['table']['con']?>
        </div>
        <div class="column">
            <?php echo $language['table']['ca']?>
        </div>
        <div class="column">
            <?php echo $language['table']['rep']?>
        </div>
        <div class="column">
            <?php echo $language['table']['ac']?>
        </div>
    </div>
    <div class="posts-list">
        <?php
        foreach (array_reverse($rowPublicaciones) as $rowPublicacion) {
            if ($rowPublicacion['fecha_baja'] != "") {
                $postDelt = "delete";
                $postMsg = $language['table']['addP'];
                $postLink = "modelos/mod/mod-restaurar-publicacion.php?id=" . $rowPublicacion['id'];
                $postBtn = "btn-add-comment";
            } else {
                $postDelt = "";
                $postMsg = $language['table']['delP'];
                $postLink = "modelos/mod/mod-eliminar-publicacion.php?id=" . $rowPublicacion['id'];
                $postBtn = "btn-mod-list";
            } ?>

            <div class="post <?php echo $postDelt ?>">
                <div class="info-column">
                    <img src="<?php echo $rowPublicacion['rutaImagen'] ?>" class="post-img">
                </div>
                <div class="info-column">
                    <?php
                    foreach ($rowPubliCategs as $rowPubliCateg) {
                        if ($rowPubliCateg['publicacion_id'] == $rowPublicacion['id']) {
                            echo "<p style='line-height: normal;'>" . $rowPubliCateg['nombre'] . "</p>";
                        }
                    }
                    ?>
                </div>
                <div class="info-column">
                    <a href="reportes.php?sec=publicacion&id=<?php echo ($rowPublicacion['id'] . "&origen=" . $_GET["origen"] . "&lista=Publicaciones") ?>"><?php echo $rowPublicacion['cantR'] ?><i class="fas fa-flag"></i></a>
                </div>
                <div class="info-column btn-mod">
                    <a href="<?php echo ($postLink . "&origen=" . $_GET["origen"] . "&lista=Publicaciones"); ?>" class="<?php echo $postBtn ?>"><?php echo $postMsg ?></a>
                    <br>
                    <?php
                    if ($rowPublicacion['censura'] == 'off') {
                        $censored = "off";
                        $msg = $language['table']['cen'];
                    } else {
                        $censored = "on";
                        $msg = $language['table']['uncen'];
                    }
                    ?>
                    <a href="modelos/mod/mod-censurar-publicacion.php?id=<?php echo ($rowPublicacion['id'] . "&cens=" . $censored . "&origen=" . $_GET["origen"] . "&lista=Publicaciones") ?>" class="btn-mod-list"><?php echo $msg ?></a>
                </div>
            </div>
        <?php } ?>
    </div>
</section>