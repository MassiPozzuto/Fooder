  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="homepage.php">Inicio</a></li>
    <li class="breadcrumb-item active"><a>Tu información</a></li>
    <li class="breadcrumb-item active">Perfil</li>
  </ol>
  <?php
  if (isset($rowCheckUser) != NULL || isset($rowUser) != NULL) {
    if (!isset($_GET["User"]) || isset($_GET['User']) == NULL) { ?>
      <h1>No puedes ver ningún perfil porque no has puesto ninguna ID de usuario en la URL</h1>
      <?php } else if (!isset($_SESSION["datos"]) || $_SESSION["datos"]["ID"] != $_GET["User"]) {
      if (isset($rowUser["bg_dir"]) !== NULL) {
      ?>
        <style type="text/css">
          body {
            background-image: url("<?php echo $rowUser['bg_dir'] ?>");
            background-size: 100% 100%;
          }
        </style>
      <?php }

      if (isset($_SESSION['datos']['ID']) != NULL && $rowUser['ID'] != $_SESSION['datos']['ID']) { ?>
        <div class="d-flex justify-content-end align-items-start">

          <div class="modal fade" id="report" tabindex="-1" aria-labelledby="rpot" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="report">Reportar usuario</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>Danos más información para procesar al usuario:</p>
                  <form action="../controllers/moderation/reportaruser.php?user=<?php echo $rowUser['ID'] ?>" method="POST">
                    <textarea type="text" class="form-control" name="information" id="informacion"></textarea>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      <?php }
      // Perfil de otros usuarios
      ?>
      <div class="container mt-2" id="">
        <div class="row">
          <div class="col-sm-3">
            <div class="🚫">
              <div class="d-flex flex-column px-3">
                <div class="ProfileSidebar shadow rounded-5">
                  <!-- Sidebar de la izquierda -->
                  <h4 class="text-center titlem"><?php echo ($rowUser["Name"]); ?>
                    <?php
                    if (isset($_SESSION['datos']['ID']) != NULL && $rowUser['ID'] != $_SESSION['datos']['ID']) { ?>
                      <div class="d-flex justify-content-end align-items-start">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#report" onclick="open_modal_report()">
                          <span class="badge text-bg-secondary"><i class="bi bi-flag-fill"></i></span>
                        </button>

                      <?php }
                      ?>
                  </h4> <!-- Nombre de usuario -->
                  <img src="<?php echo $rowUser['profile_pic']; ?>" class="profilePhoto shadow rounded-4 mx-auto d-block" alt="foto perfil">
                  <p class="text-center marginBottom60">
                  </p> <!-- Breve descripcion -->
                  <h4 class="text-center titlem"> Manga favorito </h4>
                  <hr class="invisible">
                  <?php
                  if ($rowUser['favourite_manga_ID'] == 0) { ?>
                    <h4 class="text-center"> No tienes ningún manga favorito </h4>
                    <style>
                      .ProfileSidebar {
                        height: 600px;
                      }
                    </style>
                </div>
              <?php } else { ?>

                <div class="centeramanga mx-auto d-block">
                  <div class="card box varios" style="width:70%;margin:10px auto">
                    <a href="../controllers/manga.php?manga=<?php echo $rowUserFavManga['ID']; ?>">
                      <img src="../mangas/<?php echo ($rowUser['favourite_manga_ID']); ?>/caratula.png" class="card-img-top" onerror="this.src='../img/notfound.png'" alt="Card Image">
                      <div class="card-body d-flex flex-column">
                        <div class="text-center"><?php echo htmlspecialchars($rowUserFavManga['title']); ?>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            <?php } ?>
            </div>
          </div>
          <hr class="d-sm-none">
        </div>
        <div class="col-sm-9">
          <div class="ProfileBox shadow rounded-4">
            <h4 class="marginLeft30 titlem"> Biografía </h4>
            <?php if ($rowUser['description'] == 0) { ?>
              <h4 class="text-center"> Este usuario no tiene descripción aún :c </h4>
            <?php } else { ?>
              <p class="biografia"><?php echo htmlspecialchars($rowUser["description"]); ?></p>
            <?php } ?>
          </div>
          <hr class="invisible">
          <div class="ProfileBox shadow rounded-4">
            <!-- Insgnias -->
            <h4 class="marginLeft30 titlem"> Insignias </h4>
            <hr class="d-sm-none">
            <?php if ($rowUser['badge_ID'] == 0) { ?>
              <h4 class="text-center"> Este usuario no posee ninguna insignia </h4>
            <?php } else { ?>
              <img src="../Img/PlaceholderInsignias.png" class="insignias">
              <img src="../Img/PlaceholderInsignias.png" class="insignias">
              <img src="../Img/PlaceholderInsignias.png" class="insignias">
              <img src="../Img/PlaceholderInsignias.png" class="insignias">
              <img src="../Img/PlaceholderInsignias.png" class="insignias">
              <img src="../Img/PlaceholderInsignias.png" class="insignias">
            <?php } ?>
          </div>
          <hr class="invisible">
          <div class="RecomendedMangasContainer shadow rounded-4">
            <!-- Mangas recomendados -->
            <h4 class="marginLeft30 titlem"> Mangas subidos </h4>
            <hr class="d-sm-none">
            <div class="d-flex justify-items-center">
              <?php if ($rowUserManga == NULL) {
              ?>
                <h4 class="marginLeft30"> Este usuario no ha subido ningún manga </h4>
                <?php } else {
                foreach ($rowUserManga as $mangas_user) { ?>
                  <div class="col-sm-3 mb-3 d-align-content-start flex-wrap" style="color:orange">
                    <div class="card box varios hola12" style="width:150px">
                      <a href="../controllers/manga.php?manga=<?php echo ($mangas_user[0]); ?>">
                        <img src="../mangas/<?php echo ($mangas_user[0]); ?>/caratula.png" class="card-img-top" onerror="this.src='../img/notfound.png'" alt="Card Image">
                        <div class="card-body d-flex flex-column">
                          <div class="text-center"><?php echo htmlspecialchars($mangas_user[1]); ?>
                            <div class="backside">
                              <div class="card-img-overlay">
                                <h4 class="card-title"><?php echo htmlspecialchars($mangas_user[1]); ?></h4>
                                <p class="card-text"><?php echo htmlspecialchars($mangas_user[2]); ?></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
            <?php }
              }
            } ?>
            </div>
          </div>
        </div>
      </div>

      <?php
      //Perfil propio
      if (isset($_SESSION['datos'])  && isset($_GET['User']) && $_SESSION['datos']['ID'] == $_GET['User']) {
        if (isset($rowUser["bg_dir"]) !== NULL) {
      ?>
          <style type="text/css">
            body {
              background-image: url("<?php echo $rowUser['bg_dir'] ?>");
              background-size: 100% 100%;
            }
          </style>
        <?php }
        ?>
        <button class="btn btn-primary hola12" onclick="changeInvisible()"><i class="bi bi-eye"></i> Fondo completo</button>

        <div class="container mt-2" id="dinv">
          <div class="row">
            <div class="col-sm-3">
              <div class="🚫">
                <div class="d-flex flex-column px-3">
                  <div class="ProfileSidebar shadow rounded-5">
                    <!-- Sidebar de la izquierda -->
                    <h4 class="text-center titlem"><?php echo ($_SESSION['datos']['Name']); ?></h4> <!-- Nombre de usuario -->
                    <img src="<?php echo $rowUser['profile_pic']; ?>" class="profilePhoto shadow rounded-4 mx-auto d-block" alt="foto perfil">
                    <div class="d-grid gap-2 justify-content-end">
                      <a href="configuracion_perfil.php" type="button" class="btn btn-secondary btn-sm  me-md-2">
                        <span class="badge text-bg-secondary"><i class="bi bi-gear"></i></span>
                      </a>
                  </div>
                    <p class="text-center marginBottom60">
                    </p> <!-- Breve descripcion -->
                    <h4 class="text-center titlem"> Tu manga favorito </h4>
                    <hr class="invisible">
                    <?php
                    if ($rowUser['favourite_manga_ID'] == 0) { ?>
                      <h4 class="text-center"> No tienes ningún manga favorito </h4>
                      <style>
                        .ProfileSidebar {
                          height: 600px;
                        }
                      </style>
                  </div>

                <?php } else { ?>
                  <div class="centeramanga mx-auto d-block">
                    <div class="card box varios" style="width:70%;margin:10px auto">
                      <a href="../controllers/manga.php?manga=<?php echo $rowUserFavManga['ID']; ?>">
                        <img src="../mangas/<?php echo ($rowUser['favourite_manga_ID']); ?>/caratula.png" class="card-img-top" onerror="this.src='../img/notfound.png'" alt="Card Image">
                        <div class="card-body d-flex flex-column">
                          <div class="text-center"><?php echo htmlspecialchars($rowUserFavManga['title']); ?>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              <?php } ?>
              </div>
            </div>
            <hr class="d-sm-none">
          </div>







          <div class="col-sm-9">
            <div class="ProfileBox shadow rounded-4">
              <h4 class="marginLeft30 titlem"> Biografía </h4>
              <?php if ($rowUser['description'] == null) { ?>
                <h4 class="text-center"> No tienes una biografía aun :c</h4>
              <?php } else { ?>
                <p class="biografia"><?php echo htmlspecialchars($rowUser["description"]); ?></p>
              <?php } ?>
            </div>
            <hr class="invisible">
            <div class="ProfileBox shadow rounded-4">
              <!-- Insgnias -->
              <h4 class="marginLeft30 titlem"> Tus Insignias </h4>
              <hr class="d-sm-none">
              <?php if ($rowUser['badge_ID'] == 0) { ?>
                <h4 class="text-center"> No posees ninguna insignia </h4>
              <?php } else { ?>
                <img src="../Img/PlaceholderInsignias.png" class="insignias">
                <img src="../Img/PlaceholderInsignias.png" class="insignias">
                <img src="../Img/PlaceholderInsignias.png" class="insignias">
                <img src="../Img/PlaceholderInsignias.png" class="insignias">
                <img src="../Img/PlaceholderInsignias.png" class="insignias">
                <img src="../Img/PlaceholderInsignias.png" class="insignias">
              <?php } ?>
            </div>
            <hr class="invisible">

            <div class="RecomendedMangasContainer shadow rounded-4">
              <!-- Mangas recomendados -->
              <h4 class="marginLeft30 titlem"> Tus mangas subidos </h4>
              <hr class="d-sm-none">
              <div class="d-flex justify-items-center">
                <?php if ($rowUserManga == NULL) {
                ?>
                  <h4 class="marginLeft30"> No has subido ningún manga </h4>
                  <?php } else {
                  foreach ($rowUserManga as $mangas_user) { ?>
                    <div class="col-sm-3 mb-3 d-align-content-start flex-wrap" style="color:orange">
                      <div class="card box varios hola12" style="width:150px">
                        <a href="../controllers/manga.php?manga=<?php echo ($mangas_user[0]); ?>">
                          <img src="../mangas/<?php echo ($mangas_user[0]); ?>/caratula.png" class="card-img-top" onerror="this.src='../img/notfound.png'" alt="Card Image">
                          <div class="card-body d-flex flex-column">
                            <div class="text-center"><?php echo htmlspecialchars($mangas_user[1]); ?>
                              <div class="backside">
                                <div class="card-img-overlay">
                                  <h4 class="card-title"><?php echo htmlspecialchars($mangas_user[1]); ?></h4>
                                  <p class="card-text"><?php echo htmlspecialchars($mangas_user[2]); ?></p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </a>
                      </div>
                      </div>
                <?php }
                }
              }


                ?>
                    </div>
              </div>
            </div>
          </div>

        </div>
        </div>
        <hr class="invisible">
        <hr class="invisible">
        <style>
          .centeramanga {
            margin-left: auto;
            margin-right: auto;

          }

          .hola12 {
            margin-left: 7%;
          }
        </style>
      <?php } else { ?>
        No se ha encontrado el usuario
      <?php } ?>
      <script>
        function changeInvisible() {
          var getbtninv = document.getElementById("dinv");
          getbtninv.classList.toggle("invisible");
        }
      </script>