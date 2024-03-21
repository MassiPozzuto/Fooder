<?php

require_once "../server/config.php";

require_once "../server/check_user_logged.php";


    session_destroy();
    unset($_SESSION['user_id']);
    header('location:login.php');

?>