<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo RUTA ?>/img/logo.png">
    <link rel="stylesheet" href="<?php echo RUTA ?>/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo RUTA ?>/css/estilos.css">
    <title>Memingos</title>
</head>
<body <?php echo("class='".$clase."'")?>>
    <section class="no-permissions-conteiner">
        <div class="img-conteiner"><img class="img-no-permissions" src="img/no-permissions-img/no-permissions-<?php echo $img?>"></div>
        <p class="aviso-no-permissions">No tienes los permisos necesarios para acceder a esta pagina.</p>
        <p class="aviso-no-permissions">Si crees que es un error comunicate con <a href="#" class="link-soporte">soporte</a></p>
        <hr class="hr">
        <a class="btn-home-no-permissions" href="feed-principal.php">Home</a>
    </section>
</body>

