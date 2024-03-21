<?php
require_once "../views/layout.php";
require_once '../server/mysqli_connector.php';
$limitator = 20;
$sql = "SELECT * FROM manga ORDER BY ID DESC LIMIT " . $limitator . ";";
$result = mysqli_query($conn, $sql);
$mangas = array();
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $mangas[] = $row;
  }
}

foreach ($mangas as $manga) {
  if($manga['desactivation_date'] == NULL){
?>
  <div class="col">
    <div class="card card1" style="width: 14rem; min-width: 221px; min-height:349px;">
      <img src="../mangas/<?php echo $manga['ID']; ?>/caratula.png" class="card-img-top" style="min-width: 221px; min-height:349px;"onerror="this.src='../img/notfound.png'" alt="<?php echo $manga['title']; ?>">
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
