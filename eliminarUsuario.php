<?php
include "configDB.php";
$link = mysqli_connect($server,$user,$pass,$basededatos);
$email = $_GET['email'];
$sql = "DELETE FROM usuarios WHERE email = '$email'";
if (!mysqli_query($link, $sql)) {
    die('Error: Fallo en el servidor, pruebe mas tarde.');
}
echo "Usuario eliminado.";
?>