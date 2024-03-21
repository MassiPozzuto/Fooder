<?php 
    require_once "../includes/config.php";
    require_once "../modelos/usuario-actual.php";

    $get1 = '0';
    $get2 = '0';
    $get3 = '0';
    $num = 0;

    $nombre=$_POST["nuevo-nombre"];

    if($nombre=="" || strlen($nombre) < 4){
        $nombre=$user["nombreUsuario"];
        $get1 = '1';
    }
    
    $descripcion=$_POST["descripcion-usuario"];

    if($descripcion==""){
        $descripcion = $user["descripcion"];
    }

    $correo=$_POST["nuevo-correo"];
    $correoSp = explode("@", $correo);
    
    if($correo != $user['email']){
        $mAdress = mysqli_query($conn, "SELECT * FROM usuarios WHERE email = '$correo'");
            if(!$mAdress){
                echo die('Error consulta' . mysqli_error($conn));
            }
        $num = mysqli_num_rows($mAdress);
    }

    if($correo=="" || $num == 1 || $correoSp[1] != 'gmail.com'){
        $correo = $user["email"];
        $get2 = '1';
    }

    $rawPass = $_POST["password2"];
    $password = sha1($rawPass);

    

    if(strlen($rawPass) < 8){
        $password = $user["clave"];
        $get3 = '1';
    }

    if($rawPass == ""){
        $get3 = '0';
    }

    /*
        var_dump($nombre);
        var_dump($descripcion);
        var_dump($correo);
        var_dump($password);

    */

    //var_dump($_FILES["cambiar-foto"]);

   
    
    if($_FILES["cambiar-foto"]["error"]!=4){
        $nombre_archivo=$_FILES["cambiar-foto"]["name"];
        $ruta_foto="../img/users/" . $user['id'] . "/";
        $ruta_foto_db="img/users/" . $user['id'] . "/";
        
        //echo "estoy dentro";
        /*
        if(file_exists($ruta_foto . "foto-perfil.jpg")){
            unlink($ruta_foto . "foto-perfil.jpg");
            
        }*/

        $files = glob($ruta_foto . "*"); //obtenemos todos los nombres de los ficheros
        foreach($files as $file){
            if(is_file($file))
                unlink($file); //elimino el fichero

        }
        
        @mkdir($ruta_foto);

        if(!file_exists($ruta_foto)){
           @mkdir($ruta_foto, 0777, true);
        }

        $ruta_imagen=$ruta_foto . $nombre_archivo;
        $ruta_imagen_db=$ruta_foto_db . $nombre_archivo;
        $imagenValida=false;

        if (move_uploaded_file($_FILES['cambiar-foto']['tmp_name'], $ruta_imagen)) {
            $imagenValida = true;
        }
        
        if($imagenValida){
            
            $query_foto="UPDATE usuarios SET fotoPerfil='" . $ruta_imagen_db . "' WHERE id='" . $user["id"] . "'";
            
            if(!mysqli_query($conn, $query_foto)){
                die("Error de consulta: " . mysqli_error($conn));
            }
                


        }else{
            die("error al mover imagen, no seas matias");
        } 
    }

    $query_info="UPDATE usuarios SET nombreUsuario='" . $nombre . "', descripcion='" . $descripcion . "', email='" . $correo . "', clave='" . $password . "' WHERE id='" . $user['id'] . "'";
    if(!mysqli_query($conn, $query_info)){
        die("Error de consulta: " . mysqli_error($conn));
    }

    header("Location: ../ajustes-de-cuenta.php?erru=$get1&errm=$get2&errc=$get3");

?>