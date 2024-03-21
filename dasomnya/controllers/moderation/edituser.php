<?php
require_once('../../server/config.php');
require_once "../../resources/funciones.php";

if (isset($_POST['submit'])) {

	$id = $_GET['userid'];
	$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$role_user = $_POST['role'];
	$pwd = $_POST['password'];
	$points = $_POST['points'];
	$dscdate = $_POST['datedes'];
	$page=$_GET['page'];



	function validateDate($date, $format = 'Y-m-d H:i:s')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	if ($dscdate != NULL) {
		if (!validateDate($dscdate)) {
			header("location: ../moderacion.php?section=administration&roles=todos&page=1&error=date");
			exit();
		}
	}


	if (strlen($pwd) > 12) {
		header("location: ../moderacion.php?section=administration&roles=todos&page=1&error=lgnpwd");
		exit();
	}


	if (invalidUid($username) !== false) {
		header("location: ../moderacion.php?section=administration&roles=todos&page=1&error=invaliduid");
		exit();
	}
	if (invalidEmail($email) !== false) {
		header("location: ../moderacion.php?section=administration&roles=todos&page=1&error=invalidemail");
		exit();
	}
	
	$getusername = "SELECT * FROM users WHERE name = '$username' AND ID = '$id';";
	$gtresultname = mysqli_query($conn, $getusername);
	if (!mysqli_num_rows($gtresultname) > 0) {
		if (usernamexist($conn, $username) != false) {
			header("location: ../moderacion.php?section=administration&roles=todos&page=1&error=uidtaken");
			exit();
		}
	}
	$getuseremail = "SELECT * FROM users WHERE Email = '$email' AND ID = '$id';";
	$gtresultemail = mysqli_query($conn, $getuseremail);
	if (!mysqli_num_rows($gtresultemail) > 0) {
		if (emailexist($conn, $email) != false) {
			header("location: ../moderacion.php?section=administration&roles=todos&page=1&error=uidtaken");
			exit();	
		}
	}
	



	editUser($conn, $id, $email, $username, $dscdate, $points, $pwd, $role_user,$page);

	echo $id . "<br>";
	echo $email . "<br>";
	echo $username . "<br>";
	echo $role_user . "<br>";
	echo $pwd . "<br>";
	echo $points . "<br>";
	echo $dscdate . "<br>";
}



/* 	require_once "../../resources/funciones.php";

	if(emptyInput($email, $username, $pwd, $pwd2) !== false){
		header("location: ../moderacion.php?section=administration&error=emptyinput");
		exit();
	}
	

	if(pwdMatch($pwd,$pwd2) !== false){
		header("location: ../moderacion.php?section=administration&error=passwordnotmatch");
		exit();
	}
	
} */