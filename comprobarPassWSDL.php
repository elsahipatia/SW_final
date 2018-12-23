<?php
require_once('./lib/nusoap.php');
require_once('./lib/class.wsdlcache.php');

$ns = 'http://www.sw18g12.tech/SW_final';
//$ns = 'http://localhost/SW_Lab8';
$server = new soap_server;
$server ->configureWSDL('comprobarPass',$ns);
$server ->wsdl ->schemaTargetNamespace =$ns;
$server ->register('comprobarPass', array('pass'=>'xsd:string','ticket'=>'xsd:int'), array('r'=>'xsd:string'), $ns);

function comprobarPass($pass,$ticket){
    $file = fopen('toppaswords.txt', 'r');
    if($ticket != 1010)
        return 'SIN SERVICIO';
    if ($file) {
        while (($line = fgets($file)) !== false) {
            // process the line read.
            if($line === $pass){
                fclose($file);
                return 'INVALIDA';
            }
        }
        fclose($file);
        return 'VALIDA';
    }
}
if(!isset($HTTP_RAW_POST_DATA))
    $HTTP_RAW_POST_DATA = file_get_contents('php://input');
$server ->service($HTTP_RAW_POST_DATA);