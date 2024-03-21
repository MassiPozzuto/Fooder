<?php
if (isset($_GET['capitulo']) == NULL || !isset($_GET['capitulo'])) {
  echo "No disponible";
} else {

  $chapterget = mysqli_real_escape_string($conn, $_GET['capitulo']);
  $mangaget = mysqli_real_escape_string($conn, $_GET['manga']);
  $chkchapter = "SELECT * FROM mangachapters WHERE Manga_ID = '$mangaget' AND number = '$chapterget';";
  $chaptergetresult = mysqli_query($conn, $chkchapter);
  $verifychapters = mysqli_num_rows($chaptergetresult);

 

  if ($verifychapters < 1) { ?>
    Capítulo no disponible
    <?php } else {
    if (isset($_GET['error'])) {
      if ($_GET['error'] == "true") {
        echo '<div class="alert alert-danger" role="alert">
            Algo salio mal.
              </div>';
      }
    }
    if (isset($_GET['manga']) == NULL || isset($_GET['capitulo']) == NULL || !isset($_GET['capitulo'])) {
      echo "No disponible";
    } else {


      if (isset($_SESSION['datos']['ID'])) {
        $sqlUMH = "SELECT * FROM userreadmangahistory WHERE User_ID =" . $_SESSION['datos']['ID'] . ";";
        $resultsHistory = mysqli_query($conn, $sqlUMH);
        $rCheck = mysqli_num_rows($resultsHistory);
        $lastindex = array();
        if (mysqli_num_rows($resultsHistory) > 0) {
          while ($row = mysqli_fetch_assoc($resultsHistory)) {
            $lastindex[] = $row;
          }
        }

        if ($rCheck >= 4) {
          $userid = $_SESSION['datos']['ID'];
          $mangaid = $_GET['manga'];
          $atchapter = $_GET['capitulo'];

          $index0 = $lastindex[0]['h_ID'];
          $index1 = $lastindex[1]['h_ID'];
          $index2 = $lastindex[2]['h_ID'];
          $index3 = $lastindex[3]['h_ID'];

          $manga0 = $lastindex[0]['manga_ID'];
          $manga1 = $lastindex[1]['manga_ID'];
          $manga2 = $lastindex[2]['manga_ID'];
          $manga3 = $lastindex[3]['manga_ID'];

          $chapter0 = $lastindex[0]['at_Chapter'];
          $chapter1 = $lastindex[1]['at_Chapter'];
          $chapter2 = $lastindex[2]['at_Chapter'];
          $chapter3 = $lastindex[3]['at_Chapter'];

          $sqlChecker = "SELECT * FROM userreadmangahistory WHERE manga_ID = $mangaid AND User_ID = $userid";
          $rchecker = mysqli_query($conn, $sqlChecker);
          $mangaisseen = mysqli_num_rows($rchecker);
          if ($mangaisseen == NULL || $mangaisseen == 0) {
            $sqlSave = "UPDATE userreadmangahistory SET manga_ID = $manga0, at_Chapter = $chapter0 WHERE User_ID = $userid AND h_ID = $index1;UPDATE userreadmangahistory SET manga_ID = $mangaid, at_Chapter = $atchapter WHERE User_ID = $userid AND h_ID = $index0; UPDATE userreadmangahistory SET manga_ID = $manga2, at_Chapter = $chapter2 WHERE User_ID = $userid AND manga_ID = $manga3 AND h_ID = $index3 ; UPDATE userreadmangahistory SET manga_ID = $manga1, at_Chapter = $chapter1 WHERE User_ID = $userid AND manga_ID = $manga2 AND h_ID = $index2";
            $resultsSave = mysqli_multi_query($conn, $sqlSave);
            while (mysqli_next_result($conn)) {;
            };
          }

          if ($mangaisseen != NULL || $mangaisseen != 0) {

            $sqloverwrite = "UPDATE userreadmangahistory SET at_Chapter = $atchapter WHERE User_ID = $userid AND manga_ID = $mangaid;";
            $resultsoverwrite = mysqli_query($conn, $sqloverwrite);
          }
        }
        if ($rCheck < 4 || $rCheck == NULL || $rCheck == 0) {

          $userid = $_SESSION['datos']['ID'];
          $mangaid = $_GET['manga'];
          $atchapter = $_GET['capitulo'];
          $sqlChecker = "SELECT * FROM userreadmangahistory WHERE manga_ID = $mangaid AND User_ID = $userid";
          $rchecker = mysqli_query($conn, $sqlChecker);
          $mangaisseen = mysqli_num_rows($rchecker);
          if ($mangaisseen == NULL || $mangaisseen == 0) {
            $sqlHcreate = "INSERT INTO userreadmangahistory (User_ID, manga_ID, at_Chapter)
            VALUES ($userid, $mangaid, $atchapter);";
            $resultsHcreate = mysqli_query($conn, $sqlHcreate);
          }
          if ($mangaisseen != NULL || $mangaisseen != 0) {
            $sqlSave = "UPDATE userreadmangahistory SET manga_ID = $mangaid, at_Chapter = $atchapter WHERE User_ID = $userid AND manga_ID = $mangaid;";
            $resultsSave = mysqli_query($conn, $sqlSave);
          }
        }
      }  ?>
      <div class="container">
        <center><button type="button" id="back" class="btn btn-primary" <?php if ($_GET['capitulo'] == 1) { ?> disabled <?php   } ?> onclick="window.location.href = 'leer?manga=<?php echo $_GET['manga']; ?>&capitulo=<?php echo $_GET['capitulo'] - 1; ?>';">
            <i class="bi bi-skip-backward"></i>
          </button>
          <button type="button" class="btn btn-secondary"> <a href="manga.php?manga=<?php echo $_GET['manga']; ?>#chapters"><i class="bi bi-list" style=""></i></a> </button>

          <button type="button" class="btn btn-primary" id="next" onclick="window.location.href = 'leer.php?manga=<?php echo $_GET['manga']; ?>&capitulo=<?php echo $_GET['capitulo'] + 1; ?>';"><i class="bi bi-skip-forward"></i>
          </button> </center>
          <?php
          $count = count(glob("../mangas/$_GET[manga]/$_GET[capitulo]/*.jpg"));
          ?>

          <div class="containerimg">
            <div class="row d-flex">
              <div class="d-flex fill">
                <div class="col-6 align-self-stretch col-md-6 page" onclick="prevPage()"></div>
                <div class="col-6 align-self-stretch col-md-6 page1" onclick="nextPage()"></div>
                <img id="pagina" class="paginapc" src="../mangas/<?php echo $_GET['manga'] ?>/<?php echo $_GET['capitulo'] ?>/1.jpg" onerror="this.src='../img/notfound.png'">
              </div>
            </div>
          </div>

      </div>
      <script type="text/javascript" charset="utf-8" async defer>
        if (isMobile.any()) {
          let img = document.getElementById('pagina');
          img.className = "paginamobile";
        };
      </script>
      <div class="d-flex justify-content-center">
      <center><button type="button" id="back" class="btn btn-primary" <?php if ($_GET['capitulo'] == 1) { ?> disabled <?php   } ?> onclick="window.location.href = 'leer?manga=<?php echo $_GET['manga']; ?>&capitulo=<?php echo $_GET['capitulo'] - 1; ?>';">
            <i class="bi bi-skip-backward"></i>
          </button>
          <button type="button" class="btn btn-secondary"> <a href="manga.php?manga=<?php echo $_GET['manga']; ?>#chapters"><i class="bi bi-list" style=""></i></a> </button>

          <button type="button" class="btn btn-primary" id="next" onclick="window.location.href = 'leer.php?manga=<?php echo $_GET['manga']; ?>&capitulo=<?php echo $_GET['capitulo'] + 1; ?>';"><i class="bi bi-skip-forward"></i>
          </button> </center>         
      </div>
      <center><p id="pagtext"> Página 1 de <?php echo $count ?></p> </center>

<!--       
      <div class="anuncio1 mx-auto d-block">
        <a href="https://www.coca-cola.com.ar/"> <img src="../Img/otros/cocacola.png"> </a>
      </div> -->

      <script type="application/javascript">
        lastpage = <?php echo $count ?>;
        currentpage = 1;
        let pagtext = document.getElementById("pagtext")

      

        <?php
        $getchapters = "SELECT * FROM mangachapters WHERE Manga_ID =" . $_GET['manga'] . " ORDER BY number DESC;";
        $resgetchapters = mysqli_query($conn, $getchapters);
        if (!$resgetchapters) {
          die();
        }
        $mangachapters = array();
        while ($row = mysqli_fetch_assoc($resgetchapters)) { {
            $mangachapters[] = $row;
          }
        }
        $keys = array_keys($mangachapters);
        $lastKey = $keys[count($keys) - 1];
        $firstchapter = $mangachapters[$lastKey]['number'];
        if ($firstchapter == $_GET['capitulo']) { ?>
          $(document).ready(function() {
            $('#back').addClass('disabled');
          });

        <?php }
        $lastchapter =   $mangachapters[0]['number'] - 1;
        if ($_GET['capitulo'] >  $lastchapter) { ?>
          $(document).ready(function() {
            $('#next').addClass('disabled');
          });
        <?php } ?>


        function minlimiter() {
          previous = currentpage - 1;
          <?php if ($_GET['capitulo'] !=  $firstchapter) { ?>
            if (previous < 1) {
              window.location.href = 'leer.php?manga=<?php echo $_GET['manga']; ?>&capitulo=<?php echo $_GET['capitulo'] - 1; ?>';
            }
          <?php } else { ?>
            if (previous < 2) {
              currentpage = 2;
            }
          <?php } ?>
        }

     <?php   if ($_GET['capitulo'] == $mangachapters[0]['number']) {
        ?>

          function maxlimiter() {
            if (lastpage == currentpage) {
              currentpage = lastpage - 1;
            }
          }
        <?php } else { ?>

          function maxlimiter() {
            if (lastpage == currentpage) {
              window.location.href = 'leer?manga=<?php echo $_GET['manga']; ?>&capitulo=<?php echo $_GET['capitulo'] + 1; ?>';
            }
          }

        <?php } ?>

        function nextPage() {
          maxlimiter();
          let pagina = document.getElementById("pagina");
          currentpage++;
          pagina.src = `../mangas/<?php echo $_GET['manga'] ?>/<?php echo $_GET['capitulo'] ?>/${currentpage}.jpg`;
          pagtext.textContent = `Pagina ${currentpage} de ${lastpage}`;
          document.body.scrollTop = 10; // Para safari segun bootstrap
          document.documentElement.scrollTop = 10; // Para Chrome, Firefox, IE and Opera segun bootstrap parte 2
        }


        function prevPage() {
          minlimiter()
          let pagina = document.getElementById("pagina");
          currentpage--;
          pagina.src = `../mangas/<?php echo $_GET['manga'] ?>/<?php echo $_GET['capitulo'] ?>/${currentpage}.jpg`;
          pagtext.textContent = `Pagina ${currentpage} de ${lastpage}`;
          document.body.scrollTop = 10; // Para safari segun bootstrap
          document.documentElement.scrollTop = 10; // Para Chrome, Firefox, IE and Opera segun bootstrap parte 2
        }
        window.addEventListener("keydown", (event) => {
          if (event.defaultPrevented) {
            return;
          }
          switch (event.code) {

            case "ArrowLeft":

              prevPage()
              document.body.scrollTop = 10; // Para safari segun bootstrap
              document.documentElement.scrollTop = 10; // Para Chrome, Firefox, IE and Opera segun bootstrap parte 2
              break;

            case "ArrowRight":
              nextPage()
              document.body.scrollTop = 10; // Para safari segun bootstrap
              document.documentElement.scrollTop = 10; // Para Chrome, Firefox, IE and Opera segun bootstrap parte 2
              break;
          }
          refresh();
          if (event.code !== "Tab") {
            event.preventDefault();
          }
        }, true);


        function deactivate() {
          submit.className = "btn btn-primary btn-sm disabled";
        }

        function activate() {
          let submit = document.getElementById("submit");
          let content = document.getElementById("textarea");
          submit.className = "btn btn-primary btn-sm ";
          if (content.value == '') {
            deactivate();
          }
        }
      </script>
      </div>
      <div class="container">

        <?php if (isset($_SESSION['datos'])) { ?>
          <div class="container-fluid comentariossection">
            <h6>Comentarios</h6>

            <div class="card-body py-3 border-0">
              <div class="d-flex flex-start w-100">
                <img class="rounded-circle shadow-1-strong me-3" src="<?php echo $_SESSION['datos']['profile_pic'] ?>" width="70px" height="70px" />
                <div class="form-outline w-100">
                  <form method="post" id="comentar" oninput="activate()" action="mangas/comentar.php?manga=<?php echo $_GET['manga'] ?>&capitulo=<?php echo $_GET['capitulo'] ?>">
                    <textarea class="form-control" name="comment" id="textarea" oninput="activate()" rows="4" style="background: #fff;" placeholder="Escribe tu comentario."></textarea>
                    <label class="form-label" for="textarea"></label>
                </div>
              </div>
              <div class="float-end mt-2 pt-1">
                <input type="submit" name="submit" id="submit" class="btn btn-primary btn-sm disabled">
              </div>
            </div>
            </form>
          <?php } else { ?>
            <br>
            <a class="text-primary" href="login.php">Inicia sesión para comentar!</a>
          <?php }; ?>
          </div>
      </div>
      </div>
      <div class="container my-5 py-5">
        <div class="row d-flex">
          <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="row">
              <div class="col">
                <hr>
                <?php

                $sql3 = "SELECT * FROM comments INNER JOIN users ON users.ID = comments.User_ID WHERE Manga_ID = $_GET[manga] AND mangachapter = $_GET[capitulo] ORDER BY comments.c_ID DESC";
                $result3 = mysqli_query($conn, $sql3);
                $resultCheck = mysqli_num_rows($result3);
                if ($resultCheck > 0) {
                  while ($row = mysqli_fetch_assoc($result3)) if ($row['deleted_at'] == NULL) { {
                ?>

                      <div class="d-flex flex-start mt-4">

                        <a href="../controllers/perfil.php?User=<?php echo $row['ID'] ?>">
                          <img class="rounded-circle shadow-1-strong me-3" src="<?php echo $row['profile_pic'] ?>" alt="avatar" width="65" height="65" />
                        </a>
                        <div class="flex-grow-1 flex-shrink-1">

                          <div class="">
                            <div class="">
                              <h5 class="mb-1">
                                <?php echo $row['Name'] ?>
                              </h5>
                              <span class="text-muted small" id="<?php echo $row['c_ID'] ?>">Hace</span>
                            </div>
                            <p class="small mb-0">
                              <?php echo htmlspecialchars($row['content']) ?>
                            </p>
                          </div>
                        </div>
                        <?php if (isset($_SESSION['datos']['ID']) != NULL && $row['ID'] != $_SESSION['datos']['ID']) { ?>
                          <div class="d-flex justify-content-end align-items-start">
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#report<?php echo $row['c_ID'] ?>">
                              <span class="badge text-bg-secondary"><i class="bi bi-flag-fill"></i></span>
                            </button>

                            <div class="modal fade" id="report<?php echo $row['c_ID'] ?>" tabindex="-1" aria-labelledby="rpot" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5">Reportar comentario</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <p>Danos más información para procesar al comentario:</p>
                                    <form action="../controllers/mangas/reportarcom.php?user=<?php echo $row['ID'] ?>&id=<?php echo $row['c_ID'] ?>" method="POST">
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
                      } ?>
                      </div>
                      <hr>
                      <script>
                        function fecha() {
                          let fechadesde = document.getElementById("<?php echo $row['c_ID'] ?>");
                          var datevalue = "<?php echo $row['created_at']; ?>";
                          var date = Math.abs((new Date(datevalue).getTime() / 1000).toFixed(0));
                          var currentdate = Math.abs((new Date().getTime() / 1000).toFixed(0));

                          var diff = currentdate - date;
                          var days = Math.floor(diff / 86400);
                          var hours = Math.floor(diff / 3600) % 24;
                          var minutes = Math.floor(diff / 60) % 60;
                          if (days >= 1) {
                            fechadesde.textContent = "Hace " + days + " dias";
                          } else if (days < 1 && hours > 1) {
                            fechadesde.textContent = "Hace " + hours + " horas";
                          } else if (days < 1 && hours < 1) {
                            fechadesde.textContent = "Hace " + minutes + " minutos";
                          }
                        }
                        fecha();
                      </script>
                  <?php
                  }
                } else {
                  echo "<p class='h6'>No hay ningun comentario. Se el primero en comentar!</p>";
                }

                  ?>
              </div>
            </div>
          </div>
        </div>

      </div>

<?php }
  }
} ?>