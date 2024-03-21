<?php
//Esto carga el modulo mysqli_connector si es que no ha sido cargado previamente
function getRequired(): void {
    if (class_exists("MySQLIclass") !== true) {
        require_once(((isset($GLOBALS["main"]) === true) ? "" : "../") . "api/mysqli_connector.php");
    }
    if (isset($GLOBALS["mClass"]) !== true) {
        createClass();
    }
}
//Esto actualiza el dinero del jugador en $_SESSION["coins"] respecto a la base de datos
function getUserCoins(): bool
{
    getRequired();
    $query = "SELECT monedas FROM usuarios WHERE id=" . $_SESSION['userid'] . ";";
    $result = $GLOBALS["mClass"]->execute_sql($query, "global.query_failed.getUserCoins", 500, null);
    $GLOBALS["mClass"]->numRowIsNotZero("global.getUserCoins.empty", $result, 500, null);
    $_SESSION["coins"] = $result->fetch_assoc()["monedas"];
    return true;
}