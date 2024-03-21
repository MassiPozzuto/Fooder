<?php
    require_once "includes/config.php";
    session_start();
    $_SESSION['correoUsur'] = $_POST["mail"];
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'includes/PHPMailer/Exception.php';
    require 'includes/PHPMailer/PHPMailer.php';
    require 'includes/PHPMailer/SMTP.php';
    $email = $_POST["mail"];
    $query= "SELECT nombreUsuario FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if(!$result){
        die(mysqli_error($conn));
    }
    $usuario = mysqli_fetch_assoc($result);
    $clave = random_int(100000, 999999);
    $_SESSION['clave'] = $clave;
    $destinatario = $_POST["mail"];
    /*comienzo phpmailer */
    $mail = new PHPMailer(true);
    try {
        //configuracion para el server
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'memingos.etn26@gmail.com';
        $mail->Password   = 'tlhgpdlmolgxzjuu';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
    
        $mail->setFrom('memingos.etn26@gmail.com', 'Torres Y Asociados');
        $mail->addAddress($destinatario, $usuario["nombreUsuario"]);
        /*comienzo del cuerpo del html */
        $mail->isHTML(true);
        $mail->Subject = "Restablecer Clave de Memingos" . "\r\n";
        $mail->Body    = '<html><body<div style="
        position: absolute; 
        left:30%; 
        font-family: "calibri";
        background-color: #070707cc;
        border: 1px solid #070707;
        border-radius:10px;
        padding:10px;
        color:white;
        ">
        <img src="https://i.pinimg.com/564x/89/f4/d1/89f4d1502091dd469e385bb3d4117e9c.jpg" width="100px" height="100px">
        <h3>Hola '.$usuario["nombreUsuario"].'<br>
        <br>
        Recibimos una solicitud para restablecer tu clave de Memingos.<br>
        Ingresa el siguiente codigo para restablecer la clave:<br>
        <br>
        <span style="border: 1px solid #00bbff;background-color:#00bbff38;padding:10px 20px; border-radius: 10px;">'.$clave.'</span>
        </h3>Si no quieres cambiar la clave, simplemente ignore este correo.<br>Atte.: <b>Torres y Asociados<b></div></body></html>';
    
        $mail->send();
        header("Location: enviar-codigo.php");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>