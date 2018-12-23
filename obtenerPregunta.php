<?php
session_start();
if (!isset($_SESSION['email']))
    header("Location: login.php");
require_once('lib/nusoap.php');
require_once('lib/class.wsdlcache.php');
$soapclient = new nusoap_client( 'http://localhost/SW_Lab8/samples/obtenerPreguntaWSDL.php?wsdl', true);
$res = $soapclient->call('obtenerPregunta',array('id'=>intval($_GET['id'])));
echo $res;
?>