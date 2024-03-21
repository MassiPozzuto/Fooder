<?php
require_once "config.php";

//print_r($_FILES);die;

if (isset($_POST['nombre'])) {
    $sql = "INSERT INTO comidas (nombre, descripcion, pais_id, categoria_id, created_at) 
    VALUES ('" . $_POST['nombre'] . "', '" . $_POST['descripcion'] . "', '" . $_POST['pais_id'] . "', '" . $_POST['categoria_id'] . "', NOW())";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "Fallo consulta: " . mysqli_error($con);
        exit();
    }
    $receta_id = mysqli_insert_id($con);
    if ($_FILES['principal_img']['type'] == 'image/jpeg' && $_FILES['principal_img']['error'] == 0) {
        if (!is_dir('img/recetas/' . $receta_id)) {
            mkdir('img/recetas/' . $receta_id);
        }
        move_uploaded_file($_FILES['principal_img']['tmp_name'], 'img/recetas/' . $receta_id . '/principal.jpg');
    }
    header("location: index.php");
}

$view = "receta_alta";
require_once "views/layout.php";
