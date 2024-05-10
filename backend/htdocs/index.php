<?php
require "flight/Flight.php";
require "controller/Controlador.php";

Controlador::setHeaderCoorsJson();

Flight::route('/', function () {
    echo Controlador::home();
});
Flight::route('GET /company-carbon-footprint', function () {
    echo Controlador::getCompanyCO2FootprintJson();
});
Flight::route('GET /transportes', function () {
    echo Controlador::getTransportesJson();
});
Flight::route('GET /traslado', function () {
    echo Controlador::getTrasladoJson();
});
Flight::start();

// $tpa = Transporte::get_all_obj();
// // //$tps = $tp::get(6);
// print_r($tpa);
// $dire_partida= "calle el inicio 369, Santiago";
// $dire_termino= "calle delfin 9";
// $transporte_id= 3;
// $fecha="2009/11/15";
// $distancia_km=9.93;
// $trabajador="Juanito la Rosa";
// $ida_vuelta="1";
// // $alltranslados = Traslado::insertar($dire_partida, $dire_termino, $transporte_id, $fecha, $distancia_km, $trabajador, $ida_vuelta);
// $traup = new Traslado(2);

// $traup->dire_partida= "calle el inicio 369, Santiago";
// $traup->dire_termino= "calle delfin 9";
// $traup->transporte_id= 3;
// $traup->fecha="2009/11/15";
// $traup->distancia_km=9.93;
// $traup->trabajador="Juanito la Rosa";
// $traup->ida_vuelta=0;
// $traup->save();
// print_r($traup);
?>