<?php

require_once('../server/config.php');

if (isset($_SESSION['datos'])) {
    header("Location:homepage.php");
}

if (isset($_POST['submit'])) {
    $remember = $_POST['remember'];
    $username = $_POST['name'];
    $pwd = $_POST['password'];
    setcookie('user',$username );
    require_once "../resources/funciones.php";
    if(emptyLogInput($username, $pwd) !== false){
        header("location: login.php?error=emptyinput");
        exit();
    }
    logInUser($conn, $username, $pwd, $remember);
}



$view = "login";
require_once('../views/layout.php');
