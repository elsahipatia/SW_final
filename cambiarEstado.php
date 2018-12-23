<?php
include "configDB.php";
$link = mysqli_connect($server,$user,$pass,$basededatos);
$email = $_GET['email'];
$estado=$_GET['estado'];
if($estado==0){
    $sql = "UPDATE usuarios SET estado=1 WHERE email = '$email'";
}else{
    $sql = "UPDATE usuarios SET estado=0 WHERE email = '$email'";
}
if (!mysqli_query($link, $sql)) {
    die('Error: Fallo en el servidor, pruebe mas tarde.');
}
echo "Estado modificado correctamente.";
?>