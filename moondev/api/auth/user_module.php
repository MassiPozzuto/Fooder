<?php

declare(strict_types=1);

namespace moondev\api\auth\validator;

use Exception;
use systemException;

if (class_exists("systemException") !== true) {
    //El @ suprime el tirar WARNING
    @include_once('../system_handler.php');
    throw new systemException("global.module_failed.system_handler", 500, "global_error");
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $module_settings = parse_ini_file("../settings.ini", true)["server_auth_settings"];
    define("REGEX_PASSWORD", $module_settings["REGEX_PASSWORD"]);
    define("REGEX_USERNAME", $module_settings["REGEX_USERNAME"]);
    define("REGEX_SLASH", $module_settings["REGEX_SLASH"]);
    define("GET_USER_QUERY", $module_settings["GET_USER_QUERY"]);
    define("PASSWORD_MAX_LENGHT", $module_settings["PASSWORD_MAX_LENGHT"]);
    define("PASSWORD_MIN_LENGHT", $module_settings["PASSWORD_MIN_LENGHT"]);
    define("USERNAME_MAX_LENGHT", $module_settings["USERNAME_MAX_LENGHT"]);
    define("USERNAME_MIN_LENGHT", $module_settings["USERNAME_MIN_LENGHT"]);
    define("EMAIL_MAX_LENGHT", $module_settings["EMAIL_MAX_LENGHT"]);
    define("EMAIL_MIN_LENGHT", $module_settings["EMAIL_MIN_LENGHT"]);
    define("DEFAULT_PROFILE_ID", $module_settings["DEFAULT_PROFILE_ID"]);
    define("MIN_PROFILE", $module_settings["MIN_PROFILE"]);
    define("MAX_PROFILE", $module_settings["MAX_PROFILE"]);
    define("MIN_PERSONAJE_ID", $module_settings["MIN_PERSONAJE_ID"]);
    define("MAX_PERSONAJE_ID", $module_settings["MAX_PERSONAJE_ID"]);

    class checking
    {
        public static function dataExists($data, $error, $error2, $error3, $htmlchars, $input): string
        {
            if ((isset($_POST[$data]) !== true) || ($_POST[$data] === (null || ""))) {
                throw new systemException($error, 401, $input);
            } else if (gettype($_POST[$data]) !== 'string') {
                throw new systemException($error2, 401, $input);
            } else if ((preg_match(REGEX_SLASH, $_POST[$data])) !== 0) {
                throw new systemException($error3, 401, $input);
            } else {
                $information = stripslashes(trim($_POST[$data]));
                if ($htmlchars === true) {
                    $information = htmlspecialchars($information);
                }
                return $information;
            }
        }
        public static function validateEmail(string $email, string $counter, bool $validate_regex, ?array $messages): bool
        {
            if (gettype($messages) != "array") {
                $messages = array (
                    "max_error" => "email.max_error",
                    "max_error_input" => "email" . $counter . "_error",
                    "min_error" => "email.min_error",
                    "min_error_input" => "email" . $counter . "_error",
                    "email_wrong" => "email.login_failed",
                    "email_wrong_input" => "email" . $counter . "_error",
                    "email_wrong_register" => "email.wrong",
                    "email_wrong_register_input" => "email" . $counter . "_error",
                );
            }
            $email_lenght = strlen($email);
            if (($email_lenght > EMAIL_MAX_LENGHT) !== false) {
                throw new systemException($messages["max_error"], 401, $messages["max_error_input"]);
            } else if (($email_lenght < EMAIL_MIN_LENGHT) !== false) {
                throw new systemException($messages["min_error"], 401, $messages["min_error_input"]);
            } else if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                if ($validate_regex == true) {
                    throw new systemException($messages["email_wrong_register"], 401, $messages["email_wrong_register_input"]);
                } else {
                    throw new systemException($messages["email_wrong"], 401, $messages["email_wrong_input"]);
                }
            }
        }
        public static function validatePassword(string $password, string $counter, bool $regex_validate, bool $is_profile, ?array $messages): bool
        {
            if (gettype($messages) != "array") {
                $messages = array(
                    "max_error" => "password.max_error",
                    "max_error_input" => "password" . $counter . "_error",
                    "min_error" => "password.min_error",
                    "min_error_input" => "password" . $counter . "_error",
                    "regex_error" => "password.not_matched",
                    "regex_error_input" => "password" . $counter . "_error",
                    "non_regex_error" => "email.login_failed",
                    "non_regex_input" => "email1_error",
                    "non_regex_profile" => "password.wrong",
                    "non_regex_profile_input" => "password" . $counter . "_error",
                );
            }
            $password_lenght = strlen($password);
            if (($password_lenght > PASSWORD_MAX_LENGHT) !== false) {
                throw new systemException($messages["max_error"], 401, $messages["max_error_input"]);
            } else if (($password_lenght < PASSWORD_MIN_LENGHT) !== false) {
                throw new systemException($messages["min_error"], 401, $messages["min_error_input"]);
            }
            if ((preg_match(REGEX_PASSWORD, $password)) !== 1) {
                if ($regex_validate == true) {
                    throw new systemException($messages["regex_error"], 401, $messages["regex_error_input"]);
                } else {
                    if ($is_profile == true) {
                        throw new systemException($messages["non_regex_profile"], 401, $messages["non_regex_profile_input"]);
                    } else {
                        throw new systemException($messages["non_regex_error"], 401, $messages["non_regex_input"]);
                    }
                }
            } else {
                return true;
            }
        }

        public static function validateUsername(string $username, string $counter, bool $regex_validate, bool $is_profile, ?array $messages): bool
        {
            if (isset($messages) != true) {
                $messages = array(
                    "max_error" => "username.max_error",
                    "max_error_input" => "username" . $counter . "_error",
                    "min_error" => "username.min_error",
                    "min_error_input" => "username" . $counter . "_error",
                    "regex_error" => "username.not_matched",
                    "regex_error_input" => "username" . $counter . "_error",
                    "non_regex_error" => "email.login_failed",
                    "non_regex_input" => "email1_error",
                    "non_regex_profile" => "username.wrong",
                    "non_regex_profile_input" => "username" . $counter . "_error",
                );
            }
            $username_lenght = strlen($username);
            if (($username_lenght > USERNAME_MAX_LENGHT) !== false) {
                throw new systemException($messages["max_error"], 401, $messages["max_error_input"]);
            } else if (($username_lenght < USERNAME_MIN_LENGHT) !== false) {
                throw new systemException($messages["min_error"], 401, $messages["min_error_input"]);
            }
            if ((preg_match(REGEX_USERNAME, $username)) === 1) {
                if ($regex_validate == true) {
                    throw new systemException($messages["regex_error"], 401, $messages["regex_error_input"]);
                } else {
                    if ($is_profile == true) {
                        throw new systemException($messages["non_regex_profile"], 401, $messages["non_regex_profile_input"]);
                    } else {
                        throw new systemException($messages["non_regex_error"], 401, $messages["non_regex_input"]);
                    }
                }
            } else {
                return true;
            }
        }
        public static function doTheyMatch($match1, $match2, $error, $input): bool
        {
            if (($match1) === ($match2)) {
                return true;
            } else {
                throw new systemException($error, 401, $input);
            }
        }
        public static function hashPassword($password): string
        {
            return password_hash($password, PASSWORD_DEFAULT);
        }
        /*
        public static function pswDatabaseAuth($password, $userid) {
            self::AuthenticatePassword($password, self::getPassword($userid));
        }*/
        public static function getPassword($id)
        {
            $query = "SELECT clave FROM usuarios WHERE id=" . $id . ";";
            $result = $GLOBALS["mClass"]->execute_sql($query, "global.query_failed.getPassword", 500, "global_error");
            $GLOBALS["mClass"]->numRowIsNotZero('global.getPassword.unknow', $result, 500, "global_error");
            return $result->fetch_assoc()["clave"];
        }
        public static function AuthenticatePassword($password, $password_hashed, $error, $input)
        {
            if (password_verify($password, $password_hashed) !== true) {
                //throw new systemException("password.wrong, 401, password1_error);
                throw new systemException($error, 401, $input);
            }
            return true;
        }
        public static function validatePersonajeID($personajeid, string $error, string $input): bool
        {
            if (is_numeric($personajeid) && (($personajeid > MIN_PERSONAJE_ID) && ($personajeid < MAX_PERSONAJE_ID))) {
                return true;
            } else {
                throw new systemException($error, 400, $input);
            }
        }
        public static function validateRoles($roles, string $error, string $input): bool
        {
            if (is_numeric($roles) && (($roles >= MIN_PROFILE) && ($roles <= MAX_PROFILE))) {
                return true;
            } else {
                throw new systemException($error, 400, $input);
            }
        }
        //Si isRegister esta activado, se tirara excepcion al devolver >= 1 filas de resultados
        public static function doesUserExists(bool $isRegister, bool $validateusername, bool $validateemail, ?string $email, ?string $username, bool $returnid)
        {
            /*
            if (gettype($messages) != "array") {
                //Invalid credentials es un error generico (Email o contrasenia incorrectos)
                $messages = array (
                    "invalid_credentials" => "email.login_failed",
                    "invalid_credentials_input" => "email" . $counter . "_error",
                    "email_failed" => "email.wrong",
                    "email_failed_input" => "email" . $counter . "_error",
                    "email_used" => "email.used",
                    "email_used_input" => "email" . $counter . "_error",
                );
            }
            */
            $query = ("SELECT u.id, eh.mail, u.deleted_at, eh.deleted_at AS email_deleted_at FROM usuarios u INNER JOIN email_history eh ON u.id = eh.usuario_id WHERE eh.mail = '" . $email . "';");
            //$GLOBALS["response"]->dshjdsa = $query;
            $result = $GLOBALS["mClass"]->execute_sql($query, "global.doesUserExists.email_failed", 500, "global_error");
            if ($validateemail == true) {
                if ($isRegister === true) {
                    $GLOBALS["mClass"]->numRowIsZero('email.used', $result, 401, "email1_error");
                } else {
                    //$GLOBALS["mClass"]->numRowIsNotZero('email.not_found', $result, 401, "email1_error");
                    $GLOBALS["mClass"]->numRowIsNotZero('email.login_failed', $result, 401, "email1_error");
                }
            }
            if (($result != null) && (($result->num_rows) > 0)) {
                $fetched = $result->fetch_assoc();
                $deleted_at = $fetched["deleted_at"];
                $email_deleted_at = $fetched["email_deleted_at"];
                if (($deleted_at != null) || ($email_deleted_at != null)) {
                    //throw new systemException("email.deleted", 401, "email1_error");
                    throw new systemException("email.login_failed", 401, "email1_error");
                }
                $id = $fetched["id"];
            }
            if ($validateusername === true) {
                $query = ("SELECT uh.username, u.id, u.deleted_at, uh.deleted_at AS username_deleted_at FROM username_history uh INNER JOIN usuarios u ON uh.usuario_id = u.id WHERE ");
                if ($username == null) {
                    $query .= ("usuario_id =" . $id . ";");
                } else {
                    $query .= ("username='" . $username . "';");
                }
                $result = $GLOBALS["mClass"]->execute_sql($query, "global.doesUserExists.name_failed", 500, "global_error");
                if (($result->num_rows > 0) && ($result->fetch_assoc()["username_deleted_at"] != null)) {
                    throw new systemException("email.login_failed", 401, "email1_error");
                }
                if ($isRegister === true) {
                    $GLOBALS["mClass"]->numRowIsZero('username.used', $result, 401, "username1_error");
                } else {
                    //$GLOBALS["mClass"]->numRowIsNotZero('username.notFound', $result, 401, "username1_error");
                    $GLOBALS["mClass"]->numRowIsNotZero('email.login_failed', $result, 401, "email1_error");
                }
            }
            return ($returnid === true) ? $id : true;
        }
        public static function validateInt($int, string $error, string $input): bool
        {
            if ((is_numeric($int)) && ($int >= 0)) {
                return true;
            } else {
                throw new systemException($error, 400, $input);
            }
        }
    }
}
