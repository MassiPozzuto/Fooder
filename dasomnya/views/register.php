<div class="registrarse-container">
  <div class="registrarse-interior">
  <h1>Crea tu usuario</h1>
  <p class="text-muted blockquote menostop" id="rrandommsg"></p>
<hr>
<?php 
    if(isset($_GET['error'])){
      if($_GET['error'] == "emptyinput"){
        echo '<div class="alert alert-danger" role="alert">
              Debes completar todos los campos.
              </div>';
      }
       if($_GET['error'] == "invaliduid"){
        echo '<div class="alert alert-danger" role="alert">
              El nombre de usuario no es valido. Asegurate de que contenga entre 4 a 12 caracteres.
              </div>';
      }
       if($_GET['error'] == "invalidemail"){
        echo '<div class="alert alert-danger" role="alert">
              El Email ingresado no es valido.
              </div>';
      }
       if($_GET['error'] == "passwordnotmatch"){
        echo '<div class="alert alert-danger" role="alert">
              Las contraseñas no coinciden.
              </div>';
      }
       if($_GET['error'] == "uidtaken"){
        echo '<div class="alert alert-danger" role="alert">
              El nombre de usuario o Email ingresado ya esta en uso.
              </div>';
      }
       if($_GET['error'] == "stmt_error"){
        echo '<div class="alert alert-danger" role="alert">
             Algo salió mal. Estamos trabajando para repararlo.
              </div>';
      }
      if($_GET['error'] == "none"){
        echo '<div class="alert alert-success" role="alert">
               Usuario creado exitosamente!
              </div>';
      }
    }
    ?>
     <form action="../controllers/register.php" method="post">
      <div class="registrarse-inputs">
        <div class="estonoesunaclassignorachedejadeleerquehacescontuvidajajaseguisleyendoqwqbueaprovechoparadecirtequeestoesresponsive">
        <strong>Ingresa tu E-mail</strong>
      <input type="email" name="email" class="form-control emails rounded-4"  placeholder="E-mail"  <?php
                                if (isset($_COOKIE["email"])) {
                                    echo 'value ="' . $_COOKIE["email"] . '"';
                                }

                                ?>>
        </div>
        <div class="estonoesunaclassignorachedejadeleerquehacescontuvidajajaseguisleyendoqwqbueaprovechoparadecirtequeestoesresponsive">
        <strong>Crea un nombre de usuario</strong>
      <input type="text" name="username" class="form-control rounded-4" placeholder="Nombre de Usuario" <?php
                                if (isset($_COOKIE["username"])) {
                                    echo 'value ="' . $_COOKIE["username"] . '"';
                                }

                                ?>><br>
        </div>
        <div class="estonoesunaclassignorachedejadeleerquehacescontuvidajajaseguisleyendoqwqbueaprovechoparadecirtequeestoesresponsive">
        <strong>Crea tu contraseña</strong>
      <input type="password" class="form-control lascontrasenias rounded-4" name="password" placeholder="Contraseña"><br>
        </div>
        <div class="estonoesunaclassignorachedejadeleerquehacescontuvidajajaseguisleyendoqwqbueaprovechoparadecirtequeestoesresponsive">
        <strong>Repite la contraseña</strong>
      <input type="password" class="form-control lascontrasenias rounded-4" name="password2" placeholder="Repita la contraseña">
        </div>
        <hr class="invisible">
        <div class="estonoesunaclassignorachedejadeleerquehacescontuvidajajaseguisleyendoqwqbueaprovechoparadecirtequeestoesresponsive">
        <button type="submit" name="submit" class="btn btn-cust rounded-3 aver" text="Registrarse"> Registrarse
        </div>
      </div>
      <hr class="invisible">
      <div class="estonoesunaclassignorachedejadeleerquehacescontuvidajajaseguisleyendoqwqbueaprovechoparadecirtequeestoesresponsive">
        <p class="text-start  text-primary">¿Tienes una cuenta? <a href="../controllers/login.php" id="link"><u>Inicia sesión.</a></u></p>
        </div>
    </form>
  </div>
</div>
<hr class="invisible">
      <hr class="invisible">
      <hr class="invisible">
      <hr class="invisible">

<script>
var registermsgs = ["Lee historias increibles", "¿Seras nuestro nakama?", "Te amamos Nico", "¿Es la primera vez que te vemos?", "Welcome to the jungle", "Estas regalando tu alma", "Esta es la mejor pagina para leer mangas, de veras"];
var rand = Math.floor(Math.random()*registermsgs.length);
var randregistermsg = registermsgs[rand];
document.getElementById("rrandommsg").innerHTML = randregistermsg;

</script>

