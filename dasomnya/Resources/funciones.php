<?php

function emptyInput($email, $username, $pwd, $pwd2)
{
	isset($result);
	if (empty($email) || empty($username) || empty($pwd) || empty($pwd2)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

function invalidUid($username)
{
	isset($result);
	if (!preg_match("/^[a-zA-Z][0-9a-zA-Z_]{3,12}[0-9a-zA-Z]*$/", $username)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

function invalidEmail($email)
{
	isset($result);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}
function pwdMatch($pwd, $pwd2)
{
	isset($result);
	if ($pwd !== $pwd2) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}
function uidExist($conn, $username, $email)
{
	$sql = "SELECT * FROM users LEFT JOIN profiles
        ON users.ID = profiles.user_id WHERE Name = ? OR Email = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: register.php?error=stmterror");
		exit();
	}
	mysqli_stmt_bind_param($stmt, "ss", $username, $email);
	mysqli_stmt_execute($stmt);

	$resultData = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	} else {
		$result = false;
		return $result;
	}
	mysqli_stmt_close($stmt);
}

function usernamexist($conn, $username)
{
	$sql = "SELECT * FROM users LEFT JOIN profiles
        ON users.ID = profiles.user_id WHERE Name = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: 500.php?error=stmterror");
		exit();
	}
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);

	$resultData = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	} else {
		$result = false;
		return $result;
	}
	mysqli_stmt_close($stmt);
}
function emailexist($conn, $email)
{
	$sql = "SELECT * FROM users LEFT JOIN profiles
        ON users.ID = profiles.user_id WHERE Email = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: 500.php?error=stmterror");
		exit();
	}
	mysqli_stmt_bind_param($stmt, "s", $email);
	mysqli_stmt_execute($stmt);

	$resultData = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	} else {
		$result = false;
		return $result;
	}
	mysqli_stmt_close($stmt);
}
function createUser($conn, $email, $username, $pwd, $role_user = 2)
{
	$sql = "INSERT INTO users (`Name`, `Email`, `Password`, `profile_pic`, `activation_date`, `desactivation_date`, `suscriptions_ID`, `email_validated`, `points`) VALUES(?, ?, ?, '../Img/avatar.png', NOW(), NULL, 0, 0,100);";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: register.php?error=stmterror");
		exit();
	}
	$hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);

	mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedpwd);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);

	$puser = mysqli_escape_string($conn, $username);

	$getUser = "SELECT ID FROM users WHERE Name = '" . $puser . "';";
	$result = mysqli_query($conn, $getUser);
	$datau = array();
	if (mysqli_num_rows($result) > 0) {
		while ($data = mysqli_fetch_assoc($result)) {
			$datau[] = $data;
		}
	}
	echo $datau[0]['ID'];

	$createProfile = "INSERT INTO userprofile (User_ID, nightmode,show_badges, favourite_manga_ID, show_favourite, show_likes, description, show_interests, show_role, bg_dir) VALUES('" . $datau[0]['ID'] . "','off', 1, NULL, 1, 1, '', 1, 0, NULL); INSERT INTO profiles (role_id, user_id) VALUES('" . $role_user . "','" . $datau[0]['ID'] . "');";
	$send = mysqli_multi_query($conn, $createProfile);
	while (mysqli_next_result($conn)) {;
	};

	if (isset($_GET['section']) && $_GET['section'] === 'newuser') {
		header("Location: ../moderacion.php?section=administration");
	} else {
		unset($_COOKIE['email']);
		unset($_COOKIE['username']);
		setcookie("email", null);
		setcookie("username", null);
		session_start();
		$uidexist = uidExist($conn, $username, $email);
		while (mysqli_next_result($conn)) {;
		};
		$_SESSION['datos'] = $uidexist;
		header("location: homepage.php");
		exit();
	}
}

