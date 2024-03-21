<?php
require_once "config.php";

$sql = "SELECT * FROM comidas";
$result = mysqli_query($con, $sql);
if(!$result){
    echo "Fallo consulta: " . mysqli_error($con);
    exit();
}

// Fetch all
$comidas = mysqli_fetch_all($result, MYSQLI_ASSOC);

$view = "home";
require_once "views/layout.php";
