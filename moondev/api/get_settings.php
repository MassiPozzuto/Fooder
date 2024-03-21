<?php

function getSettings($selector)
{
    $array = parse_ini_file("settings.ini", true);
    switch ($selector) {
        case "auth":
            unset($array["server_auth_settings"]["GET_USER_QUERY"]);
            unset($array["mysqliconfig"]);
            echo (json_encode($array));
            break;
    }
}
