<?php 
require_once("../../server/config.php");

$manga = $_GET['manga'];
$category = $_GET['category'];
$at = $_GET['at'];


$sql = "DELETE FROM mangagenders_manga WHERE Manga_ID = '$manga' AND counter = '$at'; UPDATE mangagenders_manga SET counter = counter - 1 WHERE Manga_ID = '$manga' AND counter > '$at'";
$result = mysqli_multi_query($conn, $sql);

header("location: ../manga.php?manga=" . $manga);