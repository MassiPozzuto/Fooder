<?php
    require_once "includes/config.php";
    session_start();
    $codigo_mail = $_SESSION['clave'];

    $section_login = "enviar-codigo";

    require_once "views/layout-login.php";
?>