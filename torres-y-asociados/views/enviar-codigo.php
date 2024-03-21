<form action="cambiar-password-recup.php" autocomplete="off" id="verificacion_codigo" name="verificacion_codigo">
    <div class="contenedor-recup-cuenta">
        <div class="decor-recup-cuenta">
            <p class="title-recup-cuenta">Recuperar Cuenta</p>
            <img class="logo-recup-cuenta" src="img/logoMemingos.png">
        </div>
        <div class="contenido">
            <input id="codigo-mail" type="hidden" value="<?php echo sha1($codigo_mail) ?>" style="display: none;">
            <input maxlength="6" class="input-style" id="codigo" placeholder="Ingrese el codigo" required>
            <p class="codigo-correcto" id="codigo-correcto">El codigo ingresado es correcto</p>
            <p class="codigo-erroneo" id="codigo-erroneo">El codigo ingresado es incorrecto</p>
            <div class="div-btn-codigo">
                <a href="recuperacion-de-cuentas.php" class="btn-codigo">Reenviar Codigo</a>
                <a href="javascript:verificar_codigo()" class="btn-codigo">Verificar</a>
            </div>
        </div>
    </div>
</form>    
    