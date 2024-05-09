<?PHP
class Database{
    public $mysqli;
    function __construct(){
        include "db_config.php";
        $this->mysqli = new mysqli($DB_SERV, $DB_USER, $DB_PASS, $DB_NAME);
        if ($this->mysqli->connect_errno) {
            die("error de conexión: " . $this->mysqli->connect_error);
        }
    }
    function __destruct() {
        try{
            $this->mysqli->close();
        }catch(Exception $e) {
            //no pasa nada, la db está cerrada.
        }
    }
}