<?php if(isset($_GET['category'])){?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="categorias.php">Categorías</a></li>
  <?php if (isset($_GET['category'])) { ?>
    <li class="breadcrumb-item " arial-current="page"><a href="categorias.php?categoria=<?php echo $_GET['category'] ?>"><?php echo $_GET['category'] ?></a></li>
  <?php }
  if (isset($_GET['manga'])) { ?>
    <li class="breadcrumb-item active" arial-current="page"><a href="#"><?php echo $resultManga[0]['title']; ?></a></li>
  <?php } ?>
</ol>

<?php }
require '../server/mysqli_connector.php';
if (!isset($_GET['manga'])) {
  header("location: homepage");
  die();
}
$limitator = 20;
$sql = "SELECT * FROM manga WHERE ID = '$mid';";
$result = mysqli_query($conn, $sql);
$mangas = array();
$mangaviews = "SELECT * FROM mangaviews WHERE manga_ID = '$mid';";
$resultviews1 = $conn->query($mangaviews);
$rowviews = $resultviews1->fetch_assoc();
$row_cnt = mysqli_num_rows($result);

if ($row_cnt > 0 || $row_cnt != NULL) {
?>
  <h1><?php if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo htmlspecialchars($row['title']);
      ?></h1>
  <div>
    <?php
    if(isset($_GET['error'])){
      if($_GET['error'] == "emptyinput"){
        echo '<div class="alert alert-danger" role="alert">
              Genero vacio.
              </div>';
      }
      if($_GET['error'] == "none"){
        echo '<div class="alert alert-success" role="alert">
              Manga modifcado con exito.
              </div>';
      }
      if($_GET['error'] == "empty"){
        echo '<div class="alert alert-danger" role="alert">
              Descripcion vacia.
              </div>';
      }
      if($_GET['error'] == "titleinvalid"){
        echo '<div class="alert alert-danger" role="alert">
              El titulo ingresado no es valido. Asegurate de que no contenga caracteres especiales.
              </div>';
      }
      if($_GET['error'] == "invalidname"){
        echo '<div class="alert alert-danger" role="alert">
              El nombre de genero ingresado no es valido. Asegurate de que no contenga caracteres especiales.
              </div>';
      }
    }
          if (isset($_SESSION['datos'])) {
            $usersession = $_SESSION['datos']['ID'];
            if ($_SESSION['datos']['ID'] == $row['User_ID'] || $_SESSION['datos']['role_id'] == 4) { ?>

        <div class="d-flex flex-row-reverse">
          <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#edit">
            <span class="badge text-bg-secondary"><i class="bi bi-pencil-square"></i>
            </span>
          </button>
        </div>

        <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edita tu manga</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="../controllers/mangas/editmanga.php?mangaid=<?php echo $row['ID'] ?>" method="POST">
                  Título:
                  <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($row['title']) ?>"></input>
                  Descripción:
                  <textarea type="text" class="form-control" rows="5" name="description"><?php echo htmlspecialchars($row['description']) ?></textarea>
                  <div id="generos">
                    Añadir géneros:
                    <button type="button" id="addgenre" onclick="addGenre()" class="btn btn-sm btn-secondary d-grid gap-2 d-flex justify-content-end">
                      +
                    </button>
                    <?php
                     $categoriaspre = array();
                     if (mysqli_num_rows($resultgenres1) > 0) {
                       while ($row1 = mysqli_fetch_assoc($resultgenres1)) {
                         $categoriaspre[] = $row1;
                       }
                     }
                     $fecounter = 0;
                     foreach ($categoriaspre as $categoriaspre) { ?>
                        <input type="text" class="form-control" name="genre<?php echo $fecounter;?>" placeholder="Genero <?php echo $fecounter;?>" value="<?php echo $categoriaspre['Name']   ?>"></input>
                        <a href="../controllers/mangas/erasegenre.php?manga=<?php echo $_GET['manga']?>&category=<?php echo $categoriaspre['g_ID']?>&at=<?php echo $fecounter + 1?>">Eliminar</a>
                      <?php $fecounter++;} ?>
                   
                    <div id="genres">

                    </div>
                  </div>
                  Añadir capítulos:
                  <input type="number" class="form-control" name="" value=""></input>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="submit" class="btn btn-primary">Guardar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <script>
        const genrebutton = document.getElementById('addgenre');
        counter = <?php echo $fecounter - 1?>;
        function addGenre() {
          if (counter == 3) {
            genrebutton.className += " disabled";
          }
          counter++;
          newinput = document.createElement("input");
          newinput.setAttribute("type", "text")
          genrenamebf = "genre" + counter
          newinput.setAttribute("name", genrenamebf)
          newinput.setAttribute("placeholder", "Genero " + counter)

          newinput.classList.add("form-control")



          const parentdiv = document.getElementById("generos");
          const currentdiv = document.getElementById("genres");
          parentdiv.insertBefore(newinput, currentdiv);


        }
      </script>
    <?php } ?>
    <div class="container mt-2">
      <div class="row">
        <div class="col-sm-5">
          <div class="caratula"><img src="../mangas/<?php echo $row['ID'] ?>/caratula.png" onerror="this.src='../img/notfound.png'" class="float-start d-block img-thumbnail mangacover" alt="caratula"></div>
        </div>
        <div class="col-sm-7">
          <div class="">
            <aside class="nones">

              <h2>Descripción</h2>
              <p><?php echo htmlspecialchars($row['description']); ?> </p>
              <p>Visitas: <?php echo $rowviews["views_count"] ?> </p>
              <p>Añadido en: <?php echo $row['uploadDate']; ?></p>
              <p>Última actualización: <?php echo $row['lastUpdate'];
                                      }
                                    } ?></p>
            </aside>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container mt-2 d-inline-flex etiqueta">
    <?php
    $categorias = array();
    if (mysqli_num_rows($resultgenres) > 0) {
      while ($row = mysqli_fetch_assoc($resultgenres)) {
        $categorias[] = $row;
      }
    }
    foreach ($categorias as $categorias) { ?>

      <a href="../controllers/categorias.php?categoria=<?php echo $categorias['Name']; ?>" type="button" class="btn btn-outline-secondary separado"><i class="bi bi-tag"></i><?php echo $categorias['Name']; ?></a>
      <?php } ?>
    <!-- Pregunto si inició sesion-->

    <?php if (!isset($_SESSION['datos'])) { ?>
      <button type="button" class="btn btn-secondary favbtn" onclick="location.href='login.php'"><i class="bi bi-star"></i></button>
      <button type="button" class="btn btn-secondary favbtn" onclick="location.href='login.php'"><i class="bi bi-heart"></i></button>

      <!-- No le dio like-->
      <?php } else {
      if (mysqli_num_rows($resultVerify) == 0) { ?>
        <button type="button" class="btn btn-secondary favbtn" onclick="location.href='mangas/like.php?manga=<?php echo $manga_id; ?>'"><i class="bi bi-heart"></i></button>
        <!-- Le dio like-->
      <?php } else { ?>
        <button type="button" class="btn btn-secondary favbtn" onclick="location.href='mangas/like.php?manga=<?php echo $manga_id; ?>'"><i class="bi bi-heart-fill"></i></button>
        <!-- No le dio fav-->
      <?php }
      if (mysqli_num_rows($resultVerifyFav) == 0) { ?>
        <button type="button" class="btn btn-secondary favbtn" onclick="location.href='mangas/favourite.php?manga=<?php echo $manga_id; ?>'"><i class="bi bi-star"></i></button>
        <!-- Hay que hacer que muestre un mensaje de error cuando el usuario le da favorito a un manga cuando ya tiene uno en favoritos -->
        <div class="bg-danger">
          <?php echo (isset($msj) ? $msj : ''); ?>
        </div>
        <!-- Le dio fav -->
      <?php } else { ?>
        <button type="button" class="btn btn-secondary favbtn" onclick="location.href='mangas/favourite.php?manga=<?php echo $manga_id; ?>'"><i class="bi bi-star-fill"></i></button>
    <?php }
    } ?>
  </div>

  <hr class="invisible">

  <div>
    <div class="container capitulos" id="chapters">
      <h2 class="">Capítulos</h2>
      <hr>
      <?php

      $capitulos = array();
      if (mysqli_num_rows($resultchapters) > 0) {
        while ($row = mysqli_fetch_assoc($resultchapters)) {
          $capitulos[] = $row;
        }
      }
      foreach ($capitulos as $capitulos) { ?>

        <article onclick="location.href='leer?manga=<?php echo $_GET['manga']; ?>&capitulo=<?php echo $capitulos['number']; ?>';" style="cursor: pointer">
          <a href="leer.php?manga=<?php echo $_GET['manga']; ?>&capitulo=<?php echo $capitulos['number']; ?>"> Capítulo <?php echo $capitulos['number']; ?></a>
        </article>
      <?php }
      if (!mysqli_num_rows($result)) {
        echo "<p class='text'>No hay capitulos disponibles</p>";
      }
      ?>
    </div>
  </div>
  </div>
  </div>
<?php } else { ?>
  Manga no encontrado
<?php } ?>
<hr class="invisible">