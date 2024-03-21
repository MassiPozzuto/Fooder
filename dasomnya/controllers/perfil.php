<?php

require_once "../server/config.php";

require_once "../server/check_user_logged.php";

if (isset($_GET["User"])) {
  $sqlCheckUser = "SELECT ID FROM users WHERE ID = '" . $_GET["User"] . "';";
  $resultCheckUser = mysqli_query($conn, $sqlCheckUser);
  $rowCheckUser = mysqli_fetch_array($resultCheckUser);
  if ($rowCheckUser !== NULL) {
  $sqlUser = "SELECT *
              FROM users
              LEFT JOIN userbadges 
              ON users.ID = userbadges.User_ID 
              LEFT JOIN userprofile 
              ON users.ID = userprofile.User_ID
              WHERE users.ID='" . $_GET["User"] . "'";
  $resultUser = mysqli_query($conn, $sqlUser);
  if (!$resultUser) {
    die("Error de consulta" . mysqli_error($conn));
  }
  else{
  $rowUser = mysqli_fetch_array($resultUser);

  $userFavMangaId = $rowUser['favourite_manga_ID'];
  if(isset($userFavMangaId)){
    $sqlUserFavManga = "SELECT * FROM manga WHERE ID ='" .$userFavMangaId . "'";
    $resultUserFavManga = mysqli_query($conn, $sqlUserFavManga);
    if(!$resultUser){
      die ("Error de consulta 2: " . mysqli_error($conn));
    }
    $rowUserFavManga = mysqli_fetch_array($resultUserFavManga);
  }
  
  $sqlUserManga = "SELECT * FROM manga WHERE User_ID = '".$_GET["User"] . "'";
  
  $resultUserManga = mysqli_query($conn ,$sqlUserManga);

  if(!$resultUserManga){
    die ("Error de consulta " . mysqli_error($conn));
  }

  $numUserManga = mysqli_num_rows($resultUserManga);

  $rowUserManga = mysqli_fetch_all($resultUserManga);
}
}
}
$view = "perfil";
require_once "../views/layout.php";
