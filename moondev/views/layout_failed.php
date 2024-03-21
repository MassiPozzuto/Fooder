<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surmoon Falla tecnica</title>
    <script src="../includes/jquery3.6.0.js"></script>
    <script type="module" src="../controllers/failed/failed.js"></script>
    <script type="application/json" id="cookie_error">
        <?php require_once("../includes/failed_code.php"); ?>
    </script>
</head>
<body>
    <h1>Ha ocurrido una falla en el sitio web</h1>
    <p id="global_error"></p>
    <hr />
    <p><a href="../index.php?seccion=homepage">Haga click aqui</a> para regresar a la pagina principal</p>
</body>
</html>