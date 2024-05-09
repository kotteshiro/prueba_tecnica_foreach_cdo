<?php
require_once "db.php";
require_once "Transporte.php";
class Traslado extends Database{
    private $table = "traslado";
    public $id = -1;
    public $dire_partida;
    public $dire_termino;
    public $transporte_id;
    public $transporte;
    public $fecha;
    public $distancia_km;
    public $trabajador;
    public $ida_vuelta;

    function __construct($id=-1) {
        parent::__construct();
        if($id>=0){
            try{
                if(!$this->load($id)){
                    throw new Exception('No se pudo cargar Traslado id='.$id);
                }
            }catch(Exception $e){
                die($e->getMessage());
            }
        }
    }
    static function get_all(){
        $tl_obj = new Traslado();
        $sql = "SELECT * FROM $tl_obj->table";
        $registros = $tl_obj->mysqli->query($sql);
        return $registros->fetch_all(MYSQLI_ASSOC);
    }
    static function get_all_obj(){
        $all = Traslado::get_all();
        $outp = [];
        foreach($all as $tl_record){
            $outp[] = new Traslado($tl_record["id"]);
        }
        return $outp;
    }
    static function get($id){
        $tl_obj = new Traslado();
        try{
            if($tl_obj->load($id)){
                return $tl_obj;
            }else{
                throw new Exception('No se pudo cargar Traslado id='.$id);
            }
        }catch(Exception $e){
            die($e->getMessage());
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
            $this->dire_partida = $row_result["dire_partida"];
            $this->dire_termino = $row_result["dire_termino"];
            $this->transporte_id = $row_result["transporte_id"];
            $this->fecha = $row_result["fecha"];
            $this->distancia_km = $row_result["distancia_km"];
            $this->trabajador = $row_result["trabajador"];
            $this->ida_vuelta = $row_result["ida_vuelta"];
            try{
                $this->transporte = new Transporte($this->transporte_id);
            }catch(Exception $e){
                return FALSE;
            }
            return TRUE;
        }else{
            return FALSE;
        }
    }

    static function insertar($dire_partida, $dire_termino, $transporte_id, $fecha, $distancia_km, $trabajador, $ida_vuelta){
        $nuevo = new Traslado();
        $nuevo->dire_partida = $dire_partida;
        $nuevo->dire_termino = $dire_termino;
        $nuevo->transporte_id = $transporte_id;
        $nuevo->fecha = $fecha;
        $nuevo->distancia_km = $distancia_km;
        $nuevo->trabajador = $trabajador;
        $nuevo->ida_vuelta = $ida_vuelta;
        $nuevo->save();
        return $nuevo;
    }
    static function actualizar($id, $dire_partida, $dire_termino, $transporte_id, $transporte, $fecha, $distancia_km, $trabajador, $ida_vuelta){
        $traslado = new Traslado($id);
        $traslado->dire_partida = $dire_partida;
        $traslado->dire_termino = $dire_termino;
        $traslado->transporte_id = $transporte_id;
        $traslado->fecha = $fecha;
        $traslado->distancia_km = $distancia_km;
        $traslado->trabajador = $trabajador;
        $traslado->ida_vuelta = $ida_vuelta;
        $traslado->save();
    }
    function save(){
        if($this->id >= 0){
            // Actualiza existente
            $query = "UPDATE $this->table SET dire_partida = ?, dire_termino = ?, transporte_id = ?, fecha = ?, distancia_km = ?, trabajador = ?, ida_vuelta = ? WHERE traslado.id = ?;";
            try{
                $statement = $this->mysqli->prepare($query);
                $statement->bind_param('ssisdsii', $this->dire_partida, $this->dire_termino, $this->transporte_id, $this->fecha, $this->distancia_km, $this->trabajador, $this->ida_vuelta, $this->id);
                $statement->execute();
            }catch(Exception $e){
                die($e->getMessage());
            }
        }else{
            // Inserta Nuevo
            $query = "INSERT INTO $this->table (id, dire_partida, dire_termino, transporte_id, fecha, distancia_km, trabajador, ida_vuelta) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?);";
            try{
                $statement = $this->mysqli->prepare($query);
                $statement->bind_param('ssisdsi', $this->dire_partida, $this->dire_termino, $this->transporte_id, $this->fecha, $this->distancia_km, $this->trabajador, $this->ida_vuelta);
                $statement->execute();
            }catch(Exception $e){
                die($e->getMessage());
            }
            $this->id = $this->mysqli->insert_id;
        }
    }
    function delete(){
        $query = "DELETE FROM $this->table WHERE id = ?";
        try{
            $statement = $this->mysqli->prepare($query);
            $statement->bind_param('i', $this->id);
            $statement->execute();
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

}