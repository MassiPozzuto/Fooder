<?php 
$data = "SELECT * FROM users";
$info = mysqli_query($conn,$data);
$row = array();

if (mysqli_num_rows($info) > 0) {
    while ($papa = mysqli_fetch_assoc($info)) {
        $row[] = $papa;
    }
}
$a2= count($row);





$data2 = "SELECT * FROM manga";
$info2 = mysqli_query($conn,$data2);
$row2 = array();

if (mysqli_num_rows($info2) > 0) {
    while ($papa2 = mysqli_fetch_assoc($info2)) {
        $row2[] = $papa2;
    }
}
$a3= count($row2);





?>