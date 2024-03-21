  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="homepage.php">Inicio</a></li>
    <li class="breadcrumb-item active"><a>Tu información</a></li>
    <li class="breadcrumb-item active">Marcadores</li>
  </ol>
  <?php
  if (!$rowLikedMangas) { ?>
    <center>
      <h3>Tus favoritos</h3>
    </center>
    <hr />
    <h5> No has agregado ningún manga a favoritos aún. Hazlo dándole al <i class="bi bi-heart-fill"></i> en cualquier manga.</h5>
  <?php } else { ?>
    <center>
      <h3>Tus favoritos</h3>
    </center>
    <hr />
    <div class="row row-cols-2 row-cols-md-4 g-4 mb-5">
      <?php foreach ($rowLikedMangas as $likedmangas) {   ?>

        <div class="col-sm-4">
          <div class="card card1" style="width: 14rem; min-width: 221px; min-height:349px;">
            <img src="../mangas/<?php echo $likedmangas['ID']; ?>/caratula.png" style="min-width: 221px; min-height:349px;" onerror="this.src='../img/notfound.png'" class="card-img-top" alt="<?php echo $likedmangas['title']; ?>">
            <a href="../controllers/manga?manga=<?php echo $likedmangas['ID']; ?>">
              <div class="backside">
                <div class="card-img-overlay">
                  <h4 class="card-title"><?php echo htmlspecialchars($likedmangas['title']); ?></h4>
                  <p class="card-text"><?php echo htmlspecialchars($likedmangas['description']); ?></p>
                </div>
              </div>
          </div>
          <h5><?php echo $likedmangas['title']; ?></h5></a>
        </div>

    <?php }
    }
    ?>
    </div>
    <hr class="invisible">  
    <hr class="invisible">