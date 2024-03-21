<section class="lista-mod-conteiner">
    <div class="miguitas"> <?php foreach ($rowRoles as $rowRol) {
                                if ($rowRol['perfil_id'] == 1) {
                                    echo ('<a href="' . RUTA . '/lista-admin.php"> ' . $language['pan']['Admin'] . '</a> > ');
                                    break;
                                }
                            } echo $language['pan']['Mod']?> > </div>
    <div class="menu-mod-list"><a href="<?php echo RUTA ?>/lista-usuarios.php?origen=Mod" class="btns-list">
            <div class="list-button">
                <?php echo $language['admin']['us']?>
            </div>
        </a><a href="<?php echo RUTA ?>/lista-publicaciones.php?origen=Mod" class="btns-list">
            <div class="list-button">
                <?php echo $language['admin']['pub']?>
            </div>
        </a><a href="<?php echo RUTA ?>/lista-comentarios.php?origen=Mod" class="btns-list">
            <div class="list-button">
                <?php echo $language['admin']['com']?> 
            </div>
        </a>
    </div>
</section>