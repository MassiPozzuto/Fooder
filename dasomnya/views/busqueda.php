<!-- Terminado/ Quizas añadir autocompletar -->

<?php         /* Si no hay resultados se mostrara esto */
if ($numSearch == 0) { ?>
  <div class="titlesection">Resultados para "<?php echo htmlspecialchars($_GET['search']); ?>" son 0,<strong> intenta con otra búsqueda.</strong></div>

<?php       /* Si hay resultados se muestran todos los resultados que tengan una coincidencia */
} else { ?>  
  <div class="titlesection">Resultados para <strong>"<?php echo $_GET['search']; ?>"</strong>son <?php echo $numSearch; ?> </div>
  <div class="row row-cols-2 row-cols-md-4 g-4">
<?php foreach($rowSearch as $manga){ 
  if($manga['desactivation_date'] == NULL){?>
  <div class="col-sm-4">
    <div class="card card1" style="width: 14rem; min-width: 221px; min-height:349px;">
      <img src="../mangas/<?php echo $manga['ID']; ?>/caratula.png" class="card-img-top" style="min-width: 221px; min-height:349px;" onerror="this.src='../img/notfound.png'" alt="<?php echo $manga['title']; ?>">
      <a href="../controllers/manga.php?manga=<?php echo $manga['ID']; ?>">
        <div class="backside">
          <div class="card-img-overlay">
            <h4 class="card-title"><?php echo htmlspecialchars($manga['title']); ?></h4>
            <p class="card-text"><?php echo htmlspecialchars($manga['description']); ?></p>
          </div>
        </div>
    </div>
    <h5><?php echo htmlspecialchars($manga['title']);?></h5>
       </a>
  </div>
<?php
} } ?> </div> <?php } ?>

