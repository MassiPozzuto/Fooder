<?php
require_once "../server/config.php";

require_once "../server/check_user_logged.php";
$manga_id = $_GET['manga'];
if (!isset($_GET['manga'])) {
  header("location: homepage.php");
  die();
}

$mid = $_GET['manga'];

$sqlManga = "SELECT title FROM manga WHERE ID = '$mid';";
$resultManga = mysqli_query($conn, $sqlManga);
$resultManga = mysqli_fetch_all($resultManga, MYSQLI_ASSOC);

if (isset($_SESSION['datos'])) {
  $verifyLike = "SELECT * FROM mangalikes WHERE  manga_id= '" . $_GET['manga'] . "' AND user_id = " . $_SESSION['datos']['ID'] . " ";

  $resultVerify = mysqli_query($conn, $verifyLike);
  if (!$resultVerify) {
    echo "Error de consulta" . mysqli_error($conn);
    exit();
  }
  $rowVerify = mysqli_fetch_assoc($resultVerify);

  $verifyFav = "SELECT favourite_manga_ID FROM userprofile WHERE favourite_manga_ID= '" . $_GET['manga'] . "' AND User_ID = " . $_SESSION['datos']['ID'] . "";

  $resultVerifyFav = mysqli_query($conn, $verifyFav);
  if (!$resultVerifyFav) {
    die("Error de consulta: " . mysqli_error($conn));
  }
  $rowVerifyFav = mysqli_fetch_assoc($resultVerifyFav);
  //    $numVerifyFav = mysqli_num_rows($resultVerifyFav);
 

}
$sqlgenres = "SELECT * FROM mangagenders INNER JOIN mangagenders_manga ON mangagenders.g_ID = mangagenders_manga.MangaGenders_ID INNER JOIN manga ON mangagenders_manga.Manga_ID = manga.ID WHERE manga.ID = '$mid';";
$sqlgenres1 = "SELECT * FROM mangagenders INNER JOIN mangagenders_manga ON mangagenders.g_ID = mangagenders_manga.MangaGenders_ID INNER JOIN manga ON mangagenders_manga.Manga_ID = manga.ID WHERE manga.ID = '$mid';";
$resultgenres = mysqli_query($conn, $sqlgenres);
$resultgenres1 = mysqli_query($conn, $sqlgenres1);

$sqlchapters = "SELECT * FROM manga INNER JOIN mangachapters ON manga.ID = mangachapters.Manga_ID WHERE manga.ID = '$mid' ORDER BY mangachapters.number DESC;";
$resultchapters = mysqli_query($conn, $sqlchapters);

if(!$resultchapters ||!$resultchapters ){
  die();
  header("location: 500.php");
}
$counter = mysqli_num_rows($resultgenres); 

$view = "manga";
require_once "../views/layoutnf.php";

if (isset($_SESSION['datos'])) {

  $uniqueviews = "SELECT * FROM manga_unique_view WHERE User_ID =" . $_SESSION['datos']['ID'] . " AND manga_ID ='$mid';";
  $resView = mysqli_query($conn, $uniqueviews);
  $count = mysqli_num_rows($resView);

  if ($count == 0 || $count == NULL) {
    $instview = "INSERT INTO manga_unique_view (User_ID, manga_ID) VALUES(" . $_SESSION['datos']['ID'] . ",'$mid');";
    $resIns = mysqli_query($conn, $instview);

    $addview = "UPDATE mangaviews SET views_count = views_count + 1 WHERE manga_ID = '$mid';";
    $addres = mysqli_query($conn, $addview);
  }
}
