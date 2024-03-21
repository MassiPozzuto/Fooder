<?php
    require_once "../includes/config.php";

    $sql = "DELETE FROM usuarios WHERE id=" . $_GET['id'];
    $res = mysqli_query($conn, $sql);

    if (!$res) {
        die('Error de Consulta ' . mysqli_error($conn));
    }

    header('Location: ../lista.php');
?>