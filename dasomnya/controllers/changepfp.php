<?php 	
session_start();
require_once "../server/config.php";
if (isset($_POST['imgcode'])){
$imgcode = $_POST['imgcode'];
$userid = $_POST['userid'];
$sql = "SELECT * FROM users WHERE ID = " .$userid.";";

$changepfp = mysqli_query($conn, $sql);

if(!$changepfp){
    header("Location: inventario.php?type=all&error=true");
    die("Error de consulta: " . mysqli_error($conn));
    exit();
} else{
    $sqlUpdateStatus = "UPDATE users SET profile_pic='../pointshop/". $imgcode.".png' WHERE ID = ". $userid .";";
    $resultUpdateStatus = mysqli_query($conn, $sqlUpdateStatus);
    if(!$resultUpdateStatus){ 
        header("Location: inventario.php?type=all&error=true");
        die("Error de consulta: " . mysqli_error($conn));
        exit();
    }
    $_SESSION['datos']['profile_pic'] = "../pointshop/" .$imgcode.".png";
    header("Location: inventario.php?type=all&error=none");
}
}
else{
   header("Location: inventario.php?type=all&error=true");
    exit();
}
