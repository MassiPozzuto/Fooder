<?php
require_once "config.php";


$sql = "DELETE FROM comidas WHERE id=" . $_GET['receta_id'];

if (!mysqli_query($con, $sql)) {
    echo "Fallo consulta: " . mysqli_error($con);
    exit();
}

header("location: index.php");
