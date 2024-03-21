<?php
class MySQLIclass {
    private $ini_file;
    public $query;
    public $campus;
    public $numrowerror;
    public function __construct() {
        $this->createMySQLi();
    }
    private function createIniFile() {
        $ini_file = parse_ini_file("mysqli.ini", false);
        if ($ini_file == false) {
            die("Fallo al conectar a la MySQL: No se encuentra el archivo de configuracion");
        }
        return $ini_file;
    }
    private function createMySQLi() {
        $ini_file = $this->createIniFile();
        $GLOBALS["mysqli"] = new mysqli($ini_file["hostname"], $ini_file["username"], $ini_file["password"], $ini_file["database"], $ini_file["port"]);
        if ($GLOBALS["mysqli"]->connect_errno) {
            die('No pudo conectarse: ' . $GLOBALS["mysqli"]->connect_errno . " " .  $GLOBALS["mysqli"]->connect_error);
        }
    }
    public function numRowIsZero($numrowerror, $result) {
        if (($result->num_rows) > 0) { throw new Exception($numrowerror); }
        else { return true; }
    }
    public function fetchAssoc($result) {
        return ($result->fetch_assoc());
    }
    public function storeMySQLiResult($query) {
        return ($GLOBALS["mysqli"]->query($query));
    }
    public function fetchArray($query, $campus) {
        $tablearray = [];
        $result = $GLOBALS["mysqli"]->query($query);
        while ($row = $result->fetch_assoc()) {
            array_push($tablearray, $row[$campus]);
        }
        return $tablearray;
    }
    public function mysqli_function_close() {
        mysqli_close($GLOBALS["mysqli"]);
        //echo("Se cerro la conexion");
    }
    public function mysqli_query_failed_fatal() {
        echo("Fallo en la consulta: " . $GLOBALS["mysqli"]->error . ".");
        $this->mysqli_function_close();
    }
    public function __destruct() {
        //echo("Se llamo al destructor");
        if ($GLOBALS["mysqli"]->ping() !== false) { $this->mysqli_function_close(); }
    }
}

function createClass() {
    $GLOBALS["mClass"] = new MySQLIclass;
}
?>