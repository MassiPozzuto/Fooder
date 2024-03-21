<section class="lista-mod-conteiner">
    <div class="miguitas"><?php foreach ($rowRoles as $rowRol) {
                                if ($rowRol['perfil_id'] == 1) {
                                    echo ('<a href="' . RUTA . '/lista-admin.php"> '. $language['pan']["Admin"] .'</a> > ');
                                    break;
                                }
                            }
                            echo (isset($_GET["origen"]) ? '<a href="' . RUTA . "/lista-" . $_GET["origen"] . '.php">' . $language['pan'][$_GET["origen"]] . '</a>' : "?"); ?> > <?php echo $language['pan']['Comentarios']?> </div>
    <div class="columns-comments-mod-list">
        <div class="column">
            <?php echo $language['table']['pub']?>
        </div>
        <div class="column">
            <?php echo $language['table']['con']?>
        </div>
        <div class="column">
            <?php echo $language['table']['rep']?>
        </div>
        <div class="column">
            <?php echo $language['table']['ac']?>
        </div>
    </div>
    <div class="comments-list">
        <?php
        foreach (array_reverse($rowComentarios) as $rowComentario) {

            if ($rowComentario['fecha_baja'] != "") {
                $comntDelt = "delete";
                $comnMsg = $language['table']['addC'];
                $comnLink = "modelos/mod/mod-restaurar-comentario.php?id=" . $rowComentario['id'];
                $comnBtn = "btn-add-comment";
            } else {
                $comntDelt = "";
                $comnMsg = $language['table']['del'];
                $comnLink = "modelos/mod/mod-eliminar-comentario.php?id=" . $rowComentario['id'];
                $comnBtn = "btn-mod-list";
            } ?>

            <div class="comments <?php echo $comntDelt ?>">
                <div class="info-column">
                    <a href="comentarios.php?id=<?php echo $rowComentario['publicacion_id'] ?>&section=0#<?php echo $rowComentario['id'] ?>"><img src="<?php echo $rowComentario['rutaImagen'] ?>" class="post-img-com"></a>
                </div>
                <div class="info-column">
                    <?php echo "<p style='line-height: normal;'>" . $rowComentario['contenido'] . "</p>"; ?>
                </div>
                <div class="info-column">
                    <a href="reportes.php?sec=comentario&id=<?php echo ($rowComentario['id'] . "&origen=" . $_GET["origen"] . "&lista=Comentarios") ?>"><?php echo $rowComentario['cantR'] ?><i class="fas fa-flag"></i></a>
                </div>
                <div class="info-column btn-mod">
                    <a href="<?php echo ($comnLink . "&origen=" . $_GET["origen"] . "&lista=Comentarios") ?>" class="<?php echo $comnBtn ?>"><?php echo $comnMsg ?></a>
                </div>
            </div>
        <?php } ?>
    </div>
</section>