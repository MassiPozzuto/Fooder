<form method="POST" action="modelos/cambiar-preferencias.php">
    <section class="ajustes">
        <h1 class="titulo"><?php echo $language['preferencias']['title'] ?></h1>
        <div class="opciones">
            <div class="bg-opciones">
                <p><?php echo $language['preferencias']['adv-cambiarTema'] ?></p>
                <div class="swtich-container">
                    <input type="checkbox" name="switch-cambiar-tema" id="switch-cambiar-tema" <?php echo $tema?>>
                    <label for="switch-cambiar-tema" class="lbl"></label>
                </div>
            </div>
            <div class="bg-opciones">
                <p><?php echo $language['preferencias']['adv-censurarMemes'] ?></p>
                <div class="swtich-container">
                    <input type="checkbox" name="switch-cens-meme" id="switch-cens-meme" <?php echo $censMeme?>>
                    <label for="switch-cens-meme" class="lbl"></label>
                </div>
            </div>
            <div class="bg-opciones">
                <p><?php echo $language['preferencias']['adv-censurarComents'] ?></p>
                <div class="swtich-container">
                    <input type="checkbox" name="switch-cens-comentarios" id="switch-cens-comentarios" <?php echo $censComen?>>
                    <label for="switch-cens-comentarios" class="lbl"></label>
                </div>
            </div>
            <div class="bg-opciones">
                <p><?php echo $language['preferencias']['adv-cambiarIdioma'] ?></p>
                <select name="select-language" id="select-language">
                    <option value="spanish" <?php echo $idioma1?>>Español</option>
                    <option value="english" <?php echo $idioma2?>>Ingles</option>
                </select>
            </div>
        </div>
        <div class="botones-formulario-preferencias">
            <input class="botons" id="guardar-cambios" type="submit" value="<?php echo $language['preferencias']['btn-guardar'] ?>">
        </div>
    </section>
</form>