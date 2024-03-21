<?php
require_once "../server/config.php";

require_once "../server/check_user_logged.php";

if(!isset($_SESSION['datos'])){
    header("Location: login.php");
}else{
    $sqlLikedMangas = "SELECT * 
    FROM mangalikes
    LEFT JOIN manga
        ON mangalikes.manga_id = manga.ID
    WHERE mangalikes.user_id = '". $_SESSION['datos']['ID'] ."'";

    $resultLikedMangas = mysqli_query($conn, $sqlLikedMangas);

    $rowLikedMangas = mysqli_fetch_all($resultLikedMangas, MYSQLI_ASSOC);
}

$view = "likedmangas";
require_once "../views/layout.php";