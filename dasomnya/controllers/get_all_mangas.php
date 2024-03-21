<?php
require_once "../server/check_user_logged.php";

     include("../server/config.php");
     $text = mysqli_real_escape_string($conn, $_GET['search']);

     $sqlSearch = "SELECT * FROM manga WHERE title LIKE '%$text%' ";
     $resultSearch = mysqli_query($conn, $sqlSearch);
     if(!$resultSearch){
          die('Error de consulta' . mysqli_error($conn));
     }
     $rowSearch = array();
if (mysqli_num_rows($resultSearch) > 0) {
  while ($row = mysqli_fetch_assoc($resultSearch)) {
    $rowSearch[] = $row;
  }
}

     $numSearch = mysqli_num_rows($resultSearch);


     $view = "busqueda";
     require_once('../views/layout.php');
?>    