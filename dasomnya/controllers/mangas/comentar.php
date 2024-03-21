<?php 
session_start();
require_once("../../server/config.php");

if(isset($_POST) & !empty($_POST)){
	
	$userid =  $_SESSION['datos']['ID'];
	$comment = mysqli_real_escape_string($conn ,$_POST['comment']);
	$atmanga = $_GET['manga'];
    $atchapter = $_GET['capitulo'];

 	$isql = "INSERT INTO comments (User_ID, Manga_ID, content, created_at, deleted_at, mangachapter, nestedAt) VALUES(".$userid.",".$atmanga.",'".$comment."',NOW(),NULL,".$atchapter.",NULL);";

	$ires = mysqli_query($conn, $isql) or die(mysqli_error($conn));

	if($ires){
	header("Location:" . $_SERVER['HTTP_REFERER']);
		exit();
	}else{
			header("Location:" . $_SERVER['HTTP_REFERER'."&error=true"]);

	}
}