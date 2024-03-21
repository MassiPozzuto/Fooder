<?php
session_start();
require_once("../../server/config.php");
$mangaid = $_GET['manga'];

// Pregunto si le dio fav
$sqlVerifyFav = "SELECT favourite_manga_ID FROM userprofile WHERE favourite_manga_ID= '" . $_GET['manga'] . "' AND user_id = " . $_SESSION['datos']['ID'] . " ";
$resVerifyFav = mysqli_query($conn, $sqlVerifyFav);
if (!$resVerifyFav) {
    die('Error de Consulta: ' . mysqli_error($conn));
}
$rowVerifyFav = mysqli_fetch_array($resVerifyFav);

$sqlUserFav = "SELECT favourite_manga_ID FROM userprofile WHERE user_id = '" . $_SESSION['datos']['ID'] . "'";
$resUserFav = mysqli_query($conn, $sqlUserFav);
if (!$resUserFav) {
    die("Error de consulta: " . mysqli_error($conn));
}
$rowUserFav = mysqli_fetch_array($resUserFav);

//Verifico si no le dio fav
if (mysqli_num_rows($resVerifyFav) == 0) {
    //Verifico si le esta dando favorito a otro manga

    if ($_SESSION['datos']['ID'] == $rowUserFav['User_ID']) {
        $msj = "Solo puedes darle favorito a un manga";
        header("Location:" . $_SERVER['HTTP_REFERER']);
    }
    $sqlFav = "UPDATE userprofile SET favourite_manga_ID = '$mangaid'  WHERE User_ID = '" . $_SESSION['datos']['ID']."'";
    $resFav = mysqli_query($conn, $sqlFav);
    if (!$resFav) {
        die('Error de Consulta: ' . mysqli_error($conn));
    }
} else {
    // Quito el like de la db
    $sqlDisfav = "UPDATE userprofile SET favourite_manga_ID = NULL WHERE user_id= '" . $_SESSION['datos']['ID'] . "'";
    $resDisfav = mysqli_query($conn, $sqlDisfav);
    if (!$resDisfav) {
        die('Error de Consulta: ' . mysqli_error($conn));
    }
}


header("Location:" . $_SERVER['HTTP_REFERER']);
