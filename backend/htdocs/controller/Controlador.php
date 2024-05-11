<?php
require_once "model/Transporte.php";
require_once "model/Traslado.php";

class Controlador{
    static function setHeaderCoorsJson(){
        // Cabeceras genericas para omitir COORS, en un entorno productivo real debería ser específico.
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        header('Content-Type: application/json; charset=utf-8');
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
    }

    
    static function home(){
        return json_encode([]);
    }
    static function getTransportesJson(){
        $transportes = Transporte::get_all();
        return json_encode($transportes);
    }
    static function getTrasladosJson(){
        $traslados = Traslado::get_all();
        return json_encode($traslados);
    }
    static function getTrasladoJson($id){
        if($id<0) return json_encode([]);
        $traslado = new Traslado($id);
        $traslado->co2footprint = Controlador::calcCO2footprint($traslado);
        return json_encode($traslado);
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
    static function registrarTraslado($data){
        $reg = new Traslado();
        $reg->id = $data->id;
        $reg->dire_partida = $data->addrStart;
        $reg->dire_termino = $data->addrEnd;
        $reg->transporte_id = $data->transport;
        $reg->fecha = $data->traveldate;
        $reg->distancia_km = $data->distance;
        $reg->trabajador = $data->workerName;
        $reg->ida_vuelta = $data->isRoundTrip;
        $reg->save();
        return Controlador::getTrasladoJson($reg->id);
    }
    static function deleteTraslado($id){
        $traslado = new Traslado($id);
        $traslado->delete();
        $outp = new stdClass();
        $outp->deleted = $id;
        return json_encode($outp); 
    }
    static function getAllTrasladosAsArray(){
        $traslados = Traslado::get_all_obj();
        $total = 0;
        foreach($traslados as &$traslado){
            $traslado->co2=Controlador::calcCO2footprint($traslado);
        }
        return $traslados;
    }
    static function exportCSV(){
        // mil disculpas por esto, pudo ser mas prolijo, pero me pilla el tiempo.

        function download_send_headers($filename) {
            // disable caching
            $now = gmdate("D, d M Y H:i:s");
            header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
            header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
            header("Last-Modified: {$now} GMT");
        
            // force download  
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
        
            // disposition / encoding on response body
            header("Content-Disposition: attachment;filename={$filename}");
            header("Content-Transfer-Encoding: binary");
        }
        function array2csv(array &$array)
        {
            if (count($array) == 0) {
                return null;
            }
            ob_start();
            $df = fopen("php://output", 'w');
            fputcsv($df, array_keys(reset($array)));
            foreach ($array as $row) {
                fputcsv($df, $row);
            }
            fclose($df);
            return ob_get_clean();
        }

        download_send_headers("data_export_" . date("Y-m-d") . ".csv");

        $traslados = Traslado::get_all();
        foreach($traslados as &$traslado){
            
            $traslado["huella_carbono"] = Controlador::calcCO2footprint(new Traslado($traslado["id"]));
        }
        echo array2csv($traslados);
        die();
    }
}