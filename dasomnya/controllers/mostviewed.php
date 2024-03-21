<?php 
$viewed = "SELECT * FROM mangaviews INNER JOIN manga ON mangaviews.manga_ID = manga.ID WHERE mangaviews.views_count ORDER BY views_count DESC LIMIT 4";
$result_views2 = mysqli_query($conn, $viewed);
$mangasviewed1 = array();

if (mysqli_num_rows($result_views2) > 0) {
    while ($row = mysqli_fetch_assoc($result_views2)) {
      $mangas[] = $row;
    }
  }
  
  foreach ($mangas as $manga) {
    if($manga['desactivation_date'] == NULL){
  ?>
    <div class="col-sm-4">
      <div class="card card1" style="width: 14rem; min-width: 221px; min-height:349px;">
        <img src="../mangas/<?php echo $manga['ID']; ?>/caratula.png" class="card-img-top" style="min-width: 221px; min-height:349px;" onerror="this.src='../img/notfound.png'" alt="<?php echo $manga['title']; ?>">
        <a href="../controllers/manga.php?manga=<?php echo $manga['ID']; ?>">
          <div class="backside">
            <div class="card-img-overlay">
              <h4 class="card-title"><?php echo htmlspecialchars($manga['title']); ?></h4>
              <p class="card-text"><?php echo htmlspecialchars($manga['description']) ?></p>
            </div>
          </div>
      </div>
      <h5><?php echo htmlspecialchars($manga['title']);
          ?></h5></a>
    </div>
  
  <?php } }?>
 
<!--  Numero aleatorio -->
  <?php 
$sqlgetid= "SELECT ID FROM manga order by RAND() LIMIT 1";
$randommanga= mysqli_query($conn, $sqlgetid);
$randommanga1= mysqli_fetch_all($randommanga, MYSQLI_ASSOC);

  ?>

