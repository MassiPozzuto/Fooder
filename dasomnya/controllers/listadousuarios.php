<?php 
require '../server/mysqli_connector.php';

$limitator = 50;
echo ("<table border='1'>");
$query = "SELECT * FROM users ORDER BY birthdate DESC LIMIT " . $limitator . ";";
if ($resultado = mysqli_query($enlace, $query)) {  
    $row = mysqli_fetch_assoc($resultado);
    echo ("<thead><tr>");
    foreach ($row as $k => $v) {
        echo ("<td> " . $k ."</td>");
    }
    echo ("<tr></thead><tbody>");

    while ($row = mysqli_fetch_assoc($resultado)) {
        echo ("<tr>");
        foreach ($row as $v) {
            echo ("<td> " . $v ."</td>");
        }
        echo ("<tr>");
    }
    mysqli_free_result($resultado);
}
mysqli_close($enlace);
echo ("</tbody></table>");
?>