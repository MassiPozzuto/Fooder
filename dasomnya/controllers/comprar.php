<?php
require_once "../server/config.php";
session_start();
$sqlItem = "SELECT * FROM itemsshop WHERE ID = ". $_GET['itemid'].";";
$result = mysqli_query($conn, $sqlItem);

if(!$result){
    header("Location: tienda.php?type=all&error=true");
    die("Error de consulta: " . mysqli_error($conn));
    exit();
} 

else{
	$item = array();
	if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $item[] = $row;
    }
}
$sqlUser = "SELECT * FROM users WHERE ID = ". $_SESSION['datos']['ID'].";";
$result2 = mysqli_query($conn, $sqlUser);

if(!$result2){
    header("Location: tienda.php?type=all&error=true");
    die("Error de consulta: " . mysqli_error($conn));
    exit();
} 
$user = array();
	if (mysqli_num_rows($result2) > 0) {
    while ($row1 = mysqli_fetch_assoc($result2)) {
        $user[] = $row1;
    }
}
$itemprice = $item[0]['Price'];
$currentbalance = $user[0]['points'];
  if( $itemprice <= $currentbalance){
    $newbalance = $currentbalance - $itemprice;
    $sqlUpdate = "INSERT INTO userinventory (user_ID, item_ID) VALUES (".$_SESSION['datos']['ID'].", ".$item[0]['ID'].");";
    $sqlUpdate .="UPDATE users SET points = ". $newbalance ." WHERE ID = ". $_SESSION['datos']['ID'].";";
    $resultUpdate = mysqli_multi_query($conn, $sqlUpdate);
    if(!$resultUpdate){ 
    	header("Location: inventario.php?type=all&error=true");
    	die("Error de consulta: " . mysqli_error($conn));
    	exit();
    }
   $_SESSION['datos']['points'] = $newbalance;
    header("Location: tienda.php?type=all&page=1&error=none");
}
 else if (( $itemprice > $currentbalance)) {
    	header("Location: tienda.php?type=all&page=1&error=notenoughpoints");
    	exit();
    }
}