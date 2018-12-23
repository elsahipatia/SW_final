<?php
session_start();
if(!$assessmentItems = simplexml_load_file('preguntas.xml')){
    echo "No se ha podido cargar el archivo";
} else {
    if(isset($_GET['op']) && $_GET['op']=='getContador'){
        $preguntasUsuario=0;
        $preguntasTotales=0;
        foreach ($assessmentItems as $assessmentItem){
            if($assessmentItem['author'] == $_SESSION['email'])
                $preguntasUsuario++;
            $preguntasTotales++;
        }
        echo $preguntasUsuario.'/'.$preguntasTotales;
    }else{
        echo '<table border="1">';
        echo '<tr>';
        echo '<th>Autor</th>';
        echo '<th>Pregunta</th>';
        echo '<th>Respuesta Correcta</th>';
        echo '<th>Respuestas Incorrectas</th>';

        echo '</tr>';

        foreach ($assessmentItems as $assessmentItem){
            if($assessmentItem['author'] == $_SESSION['email']){
                echo '<tr>';
                echo '<th>'.$assessmentItem["author"].'</th>';
                echo '<th>'.$assessmentItem->itemBody->p.'</th>';
                echo '<th>'.$assessmentItem->correctResponse->value.'</th>';
                echo '<th>'.$assessmentItem->incorrectResponses->value[0].'/'.
                    $assessmentItem->incorrectResponses->value[1].'/'.
                    $assessmentItem->incorrectResponses->value[2].'</th>';
                echo '</tr>';
            }
        }
        echo '</table>';
    }
}
?>