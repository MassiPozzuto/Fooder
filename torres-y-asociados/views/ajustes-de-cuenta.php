<form method="POST" action="modelos/ajustes-de-cuenta.php" enctype="multipart/form-data">
  <section class="form-cambiar-datos">
    <div class="foto-perfil-ajustes">
      <img src="<?php echo $user['fotoPerfil'] ?>" class="foto">
      <div class="info">
        <p><?php echo $user['nombreUsuario'] ?></p>
        <label class="label-cambiar-foto" for="cambiar-foto"><?php echo $language['ajustesCuenta']['btn-cambiarFoto'] ?></label>
        <input type="file" name="cambiar-foto" id="cambiar-foto" style="display: none;" accept="image/*, .gif">
      </div>
    </div>
    <div class="controls-div">
      <p class="title-input"><?php echo $language['ajustesCuenta']['user']?></p>
      <abbr title="<?php echo $language['ajustesCuenta']['change-n']?>"><input class="controls" type="text" value="<?php echo $user['nombreUsuario'] ?>"name="nuevo-nombre" id="nuevo-nombre" placeholder="<?php echo $language['ajustesCuenta']['inp-nuevoNombre'] ?>" maxlength="15"
      <?php if($_GET['erru'] == '1'){echo 'style="border-color: red;"';}?>></abbr>
    </div>
    <div class="controls-div">
      <p class="title-input"><?php echo $language['ajustesCuenta']['desc']?></p>
      <abbr title="<?php echo $language['ajustesCuenta']['change-d']?>"><textarea1 class="controls" name="descripcion-usuario" id="descripcion-usuario" maxlength="460" placeholder="<?php echo $language['ajustesCuenta']['inp-nuevaDescripcion'] ?>"><?php echo $user['descripcion'] ?></textarea1></abbr>
    </div>
    <div class="controls-div">
      <p class="title-input"><?php echo $language['ajustesCuenta']['mail']?></p>
      <abbr title="<?php if(isset($_GET["errm"])&&$_GET['errm'] == '1'){echo $language['ajustesCuenta']['change-m-error'];}else{echo $language['ajustesCuenta']['change-m'];}?>"><input class="controls" type="email" value="<?php echo $user['email'] ?>" name="nuevo-correo" id="nuevo-correo" placeholder="<?php echo $language['ajustesCuenta']['inp-nuevoCorreo'] ?>"
      <?php if($_GET['errm'] == '1'){echo 'style="border-color: red;"';}?>></abbr>
    </div>
    <div class="controls-div">
      <p class="title-input"><?php echo $language['ajustesCuenta']['cont']?></p>
      <abbr title="<?php echo $language['ajustesCuenta']['change-c']?>">
        <input class="controls" type="password" name="password2" id="password2" placeholder="<?php echo $language['ajustesCuenta']['inp-nuevaContrasena'] ?>"<?php if($_GET['errc'] == '1'){echo 'style="border-color: red;"';}?>>
        <img src="img/ojo-tachado.png" id="eye4" class="icon-ajustes">
      </abbr>    
    </div>
    <div class="botones-formulario">
      <input class="botons" id="guardar-cambios" type="submit" value="<?php echo $language['ajustesCuenta']['btn-guardar'] ?>">
    </div>
  </section>
</form>