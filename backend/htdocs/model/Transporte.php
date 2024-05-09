<?php
require_once "db.php";
class Transporte extends Database{
    private $table = "transporte";
    public $id=-1;
    public $label;
    public $factor_emision;
    function __construct($id=-1) {
        parent::__construct();
        if($id >= 0){
            $this->load($id);
        }
    }
    static function get_all(){
        $tp_obj = new Transporte();
        $sql = "SELECT * FROM $tp_obj->table";
        $registros = $tp_obj->mysqli->query($sql);
        return $registros->fetch_all(MYSQLI_ASSOC);
    }
    static function get_all_obj(){
        $all_transporte = Transporte::get_all();
        $outp = [];
        foreach($all_transporte as $tp_record){
            $outp[] = new Transporte($tp_record["id"]);
        }
        return $outp;
    }
    static function get($id){
        $tp_obj = new Transporte();
        if($tp_obj->load($id)){
            return $tp_obj;
        }else{
            throw new Exception('No se pudo cargar Transporte id='.$id);
        }
    }
    function load($id){
        $query = "SELECT * FROM $this->table WHERE id=? LIMIT 1";
        $statement = $this->mysqli->prepare($query);
        $statement->bind_param('i', $id);
        $statement->execute();
        $result = $statement->get_result();
        if($row_result = $result->fetch_array()){
            $this->id = $row_result["id"];
            $this->label = $row_result["label"];
            $this->factor_emision = $row_result["factor_emision"];
            return TRUE;
        }else{
            return FALSE;
        }
    }
}