<?php
class MySQLIclass
{
    public $result;
    public $query;
    public $campus;
    public $numrowerror;
    final public function __construct()
    {
        $this->testEnviroment();
        $this->createMySQLi();
    }
    public static function testEnviroment() {
        if (class_exists("systemException") !== true && (isset($GLOBALS["main"]) !== true)) {
            define("MYSQLI_AUTO_SHUTDOWN", false);
            define("USE_EXCEPTION_HANDLER", false);
            die("El conector MySQL con clase necesita del modulo systemException.php para su correcto funcionamiento funcionamiento");
        } else {
            define("MYSQLI_AUTO_SHUTDOWN", true);
            define("USE_EXCEPTION_HANDLER", true);
        }
        if (getenv("MYSQL_HOME") == false) {
            throw new systemException("MySQLIException.mysql_not_installed", 500, "global_error");
        }
        
    }
    private static function createIniFile()
    {
        $required = (isset($GLOBALS["main"])) ? "api/settings.ini" : "settings.ini";
        $ini_file = parse_ini_file($required, true)["mysqliconfig"];
        if ($ini_file == false) {
            throw new systemException("MySQLIException.unknow_inifle", 500, "global_error");
        }
        return $ini_file;
    }
    final public static function executeConnection() {
        $ini_file = self::createIniFile();
        $GLOBALS["mysqli"] = new mysqli($ini_file["hostname"], $ini_file["username"], $ini_file["password"], $ini_file["database"], $ini_file["port"]);
    }
    private function createMySQLi()
    {
        //Establezo que el sistema tire excepciones en caso de falla SQL
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $this->executeConnection();
        } catch (mysqli_sql_exception $e) {
            $exception = "MySQLIException.connection_failed.prefix.";
            switch ($e->getCode()) {
                    //Usuario o contraseña incorrectos
                case 1045:
                    $exception .= "1";
                    break;
                    //Base de datos no encontrada
                case 1049:
                    $exception .= "2";
                    break;
                case 2022:
                    //Conexion rechazada
                    $exception .= "3";
                    break;
                default:
                    $exception .= "4";
                    break;
            }
            $GLOBALS['response']->errno  = $e->getCode();
            $GLOBALS['response']->errstr  = $e->getMessage();
            throw new systemException($exception, 500, "global_error");
        }
        // NO BORRAR - Esta linea establece el UTF8 en la conexion-
        $GLOBALS["mysqli"]->set_charset("utf8mb4");
        if (USE_EXCEPTION_HANDLER !== true) {
            mysqli_report(MYSQLI_REPORT_ERROR);
        }
    }
    // Si el resultado devuelve >= a 1 fila de resultados, tirar una excepcion.
    public function numRowIsZero(string $numrowerror, mysqli_result $result, int $http_code, string $input)
    {
        if (($result->num_rows) > 0) {
            throw new systemException($numrowerror, $http_code, $input);
        } else {
            return true;
        }
    }
    // Si el resultado devuelve 0 filas de resultados, tirar una excepcion.
    public function numRowIsNotZero(string $numrowerror, mysqli_result $result, int $http_code, ?string $input)
    {
        if (($result->num_rows) == 0) {
            throw new systemException($numrowerror, $http_code, $input);
        } else {
            return true;
        }
    }
    public function execute_sql(string $query, string $exception, int $http_code, ?string $input)
    {
        try {
            $result = $GLOBALS["mysqli"]->query($query);
        } catch (mysqli_sql_exception $e) {
            $GLOBALS["response"]->query_error = $e->getMessage();
            throw new systemException($exception, $http_code, $input);
            $this->mysqli_function_close();
        }
        return $result;
    }
    //Esta funcion solo se debe utilizar cuando en mysqli report no tira excepciones
    public function storeMySQLiResult_exception($result, string $exception, int $http_code)
    {
        if (!($result)) {
            $GLOBALS["response"]->query_error = $GLOBALS["mysqli"]->error;
            throw new Exception($exception, $http_code);
            $this->mysqli_function_close();
        } else {
            return true;
        }
    }
    public function freeMultiQueryResult()
    {
        while ($GLOBALS["mysqli"]->next_result()) {;
        }
    }
    public function mysqli_function_close()
    {
        if (isset($GLOBALS["mysqli"])) {
            $GLOBALS["mysqli"]->close();
        }
        //echo("Se cerro la conexion");
    }
    public function __destruct()
    {
        //echo("Se llamo al destructor");
        if (MYSQLI_AUTO_SHUTDOWN === true) {
            $this->mysqli_function_close();
        }
    }
}

//Esta funcion crea la clase y la conexion
function createClass()
{
    $GLOBALS["mClass"] = new MySQLIclass;
}

//Esta funcion solo crea la conexion
function createConnection() {
    MySQLIclass::executeConnection();
}