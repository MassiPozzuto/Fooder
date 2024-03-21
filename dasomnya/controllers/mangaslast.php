<?php
require_once "../server/config.php";
require_once "../server/check_user_logged.php";
require_once "../views/layout.php";
require_once '../server/mysqli_connector.php';

$sqllast = "SELECT * FROM manga INNER JOIN userreadmangahistory ON userreadmangahistory.manga_ID = manga.ID WHERE userreadmangahistory.User_ID  =". $_SESSION['datos']['ID'] ." ORDER BY h_ID ASC ;";
$resultlast = mysqli_query($conn, $sqllast);
$mangaslast = array();
if (mysqli_num_rows($resultlast) > 0) {
  while ($row = mysqli_fetch_assoc($resultlast)) {
    $mangaslast[] = $row;
  }
}

foreach ($mangaslast as $mangalast) {
  if($mangalast['desactivation_date'] == NULL){
?>
  <div class="col-sm-4">
    <div class="card card1" style="width: 14rem; min-width: 221px; min-height:349px;">
      <img src="../mangas/<?php echo $mangalast['ID']; ?>/caratula.png" class="card-img-top" style="min-width: 221px; min-height:349px;" onerror="this.src='../img/notfound.png'" alt="<?php echo $mangalast['title']; ?>">
      <a href="../controllers/leer.php?manga=<?php echo $mangalast['ID'] ; ?>&capitulo=<?php echo $mangalast['at_Chapter']; ?>">
        <div class="backside">
          <div class="card-img-overlay">
            <h4 class="card-title"><?php echo htmlspecialchars($mangalast['title']); ?></h4>
            <p class="card-text"><?php echo htmlspecialchars($mangalast['description']);?></p>
          </div>
        </div>
    </div>
    <h5><?php echo htmlspecialchars($mangalast['title']);
        ?></h5></a>
  </div>

<?php } }?>