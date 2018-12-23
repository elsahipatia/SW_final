<?php
    include "configDB.php";
    $link = mysqli_connect($server,$user,$pass,$basededatos);
    $nick = trim($_POST['nick']);
    $puntuacion = $_POST['puntuacion'];
    $sql = "INSERT INTO ranking(nick, puntuacion) VALUES ('$nick',$puntuacion)";
    $res = mysqli_query($link, $sql);
    mysqli_close($link);
    header("Location: layout.php");