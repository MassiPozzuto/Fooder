<?php
require_once "../../server/config.php";


if(isset($_POST['submit'])){
	
	$email = $_POST['email'];
	$username = $_POST['username'];
	$role_user = $_POST['role'];
	$pwd = $_POST['password'];
	$pwd2 = $_POST['password2'];

	require_once "../../resources/funciones.php";

	if(emptyInput($email, $username, $pwd, $pwd2) !== false){
		header("location: ../moderacion.php?section=administration&roles=todos&page=1&error=emptyinput");
		exit();
	}
	if(invalidUid($username) !== false){
		header("location: ../moderacion.php?section=administration&roles=todos&page=1&error=invaliduid");
		exit();
	}
	if(invalidEmail($email) !== false){
		header("location: ../moderacion.php?section=administration&roles=todos&page=1&error=invalidemail");
		exit();
	}
	if(pwdMatch($pwd,$pwd2) !== false){
		header("location: ../moderacion.php?section=administration&roles=todos&page=1&error=passwordnotmatch");
		exit();
	}
	if(uidExist($conn,$username,$email) !== false){
		header("location: ../moderacion.php?section=administration&roles=todos&page=1&error=uidtaken");
		exit();
	}
	createUser($conn, $email, $username, $pwd, $role_user);
}