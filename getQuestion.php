<?php
include "configDB.php";
$link = mysqli_connect($server,$user,$pass,$basededatos);
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($link,"SELECT enunciado,correct,incorrect1,incorrect2,incorrect3 FROM preguntas");
//$question_list = array_fill(0,mysqli_num_rows($result),null);
$i = 0;
while($row = mysqli_fetch_array($result))
{
    $question_list[$i]=$row;
    $i=$i+1;
}
mysqli_close($link);
echo json_encode($question_list);
return;
?>