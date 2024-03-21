<?php
require_once "config.php";

if (isset($_POST['nombre'])) {
    $sql = "UPDATE comidas SET 
            nombre = '" . $_POST['nombre'] . "',
            descripcion = '" . $_POST['descripcion'] . "', 
            pais_id = '" . $_POST['pais_id'] . "', 
            categoria_id = '" . $_POST['categoria_id'] . "'
            WHERE id = " . $_GET['receta_id'];
    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "Fallo consulta: " . mysqli_error($con);
        exit();
    }
    header("location: index.php");
}

$sql = "SELECT * FROM paises";
$result = mysqli_query($con, $sql);
if (!$result) {
    echo "Fallo consulta: " . mysqli_error($con);
    exit();
}
// Fetch all
$paises = mysqli_fetch_all($result, MYSQLI_ASSOC);


$sql = "SELECT * FROM comidas WHERE id = " . $_GET['receta_id'];
$result = mysqli_query($con, $sql);
if (!$result) {
    echo "Fallo consulta: " . mysqli_error($con);
    exit();
}
$comida = mysqli_fetch_assoc($result);

$view = "receta_modificar";
require_once "views/layout.php";
