<?php
require_once("systemException.php");

function exception_handler($exception)
{
    if (strlen($exception->getMessage()) > 50) {
        $GLOBALS['response']->message = "global.unknow";
        $GLOBALS['response']->errstr = $exception->getMessage();
        $GLOBALS['response']->http_code = 500;
    } else {
        $GLOBALS['response']->message = $exception->getMessage();
        $GLOBALS['response']->http_code = $exception->getCode();
    }
    $GLOBALS["response"]->errline = $exception->getLine();
    $GLOBALS["response"]->input = method_exists($exception, "getInput") ? $exception->getInput() : null;
    just_print();
}

set_exception_handler('exception_handler');

function error_handler($errno, $errstr, $errfile, $errline)
{
    //http_response_code(500);
    $GLOBALS['response']->http_code = 500;
    $GLOBALS['response']->message = "global.ErrorException";
    $GLOBALS['response']->input = "global_error";
    $GLOBALS['response']->errno = $errno;
    $GLOBALS['response']->errstr = $errstr;
    $GLOBALS['response']->errline = $errline;
    just_print();
}

set_error_handler("error_handler");

function query_success()
{
    //http_response_code(200);
    $GLOBALS['response']->http_code = 200;
    $GLOBALS['response']->message = 'La consulta fue un exito';
    just_print();
}

function just_print()
{
    $GLOBALS["response"]->file = $_SERVER["PHP_SELF"];
    headers();
    echo (json_encode($GLOBALS['response']));
    die;
}

function headers() {
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Access-Control-Allow-Methods: POST");
    header('Content-Type: application/json; charset=utf-8');
}

function shutdown()
{
    //Si la supervariable response no esta seteada o esta vacia, significa que se llego al fin del programa sin una respuesta
    //Siempre se debe tener una respuesta, por lo que imprimimos una de error diciendo que no hay respuesta.
    if ((isset($GLOBALS["response"]) !== true) || (count((array)$GLOBALS["response"]) == 0)) {
        //http_response_code(500);
        headers();
        echo (
            '{"http_code":500,"message":"global.empty_response","file":"' . $_SERVER["PHP_SELF"] . '"}'
        );
    }
}
register_shutdown_function("shutdown");