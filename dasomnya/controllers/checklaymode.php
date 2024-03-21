<?php 
if(!isset( $_SESSION['datos'])){
session_start();
}

$userid =  $_SESSION['datos']['ID'];
require_once "../server/config.php";

$sqlmode = "SELECT nightmode FROM userprofile WHERE User_ID =". $userid .";";
$moderesult = mysqli_query($conn, $sqlmode);
if(!$moderesult){
    die();
    header("Location:" . $_SERVER['HTTP_REFERER']);

}
$mode = mysqli_fetch_assoc($moderesult);

if(isset($_POST['change'])){
$change = $_POST['change'];
}
if(isset($change) != NULL){
    if($mode['nightmode'] != 'off'){
        $sqlcmode = "UPDATE userprofile SET nightmode ='off' WHERE User_ID =". $userid .";";
        $changeresult = mysqli_query($conn, $sqlcmode);

     }
     else{
        $sqlcmode = "UPDATE userprofile SET nightmode ='on' WHERE User_ID =". $userid .";";
        $changeresult = mysqli_query($conn, $sqlcmode);

     }
}
else{
if($mode['nightmode'] != 'off'){
   echo '<body class="darkmode">';
}
else{
    echo '<body class="lightmode">';
}
}
