<?php
    require_once "../../includes/config.php";
    //require_once "../usuario-actual.php";
    
    $cantCommentsToShow = $_GET['cantComments'];
    $publicacion = $_GET['id'];

    $query = 'SELECT * FROM comentarios WHERE publicacion_id = ' . $publicacion . ' AND fecha_baja IS NULL';
    $res = mysqli_query($conn, $query);

    if(!$res){
        die('Error de Consulta');
    }

    $cantComments = ceil(mysqli_num_rows($res) / $cantCommentsToShow);

    echo $cantComments;
?>