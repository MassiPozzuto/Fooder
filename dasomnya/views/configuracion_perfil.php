  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="homepage.php">Inicio</a></li>
    <li class="breadcrumb-item active"><a>Tu información</a></li>
    <li class="breadcrumb-item active">Configuración</li>
  </ol>
  <style>
    .Login-container {
      width: 100%;
      margin: auto;
      max-width: 575px;
      min-height: 990px;
      position: relative;
      box-shadow: 0 12px 15px 0 rgba(0, 0, 0, .24), 0 17px 50px 0 rgba(0, 0, 0, .19);
    }

    .Login-interior {
      width:100%;
height:100%;
position:absolute;
background: #A0ACBD;
opacity: 0.85;
text-align: center;
font-family: 'Source Sans Pro', sans-serif;
background-color: rgb(218, 218, 228);
border-radius: 3px;
padding: 3em;
padding-bottom: 2em;
margin: auto;
margin-bottom: 3em;
    }
  </style>


  <!-- No funciona: cambiar contraseña. Lo demas correcto -->
  <div class="Login-container rounded justify-content-center align-items-center">
    <div class="Login-interior rounded justify-content-center align-items-center">
      <h1>Edita tu perfil</h1>
      <hr>
      <?php
      if (isset($_GET['error'])) {
        if ($_GET['error'] == "none") {
          echo '<div class="alert alert-success" role="alert">
               Cambios realizados con exito
              </div>';
        }
      }
      ?>
      <form action="../controllers/configuracion_perfil.php" oninput="activate()" method="POST">
        <strong>Modifica tu E-mail</strong>
        <input type="email" name="email" class="form-control emails rounded-4" placeholder="E-mail" value="<?php echo (isset($email)) ? $email : $_SESSION['datos']['Email']; ?>">
        <strong>Modifica tu nombre de usuario</strong>
        <input type="text" name="username" class="form-control rounded-4" placeholder="Nombre de Usuario" value="<?php echo (isset($username)) ? $username : $_SESSION['datos']['Name']; ?>"><br>
        <strong>Modifica tu biografía</strong>
        <textarea type="text" oninput="activate()" name="biography" id="bio" class="form-control rounded-4" placeholder="Coloca tu biografia"><?php echo (isset($biography)) ? $biography : $rowPreferences['description']; ?></textarea>
        <div class="d-flex justify-content-end">
          <p type="text-secondary" id="counter">0/500</p>
        </div>
        <strong>Modifica tu contraseña</strong>
        <input type="password" class="form-control lascontrasenias rounded-4" name="newpassword" placeholder="Nueva contraseña"><br>
        <strong>Repite la nueva contraseña</strong>
        <input type="password" class="form-control lascontrasenias rounded-4" name="newpassword2" placeholder="Repita la contraseña"><br>
        <strong>¿Quieres que tu manga favorito sea público?</strong><br>
        <label class="form__container--text"></label>
        <select id="subres" name="favourite" class="form-select form__container--input rounded-3">
          <?php if ($rowPreferences['show_favourite'] == 'No') { ?>
            <option value="No">No</option>
            <option value="Si">Si</option>
          <?php } else { ?>
            <option value="Si">Si</option>
            <option value="No">No</option>
          <?php } ?>

        </select><br>
        <strong>¿Quieres que tus likes sean públicos?</strong><br>
        <label class="form__container--text"></label>
        <select id="subres1" name="likes" class="form-select form__container--input rounded-3">
          <?php if ($rowPreferences['show_likes'] == 'No') { ?>
            <option value="No">No</option>
            <option value="Si">Si</option>
          <?php } else { ?>
            <option value="Si">Si</option>
            <option value="No">No</option>
          <?php } ?>
        </select><br>

        <button type="submit" name="submit" id="submit" class="btn btn-cust" text="Enviar">Guardar cambios
      </form>
    </div>
  </div>

  <script>
    function deactivate() {
      submit.className = "btn btn-cust disabled";
    }

    function activate() {
      let counter = document.getElementById("counter");
      let submit = document.getElementById("submit");
      let content = document.getElementById("bio");
      var length = content.value.length;
      counter.textContent = length + "/500"
      submit.className = "btn btn-cust ";
      if (length > 500) {
        deactivate();
        counter.className = "text-danger";
      }
      if (length <= 500) {

        counter.className = "";
      }
    }
  </script>
  <hr class="invisible">
  <hr class="invisible">
  <hr class="invisible">