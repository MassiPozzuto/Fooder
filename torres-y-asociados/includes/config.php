<?php
    define('RUTA', '/proyectos/22-4.10-proyectos/torres-y-asociados');

    $conn = mysqli_connect('localhost', 'root', '', 'memingos');

    if (!$conn) {
        die('Error de Conexion (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
?>