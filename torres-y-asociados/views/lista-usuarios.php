<?php if ($_GET["origen"] == "Admin") { ?>
    <section class="lista-mod-conteiner">
        <div class="miguitas"><?php echo (isset($_GET["origen"]) ? '<a href="' . RUTA . "/lista-" . $_GET["origen"] . '.php">' . $language['pan'][$_GET["origen"]] . '</a>' : "?"); ?> > <?php echo $language['pan']['Usuarios']?> </div>
        <div class="columns-users-mod-list">
            <div class="column">
                <p><?php echo $language['table']['fo']?></p>
            </div>
            <div class="column">
                <p><?php echo $language['table']['nick']?></p>
            </div>
            <div class="column">
                <p><?php echo $language['table']['desc']?></p>
            </div>
            <div class="column">
                <p><?php echo $language['table']['rep']?></p>
            </div>
            <div class="column">
                <p><?php echo $language['table']['ac']?></p>
            </div>
        </div>
        <!-- comienzo de usuarios -->
        <div class="mods-list">
            <?php for ($i = 0; $i < count($rowUsuarios); $i++) {
                if ($rowUsuarios[$i][4] == 1) {
                    $i += 2;
                    continue;
                } else if ($rowUsuarios[$i][4] == 2) {
                    $i++;
                    continue;
                } ?>

                <div class="mods <?php echo $rowUsuarios[$i][6] != "" ? 'delete' : '' ?>">
                    <div class="info-column">
                        <img class="info-column-img" src="<?php echo (RUTA . "/" . $rowUsuarios[$i][1]) //fotoPerfil ?>">
                    </div>
                    <div class="info-column"><?php echo $rowUsuarios[$i][2] //nombreUsuario ?> </div>
                    <div class="info-column"><?php echo $rowUsuarios[$i][3] //descripcion ?></div>
                    <div class="info-column">
                        <a href="reportes.php?sec=usuario&id=<?php echo ($rowUsuarios[$i][0] . "&origen=" . $_GET["origen"] . "&lista=Usuarios"); ?>"><?php echo $rowUsuarios[$i][7] ?> <i class="fas fa-flag"></i></a>
                    </div>
                    <div class="info-column btn-mod">
                        <?php
                            if($rowUsuarios[$i][6] != ""){
                                echo '<a class="btn-add-comment" href="'.RUTA.'/modelos/mod/mod-restaurar-usuario.php?id='.$rowUsuarios[$i][0].'&origen='.$_GET["origen"].'&lista=usuarios">Desbanear Usuario</a>';
                            }else{
                                echo '<a class="btn-mod-list" href="'.RUTA.'/modelos/agregar-mod.php?id='.$rowUsuarios[$i][0].'&origen='.$_GET["origen"].'&lista=usuarios">'.$language['table']['adda'].'</a>';
                                echo '<a class="btn-mod-list" href="'.RUTA.'/modelos/agregar-admin.php?id='.$rowUsuarios[$i][0].'&origen='.$_GET["origen"].'&lista=usuarios">'.$language['table']['addm'].'</a>';
                                echo '<a class="btn-mod-list" href="'.RUTA.'/modelos/mod/mod-eliminar-usuario.php?id='.$rowUsuarios[$i][0].'&origen='.$_GET["origen"].'&lista=usuarios">'.$language['table']['delU'].'</a>';
                            }
                        ?>
                    </div>
                </div>
            <?php }
            ?>
        </div>
    </section>
<?php } else if ($_GET["origen"] == "Mod") { ?>
    <section class="lista-mod-conteiner">
        <div class="miguitas"><?php  foreach ($rowRoles as $rowRol) {
                                if ($rowRol['perfil_id'] == 1) {
                                    echo ('<a href="' . RUTA . '/lista-admin.php"> '. $language['pan']['Admin'] .'</a> > ');
                                    break;
                                }
                            }  echo (isset($_GET["origen"]) ? '<a href="' . RUTA . "/lista-" . $_GET["origen"] . '.php">' . $language['pan']['Mod'] . '</a>' : "?"); ?> > <?php echo $language['pan']['Usuarios']?> </div>
        <div class="columns-users-mod-list">
            <div class="column">
                <p><?php echo $language['table']['fo']?></p>
            </div>
            <div class="column">
                <p><?php echo $language['table']['nick']?></p>
            </div>
            <div class="column">
                <p><?php echo $language['table']['desc']?></p>
            </div>
            <div class="column">
                <p><?php echo $language['table']['rep']?></p>
            </div>
            <div class="column">
                <p><?php echo $language['table']['ac']?></p>
            </div>
        </div>
        <div class="users-list">
            <?php for ($i = 0; $i < count($rowUsuarios); $i++) {
                    if ($rowUsuarios[$i][4] == 1) {
                        $i += 2;
                        continue;
                    } else if ($rowUsuarios[$i][4] == 2) {
                        $i++;
                        continue;
                    }?>

                <div class="user <?php echo $rowUsuarios[$i][6] != "" ? 'delete' : '' ?>">
                    <div class="info-column">
                        <img src="<?php echo $rowUsuarios[$i][1] //fotoPerfil
                                    ?>" class="info-column-img">
                    </div>
                    <div class="info-column">
                        <?php echo $rowUsuarios[$i][2] //nombreUsuario
                        ?>
                    </div>
                    <div class="info-column">
                        <?php echo "<p style='line-height: normal;'>" . $rowUsuarios[$i][3]  . "</p>"; //descripcion
                        ?>
                    </div>
                    <div class="info-column">
                        <a href="reportes.php?sec=usuario&id=<?php echo($rowUsuarios[$i][0] . "&origen=" . $_GET["origen"] . "&lista=Usuarios"); ?>"><?php echo $rowUsuarios[$i][7] ?><i class="fas fa-flag"></i></a>
                    </div>
                    <div class="info-column btn-mod">
                        <?php
                            if($rowUsuarios[$i][6] != ""){
                                echo '<a class="btn-add-comment" href="'.RUTA.'/modelos/mod/mod-restaurar-usuario.php?id='.$rowUsuarios[$i][0].'&origen='.$_GET["origen"].'&lista=usuarios">Desbanear Usuario</a>';
                            }else{
                                echo '<a class="btn-mod-list" href="'.RUTA.'/modelos/mod/mod-eliminar-usuario.php?id='.$rowUsuarios[$i][0].'&origen='.$_GET["origen"].'&lista=usuarios">'.$language['table']['delU'].'</a>';
                                echo '<a class="btn-mod-list" href="'.RUTA.'/modelos/mod/mod-censurar-descripcion.php?id='.$rowUsuarios[$i][0].'&origen='.$_GET["origen"].'&lista=usuarios">'.$language['table']['cenD'].'</a>';
                            }
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section><?php } ?>