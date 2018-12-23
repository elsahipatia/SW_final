<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Preguntas</title>
    <link rel='stylesheet' type='text/css' href='estilos/style.css' />
    <link rel='stylesheet'
          type='text/css'
          media='only screen and (min-width: 530px) and (min-device-width: 481px)'
          href='estilos/wide.css' />
    <link rel='stylesheet'
          type='text/css'
          media='only screen and (max-width: 480px)'
          href='estilos/smartphone.css' />
</head>
<body>
<div id='page-wrap'>
    <header class='main' id='h1'>

        <span class="right"><a href="layout.php">Logout</a></span>
        <span>
            <?php
            include "configDB.php";
            $link = mysqli_connect($server,$user,$pass,$basededatos);
            // Check connection
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            $email = $_SESSION['email'];
            $result = mysqli_query($link,"SELECT foto FROM usuarios WHERE email = '$email'");
            while($row = mysqli_fetch_array($result))
            {
                echo '<img height="60" width="60" src="data:image/*;base64,'.base64_encode($row['foto']).' "/>';
            }
            ?>
        </span>
        <h2>Quiz: el juego de las preguntas</h2>
    </header>
    <nav class='main' id='n1' role='navigation'>
        <span><a href="layout2.php">Inicio</a></span>
        <span><a href="gestionPreguntas.php">Gestionar Preguntas</a></span>
        <span><a href="creditos2.php">Creditos</a></span>
        <span><a href="obtenerDatos.php">Obtener Datos</a></span>
        <span><a href="obtenerPreguntaId.php">Ver preguntas por ID</a></span>
        <span><a href="verPreguntasXML.php">Ver tabla XML</a></span>
        <span><a href="preguntas.xml">Ver tabla XSL</a></span></nav>
    <section class="main" id="s1" >

        <div style="font-weight: bold ; font-size: large">
            <?php
            include "configDB.php";
            $link = mysqli_connect($server,$user,$pass,$basededatos);
            $email = trim($_POST['email']);
            $enunciado = trim($_POST['question']);
            $correct = trim($_POST['correct']);
            $incorrect1 = trim($_POST['incorrect1']);
            $incorrect2 = trim($_POST['incorrect2']);
            $incorrect3 = trim($_POST['incorrect3']);
            $complejidad = trim($_POST['complexity']);
            $tema = trim($_POST['subject']);

            if(preg_match("/^([a-z]+[0-9]{3}@ikasle\.ehu\.eus)|(admin@ehu.es)$/",$email)!=1 ||
                preg_match("/^.{10,}$/",$enunciado)!=1 ||
                preg_match("/^[0-5]$/",$complejidad)!=1 ||
                empty($correct) ||
                empty($incorrect1) ||
                empty($incorrect2) ||
                empty($incorrect3) ||
                empty($tema))
            {
                echo "Error en el envio de datos.";
                return;
            }
            if($_FILES['examine']['tmp_name']!="")
                $img = mysqli_real_escape_string($link,file_get_contents($_FILES['examine']['tmp_name']));
            else
                $img = mysqli_real_escape_string($link, file_get_contents("pregunta.png"));
            $sql = "INSERT INTO preguntas(email, enunciado, correct, incorrect1, incorrect2, incorrect3, complejidad, tema, foto) VALUES ('$email','$enunciado','$correct','$incorrect1','$incorrect2','$incorrect3',$complejidad,'$tema', '$img')";
            if (!mysqli_query($link, $sql)) {
                die('Error: Fallo en el servidor, pruebe mas tarde.');
            }
            echo "Pregunta añadida correctamente.<br>";
            $refEmail = "gestionPreguntas.php?email=" . $email;
            $aux = "<a href='".$refEmail."'>aquí</a>";
            echo "Para visualizar las preguntas haz click " . $aux;
            mysqli_close($link);


            /*Añadir información al XML */
            if (file_exists('preguntas.xml')) {
                $assessmentItems = simplexml_load_file('preguntas.xml');
            } else {
                exit('Error abriendo preguntas.xml.');
            }
            $item = $assessmentItems->addChild('assessmentItem');
            $item->addAttribute('subject',$tema);
            $item->addAttribute('author',$email);
            $item->addChild('itemBody')->addChild('p',$enunciado);
            $item->addChild('correctResponse')->addChild('value',$correct);
            $itemIncorrect = $item->addChild('incorrectResponses');
            $itemIncorrect->addChild('value',$incorrect1);
            $itemIncorrect->addChild('value',$incorrect2);
            $itemIncorrect->addChild('value',$incorrect3);

            $assessmentItems->asXML('preguntas.xml');
            ?>

        </div>
    </section>
    <footer class='main' id='f1'>
        <a href='https://github.com/elsahipatia/SW_final'>Link GITHUB</a>
    </footer>
</div>
</body>
</html>
