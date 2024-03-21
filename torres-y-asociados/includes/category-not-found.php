<section class="conteiner-categoria-no-encontrada">
    <?php
        if ($clase == "dark") {
            $alert = RUTA . "/img/alert-dark.png";
        } else {
            $alert = RUTA . "/img/alert-light.png";
        }
    ?>
    <div class="titulo-categoria-no-encontrada">
        <img src="<?php echo $alert; ?>" class="alerta">
        <h2 class="texto-titulo">CATEGORIA NO ENCONTRADA</h2>
    </div>
    <img src="<?php echo RUTA ?>/img/wazaa.gif" class="meme-categoria-no-encontrada">

    <p class="explicacion">La categoría que buscaste no existe por algunas de estas razones:</p>
    <ul class="lista-motivos">
        <li>Nadie creó esta categoría.</li>
        <li>La categoría no cumple con las normas de la página.</li>
    </ul>
</section>