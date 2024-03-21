<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="img/icono.png">
    <title>Administracion</title>
    <script src="includes/jquery3.6.0.js"></script>
    <script type="module" src="controllers/print_table.js"></script>
    <script src="controllers/gestion-pagina/editor.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="font-awesome\css\font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="img/icon1.png">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="adminm">
    <div class="main-container">
        <div class="body-nav-bar">
            <img src="assets/luna.png" alt="aaa">
            <center>
                <h3>Administrador</h3>
            </center>
            <ul class="mt10">
                <li><a href="<?php echo ($GLOBALS["index_root"]); ?>usuariosadm">Jugadores</a></li>
                <li><a href="<?php echo ($GLOBALS["index_root"]); ?>objetos">Objetos</a></li>
                <li><a href="<?php echo ($GLOBALS["index_root"]); ?>misionesadm">Misiones</a></li>
                <li><a href="<?php echo ($GLOBALS["index_root"]); ?>mercado">Salir</a></li>
            </ul>
        </div>
        <div class="body-pagem">
            <?php require_once("views/" . $folder . "/" . $section); ?>
        </div>
    </div>
</body>
</html>