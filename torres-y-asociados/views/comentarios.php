<section class="conteiner">
    <div class="categoria-comentario">
        <p>Categorias:</p>
        <!-- Obtengo todas las categorias de la publicacion -->
        <?php require_once ('modelos/categorias-comentarios.php');?>
    </div>
    <div class="div-comentarios" id="referent" style="scroll-behavior: smooth">
        <!-- Obtengo todos los comentarios -->
        <?php require_once ('views/selector-comentarios.php');?>
    </div>
    <div class="acciones">
        <a class="retroceder" href="<?php echo RUTA ?>/<?php echo $goTo ?>.php?<?php if(isset($usuGaleryId)){echo 'id=' . $usuGaleryId;} if(isset($categoria)){echo 'busqueda=' . $categoria;} if(isset($notifPubId)){echo 'id=' . $notifPubId;}?>#<?php echo $_GET['id']; ?>"><img src="<?php echo RUTA ?>/img/flecha.png" class="atras"></a>
        <img src="<?php echo $user['fotoPerfil']?>" class="img-usuario-comentarios">
        <p contenteditable="true" class="destinatario-respuesta" id="dest"></p>
            
        <input type="text" onkeyup="enter(event)" placeholder="Agregar un comentario..." class="input-comentario" id="comentar" maxlength="190" autocomplete="off" autofocus>
        <input type="hidden" id="idP" value="<?php echo $_GET['id']?>">
        <input type="hidden" id="idF" value="0">
        <input type="submit" id="enviaravion" class="enviar-comentario" value="" onclick="responder();">
    </div>
</section>