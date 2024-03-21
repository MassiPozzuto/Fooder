<?php
require_once "../server/config.php";
require_once "../server/check_user_logged.php";



$sqlCategories = "  SELECT Name, g_ID AS categorias  FROM   mangagenders";

$sqlSuscription = "SELECT Name AS suscripcion FROM  suscriptions";

$resultCategories = mysqli_query($conn, $sqlCategories);

$rowCategories = mysqli_fetch_all($resultCategories);

if (isset($_POST['submit'])) {
    $titulo = mysqli_real_escape_string($conn, $_POST['title']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['description']);
    $categorias = $_POST['categories'];
    $fecha = date("YmdHis");
    require_once "../resources/funciones.php";

    $file = $_FILES['caratula'];
    $chapters = $_FILES['chapters'];
    $filename = $_FILES['caratula']['name'];
    $filetmpname = $_FILES['caratula']['tmp_name'];
    $filerror = $_FILES['caratula']['error'];
    $filetype = $_FILES['caratula']['type'];
    $filesize = $_FILES['caratula']['size'];

    $fileext = explode('.',$filename);
    $filenewext = strtolower(end($fileext));

    $allowed = array('png','jpeg','jpg');

    if(in_array($filenewext, $allowed)){
        if($filerror === 0){
                if($filesize < 10000000){
                    uploadmanga($conn, $titulo, $descripcion, $categorias, $fecha,$file,$chapters);
                }
                else{
                    echo "too big";

                }
        }
        else{
            echo "error";

        }
    }
    else{
        echo "invalid type";
    }

}


$view = "subir_manga";
require_once('../views/layout.php');
