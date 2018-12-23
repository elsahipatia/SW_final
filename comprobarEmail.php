<?php
require_once('lib/nusoap.php');
require_once('lib/class.wsdlcache.php');
$soapclient = new nusoap_client( 'http://ehusw.es/jav/ServiciosWeb/comprobarmatricula.php?wsdl', true);
$res = $soapclient->call('comprobar',array('x'=>$_GET['email']));
echo $res;
?>