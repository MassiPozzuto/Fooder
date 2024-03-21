<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="icon" type="image/x-icon" href="img/icono.png">
    <script src="includes/jquery3.6.0.js"></script>
    <script type="module" src="controllers/auth/view.js"></script>
    <script src="controllers/auth/ajax.js"></script>
    <script src="controllers/auth/swipe.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="img/icon1.png">
    <title>Autentificacion</title>
    <script id="auth_settings" type="application/json">
        <?php require_once("api/get_settings.php");
        getSettings("auth"); ?>
    </script>
</head>
<body class="login">
    <div class="formulario">
        <img src="img/luna.jpg" alt="Cargando..." class="icono">
        <form action="javascript:loadAjax(false);" class="registro" id="auth_form">
            <div hidden class="alert alert-danger bootstrap_alertas" role="alert" id="global_div">
                <p class="bolded" id="global_error"></p>El sistema de autenticacion se ha deshabilitado, contactar soporte.
            </div>
            <br id="br_1" />
            <br />
            <div class="botonescont">
                <button class="bot" id="submit_button" id="submit_button">Ingresar</button>
            </div>
        </form>
    </div>
    <div class="texto" id="swipe_button1"></div>
    <div class="texto" id="swipe_button2"></div>
    <div class="texto" id="swipe_button3"></div>
    <div class="texto" id="swipe_button4"></div>
    <h4>nico205@gmail.com</h4>
    <h4> EE$$$77eeGg </h4>
</body>
</html>