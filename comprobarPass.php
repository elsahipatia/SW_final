<?php
require_once('lib/nusoap.php');
require_once('lib/class.wsdlcache.php');
$soapclient = new nusoap_client( 'http://www.sw18g12.tech/SW_final/samples/comprobarPassWSDL.php?wsdl', true);
//$soapclient = new nusoap_client( 'http://localhost/SW_Lab8/samples/comprobarPassWSDL.php?wsdl', true);

$res = $soapclient->call('comprobarPass',array('pass'=>$_GET['password'], 'ticket'=>1010));
echo $res;
?>