<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

    <link href="../Css/bootstrap.css" rel="stylesheet" crossorigin="anonymous">
    <link href="../Css/styles.css" rel="stylesheet" crossorigin="anonymous">
    <link href="../Css/fonts.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../css/swiper-bundle.min.css">
    <link rel="icon" type="image/x-icon" href="../Img/favicon.png">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="../Css/jquery-ui.css" rel="stylesheet" type="text/css"> 
    <script type="text/javascript" src="../js/jquery-1.12.1.min.js"></script>

 <script
  src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"
  integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c="
  crossorigin="anonymous"></script>
    <script type="text/javascript" src="../js/detectphone.js"></script>

    <title>Cattus Manga</title>
</head>
<?php if(!isset($_SESSION['datos'])){?>
<body class= "lightmode">
<?php }else {require_once ("../controllers/checklaymode.php");}?>
     <?php require_once('../resources/checkBan.php');
    ?>
    <?php require_once('../includes/menu.php');
    ?>
    <div class="container">
    <br><br>

        <?php require_once($view . ".php") ?>

    </div>
  
    <button class="shadow border border-primary" onclick="topFunction()" id="ToTop">Subir <i class="bi bi-arrow-up"></i>
</button>
</body>
<script>
let TopButton = document.getElementById("ToTop");

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 450 || document.documentElement.scrollTop > 450) {
    TopButton.style.display = "block";
  } else {
    TopButton.style.display = "none";
  }
}

function topFunction() {
  document.body.scrollTop = 0; // Para safari segun bootstrap a
  document.documentElement.scrollTop = 0; // Para Chrome, Firefox, IE and Opera segun bootstrap parte 2
}
    
</script>

</html>