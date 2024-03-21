<?php
require_once "config.php";
if (isset($_POST['mail'])) {
    $sql = "SELECT * FROM usuarios WHERE mail='" . $_POST['mail'] . "' AND password='" . sha1($_POST['password']) . "'"; 
    $res = mysqli_query($con, $sql);
    if (mysqli_num_rows($res) === 1) {
        $_SESSION['usuario'] = mysqli_fetch_assoc($res);
        header('Location: index.php');
    }else{
        $err = "No existis";
    }
}
require_once "views/login.php";
