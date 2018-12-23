<?php
//incluimos la clase nusoap.php
require_once('../lib/nusoap.php');
require_once('../lib/class.wsdlcache.php');
$ns = 'http://sw18g12.tech/SW_final';
$server = new soap_server;
$server ->configureWSDL('obtenerPregunta',$ns);
$server ->wsdl ->schemaTargetNamespace =$ns;
$server ->register('obtenerPregunta', array('id'=>'xsd:int'), array('res'=>'xsd:string'), $ns);


function obtenerPregunta($id){
    include "../configDB.php";
    $link = mysqli_connect($server,$user,$pass,$basededatos);
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $result = mysqli_query($link,"SELECT email, enunciado, correct FROM preguntas WHERE id = $id");
    if($row = mysqli_fetch_array($result)){
        return '<table border="1"><tr><td>Autor</td><td>Enunciado</td><td>Respuesta correcta</td></tr>'.
               '<tr><td>'.$row["email"].'</td><td>'.$row["enunciado"].'</td><td>'.$row["correct"].'</td></tr>'.
            '</table>';
    }else{
        return '<table border="1"><tr><td>Autor</td><td>Enunciado</td><td>Respuesta correcta</td></tr>'.
            '<tr><td>'.'  '.'</td><td>'.'  '.'</td><td>'.'  '.'</td></tr>'.
            '</table>';
    }
}
if(!isset($HTTP_RAW_POST_DATA))
    $HTTP_RAW_POST_DATA = file_get_contents('php://input');
$server ->service($HTTP_RAW_POST_DATA);