<?php
require_once "model/Transporte.php";
require_once "model/Traslado.php";

class Controlador{
    static function setHeaderCoorsJson(){
        // Cabeceras genericas para omitir COORS, en un entorno productivo real debería ser específico.
        header('Access-Control-Allow-Origin: *');
        // header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header('Content-Type: application/json; charset=utf-8');
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
    }
    static function registrar(){

        echo json_encode($data);
    }
    static function home(){
        return json_encode([]);
    }
    static function getTransportesJson(){
        $transportes = Transporte::get_all();
        return json_encode($transportes);
    }
    static function getTrasladoJson(){
        $traslados = Traslado::get_all();
        return json_encode($traslados);
    }
    static function calcCO2footprint(Traslado $traslado){
        $factor = $traslado->transporte->factor_emision;
        $kms = $traslado->distancia_km;
        $total = $factor * $kms;
        $total = ($traslado->ida_vuelta) ? $total*2 : $total;
        return $total;
    }
    static function calcCompanyCO2Footprint(){
        $traslados = Traslado::get_all_obj();
        $total = 0;
        foreach($traslados as $traslado){
            $total+=Controlador::calcCO2footprint($traslado);
        }
        return $total;
    }
    static function getCompanyCO2FootprintJson(){
        $outp = new stdClass();
        $outp->total = Controlador::calcCompanyCO2Footprint();
        return json_encode($outp);
    }
}