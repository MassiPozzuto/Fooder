<div class="contenedor-recup-cuenta" id="contenedor-recup-cuenta">
    <form action="generador-de-codigo.php" method="POST" name="form_envio_correo_recup" id="form_envio_correo_recup" autocomplete="off">
        <div class="decor-recup-cuenta">
            <p class="title-recup-cuenta">Recuperar Cuenta</p>
            <img class="logo-recup-cuenta" src="img/logoMemingos.png">
        </div>
        <div class="contenido">
            <input type="email" class="input-style" id="email-recup-cuenta"name="mail" placeholder="Correo Electronico" required>
            <p class="error-recup" id="email-error-recup"></p>
            <a href="javascript:verificar_email_recup();" class="btn-enviar-correo-recup-cuenta">Enviar</a>
        </div>
    </form>
</div>

<div class="contenedor-gen-codigo" id="contenedor-gen-codigo">
    <p class="txt-gen-codigo">El codigo se esta generando...</p>
    <div class="carga"></div>
</div>