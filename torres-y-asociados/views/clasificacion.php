<div class="contenedor-top">
    <div class="fila">
        <div class="columnas" style="width: 34%; border-radius:0px;">Puesto</div>
        <div class="columnas" style="width: 33%; border-radius:0px;">Usuario</div>
        <div class="columnas" style="width: 34%; border-radius:0px;">Me gustas</div>
    </div>
    <?php //foreach ($likesTotales as $key => $usuario) { 
          for($k = 0; $k < count($likesTotales); $k++){?>
        <div class="fila">
            <div class="puesto-contenedor">
                <div class="puesto-clasificacion"><?php echo ($k + 1) ?></div>
                <?php
                $medalla = $k + 1;

                if ($medalla == 1) { ?>
                    <abbr title="Estas en el 1° puesto!!!"><img src="img/medalladeoro.png" class="medallas"></abbr>
                <?php } elseif ($medalla == 2) { ?>
                    <abbr title="Estas en el 2° puesto!!"><img src="img/medalladeplata.png" class="medallas"></abbr>
                <?php } elseif ($medalla == 3) { ?>
                    <abbr title="Estas en el 3° puesto!"><img src="img/medalladebronce.png" class="medallas"></abbr>
                <?php } else { ?>
                    <abbr title="Sube memes y consigue likes para subir de posición"><img src="img/medallanuv.png" class="medallasnuv"></abbr>
                <?php } ?>
            </div>
            <div class="user-top-container">
                <div class="prolife-image-top"><a href="<?php echo RUTA . "/perfil-foraneo.php?id=" . $likesTotales[$k][3]; ?>"><img src="<?php echo RUTA . "/" . $likesTotales[$k][1] //fotoPerfil ?>"></a></div>
                <p class="username-top"><a href="<?php echo RUTA . "/perfil-foraneo.php?id=" . $likesTotales[$k][3]; //usuario_id ?>" style="text-decoration: none;"><?php echo ($likesTotales[$k][2]) //nombreUsuario ?></a></p>
            </div>
            <div class="likes-contenedor">
                <div class="likes-image"><img src="<?php echo RUTA ?>/img/corazon.png"></div>
                <p class="likes-cantidad"><?php echo ($likesTotales[$k][0]) //likesTotales?></p>
            </div>
        </div>
    <?php } ?>
    <div class="filaF">
        <img src="<?php echo RUTA ?>/img/final-clas.png">
        <p>Final de la Clasificacion</p>
        <img src="<?php echo RUTA ?>/img/final-clas.png">
    </div>
</div>