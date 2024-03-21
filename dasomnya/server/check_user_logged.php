<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $sqlUserLogged = "SELECT * FROM users WHERE id = " . $_SESSION['user_id'] . ";";
    $resultUserLogged = mysqli_query($conn, $sqlUserLogged);

    $user = null;

    if (mysqli_num_rows($resultUserLogged) > 0) {
    $row = mysqli_fetch_assoc($resultUserLogged);
    $user = $row;
    }
}
?>