<?php
   // session_start();

    /*if(isset($_SESSION['usuario_id'])){
        //header("Location: feed-principal.php");
        echo "<script>alert('Inicie Sesion');</script>";
    }*/

    if(isset($_GET['success']) && $_GET['success'] == '1'){
        header("Location: feed-principal.php");
    }

    require_once "includes/config.php";

    $section_login = "login";

    if(isset($_GET['recordar-checkbox']) && $_GET['recordar-checkbox'] == 'SI'){
        setcookie('emailInicio', $_GET['emailInicio']);
        setcookie('claveInicio', $_GET['claveInicio']);
        setcookie('recordar-checkbox', $_GET['recordar-checkbox']);
        $_COOKIE = $_GET;
    }else if(!isset($_GET['recordar-checkbox']) && (isset($_GET['emailInicio']) || isset($_GET['claveInicio']))){
        setcookie('emailInicio', '');
        setcookie('claveInicio', '');
        setcookie('recordar-checkbox', '');
        unset($_COOKIE);
    }

    require_once "views/layout-login.php";
?>