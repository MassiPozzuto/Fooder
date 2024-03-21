<?php
    $id = $_GET['id'];
    $from = $_GET['sec'];

    $condition = $from=='usuario' ? 'destinatario' : $_GET['sec'];

    $sql = "SELECT usuarios.*, reportes_$from.descripcion AS descrip, reportes_$from.id AS rep_id, IF(true, '$from', false) AS from_table 
            FROM reportes_$from INNER JOIN usuarios ON usuarios.id = reportes_$from.usuario_id 
            WHERE ".$condition."_id = $id";
            
    $query = mysqli_query($conn, $sql);
    if(!$query){
        die('Error Consulta:' . mysqli_error($conn));
    }

    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>
