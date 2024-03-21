<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo RUTA ?>/img/logo.png">
    <link rel="stylesheet" href="<?php echo RUTA ?>/css/login-styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="<?php echo RUTA ?>/js/sha1.js"></script>
    <script src="<?php echo RUTA ?>/js/verifications.js"></script>
    <title>Memingos</title>
</head>

<body>

    <!-- Header -->

    <header class="header-index">
        <div class="logo-index">
            <img src="img/logoMemingos.png">
            <h2>MEMINGOS</h2>
            <img src="img/logoEmpresaa.png">
        </div>
    </header>

    <?php
        require_once($section_login . ".php");
    ?>
</body>