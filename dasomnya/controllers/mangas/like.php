<?php
session_start();
require_once("../../server/config.php");


// Pregunto si le dio like
    $sqlVerifyLike = "SELECT * FROM mangalikes WHERE manga_id= '" . $_GET['manga'] . "' AND user_id = " . $_SESSION['datos']['ID'] . " ";
    $resVerifyLike = mysqli_query($conn, $sqlVerifyLike);
    if (!$resVerifyLike) {
       die('Error de Consulta ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($resVerifyLike) == 0) {
        // Añado el like a la db
        $sqlLike = "INSERT INTO mangalikes (user_id, manga_id) VALUES ('" . $_SESSION['datos']['ID'] . "' , '" . $_GET['manga']. "')";
        $resLike = mysqli_query($conn, $sqlLike);
        if (!$resLike) {
           die('Error de Consulta ' . mysqli_error($conn));
        }
    } else {
        // Quito el like de la db
        $sqlDislike = "DELETE FROM mangalikes WHERE manga_id= '" . $_GET['manga'] . "' AND user_id= '" . $_SESSION['datos']['ID'] . "' ";
        $resDislike = mysqli_query($conn, $sqlDislike);
        if (!$resDislike) {
           die('Error de Consulta ' . mysqli_error($conn));
        }
    }
 

header("Location:" . $_SERVER['HTTP_REFERER']);
