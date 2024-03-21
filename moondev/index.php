<?php
/*
1) Funcionamiento del require y el include

Imaginemos que hay un php en ejemplo/archivo.php y le hacemos un require_once desde index.php
archivo.php se fusionara a index.php, eso significa que todo sigue operando desde index.php
Por lo tanto, si hacemos un require_once desde archivo.php, debemos poner la URL relativa suponiendo
que se estuviera accediendo desde index.php

*/

//Con esto indicamos que estamos dentro del index
$GLOBALS["main"] = true;

//Cargamos el error handler para redigir a pagina de error en caso de falla.
require_once 'api/error_handler.php';

//Indicamos al navegador que no guarde cache del sitio web, asi podemos actualizar la programacion.
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");

//Cargo el validador de inicio de sesion
require_once 'api/auth/islogged.php';
$GLOBALS['auth_var']  = new autoLogin;
//Ruta que tendran todos los HTML tags que redirigen dentro del sitio web.
$GLOBALS["index_root"] = $_SERVER['PHP_SELF'] . "?seccion=";

//Funcion por si se debe redigir a cierto lugar dentro del sitio
function location($location)
{
    header('Location: ' . $GLOBALS["index_root"] . $location);
    die;
}

//Si la seccion es nula, falsa o vacia, redirigir a homepage.
if (isset($_GET['seccion']) == (false || null || "")) {
    location('homepage');
} else {
    $get = $_GET['seccion'];
}

//Paginas habilitadas para main y administracion.
$admin_pages = ["admin", "main", "misionesadm", "objetos", "usuariosadm"];
$home_pages = ["homepage"];

$is_logged = $GLOBALS['auth_var']->islogged();
$admin_rights = $GLOBALS['auth_var']->adminRights();

if ($get == "logout") {
    session_unset();
    if (isset($_COOKIE["moondev_auth"]) === true) {
        setcookie('moondev_auth', "", -1, '/');
    }
    location('homepage');
} else if (in_array($get, $home_pages)) {
    $layout = "layout_home";
    $folder = "main";
} else if ($is_logged !== true) {
    if ($get == "auth") {
        $layout = "layout_auth";
        $folder = null;
    } else {
        location('homepage');
    }
} else {
    require_once("apipag/update_user_coins.php");
    getUserCoins();
    if (in_array($get, $admin_pages)) {
        if ($admin_rights === true) {
            $layout = "layout_admin";
            $folder = "gestion-pagina";
        } else {
            location('homepage');
        }
    } else if ($get == "change") {
        $layout = "layout_change";
        $folder = null;
    } else {
        $layout = "layout";
        $folder = "normal";
    }
}

//Compruebo si el archivo existe, si no existe llamar a 404.


//Aca debemos comprobar si la vista dentro de la carpeta de la seccion existe, si la seccion no tiene carpeta
//devolver un true, y si la tiene y la vista no existe devolver false.
$pre_filename1 = ($folder == null) ? true : (file_exists("views/" . $folder . "/" . $get . ".php"));
//Aca debemos comprobar si el layout existe, si existe devolver true, caso contrario devolver false.
$pre_filename2 = file_exists("views/" . $layout . ".php");

//Ambos deben ser verdaderos asi que los unimos, si uno de los dos es false se tirara un 404.
$filename = ($pre_filename1 && $pre_filename2);
//$filename = true;
if ($filename === true) {
    $section = ($get . ".php");
} else {
    throw new systemException("global.404", 404, "global_error");
};

//Obtengo la ruta en al cual se cargaran los CSS y JS correspondientes a cada seccion.
$fileinfo = "controllers/" . $folder . "/" . $get . "/";

//Cargo el layout de la seccion la cual se esta viendo actualmente.
require_once("views/" . $layout . ".php");
