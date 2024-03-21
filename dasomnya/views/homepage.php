
  <!-- carrusel -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="homepage.php">Inicio</a></li>
  </ol>
  <div class="container fluid">
  <div id="carousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
      <a href="../controllers/manga.php?manga=10013"><img src="../Img/Otros/ba.jpg" class="d-block w-100" alt="Baki The Grappler"></a>
      </div>
      <div class="carousel-item">
      <a href="../controllers/manga.php?manga=10000"> <img src="../Img/Otros/wata.jpg" class="d-block w-100" alt="Watashi"></a>
      </div>
      <div class="carousel-item">
      <a href="../controllers/manga.php?manga=10002"> <img src="../Img/Otros/naruto-banner-test.jpg" class="d-block w-100" alt="..."></a>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Siguiente</span>
    </button>
</div>
</div>

<div class="container mb-5">
  <!-- fin del carousel -->
  
  <hr class="invisible">
   <center><h2>Mangas más vistos</h2></center>
  <hr>
  <div class="row row-cols-2 row-cols-md-4 g-4">
    <?php
    require_once "../controllers/mostviewed.php";
    ?>
  </div>
  <hr class="invisible">
  <center><h2>Últimas entradas</h2></center>
<p class="text-start text-primary"> <a class="btn btn-celeste" href="../controllers/manga.php?manga=<?php echo $randommanga1[0]['ID']; ?>"> Ver un manga aleatorio</a></p>
  <hr>
  <div class="row row-cols-2 row-cols-md-4">
    <?php
    require_once "../controllers/mangashomepage.php";
    ?>
  </div>
  <?php 
 if(isset($_SESSION['datos']['ID'])){
  $sqlUMH= "SELECT * FROM userreadmangahistory WHERE User_ID =" .$_SESSION['datos']['ID'] . ";";
  $resultsHistory = mysqli_query($conn, $sqlUMH);
  $rCheck = mysqli_num_rows($resultsHistory);


if ($rCheck !== 0 ||$rCheck !== NULL) {?>
 <hr class="invisible">
<center><h2>Continuar leyendo</h2></center>
<hr>
<div class="row row-cols-2 row-cols-md-4 g-4">
<?php
    require_once "../controllers/mangaslast.php";
    ?>
</div>
<hr>
<?php } }?>

</div>



<hr class="invisible">
<hr class="invisible">
<style>
  .card:hover .backside{
    opacity: 1;
    
  }
.card:hover .card-img-top{
    opacity: 70%;
    filter: brightness(20%);
    transition: all 0.25s ease 0s;   
    
}

</style>

