
<div class="Login-container rounded justify-content-center align-items-center">
    <div class="Login-interior rounded justify-content-center align-items-center">
    <center><h1 class="">Iniciar sesión</h1></center>
     <center> <p class="text-muted blockquote menostop" id="randommsg"></p></center>
        <hr class="">
            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == "emptyinput") {
                    echo '<div class="alert alert-danger" role="alert">
                Debes completar todos los campos.
                </div>';
                }
                if ($_GET['error'] == "wronglogin") {
                    echo '<div class="alert alert-danger" role="alert">
                El nombre o contraseña son incorrectos.
                </div>';
                }
            }
            ?>
    <div class="login-form">
     
            <div class="estonoesunaclassignorachedejadeleerquehacescontuvidajajaseguisleyendoqwqbueaprovechoparadecirtequeestoesresponsive">
                <form action="../controllers/login.php" method="post">
        <strong>Ingrese su E-mail o Nombre de usuario</strong>
                <input type="text" id="elemail" name="name" class="form-control emails rounded-4" placeholder="E-mail/nombre de usuario" <?php
                                if (isset($_COOKIE["user"])) {

                                    echo 'value ="' . $_COOKIE["user"] . '"';
                                }

                                ?> <br>
        </div>
        <div class="estonoesunaclassignorachedejadeleerquehacescontuvidajajaseguisleyendoqwqbueaprovechoparadecirtequeestoesresponsive">
        <strong> Ingrese su contraseña </strong>
            <input type="password" id="lacontra" name="password" placeholder="Contraseña" class="form-control lascontrasenias rounded-4" <?php if (isset($_COOKIE["pass"])) {
            echo 'value ="' . $_COOKIE["pass"] . '"';
        } ?>><br>
        </div>
        <div class="form-check form-switch text-start">
            <input class="form-check-input rounded-3 " type="checkbox" role="switch" name="remember" <?php
                                if (isset($_COOKIE["remember"])) {

                                    echo 'checked';
                                }

                                ?>>
            <label class="form-check-label" for="remember" styles="">Recordar mi cuenta</label>
        </div>
        <hr class="invisible">
        <div class="estonoesunaclassignorachedejadeleerquehacescontuvidajajaseguisleyendoqwqbueaprovechoparadecirtequeestoesresponsive">
        <center> <button type="submit" id="botonenviar" name="submit" class="btn btn-cust aver rounded-3" text="Iniciar"> Iniciar</center>
        </div>
       <hr class="invisible">
        <div class="estonoesunaclassignorachedejadeleerquehacescontuvidajajaseguisleyendoqwqbueaprovechoparadecirtequeestoesresponsive">
        <p class="text-start text-primary">¿Eres nuevo? <a href="../controllers/register.php" id="link"><u>Crea tu cuenta.</u></a></p>
        </div>
        </form>
      </div>
      </div>
  </div>
</div><hr class="invisible">
      <hr class="invisible">
      <hr class="invisible">
      <hr class="invisible">

<script>
    var loginmsgs = ["¿Qué leeremos hoy?","No jueguen LoL", "Es bueno volver a verte", "Te odiamos Nico", "Esto se esta volviendo adictivo ¿No?", "I was here before", "No encontraste otra pagina mejor, ¿verdad?", "Miau"];
    var rand = Math.floor(Math.random() * loginmsgs.length);
    var randloginmsg = loginmsgs[rand];
    document.getElementById("randommsg").innerHTML = randloginmsg;
</script>