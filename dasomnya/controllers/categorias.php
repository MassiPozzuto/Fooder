<?php
require_once "../server/config.php";

require_once "../server/check_user_logged.php";


$sqlCategories = "SELECT * FROM mangagenders";

$resultCategories = mysqli_query($conn, $sqlCategories);
if (!$resultCategories) {
    die('Error de consulta' . mysqli_error($conn));
}
$sqlMangas = "SELECT * FROM manga LEFT JOIN mangagenders_manga ON mangagenders_manga.Manga_ID = manga.ID INNER JOIN mangagenders ON mangagenders.g_ID = mangagenders_manga.MangaGenders_ID ORDER BY manga.ID";
$resultMangas = mysqli_query($conn, $sqlMangas);

if (!$resultMangas) {
    die('Error de consulta' . mysqli_error($conn));
}
$mangas = array();
if (mysqli_num_rows($resultMangas) > 0) {
  while ($row = mysqli_fetch_assoc($resultMangas)) {
    $mangas[] = $row;
  }
}


$view = "categorias";
require_once "../views/layout.php";
