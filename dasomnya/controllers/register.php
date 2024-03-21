<?php
require_once "../server/config.php";
require_once "../resources/funciones.php";

if(isset($_POST['submit'])){
	
	$email = $_POST['email'];
	$username = $_POST['username'];
	setcookie('username', $username);
	setcookie('email', $email);
	$pwd = $_POST['password'];
	$pwd2 = $_POST['password2'];
	if(emptyInput($email, $username, $pwd, $pwd2) !== false){
		header("location: register.php?error=emptyinput");
		exit();
	}
	if(invalidUid($username) !== false){
		header("location: register.php?error=invaliduid");
		exit();
	}
	if(invalidEmail($email) !== false){
		header("location: register.php?error=invalidemail");
		exit();
	}
	if(pwdMatch($pwd,$pwd2) !== false){
		header("location: register.php?error=passwordnotmatch");
		exit();
	}
	if(uidExist($conn,$username,$email) !== false){
		header("location: register.php?error=uidtaken");
		exit();
	}

	createUser($conn, $email, $username, $pwd);
	
	

}
$view = "register";
require_once "../views/layout.php";