<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');

$conn = mysqli_connect('localhost', 'root', '', 'cattusmanga');

if (!$conn) {
    die('Error de Conexión (' . mysqli_connect_errno() . ') '
        . mysqli_connect_error());
}
mysqli_set_charset($conn, 'utf8');


?>