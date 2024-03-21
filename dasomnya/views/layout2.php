<html>

<head>
    <link href="../Css/bootstrap.css" rel="stylesheet" crossorigin="anonymous">
    <link href="../Css/styles.css" rel="stylesheet" crossorigin="anonymous">
    <link href="../Css/fonts.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/swiper-bundle.min.css">
    <link rel="icon" type="image/x-icon" href="../Img/favicon.png">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>

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

        <?php require_once($view . ".php") ?>

    </div>
  
  
</body>
<script>
    const bdark = document.querySelector('#bdark');
    const body = document.querySelector('body');
    
    load();
    
    bdark.addEventListener('click', e ==>{
        body.classList.toggle('darkmode');
        store(body.classList.contains('darkmode'));
    });

    function load(){
      const darkmode =  localStorage.getItem('darkmode');
        if (!darkmode) {
            store('false');
        }
         elseif(darkmode == 'true'){
            body.classList.add('darkmode');
        }
        function store(value){
            localStorage.setItem('darkmode', value);
        }

        
    }
</script>
</html>