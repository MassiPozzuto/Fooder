<?php 
include "../config.php";
/*mostrara si la publicacion tiene likes */
    $query = "SELECT * FROM `publicaciones_likes` WHERE usuario_id = ".$_POST['usuario']." AND publicacion_id =".$_POST['publicacion'];
    $result = mysqli_query($conn,$query);
    if(!$result){
        die('Error de Consulta' . mysqli_error($conn));
    }
    if(mysqli_num_rows($result) == 1){
        echo('si dio like');
    }else{
        echo('no dio like');
    }
?>