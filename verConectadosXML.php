<?php
/**
 * Created by PhpStorm.
 * User: cerve
 * Date: 15/11/2018
 * Time: 18:26
 */
if(!$conectados = simplexml_load_file('contador.xml')){
    echo "No se ha podido cargar el archivo";
} else {
    echo $conectados->usuariosOnline;
}

?>