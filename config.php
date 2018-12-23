<?php
session_start();

require_once "Facebook/autoload.php";

$FB = new \Facebook\Facebook([
    'app_id' => '739658486399213',
    'app_secret' => 'fe63cf9361990d680e519a354321ad1d',
    'default_graph_version' => 'v2.10'
]);

$helper = $FB->getRedirectLoginHelper();
?>