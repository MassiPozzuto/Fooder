<!DOCTYPE HTML>
<html lang="es">
<head>
    <title>MoonDev</title>
    <link rel="stylesheet" type="text/css" href="css/main/style.css">
    <link rel="icon" type="image/x-icon" href="img/icon1.png">
</head>
<body>
    <header>
        <h1 class="logo">MOONDEV</h1>
        <ul>
            <p class="text">
                <?php if ($is_logged !== true) {
                    echo ("No has iniciado sesion");
                } else {
                    echo ("Bienvenido " . $_SESSION['username']);
                } ?>
            </p>
            <?php if ($is_logged === true) {
            ?>
                <li><a href="<?php echo ($GLOBALS["index_root"]) ?>logout">Cerrar sesion</a></li>
            <?php
            }  ?>
            <?php if ($admin_rights === true) { ?>
                <li><a href="<?php echo ($GLOBALS["index_root"]) ?>admin">Administracion</a></li>
            <?php } ?>
        </ul>
    </header>
    <?php require_once("views/" . $folder . "/" . $section); ?>
</body>
</html>