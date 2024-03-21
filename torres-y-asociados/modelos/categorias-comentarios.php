<?php
    require_once 'includes/config.php';
    $idPubCategoria = $_GET["id"];
    $queryCategoria = 'SELECT categorias.nombre FROM `categorias` INNER JOIN publicaciones_categorias AS pub_cat ON pub_cat.categoria_id = categorias.id INNER JOIN publicaciones AS pub ON pub.id = pub_cat.publicacion_id WHERE pub.id = '.$idPubCategoria.' AND categorias.fecha_baja IS null';
    $resultCategoria = mysqli_query($conn,$queryCategoria);
    if(!$resultCategoria){
        die("error de consulta");
    }
    $categoriasComentario = mysqli_fetch_all($resultCategoria,MYSQLI_ASSOC);
    foreach($categoriasComentario as $categoriaComentario){
        echo('<a href="'.RUTA.'/resultados-busqueda.php?busqueda='.$categoriaComentario["nombre"].'">#'.$categoriaComentario["nombre"].'</a>');
    }
?>