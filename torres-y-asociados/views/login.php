<!-- Inicio de Sesion -->
<div class="container-index">
    <div class="forms-index">
        <form class="iniciar-sesion" id="inicio-sesion" method="POST" autocomplete="off">
            <div class="logo-index"><img src="img/logoMemingos.png"></div>
            <input type="email" value="<?php echo (isset($_COOKIE['emailInicio'])) ? $_COOKIE['emailInicio'] : '' ?>" placeholder="Correo Electronico" onkeyup="log_direct_e()" id="errorEmail" class="input-index" name="emailInicio" required>
            <p class="error-login" id="email-error"></p>
            <div class="contenedor-ojo">
                <input type="password" value="<?php echo (isset($_COOKIE['claveInicio'])) ? $_COOKIE['claveInicio'] : '' ?>" placeholder="Contraseña" onkeyup="log_direct_c()" id="errorClave" class="input-index" name="claveInicio" required>
                <img src="img/ojo-tachado.png" id="eye" class="icono">
            </div>
            <input type="checkbox" value="SI" <?php echo (isset($_COOKIE['recordar-checkbox'])) ? 'checked' : '' ?> name="recordar-checkbox" id="recordar-checkbox">
            <p class="error-login" id="clave-error"></p>
            <div class="msg-error-inicio" id="msg-error-inicio">
                <p>Los datos ingresados son incorrectos</p>
            </div>
            <a href="recuperacion-de-cuentas.php" class="link-recuperar-cuenta">¿Olvidaste tu contraseña?</a>
            <input type="submit" value="Iniciar Sesion" class="login-index">
            <div class="register-index"></div>
            <label for="bts-modal" class="crear-cuenta">Crear nueva cuenta</label>
        </form>
        <!-- Registro De Usuario -->
        <input type="checkbox" id="bts-modal">
        <div class="modal">
            <div class="contenedor" id="cont">
                <label for="bts-modal" id="cerrar" class="cerrar">X</label>
                <div class="contenido-regis-cuenta">
                    <img src="img/logoMemingos.png" id="im2">
                    <form method="POST" action="<?php echo RUTA ?>/modelos/alta.php" class="formulario_regis" name="formulario_regis" id="formulario_regis" autocomplete="off">
                        <div class="usuario" id="usuario">
                            <input type="text" placeholder="Usuario" id="usu" name="nombreUsuario" onkeyup="usuario()" class="us-0">
                            <p class="msg-error-input" id="msg-usu"></p>
                        </div>

                        <div class="usuario" id="usuario">
                            <input type="text" placeholder="Email" id="mail" name="email" onkeyup="correo()" autocomplete="off" class="us-1">
                            <p class="msg-error-input" id="msg-mail"></p>
                        </div>

                        <div class="usuario" id="usuario">
                            <input type="password" placeholder="Contrasena" id="clave" name="clave" onkeyup="password()" class="us-2">
                            <img src="img/ojo-tachado.png" id="eye2" class="icon-reg">
                            <p class="msg-error-input" id="msg-pass"></p>
                        </div>

                        <div class="usuario" id="usuario">
                            <input type="password" placeholder="Confirmar Contrasena" id="clave2" name="clave2" onkeyup="verifPass()" class="us-2">
                            <p class="msg-error-input" id="msg-pass2"></p>
                        </div>

                        <div class="nacimiento usuario" id="usuario">
                            <p class="fecha">Fecha de Nacimiento:</p>
                            <input type="date" id="nac" name="fechaNacimiento" value="<?php echo date('Y-m-d') ?>" onkeyup="edad()" class="us-3">
                            <p class="msg-error-input" id="msg-edad"></p>
                        </div>

                        <div class="usuario" id="usuario">
                            <p class="genero">Genero:</p>
                            <div class="radio">
                                <input type="radio" name="genero_id" id="hombre" value="1">
                                <label id="hombre-l" for="hombre" onclick="genero(1)">Hombre</label>
                                <input type="radio" name="genero_id" id="mujer" value="2">
                                <label id="mujer-l" for="mujer" onclick="genero(2)">Mujer</label>
                                <input type="radio" name="genero_id" id="personalizado" value="3">
                                <label id="personalizado-l" for="personalizado" onclick="genero(3)">Personalizado</label>
                            </div>
                        </div>

                        <div class="msg-error usuario" id="msg-error">
                            <p id="final-msg"></p>
                        </div>

                        <div class="usuario registro">
                            <a href="javascript:registrarse()">Registrarse</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-1000">
    <input id="m-int" type="text" placeholder="Ingrese cantidad de registros">
</div>
<a href="https://www.instagram.com/memingos.etn26/?hl=es" target="_blank">
    <img class="instagram" src="img/logoins.jpg">
</a>
<button class="button-1000">Insertar</button>
<div class="recordar-div">
    <h1>Esta página hace uso de cookies</h1>
    <h2>Cuando vuelvas a iniciar sesión, no tendrás que ingresar tus datos denuevo</h2>
    <div class="cont-op">
        <div class="cont-op1">
            <label for="recordar-checkbox" id="label-recordar">Habilitar cookies</label>
        </div>
        <p id="closeC">X</p>
    </div>
</div>
<div class="res-1000" id="res-m">&nbsp;</div>