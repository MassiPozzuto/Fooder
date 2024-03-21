<?php

require_once("api/systemException.php");

$GLOBALS["response"] = new stdClass;

function error_handler($errno, $error_message, $error_file, $error_line, $error_context = null)
{
    $GLOBALS["response"]->errno = $errno;
    $GLOBALS["response"]->type = "ERROR";
    $GLOBALS["response"]->errstr = $error_message;
    $GLOBALS["response"]->message = "global.ErrorException";
    $GLOBALS["response"]->file = $error_file;
    $GLOBALS["response"]->line = $error_line;
    print_cookie_and_finalize();
}

function exception_handler($exception) {
    if ((strlen($exception->getMessage()) > 50)) {
        $GLOBALS['response']->message = "global.unknow";
        $GLOBALS['response']->errstr = $exception->getMessage();
        $GLOBALS['response']->http_code = 500;
    } else {
        $GLOBALS['response']->message = $exception->getMessage();
        $GLOBALS['response']->http_code = $exception->getCode();
    }
    $GLOBALS["response"]->errline = $exception->getLine();
    $GLOBALS["response"]->input = method_exists($exception, "getInput") ? $exception->getInput() : null;
    print_cookie_and_finalize();
}

set_error_handler("error_handler");
set_exception_handler("exception_handler");

$php_version = phpversion();

//El sitio web requiere de minimo PHP 7.4 para su correcto funcionamiento
if ($php_version < 7.4) {
    throw new systemException("global.UNSUPPORTED_PHP", 500, "global_error");
}
//Tambien requiere de MySQL instalado
if (getenv("MYSQL_HOME") == false) {
    throw new systemException("MySQLIException.mysql_not_installed", 500, "global_error");
}

function print_cookie_and_finalize() {
    setcookie(
        "moondev_error",
        json_encode($GLOBALS["response"]),
        "-1",
        "/",
        "",
        false,
        false
    );
    header("Location: views/layout_failed.php");
    die;
}