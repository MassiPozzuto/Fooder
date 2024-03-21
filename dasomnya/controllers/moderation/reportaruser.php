<?php 
session_start();
require_once("../../server/config.php");

if(isset($_POST) & !empty($_POST)){
	
	$userid =  $_SESSION['datos']['ID'];
    $afctduser =  $_GET['user'];
	$info = mysqli_real_escape_string($conn ,$_POST['information']);

    echo $userid . "<br>";
    echo $afctduser .  "<br>";
    echo $info . "<br>";

}
	$isql = "INSERT INTO moderationlogusers(`Affected_User_ID`, `User_ID`, `date`, `moderationStatus_ID`, `information`) VALUES ($afctduser, $userid ,NOW(),1, '$info');";

	$ires = mysqli_query($conn, $isql) or die(mysqli_error($conn)); 

 	if($ires){
	header("Location:" . $_SERVER['HTTP_REFERER']);
		exit();
	}else{
			header("Location:" . $_SERVER['HTTP_REFERER'."&error=true"]);

    }