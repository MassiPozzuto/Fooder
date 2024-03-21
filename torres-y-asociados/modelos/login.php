<?php
    session_start();
    require_once '../includes/config.php';

    $emailInicio = $_POST['emailInicio'];
    $clave = $_POST['claveInicio'];
    $claveInicio = sha1($_POST['claveInicio']);

    $checkbox = (isset($_POST['recordar-checkbox'])) ? $_POST['recordar-checkbox'] : '';

    $result = [
        "success" => null,
        "remind" => $checkbox,
        "email" => $emailInicio,
        "pass" => $clave,
        "response" => null
    ];

    $queryValidar = "SELECT * FROM usuarios
                    WHERE email='$emailInicio'
                    AND clave='$claveInicio'
    ";

    $validar_login = mysqli_query($conn, $queryValidar);
    
    if(!$validar_login){
        die(mysqli_error($conn));
    }

    $actUser = mysqli_fetch_assoc($validar_login);

   
    if(mysqli_num_rows($validar_login) == 0){
        $result['success'] = 0;
        $result['response'] = 'Los datos ingresados son incorrectos';

        echo json_encode($result);
        //echo("Los datos ingresados son incorrectos");
    }else if($actUser['fecha_baja'] != NULL){
        $result['success'] = 0;
        $result['response'] = 'Su cuenta ha sido baneada';

        echo json_encode($result);
        //echo("Su cuenta ha sido baneada");
    }else if(mysqli_num_rows($validar_login) > 0){
        $result['success'] = 1;

        $_SESSION['usuario_id'] = $actUser['id'];
        echo json_encode($result);
        //echo("1");
    }
?>