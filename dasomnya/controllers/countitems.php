<?php
$sql = "SELECT * FROM itemsshop RIGHT JOIN userinventory ON itemsshop.ID = userinventory.item_ID WHERE userinventory.user_ID =" . $_SESSION['datos']['ID'] . ";";
$result = mysqli_query($conn, $sql);
$items = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
}

$contaritems= count($items);
$owo = 0;
if ($contaritems + $owo > 10){
    
}




$_SESSION['itemstotales'] = $contaritems;
if($_SESSION['itemstotales'] == NULL){
    echo 'Actualmente no tienes items :c. Compra algunos items geniales en nuestra tienda';
} 
    else{
        if ($contaritems + $owo > 10){
            echo "Actualmente tienes ". $_SESSION['itemstotales'] . " items :D eso es mucho";
        }else{
        echo "Actualmente tienes ". $_SESSION['itemstotales'] . " items :D"; 
    }
        }
