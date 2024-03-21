<div class="list-report">
    <div class="miguitas"><?php if($_GET["origen"] != "Admin"){foreach ($rowRoles as $rowRol) {
                                if ($rowRol['perfil_id'] == 1) {
                                    echo ('<a href="' . RUTA . '/lista-admin.php"> '.$language['pan']['Admin'].'</a> > ');
                                    break;
                                }
                            } }echo(isset($_GET["origen"])?'<a href="'.RUTA."/lista-".$_GET["origen"].'.php">'.$language['pan'][$_GET["origen"]].'</a>':"?");?> > <?php echo(isset($_GET["lista"])?'<a href="'.RUTA."/lista-".$_GET["lista"].'.php?origen='.$_GET["origen"].'">'.$language['pan'][$_GET["lista"]].'</a>':"?");?> > <?php echo $language['pan']['rep']?> </div>
    <h3><?php echo $language['table']['rR']?></h3>
    <div class="comentsR">
        <?php foreach($result as $comReport){?>
            <div class="comentario hvr-float-shadow" style="border: dashed 3px white" id="<?php echo $comReport['rep_id']?>">
                <a href="perfil-foraneo.php?id=<?php echo $comReport['id']?>" class="link-perfil"><img src="<?php echo $comReport['fotoPerfil']?>" class="img-usuario-comentarios"></a>
                <p class="text-comentario">
                    <a href="perfil-foraneo.php?id=<?php echo $comReport['id']?>" class="link-nombre-perfil"><?php echo $comReport['nombreUsuario']?></a>
                    <?php echo $comReport['descrip']?>
                </p>
                <p class="dia-comentario"><?php echo $comReport['fecha_alta']?></p>
                <a href="javascript:confirmar_borrar_reporte('<?php echo $comReport['from_table']?>', '<?php echo $comReport['rep_id']?>', '<?php echo $comReport['id']?>')" class="like-comentario"><img src="img/eliminar.png" class="img-like-comentario"></a>
            </div>
        <?php }?>
    </div>
</div>