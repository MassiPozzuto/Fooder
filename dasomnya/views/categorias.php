<div class="container-fluid mb-5">

  <?php if (isset($_GET['categoria']) == NULL) { ?>

    <h1> Categorías </h1>
  <?php } else { ?>
    <h1><?php echo $_GET['categoria']; ?> </h1>
  <?php } ?>
  <hr />
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="homepage.php">Inicio</a></li>

    <li class="breadcrumb-item"><a href="categorias.php">Categorías</a></li>
    <?php if (isset($_GET['categoria'])) { ?>
      <li class="breadcrumb-item active" arial-current="page"><a href="#"><?php echo $_GET['categoria'] ?></a></li>
    <?php } ?>
  </ol>
  <div class="row row-cols-2 row-cols-md-4 g-4">
    <?php
    if (isset($_GET['categoria']) == NULL) {
      foreach ($resultCategories as $categoria) {
    ?>
        <div class="col-sm-4 col-sm-2 mr-3 mb-3" style="color:orange">
          <div class="card" style="max-width: 12em">
            <a href="../controllers/categorias.php?categoria=<?php echo $categoria['Name']; ?>">
              <img src="../mangas/<?php echo $categoria['image']; ?>/caratula.png" onerror="this.src='../img/notfound.png'" class="card-img-top" alt="Card Image">
              <div class="card-body">
                <div class="card-title text-center">
                  <p><?php echo htmlspecialchars($categoria['Name']); ?></p>
                </div>
            </a>
          </div>
        </div>
  </div>
  <?php }
    }

    if (isset($_GET['categoria'])) {

      foreach ($mangas as $manga) {
        if ($_GET['categoria'] == $manga['Name']) {
  ?>
    <div class="col-sm-4">
      <div class="card card1" style="width: 14rem; min-width: 221px; min-height:349px;">
        <img src="../mangas/<?php echo $manga['ID']; ?>/caratula.png" class="card-img-top"  style="min-width: 221px; min-height:349px;"onerror="this.src='../img/notfound.png'" alt="<?php echo $manga['title']; ?>">
        <a href="../controllers/manga.php?manga=<?php echo $manga['ID']; ?>&category=<?php echo $_GET['categoria']?>">
          <div class="backside">
            <div class="card-img-overlay">
              <h4 class="card-title"><?php echo htmlspecialchars($manga['title']); ?></h4>
              <p class="card-text"><?php echo htmlspecialchars($manga['description']); ?></p>
            </div>
          </div>
      </div>
      <h5><?php echo htmlspecialchars($manga['title']);
          ?></h5></a>
    </div>

<?php

        }
      }
    } ?>

</div>
</div>
<script>
 $(document).ready(function () {
    $('#tabcategorias').addClass('underline');

});
</script>