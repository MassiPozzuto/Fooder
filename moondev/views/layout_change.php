<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="includes/jquery3.6.0.js"></script>
    <script type="module" src="controllers/print_table.js"></script>
    <script src='controllers/change/change.js'></script>
    <script src='controllers/auth/swipe.js'></script>
    <script type='module' src='controllers/auth/view.js'></script>
    <script src='controllers/auth/ajax.js'></script>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="icon" type="image/x-icon" href="img/icono.png">
    <link rel="stylesheet" href="font-awesome\css\font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="includes/jquery3.6.0.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="controllers/normal/mercado/mercado.css"/>
    <script id="auth_settings" type="application/json">
        <?php require_once("api/get_settings.php");
        getSettings("auth"); ?>
    </script>
    <title>Surmoon - Cambio De Credenciales </title>
    

</head>

<body>

<?php require_once("includes/sidenav.php");?>
<div class="men">
    <h2 id="paginator_section_1"></h2>
    <div id="global_error_1"></div>
    <table class="mt10" id="get_table_all_1">
    </table>
    <div id="paginator_list_1"></div>
</div>
    <div class="mailhist">
    <h1>Historial de emails</h1>
    <h2 id="paginator_section_2"></h2>
    <P>Ordenados del mas reciente al mas viejo</p>
    <div id="global_error_2"></div>
    <table class="mt10" id="get_table_all_2">
    </table>
    <div id="paginator_list_2"></div>
    </div>
    <div class="nombhist">
    <h1>Historial de nombres de usuario</h1>
    <h2 id="paginator_section_3"></h2>
    <P>Ordenados del mas reciente al mas viejo</p>
</div>
    <div id="global_error_3"></div>
    <table class="mt10" id="get_table_all_3">
    </table>
    <div id="paginator_list_3"></div>
    <h1 class="papuh1">Edite la informacion de su cuenta</h1>
    <div class="formulario">
        <form action="javascript:loadAjax(false);" class="registro" id="auth_form">
            <div hidden class="alert alert-danger bootstrap_alertas" role="alert" id="global_div">
                <p class="bolded" id="global_error"></p>El sistema de cambio de informaci&oacute;n se ha deshabilitado. Contactar soporte.
            </div>
            <br id="br_1" />
            <br />
            <div class="botonescont">
                <button class="bot" id="submit_button" id="submit_button">Ingresar</button>
            </div>
        </form>
        <div class="texto" id="swipe_button1"></div>
        <div class="texto" id="swipe_button2"></div>
    </div>
    <header class="navbar-shop">
<?php require_once("includes/nav.php");?>
</header>
</body>
</html>