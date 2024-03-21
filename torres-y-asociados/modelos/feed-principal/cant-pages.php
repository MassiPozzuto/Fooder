<?php
    require_once "../../includes/config.php";
    //require_once "../usuario-actual.php";
    
    $cantPostsToShow = $_GET['cantPosts'];

    $query = 'SELECT * FROM publicaciones';
    $res = mysqli_query($conn, $query);

    if(!$res){
        die('Error de Consulta');
    }

    $cantPosts = ceil(mysqli_num_rows($res) / $cantPostsToShow);

    echo $cantPosts;
?>