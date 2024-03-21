<?php
    require_once "../includes/config.php";

    $table = $_POST['from'];
    $report_id = $_POST['id'];
    $aviso = $_POST['dest'];

    $sql = "DELETE FROM reportes_$table WHERE id = $report_id";
    $query = mysqli_query($conn, $sql);
    if(!$query){
        echo die('Error Consulta:' . mysqli_error($conn));
    }

    $qry = mysqli_query($conn, "SELECT * FROM roles WHERE perfil_id < 3 AND usuario_id = $aviso");
    if(!$qry){
        echo die('Error de Consulta: ' . mysqli_error($conn));
    }
    
    if(mysqli_num_rows($qry) == 0){
        $queryN = mysqli_query($conn, "INSERT INTO notificaciones VALUES (null, null, $aviso, null, 4, $aviso, NOW(), null)");
        if(!$queryN){
            echo die('Error de Consulta: ' . mysqli_error($conn));
        }
    }
    
?>