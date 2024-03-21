<form action="modelos/cambiar-password-recup.php" name="formulario_cambiar_pass_recup"id="formulario_cambiar_pass_recup" method="POST" autocomplete="off">
    <div class="contenedor-cambiar-pass-recup">
        <div class="decor-recup-cuenta">
            <p class="title-recup-cuenta">Recuperar Cuenta</p>
            <img class="logo-recup-cuenta" src="img/logoMemingos.png">
        </div>
        <div class="contenido">
            <input id="cambiar-pass-recup1" type="password" class="input-cambiar-pass1" name="password" placeholder="Contraseña nueva" required>
            <img src="img/ojo-tachado.png" id="eye3" class="icono-ojo1">
            <p class="error-recup" id="email-error-recup1"></p>
            <input id="cambiar-pass-recup2" type="password" class="input-cambiar-pass2" name="confirm-password" placeholder="Confirmar Contraseña nueva" required>
            <p class="error-recup" id="email-error-recup2"></p>
            <input type="button" onclick="verif_pass_recup()" class="btn-enviar-correo-recup-cuenta" value="Cambiar Contraseña">
        </div>
    </div>
</form>