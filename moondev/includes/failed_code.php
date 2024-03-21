<?php
if (isset($_COOKIE["moondev_error"])) {
    echo ($_COOKIE["moondev_error"]);
    setcookie(
        "moondev_error",
        "",
        "1",
        "/",
        "",
        false,
        false
    );
} else {
    $GLOBALS["response"] = new stdClass;
    $GLOBALS["response"]->message = "global.unknow";
    $GLOBALS["response"]->http_code = 500;
    $GLOBALS["response"]->input = "global_error";
    $GLOBALS["response"]->errstr = "No se encontro la cookie del error";
    echo (json_encode($GLOBALS["response"]));
}
