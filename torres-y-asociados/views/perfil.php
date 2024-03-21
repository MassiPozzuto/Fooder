<div class="album py-5">
    <div class="row row-cols-1">
        <div class="col contenedor" style="margin: -25px auto;">
            <div class="card shadow-sm perfil-layout">
                <div class="bd-placeholder-img card-img-top info-perfil">
                    <div><img src="<?php echo $user['fotoPerfil'] ?>" class="foto-perfil-usuario"></div>
                    <div>
                        <p class="info-puesto">
                            <i class="star fa-solid fa-star">
                                <?php echo $language['perfil']['adv-puesto'];
                                $puesto = null;
                                for ($r = 0; $r < count($likesTotales); $r++) {
                                    if ($likesTotales[$r][3] == $user['id']) {
                                        $puesto = $r + 1;
                                    }
                                }
                                echo " " . $puesto;
                                ?>
                            </i>
                        </p>
                    </div>
                    <div>
                        <div class="info-nombre-usuario">
                            <p><?php echo $user['nombreUsuario'] ?></p>
                            <?php 
                                foreach($rowRoles as $userRol){
                                    if($userRol['perfil_id'] == 1){
                                        echo "<p class='adv-admin'>ADMIN</p>";
                                        echo "<p class='adv-mod'>MOD</p>";
                                        break;
                                    }else if($userRol['perfil_id'] == 2){
                                        echo "<p class='adv-mod'>MOD</p>";
                                        break;
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <div>
                        <p class="info-likes"><i class="heart fa-solid fa-heart"> <?php echo $likes ?></i></p>
                    </div>
                </div>
                <div class="card-body desc-posts">
                    <div class="card-text area-desc" style="width: 100%;"><?php echo $user['descripcion'] ?></div>
                    <div class="d-flex justify-content-between align-items-center contenerdor-publicaciones">
                        <div class="div-cont-opt">
                            <p class="contador-publicaciones"><?php echo ($cantPublicaciones . " " . $language['perfil']['adv-publicaciones']) ?></p>
                            <a href="galeria-usuario.php?id=<?php echo $user['id'] ?>" class="btn-ver-mas"><?php //echo $language['perfil']['adv-publicaciones'] ?>Ver más</a>
                        </div>
                    </div>
                    <div class="publicaciones">
                        <?php
                        if (isset($publicaciones)) {
                            do { ?>
                                <article class="publicacion"><a href="galeria-usuario.php?id=<?php echo $user['id'] ?>#<?php echo $publicaciones['id'] ?>"><img src="<?php echo (RUTA . "/" . $publicaciones["rutaImagen"]) ?>" class="img-publicacion"></a></article>
                        <?php   } while ($publicaciones = mysqli_fetch_assoc($result));
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</div>