function emptyLogInput($username, $pwd)
{
	isset($result);
	if (empty($username) || empty($pwd)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

function logInUser($conn, $username, $pwd, $remember)
{
	$uidExist = uidExist($conn, $username, $username);
	if ($uidExist === false) {
		header("location: login.php?error=wronglogin");
		exit();
	}
	$hashedpwd = $uidExist["Password"];
	$checkpwd = password_verify($pwd, $hashedpwd);

	if ($checkpwd === false) {
		header("location: login.php?error=wronglogin");
		exit();
	} else if ($checkpwd === true && $remember == true) {
		session_start();
		setcookie("remember", $remember);
		setcookie("pass", $pwd);
		setcookie("user", $username);
		$_SESSION['datos'] = $uidExist;
		header("location: homepage.php");
	} else if ($checkpwd === true && $remember == NULL) {
		session_start();
		unset($_COOKIE['pass']);
		unset($_COOKIE['remember']);
		unset($_COOKIE['user']);
		setcookie("remember", null);
		setcookie("pass", null);
		setcookie("user", null);
		$_SESSION['datos'] = $uidExist;
		header("location: homepage.php");
	}
}

function editUser($conn, $id, $email, $username, $dscdate, $points, $pwd, $role_user,$page)
{
	$getuser = "SELECT * FROM users WHERE ID = '$id';";
	$gtresult = mysqli_query($conn, $getuser);

	if ($dscdate == NULL && $pwd == NULL) {
		$sqledit = "UPDATE users SET Name = '$username', Email='$email', points=$points WHERE ID = $id; UPDATE profiles SET role_id = $role_user WHERE user_id = $id";
		$result = mysqli_multi_query($conn, $sqledit);
		if (!$result) {
			return false;
		}
	}
	if ($pwd != NULL) {
		$hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);
		$sqledit = "UPDATE users SET Name = '$username', Email='$email',points=$points,Password='$hashedpwd' WHERE ID = $id; UPDATE profiles SET role_id = $role_user WHERE user_id = $id";
		$result = mysqli_multi_query($conn, $sqledit);
		if (!$result) {
			return false;
		}
	}
	if ($dscdate != NULL) {
		$sqledit = "UPDATE users SET Name = '$username', Email='$email'	,points=$points,desactivation_date='$dscdate' WHERE ID = $id; UPDATE profiles SET role_id = $role_user WHERE user_id = $id";
		$result = mysqli_multi_query($conn, $sqledit);
		if (!$result) {
			return false;
		}
	}
	if ($dscdate != NULL && $pwd != NULL) {
		$hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);
		$sqledit = "UPDATE users SET Name = $username, Email=$email,points=$points,Password='$hashedpwd',,desactivation_date='$dscdate' WHERE ID = $id; UPDATE profiles SET role_id = $role_user WHERE user_id = $id";
		$result = mysqli_multi_query($conn, $sqledit);
		if (!$result) {
			return false;
		}
	}
	header("Location: ../moderacion.php?section=administration&roles=todos&page=".$page."&error=none1");
}



function uploadmanga($conn, $titulo, $descripcion, $categorias, $fecha,$file,$chapters )
{


	$sql = "INSERT INTO manga (title, description, uploadDate, User_ID, desactivation_date)
	VALUES ('$titulo', '$descripcion', '$fecha', '" . $_SESSION['datos']['ID'] . "',NULL);";
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		die('Error de consulta' . mysqli_error($conn));
	} else {
		$sqlgetid = "SELECT * FROM manga WHERE title = '$titulo' ORDER BY ID DESC;";
		$resultid = mysqli_query($conn, $sqlgetid);
		$dataid = array();
		if (mysqli_num_rows($resultid) > 0) {
			while ($data = mysqli_fetch_assoc($resultid)) {
				$dataid[] = $data;
			}
		}
		$mangaid = $dataid[0]['ID'];
		$sqlupdtgnr = "INSERT INTO mangagenders_manga(Manga_ID, MangaGenders_ID, counter) VALUES($mangaid, $categorias, 1); INSERT INTO mangaviews (manga_ID, views_count) VALUES($mangaid, 0);INSERT INTO mangachapters(Manga_ID, description, number, uploadDate, User_ID, LastPagesSuscription, LastPagesPrice, allow_purchase, desactivation_date) VALUES ($mangaid, NULL, 1, '$fecha', " . $_SESSION['datos']['ID'] . ",0, 0, 0, NULL);";
		
		$file = $_FILES['caratula'];
		$chapters = $_FILES['chapters'];
		$resultgnr = mysqli_multi_query($conn, $sqlupdtgnr);
		$filename = $_FILES['caratula']['name'];
		$filetmpname = $_FILES['caratula']['tmp_name'];
		$filerror = $_FILES['caratula']['error'];
		$filetype = $_FILES['caratula']['type'];
		$filesize = $_FILES['caratula']['size'];
	
		$fileext = explode('.',$filename);
		$filenewext = strtolower(end($fileext));
	
		$allowed = array('png','jpeg','jpg');
	
		mkdir("../mangas/" . $mangaid, 0700);
		mkdir("../mangas/" . $mangaid . "/1", 0700);
		$filedestination = "../mangas/".$mangaid."/".$fileext[0].".".$filenewext;
		move_uploaded_file($filetmpname,$filedestination);
		sleep(1);
		rename("../mangas/".$mangaid."/".$filename, "../mangas/".$mangaid."/caratula.png");

		
		$crror = $_FILES['chapters']['error'];
		$ctype = $_FILES['chapters']['type'];
		$csize = $_FILES['chapters']['size'];

		$allowed = array('jpg');
$totalchp =	count($_FILES['chapters']['name']);
for($i=0;$i<=$totalchp;$i++){	
	$cname = $_FILES['chapters']['name'][$i];
	$cext = explode('.',$cname);
	$cnewext = strtolower(end($cext));
	$ctmpname = $_FILES['chapters']['tmp_name'][$i];

		$cdestination = "../mangas/".$mangaid."/1/".$cext[0].".".$cnewext;
		move_uploaded_file($ctmpname,$cdestination);
		sleep(1);
		$ii = $i+1;
		rename("../mangas/".$mangaid."/1/".$cname, "../mangas/".$mangaid."/1/".$ii.".jpg");

}
header("location: ../controllers/manga.php?manga=".$mangaid);
}
}
