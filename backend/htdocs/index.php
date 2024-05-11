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
Flight::route('GET /traslados', function () {
    echo Controlador::getTrasladosJson();
});
Flight::route('GET /traslado/@id', function ($id) {
    echo Controlador::getTrasladoJson($id);
});
Flight::route('DELETE /traslado/@id', function ($id) {
    echo Controlador::deleteTraslado($id);
});
Flight::route('POST /traslado', function () {
    $data = json_decode(file_get_contents('php://input'));
    $outp = Controlador::registrarTraslado($data);
    echo $outp;
});
Flight::route('GET /export', function () {
    Controlador::exportCSV();
});
Flight::start();

?>