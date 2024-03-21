<?php
class autoLogin
{
    public function __construct()
    {
        $this->inicializate();
        if (isset($_SESSION["userid"]) !== true) {
            if (class_exists("MySQLIclass") !== true) {
                $required = (isset($GLOBALS["main"])) ? "api/mysqli_connector.php" : "../mysqli_connector.php";
                require_once($required);
                createClass();
            }
            $this->cookieAuth();
        }
    }
    public function cookieAuth(): bool
    {
        if ((isset($_COOKIE["moondev_auth"]) === true) && (isset($_SESSION["userid"]) === false)) {
            if ((isset($_COOKIE["moondev_auth"])) && (is_numeric($_COOKIE["moondev_auth"]))) {
                $query = parse_ini_file((isset($GLOBALS["main"])) ? "api/settings.ini" : "settings.ini", false)["GET_USER_QUERY"];
                //echo($query);
                $apply = $GLOBALS["mysqli"]->real_escape_string($_COOKIE["moondev_auth"]);
                $query_final = $query . " WHERE u.id=" . $apply . ";";
                //echo($query_final);
                $result = $GLOBALS["mClass"]->execute_sql($query_final, "global.query_failed.cookieAuth", 500, "global_error");
                $GLOBALS["mClass"]->numRowIsNotZero("global.cookie.empty", $result, 500, "global_error");
                $user_information = $result->fetch_assoc();
                $this->createSessionID($user_information);
                unset($query);
                unset($apply);
                unset($query_final);
                return true;
            } else {
                setcookie('moondev_auth', "", -1, '/');
                return false;
            }
        } else {
            return true;
        }
    }
    public static function inicializate(): void
    {
        $expirationCode = (14 * 24 * 60 * 60);
        session_set_cookie_params($expirationCode);
        session_start();
    }
    public static function isLogged(): bool
    {
        if (isset($_SESSION['userid'])) {
            return true;
        } else {
            return false;
        }
    }
    public static function adminRights(): bool
    {
        if (isset($_SESSION['systemRights']) === true) {
            if ($_SESSION['systemRights'] == 1) {
                return true;
            }
            return false;
        }
        return false;
    }
    public static function createSessionID($array): bool
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            autoLogin::inicializate();
        }
        $_SESSION['userid'] = $array['id'];
        $_SESSION['email'] = $array['mail'];
        $_SESSION['personaje_id'] = $array['personaje_id'];
        $_SESSION['username'] = $array['username'];
        $_SESSION['coins'] = $array['monedas'];
        $_SESSION['systemRights'] = $array['systemRights'];
        $_SESSION['created'] = $array['created_at'];
        return true;
    }
}