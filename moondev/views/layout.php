<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="font-awesome\css\font-awesome.min.css">
    <script src="includes/jquery3.6.0.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="img/icon1.png">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="every">
    <div>
        <div>
            <?php require_once "includes/sidenav.php" ?>
        </div>
        <div>
            <div class="container">
                <?php require_once("views/" . $folder . "/" . $section); ?>
            </div>
        </div>
    </div>
</body>
</html>